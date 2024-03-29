<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\News;
use App\History;
use Carbon\Carbon;
use Storage;

class NewsController extends Controller
{
  public function add()
  {
    return view('admin.news.create');
  }

  public function create(Request $request){
    $this->validate($request,News::$rules);
    $news = new News;
    $form = $request->all();

    if(isset($form['image'])){
      // 下記はこうも書けると思ったら型が違う、$form['image']は配列になってしまう。$request->file('image')は
      // uploadedFileの型
      // $path = $form['image']->store('public/image');
      // $path = $request->file('image')->store('public/image');
      // $news->image_path = basename($path);
      $path = Storage::disk('s3')->putFile('/',$form['image'],'public');
      $news->image_path = Storage::disk('s3')->url($path);
    }else {
      $news->image_path = null;
    }

    unset($form['_token']);
    unset($form['image']);

    // 下記のように書いてもよい
    // $news->title = $form['title'];
    // $news->body = $form['body'];

    $news->fill($form);
    $news->save();

    //admin/news/createにリダイレクトする
    return redirect('admin/news/create');
  }

  public function index(Request $request)
  {
    $cond_title = $request->cond_title;
    if($cond_title != ''){
      $posts = News::where('title',$cond_title)->get();
    }else{
      $posts = News::all();
    }
    return view('admin.news.index',['posts' => $posts, 'cond_title' => $cond_title]);
  }

  public function edit(Request $request)
  {
    $news = News::find($request->id);
    if(empty($news)){
      abort(404);
    }
    return view('admin.news.edit',['news_form' => $news]);
  }

  public function update(Request $request)
  {
    $this->validate($request, News::$rules);
    $news = News::find($request->input('id'));
    // $news = News::find($request->id);
    $news_form = $request->all();

    // if ($request->remove == 'true') {
    if ($request->input('remove')) {
      $news_form['image_path'] = null;
    } elseif ($request->file('image')) {
      // $path = $request->file('image')->store('public/image');
      // $news_form['image_path'] = basename($path);
      $path = Storage::disk('s3')->putFile('/',$form['image'],'public');
      $news_form['image_path'] = Storage::disk('s3')->url($path);
    } else {
      $news_form['image_path'] = $news->image_path;
    }

    unset($news_form['_token']);
    unset($news_form['image']);
    unset($news_form['remove']);
    $news->fill($news_form)->save();

    $history = new History;
    $history->news_id = $news->id;
    $history->edited_at = Carbon::now();
    $history->save();

    return redirect('admin/news');
  }

  public function delete(Request $request)
  {
    $news = News::find($request->id);
    $news->delete();
    return redirect('admin/news');
  }
}
