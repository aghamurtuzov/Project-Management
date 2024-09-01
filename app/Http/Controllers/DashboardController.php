<?php

namespace App\Http\Controllers;

class DashboardController extends Controller
{
    public function index()
    {
        return view('app.index');
    }

    public function detail($id)
    {
        return view('app.detail', compact('id'));
    }
}
