<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Auth;
use App\Admin;

class DashController extends Controller
{

    public function __construct()
    {
         $this->middleware('auth');
    }


    public function showDash()
    {
        if(Admin::exists('cpf', auth()->user()->username)) return view('adminDash');
        
        return view('dashboard');
    }


}
