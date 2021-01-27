@foreach($comments as $comment)
    <div class="pl-10 d-flex justify-content-between">
        <div class="d-flex justify-content-between">
            <strong class="text-gray-dark">{{ $comment->name }} wrote:</strong>
            <a @click.prevent="reply_text = 'Reply to {{ $comment->name }}\'s comment', parent_comment_id = {{ $comment->id }}" href="#" class="float-right text-base font-semibold text-indigo-600 hover:text-indigo-500">Reply</a>
        </div>
        <span class="d-block italic">{{ '@'.$comment->parent_name }}</span>
        {{ $comment->comment }}
    </div>
    @if(count($comment->children))
        @include('comments.partials.comment-tree',['comments' => $comment->children])
    @endif
@endforeach