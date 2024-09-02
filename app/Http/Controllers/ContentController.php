<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use Illuminate\Http\Request;

class Contentcontroller extends Controller
{
    public function index()
    {
        $profile = Profile::where('status', 1)->first();
        return view('layouts_3.index', compact('profile'));
    }
}
