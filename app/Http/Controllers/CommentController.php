<?php

namespace App\Http\Controllers;

use App\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request) {
        $data = $request->all();
        $data['user_id'] = auth()->user()->id;
        Comment::create($data);
        return back();
    }
    public function destroy($id) {
        $data_comment = Comment::findOrFail($id);
        if( $data_comment->user_id != auth()->user()->id ) {
            return back();
        }
        $data_comment->delete();
        return back();
    }
    public function update(Request $request, $id) {
        $data = $request->all();
        $data['user_id'] = auth()->user()->id;
        Comment::findOrFail($id)->update($data);
        return back();
    }
}
