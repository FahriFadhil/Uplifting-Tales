<?php

namespace App\Http\Controllers;

use App\FollowingTag;
use Illuminate\Http\Request;

class FollowingTagController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->all();
        $data['user_id'] = auth()->user()->id;
        FollowingTag::create($data);
        return back();
    }
    public function destroy($id)
    {
        $data_tag = FollowingTag::where('user_id', auth()->user()->id)->where('tag_id', $id)->first();
        $data_tag->delete();
        return back();
    }
}
