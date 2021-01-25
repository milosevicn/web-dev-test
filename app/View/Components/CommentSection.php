<?php

namespace App\View\Components;

use Illuminate\View\Component;
use App\Models\Comment;

class CommentSection extends Component
{
    public $blogId;
    public $type;
    public $comment;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($blogId, $type, $comment = null)
    {
        $this->blogId = $blogId;
        $this->type = $type;
        $this->comment = $comment;
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
        $comments = Comment::whereNull('parent_id')->with('children')->orderBy('created_at', 'desc');
        if($this->type == 'post') {
            $comments = $comments->where('post_id', $this->blogId);
        } else {
            $comments = $comments->where('news_id', $this->blogId);
        }
        $comments = $comments->get();
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
