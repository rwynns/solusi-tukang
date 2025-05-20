<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Display admin dashboard
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('admin.index');
    }
}
