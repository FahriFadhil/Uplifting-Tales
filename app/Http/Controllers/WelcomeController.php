<?php

namespace App\Http\Controllers;

use App\Story;
use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    public function index() {
        $data_story = Story::latest()->paginate(6);
        return view('welcome', compact('data_story'));
    }
}
