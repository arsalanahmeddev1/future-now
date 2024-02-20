<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function comments(Request $request)
    {
        $request->validate([
            'post_id' => 'required|exists:App\Models\Post,id',
            'comment' => 'required'
        ]);
        $comments = Comment::create([
            'post_id' => $request->post_id,
            'user_id' => auth()->user()->id,
            'comments' => $request->comment,
        ]);
        $comments->load('user');
        return response()->json($comments);
    }

    public function showComments(Request $request)
    {
        $comments = Post::find($request->post_id)->comments;
        $comments->load('user');
        $comm_array = $comments->toArray();
        return response()->json($comm_array);
    }
}
