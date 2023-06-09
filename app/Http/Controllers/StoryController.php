<?php

namespace App\Http\Controllers;

use App\Bookmark;
use App\Comment;
use App\Story;
use App\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class StoryController extends Controller
{
    public function show($story_slug)
    {
        $data_story = Story::where('slug', $story_slug)->first();
        $data_user_story = Story::where('user_id', $data_story->user_id)->whereNotIn('id', [$data_story->id])->latest()->paginate(3);
        $data_random_tag = Tag::inRandomOrder()->take(5)->get();
        $data_comment = Comment::where('story_id', $data_story->id)->get();
        $data_story_bookmarked = Bookmark::where('user_id', auth()->user()->id)->latest()->get();
        return view('detail', compact('data_story', 'data_user_story', 'data_random_tag', 'data_comment', 'data_story_bookmarked'));
    }

    public function create()
    {
        $data_tag = Tag::all();
        return view('write', compact('data_tag'));
    }

    public function store(Request $request)
    {
        $data = $request->all();

        $bodyArr = explode(' ', $data['body']);
        $readtime = 0;
        for ($i = 0; $i < count($bodyArr); $i += 5) {
            $readtime += 1;
        }

        $data['user_id'] = auth()->user()->id;
        $data['slug'] = Str::slug($data['title']) . "-u-" . auth()->user()->id;
        if($readtime <= 60) {
            $data['readtime'] = ($readtime % 60).' Seconds ';
        } 
        elseif ($readtime % 60 == 0) {
            $data['readtime'] = floor($readtime / 60).' Minute ';
        }
        else {
            $data['readtime'] = floor($readtime / 60).' Minute '. ($readtime % 60).' Seconds ';
        }

        Story::create($data);
        return redirect('/home');
    }

    public function edit($story_slug)
    {
        $data_story = Story::where('slug', $story_slug)->first();
        if( $data_story->user_id == auth()->user()->id || auth()->user()->authorization == 'admin' ) {
            $data_tag = Tag::all();
            return view('edit', compact('data_story', 'data_tag'));
        }
        return redirect('/home');
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();

        $bodyArr = explode(' ', $data['body']);
        $readtime = 0;
        for ($i = 0; $i < count($bodyArr); $i += 5) {
            $readtime += 1;
        }

        $data['user_id'] = auth()->user()->id;
        $data['slug'] = Str::slug($data['title']) . "-u-" . auth()->user()->id;
        if($readtime <= 60) {
            $data['readtime'] = ($readtime % 60).' Detik ';
        } 
        elseif ($readtime % 60 == 0) {
            $data['readtime'] = floor($readtime / 60).' Menit ';
        }
        else {
            $data['readtime'] = floor($readtime / 60).' Menit '. ($readtime % 60).' Detik ';
        }

        Story::findOrFail($id)->update($data);
        return redirect('/home');
    }

    public function destroy($id) {
        $data_story = Story::findOrFail($id);
        if( $data_story->user_id == auth()->user()->id || auth()->user()->authorization == 'admin' ) {
            $data_story->delete();
            return redirect('/home');
        }
        return redirect('/home');
    }
}
