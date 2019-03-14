<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\News;

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
      $path = $request->file('image')->store('public/image');
      $news->image_path = basename($path);
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
}
