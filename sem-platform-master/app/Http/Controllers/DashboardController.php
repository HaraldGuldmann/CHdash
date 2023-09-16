<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $totalEarnings = auth()->user()->earnings->sum('amount');
        return view('dashboard', compact('totalEarnings'));
    }
}
