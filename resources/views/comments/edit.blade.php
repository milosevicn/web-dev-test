<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('View/Edit Comment') }}
        </h2>
    </x-slot>

    @if ($comment->type == 'post')
        <x-comment-section :blogId="$comment->post_id" type="post" :comment="$comment"/>
    @else
        <x-comment-section :blogId="$comment->news_id" type="news" :comment="$comment"/>
    @endif
</x-app-layout>