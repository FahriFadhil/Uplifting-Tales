<?php

namespace App\Http\Controllers;

use App\Following;
use Illuminate\Http\Request;

class FollowController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->all();
        $data['following_id'] = auth()->user()->id;
        Following::create($data);
        return back();
    }
    public function destroy($id)
    {
        $data_tag = Following::where('user_id', $id)->where('following_id', auth()->user()->id)->first();
        $data_tag->delete();
        return back();
    }
}
