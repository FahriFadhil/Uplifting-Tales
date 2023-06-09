<?php

namespace App\Http\Controllers;

use App\Bookmark;
use Illuminate\Http\Request;

class BookmarkController extends Controller
{
    public function toggle($storyId) {        
        $bookmark = Bookmark::where('user_id', auth()->user()->id)->where('story_id', $storyId)->first();
        
        if ($bookmark) {
            $bookmark->delete();
            return response()->json(['message' => 'Story removed from bookmarks']);
        } else {
            $bookmark = new Bookmark();
            $bookmark->user_id = auth()->user()->id;
            $bookmark->story_id = $storyId;
            $bookmark->save();
            return response()->json(['message' => 'Story added to bookmarks']);
        }
    }
}
