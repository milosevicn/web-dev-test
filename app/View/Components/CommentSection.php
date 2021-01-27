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
        $comments = Comment::where('approved', 1)->whereNull('parent_id')->with('children')->orderBy('created_at', 'desc');
        if($this->type == 'post') {
            $comments = $comments->where('post_id', $this->blogId);
        } else {
            $comments = $comments->where('news_id', $this->blogId);
        }
        $comments = $comments->paginate(2);

        return view('components.comment-section', [
          'comments' => $comments,
        ]);
    }
}
