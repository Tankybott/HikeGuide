<x-app-layout>
    <div class="pt-8">

        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold text-gray-900">Hike Drafts</h1>
        </div>

        <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
            @if($drafts->isEmpty())
                <div class="px-6 py-12 text-center text-gray-400 text-sm">
                    No drafts submitted yet.
                </div>
            @else
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-gray-100 bg-gray-50 text-left">
                            <th class="px-6 py-3 font-semibold text-gray-600">Title</th>
                            <th class="px-6 py-3 font-semibold text-gray-600">Submitted by</th>
                            <th class="px-6 py-3 font-semibold text-gray-600">Difficulty</th>
                            <th class="px-6 py-3 font-semibold text-gray-600">Proposed region</th>
                            <th class="px-6 py-3 font-semibold text-gray-600">Submitted</th>
                            <th class="px-6 py-3 font-semibold text-gray-600 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($drafts as $draft)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 font-medium text-gray-900">{{ $draft->title }}</td>
                                <td class="px-6 py-4 text-gray-500">{{ $draft->user->nickname }}</td>
                                <td class="px-6 py-4 text-gray-500 capitalize">{{ $draft->difficulty }}</td>
                                <td class="px-6 py-4 text-gray-500">
                                    {{ $draft->proposed_region_name ?? '—' }}
                                </td>
                                <td class="px-6 py-4 text-gray-400 text-xs">{{ $draft->created_at->format('d M Y') }}</td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <a
                                            href="{{ route('admin.drafts.show', $draft) }}"
                                            class="px-3 py-1.5 text-xs font-medium text-white bg-orange-500 hover:bg-orange-600 rounded-md transition-colors"
                                        >
                                            Proceed
                                        </a>
                                        <form method="POST" action="{{ route('admin.drafts.destroy', $draft) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button
                                                type="submit"
                                                class="px-3 py-1.5 text-xs font-medium text-red-600 bg-red-50 hover:bg-red-100 rounded-md transition-colors"
                                            >
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>

    </div>
</x-app-layout>
