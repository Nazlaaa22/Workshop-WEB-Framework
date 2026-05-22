<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        if (auth()->user()->role == 'vendor') {
            return redirect('/vendor-dashboard');
        }

        if (auth()->user()->role == 'adminRS') {
            return redirect('/admin-dashboard');
        }

        return view('dashboard');
    }
}
