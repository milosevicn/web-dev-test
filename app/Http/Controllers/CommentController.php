<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function index()
    {
        //
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $data['post_id'] = $request->postId;
        $data['approved'] = false;
        $comment = new Comment($data);
        if($data['parent_comment_id']) {
            $comment->parent_id = $data['parent_comment_id'];
        }
        $comment->save();
        return redirect()->route('post.show', ['id' => $request->postId]);
    }

    public function show(Comment $comment)
    {
        //
    }

    public function edit(Comment $comment)
    {
        //
    }

    public function update(Request $request, Comment $comment)
    {
        //
    }

    public function destroy(Comment $comment)
    {
        //
    }
}
