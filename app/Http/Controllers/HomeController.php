<?php

namespace App\Http\Controllers;

use App\Bookmark;
use App\FollowingTag;
use App\Story;
use App\Tag;
use App\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $data_story = Story::latest()->paginate(10);
        if($request->get('query_tag')) {
            $data_selected_tag = Tag::where('body', $request->get('query_tag'))->first();
            $data_story = Story::where('tag_id', $data_selected_tag->id)->latest()->paginate(10);
        };
        
        $data_following_tags = FollowingTag::where('user_id', auth()->user()->id)->get();
        $data_story_bookmarked = Bookmark::where('user_id', auth()->user()->id)->latest()->get();

        $data_random_story = Story::inRandomOrder()->take(2)->get();;
        $data_random_tag = Tag::inRandomOrder()->take(5)->get();
        $data_developer = User::where('authorization', 'admin')->first();

        return view('home', compact('data_story', 'data_following_tags', 'data_random_story', 'data_random_tag', 'data_developer', 'data_story_bookmarked'));
    }
}
