<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Admin;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function showProfile()
    {
        if (Admin::where('adminCpf', auth()->user()->username)->exists()) {
            return view('admin.adminUserProfile', ['userData' => auth()->user()]);
        }

        return view('user.userProfile', ['userData' => auth()->user()]);
    }
}
