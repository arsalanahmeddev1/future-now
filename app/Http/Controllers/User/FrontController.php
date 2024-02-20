<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Like;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;

class FrontController extends Controller
{
    public function index(){
        $posts = Post::all();
        // $postId=$posts[0]['id'];

        // dd($posts->id);
        $active = User::latest();
        $suggest = User::latest()->limit(3)->get();
        $likes=Like::all()->count();
        // $comments= Comment::where('post_id',$postId)->get();
        // dd($comments);
        return view('front.index',compact('posts','active','suggest','likes'));

    }
}
