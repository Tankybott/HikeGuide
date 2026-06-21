@if($hikes->isEmpty())
    <div class="px-6 py-12 text-center text-gray-400 text-sm">
        {{ $search ? 'No hikes match your search.' : 'No hikes yet. Add one above.' }}
    </div>
@else
    <table class="w-full text-sm">
        <thead>
            <tr class="border-b border-gray-100 bg-gray-50 text-left">
                <th class="px-6 py-3 font-semibold text-gray-600">Title</th>
                <th class="px-6 py-3 font-semibold text-gray-600">Region</th>
                <th class="px-6 py-3 font-semibold text-gray-600">Difficulty</th>
                <th class="px-6 py-3 font-semibold text-gray-600">Length</th>
                <th class="px-6 py-3 font-semibold text-gray-600 text-right">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @foreach($hikes as $hike)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-4 font-medium text-gray-900">{{ $hike->title }}</td>
                    <td class="px-6 py-4 text-gray-500">{{ $hike->region->name }}</td>
                    <td class="px-6 py-4 text-gray-500 capitalize">{{ $hike->difficulty }}</td>
                    <td class="px-6 py-4 text-gray-500">{{ $hike->length_km ? $hike->length_km . ' km' : '—' }}</td>
                    <td class="px-6 py-4 text-right">
                        <div class="flex items-center justify-end gap-2">
                            <a
                                href="{{ route('admin.hikes.edit', $hike) }}"
                                class="px-3 py-1.5 text-xs font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-md transition-colors"
                            >
                                Edit
                            </a>
                            <button
                                @click="openDelete({{ $hike->id }}, @js($hike->title))"
                                class="px-3 py-1.5 text-xs font-medium text-red-600 bg-red-50 hover:bg-red-100 rounded-md transition-colors"
                            >
                                Delete
                            </button>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endif
