<?php

namespace App\Http\Controllers;

use App\Bookmark;
use App\Following;
use App\Story;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function index($user_slug)
    {
        $data_user = User::where('slug', $user_slug)->first();
        $data_user_story = Story::where('user_id', $data_user['id'])->latest()->paginate(16);
        $data_story_bookmarked = Bookmark::where('user_id', auth()->user()->id)->get();
        $data_user_followed = false;
        $user_state = Following::where('user_id', $data_user->id)->where('following_id', auth()->user()->id)->first();
        if ($user_state) {
            $data_user_followed = true;
        }
        $data_follower = Following::where('user_id', $data_user->id)->get()->count();
        $data_following = Following::where('following_id', $data_user->id)->get()->count();
        // dd($data_user);
        return view('profile', compact('data_user', 'data_user_story', 'data_story_bookmarked', 'data_user_followed', 'data_following', 'data_follower'));
    }
    public function bookmarks($user_slug)
    {
        $data_user = User::where('slug', $user_slug)->first();
        $data_user_bookmark = Bookmark::where('user_id', $data_user['id'])->latest()->paginate(16);
        return view('bookmarks', compact('data_user', 'data_user_bookmark'));
    }
    public function update(Request $request ,$id)
    {
        $user = User::findOrFail($id);
        if($user->pfp) {
            Storage::delete($user->pfp);
            $user->pfp = null;
        }
        $user->slug = Str::slug($request->input('name')).'-u-'.rand(99999, 999999);
        $user->name = $request->input('name');
        $user->bio = $request->input('bio');
        $imageFileName = Str::slug($request->input('name')).'-p-'.rand(99999, 999999);
        if ($request->hasFile('pfp')) {
            $request->file('pfp')->storeAs('public/images', $imageFileName);
            $user->pfp = $imageFileName;
        };
        $user->save();
        return redirect('/home');
    }
    public function destroy($id)
    {
        if( auth()->user()->authorization == 'admin' ) {
            User::findOrFail($id)->delete();
        }
        return redirect('/home');
    }
}
