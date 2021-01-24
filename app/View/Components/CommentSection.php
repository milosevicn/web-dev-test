<?php

namespace App\View\Components;

use Illuminate\View\Component;
use App\Models\Comment;

class CommentSection extends Component
{
    public $postId;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($postId)
    {
        $this->postId = $postId;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        $comment_children = function($comments) use (&$comment_children) {
            $result = [];
            foreach($comments->children as $child) {
                $result[] = $child;
                if($child->children) {
                    $result = array_merge($result, $comment_children($child));
                }
            }
            return $result;
        };
        $comments = Comment::where('post_id', $this->postId)->whereNull('parent_id')->with('children')->orderBy('created_at', 'desc')->get();
        $ordered_comments = [];
        foreach($comments as $comment) {
            $ordered_comments[] = $comment;
            $ordered_comments = array_merge($ordered_comments, $comment_children($comment));
        }

        return view('components.comment-section', [
          'comments' => $ordered_comments,
        ]);
    }
}
