<?php

namespace App\Http\Controllers;

use App\Mailers\AppMailer;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function index()
    {
        $comments = Comment::orderBy('approved', 'desc')->latest()->paginate(10);

        return view('comments.index', compact('comments'));
    }

    public function approve(Request $request)
    {
        $app_mailer = app(AppMailer::class);

        $comment = Comment::find($request->id);
        $comment->approved = 1;
        $comment->save();

        $article = $comment->post ?: $comment->news;
        $app_mailer->sendTo($comment->email, 'New Comment', 'emails.new_comment', ['entity' => $comment, 'title' => $article->title, 'name' => $article->author->name]);
        $app_mailer->sendTo($comment->email, 'Comment Approved', 'emails.approved_comment', ['title' => $article->title, 'name' => $comment->name]);
        if($comment->parent_id) {
            $parent_comment = Comment::find($comment->parent_id);
            $app_mailer->sendTo($parent_comment->email, 'New Reply', 'emails.reply', ['title' => $article->title, 'name' => $parent_comment->name]);
        }

        return $this->index();
    }

    public function store(Request $request)
    {
        $type = $request->type;
        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'comment' => $request->comment,
            'type' => $type,
            $type.'_id' => $request->blogId
        ];
        $comment = Comment::updateOrCreate(['id' => $request->id], $data);
        if($request->parent_comment_id) {
            $comment->parent_id = $request->parent_comment_id;
        }
        $comment->save();
        if(Auth::user()) {
            return $this->index();
        }
        return redirect()->route($comment->type.'.show', ['id' => $comment->{$comment->type.'_id'}]);
    }

    public function edit(Request $request)
    {
        $comment = Comment::findOrFail($request->id);

        return view('comments.edit', compact('comment'));
    }

    public function destroy(Request $request)
    {
        Comment::destroy($request->id);
        $parent_ids = [$request->id];
        while(Comment::whereIn('parent_id', $parent_ids)->count() > 0) {
            $for_delete = Comment::whereIn('parent_id', $parent_ids);
            $parent_ids = $for_delete->pluck('id');
            $for_delete->delete();
        }

        return redirect()->route('comments.index')->with('success', 'Post Deleted!');
    }
}
