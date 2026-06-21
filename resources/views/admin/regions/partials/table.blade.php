@if($regions->isEmpty())
    <div class="px-6 py-12 text-center text-gray-400 text-sm">
        {{ $search ? 'No regions match your search.' : 'No regions yet. Add one above.' }}
    </div>
@else
    <table class="w-full text-sm">
        <thead>
            <tr class="border-b border-gray-100 bg-gray-50 text-left">
                <th class="px-6 py-3 font-semibold text-gray-600">Name</th>
                <th class="px-6 py-3 font-semibold text-gray-600">Country</th>
                <th class="px-6 py-3 font-semibold text-gray-600">Short Description</th>
                <th class="px-6 py-3 font-semibold text-gray-600 text-right">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @foreach($regions as $region)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-4 font-medium text-gray-900">{{ $region->name }}</td>
                    <td class="px-6 py-4 text-gray-500">{{ $region->country }}</td>
                    <td class="px-6 py-4 text-gray-500 max-w-xs truncate">{{ $region->short_description }}</td>
                    <td class="px-6 py-4 text-right">
                        <div class="flex items-center justify-end gap-2">
                            <a
                                href="{{ route('admin.regions.edit', $region) }}"
                                class="px-3 py-1.5 text-xs font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-md transition-colors"
                            >
                                Edit
                            </a>
                            <button
                                @click="openDelete({{ $region->id }}, @js($region->name))"
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
