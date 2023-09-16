<?php

namespace App\Http\Controllers;

use App\Models\ContentOwner;

class ContentOwnerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $contentOwners = ContentOwner::all();
        return view('contentowners.index', compact('contentOwners'));
    }
}
