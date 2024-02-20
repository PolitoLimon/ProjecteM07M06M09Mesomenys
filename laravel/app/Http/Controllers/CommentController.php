<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Comment;

class CommentController extends Controller
{
    //
    public function index(int $id)
    {
        if ($this->authorize('viewAny', Post::class)) {
            $comments = Post::with('comments')->find($id);
            return view("comments.index", ["comments" => $comments]);
        }
    }

    public function store(Request $request, int $id)
    {
        if ($this->authorize('create', Comment::class)) {

            $request->validate([
                'comment' => 'required|string',
            ]);
        
            $post = Post::find($id);

            $user = auth()->user();
            $comment = $post->comments()->create([
                'author_id' => $user->id,
                'comment' => $request->comment,
            ]);
            
            return redirect()->route('posts.show', ['post' => $id])->with('success', 'Comentario creado con éxito');
        }
    }

    public function destroy(int $id)
    {
        $comment = Comment::find($id);
        if ($this->authorize('delete', $comment)) {
            $comment->delete();
            return redirect()->route('posts.show', ['post' => $comment->post_id])->with('success', 'Comentario eliminado con éxito');
        }
    }
}