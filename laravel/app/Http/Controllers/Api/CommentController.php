<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Comment;

class CommentController extends Controller
{
    public function index($id)
    {
        if ($this->authorize('viewAny', Post::class)) {
            $post = Post::find($id);
            return response()->json([
                'success' => true,
                'data' => $post->comments ?? []
            ], 200);
        }
    }

    public function store(Request $request, $id)
    {
        if ($this->authorize('create', Comment::class)) {

            $request->validate([
                'comment' => 'required|string',
            ]);
        
            $post = Post::find($id);

            if (!$post) {
                return response()->json([
                    'success' => false,
                    'message' => 'Post not found'
                ], 404);    
            }
            
            $user = auth()->user();
            $comment = $post->comments()->create([
                'author_id' => $user->id,
                'comment' => $request->comment,
            ]);
            
            return response()->json([
                'success' => true,
                'data' => $comment
            ], 201);
        }
    }

    public function destroy($id, $commentId)
    {
        $post = Post::find($id);
        $comment = Comment::find($commentId);

        if (!$post) {
            return response()->json([
                'success' => false,
                'message' => 'Post not found'
            ], 404);    
        }
        if (!$comment) {
            return response()->json([
                'success' => false,
                'message' => 'Comment not found'
            ], 404);    
        }
        if ($this->authorize('delete', $comment)) {
            
            $comment->delete();
            return response()->json([
                'success' => true,
                'data' => $post
            ], 200);
        }
    }
}