<?php

namespace App\Http\Controllers;

use App\FollowingTag;
use App\Story;
use App\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    public function index($tag_slug)
    {
        $data_tag = Tag::where('body', $tag_slug)->first();
        $data_story = Story::where('tag_id', $data_tag->id)->get();
        $data_tag_followed = false;
        $tag_state = FollowingTag::where('user_id', auth()->user()->id)->where('tag_id', $data_tag->id)->first();
        if ($tag_state) {
            $data_tag_followed = true;
        }
        return view('tag', compact('data_tag', 'data_story', 'data_tag_followed'));
    }
    public function store(Request $request)
    {
        Tag::create($request->all());
        return back();
    }
    public function destroy($id)
    {
        $data_tag = Tag::findOrFail($id);
        if( auth()->user()->authorization == 'admin' ) {
            $data_tag->delete();
        }
        return redirect('/search');
    }
    
}
