<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EarningController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $earnings = auth()->user()->earnings;
        return view('earnings.index',compact('earnings'));
    }
}
