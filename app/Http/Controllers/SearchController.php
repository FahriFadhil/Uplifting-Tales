<?php

namespace App\Http\Controllers;

use App\Bookmark;
use App\Story;
use App\Tag;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $data_tag = Tag::all();
        $data_random_tag = Tag::inRandomOrder()->take(3)->get();
        $data_story = false;
        if($request->get('query_search')) {
            $data_story = Story::where('title', 'LIKE', '%'.$request->get('query_search').'%')
            ->orWhere('body', 'LIKE', '%'.$request->get('query_search').'%')
            ->latest()->paginate(16);
        };
        $data_story_bookmarked = Bookmark::where('user_id', auth()->user()->id)->latest()->get();
        return view('search', compact('data_tag', 'data_random_tag', 'data_story', 'data_story_bookmarked'));
    }
}
