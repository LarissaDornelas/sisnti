<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Admin;

class InfoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function showInfo()
    {
        if (Admin::where('adminCpf', auth()->user()->username)->exists()) {
            return view('admin.adminAbout');
        }
        return view('about');
    }
}
