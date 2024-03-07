<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Support\Facades\Request;

class LikeController extends Controller
{
    public function postlike()
    {
        $postId=Request::input('postId');
        $post=Post::find($postId);

        if(!$post->YouLiked()){
            $post->YoulikeIt();
            return response()->json(['status'=>'success','message' => 'liked']);
        }else{
            $post->YouUnlike();
            return response()->json(['status'=>'success','message' => 'unliked']);
        }
    }
}
