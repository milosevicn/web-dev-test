<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            All Comments
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(!count($comments))
                <p class="text-center font-bold text-3xl">No comments found!</p>
            @else
                <div class="bg-white mb-8 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="flex flex-col">
                        <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                            <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                                <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                                    <table class="min-w-full divide-y divide-gray-200">
                                        <thead>
                                            <tr>
                                                <th scope="col" class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Title
                                                </th>
                                                <th scope="col" class="px-6 py-3 bg-gray-50">
                                                    <span class="sr-only">Actions</span>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($comments as $comment)
                                            <tr class="{{ $loop->iteration % 2 ? 'bg-white' : 'bg-gray-50' }}">
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    <div class="truncate w-96">{{ $comment->comment }}</div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                    @if (!$comment->approved)
                                                        <a href="{{ route('comments.approve', $comment->id) }}" class="ml-4 text-indigo-600 hover:text-indigo-900">Approve</a>
                                                    @endif
                                                    <a href="{{ route('comments.edit', $comment->id) }}" class="ml-4 text-indigo-600 hover:text-indigo-900">View/Edit</a>
                                                    <form class="inline-block" action="{{ route('comments.destroy', $comment->id) }}" method="POST">
                                                        @method('DELETE')
                                                        @csrf
                                                        <button type="submit" class="ml-4 text-indigo-600 hover:text-indigo-900">Delete</button>
                                                    </form>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{ $comments->links() }}
            @endif
        </div>
    </div>
</x-app-layout>