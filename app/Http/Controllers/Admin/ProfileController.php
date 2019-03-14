<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Profile;
use App\User;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
  public function add()
  {
    return view('admin.profile.create');
  }
  public function create(Request $request)
  {
    $this->validate($request,Profile::$rules);
    $profile = new Profile;
    $profile->fill($request->all());
    $profile->save();

    User::create([
      'name' => '森本2',
      'email' => 'morimoto2@tech.com',
      'password' => Hash::make('pass2'),
    ]);

    return redirect('admin/profile/create');
  }
  public function edit()
  {
    return view('admin.profile.edit');
  }
  public function update()
  {
    return redirect('admin/profile/edit');
  }
}
