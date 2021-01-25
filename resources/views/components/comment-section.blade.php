<div class="relative mt-6 prose prose-indigo prose-lg text-gray-500 mx-auto" x-data="{ reply_text: 'Comment', parent_comment_id: 0}">
    <form action="{{ route('comment.store', ['blogId' => $blogId, 'type' => $type, 'id' => isset($comment) ? $comment->id : '' ]) }}" method="POST" class="space-y-8">
        @csrf
        <div class="space-y-8 divide-y divide-gray-200">
            <div class="mt-6 grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">

                {{-- Parent comment --}}
                <input type="hidden" name="parent_comment_id" x-bind:value="parent_comment_id">

                <div class="sm:col-span-3">
                    <label for="name" class="block text-sm font-medium text-gray-700">
                        Name
                    </label>
                    <div class="mt-1 relative rounded-md shadow-sm">
                        <input type="text" id="name" name="name" value="{{ old('name') ?? $comment->name ?? '' }}" class="{{ $errors->has('name') ? 'text-red-900 border-red-300 placeholder-red-300 focus:ring-red-500 focus:border-red-500' : 'border-gray-300 focus:ring-indigo-500 focus:border-indigo-500' }} block w-full pr-10 focus:outline-none sm:text-sm rounded-md">
                        @error('name')
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-red-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        @enderror
                    </div>
                    @error('name')
                    <p class="mt-2 text-sm text-red-600" id="name-error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="sm:col-span-3">
                    <label for="email" class="block text-sm font-medium text-gray-700">
                        Email
                    </label>
                    <div class="mt-1 relative rounded-md shadow-sm">
                        <input type="text" id="email" name="email" value="{{ old('email') ?? $comment->email ?? '' }}" class="{{ $errors->has('email') ? 'text-red-900 border-red-300 placeholder-red-300 focus:ring-red-500 focus:border-red-500' : 'border-gray-300 focus:ring-indigo-500 focus:border-indigo-500' }} block w-full pr-10 focus:outline-none sm:text-sm rounded-md">
                        @error('email')
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-red-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        @enderror
                    </div>
                    @error('email')
                    <p class="mt-2 text-sm text-red-600" id="email-error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="sm:col-span-6">
                    <label x-text="reply_text" for="comment" class="block text-sm font-medium text-gray-700">
                        Comment
                    </label>
                    <template x-if="parent_comment_id">
                        <a @click.prevent="reply_text = 'Comment', parent_comment_id = 0" href="#" class="text-base font-semibold text-indigo-600 hover:text-indigo-500">Cancel Reply</a>
                    </template>
                    <div class="mt-1">
                        <textarea id="comment" name="comment" rows="10" class="{{ $errors->has('comment') ? 'text-red-900 border-red-300 placeholder-red-300 focus:ring-red-500 focus:border-red-500' : 'border-gray-300 focus:ring-indigo-500 focus:border-indigo-500' }} shadow-sm block w-full sm:text-sm border-gray-300 rounded-md">{{ old('comment') ?? $comment->comment ?? '' }}</textarea>
                    </div>
                    @error('comment')
                    <p class="mt-2 text-sm text-red-600" id="comment-error">{{ $message }}</p>
                    @enderror
                </div>

            </div>
        </div>

        <div class="pt-5">
            <div class="flex justify-end">
                <button type="submit" class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Save comment
                </button>
            </div>
        </div>
    </form>

    @if (!empty($comments) && !isset($comment))
    <div class="my-3 p-3 bg-white rounded shadow-sm">
        <h3 class="border-bottom pb-2 mb-0">Comments:</h3>

        @foreach ($comments as $comment)
            <div class="d-flex text-muted pt-3">
                <div :class="{ 'pl-10': '{{ $comment->parent_id }}' }">
                    <div class="d-flex justify-content-between">
                        <strong class="text-gray-dark">{{ $comment->name }} wrote:</strong>
                        <a @click.prevent="reply_text = 'Reply to {{ $comment->name }}\'s comment', parent_comment_id = {{ $comment->id }}" href="#" class="float-right text-base font-semibold text-indigo-600 hover:text-indigo-500">Reply</a>
                    </div>
                    @if ($comment->parent_id)
                        @<span class="d-block italic">{{ $comment->parent_name }}</span>
                    @endif
                    {{ $comment->comment }}
                </div>
            </div>
        @endforeach
    @endif
</div>