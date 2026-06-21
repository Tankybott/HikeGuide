<x-app-layout>
    <div class="max-w-4xl mx-auto pt-8">

        <div class="flex items-center gap-3 mb-6">
            <a href="{{ route('admin.drafts.index') }}" class="text-sm text-gray-500 hover:text-orange-600 transition-colors">← Drafts</a>
            <span class="text-gray-300">/</span>
            <h1 class="text-2xl font-bold text-gray-900">{{ $draft->title }}</h1>
        </div>

        {{-- Draft details --}}
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6 space-y-4 mb-6">
            <h2 class="text-base font-semibold text-gray-900">Hike Details</h2>

            <div class="grid grid-cols-2 sm:grid-cols-3 gap-4 text-sm">
                <div>
                    <p class="text-xs font-medium text-gray-400 uppercase tracking-wide mb-0.5">Submitted by</p>
                    <p class="text-gray-700">{{ $draft->user->nickname }}</p>
                </div>
                <div>
                    <p class="text-xs font-medium text-gray-400 uppercase tracking-wide mb-0.5">Difficulty</p>
                    <p class="text-gray-700 capitalize">{{ $draft->difficulty }}</p>
                </div>
                @if($draft->length_km)
                    <div>
                        <p class="text-xs font-medium text-gray-400 uppercase tracking-wide mb-0.5">Length</p>
                        <p class="text-gray-700">{{ $draft->length_km }} km</p>
                    </div>
                @endif
                <div>
                    <p class="text-xs font-medium text-gray-400 uppercase tracking-wide mb-0.5">Submitted</p>
                    <p class="text-gray-700">{{ $draft->created_at->format('d M Y') }}</p>
                </div>
            </div>

            <div>
                <p class="text-xs font-medium text-gray-400 uppercase tracking-wide mb-1">Description</p>
                <p class="text-sm text-gray-700 break-words">{{ $draft->description }}</p>
            </div>

            @if($draft->has_parking || $draft->is_parking_free || $draft->needs_climbing_equipment || $draft->needs_helmet)
                <div>
                    <p class="text-xs font-medium text-gray-400 uppercase tracking-wide mb-2">Options</p>
                    <div class="flex flex-wrap gap-2">
                        @if($draft->has_parking)
                            <span class="px-2 py-0.5 text-xs rounded-full bg-gray-100 text-gray-600">Has parking</span>
                        @endif
                        @if($draft->is_parking_free)
                            <span class="px-2 py-0.5 text-xs rounded-full bg-gray-100 text-gray-600">Parking free</span>
                        @endif
                        @if($draft->needs_climbing_equipment)
                            <span class="px-2 py-0.5 text-xs rounded-full bg-gray-100 text-gray-600">Climbing equipment</span>
                        @endif
                        @if($draft->needs_helmet)
                            <span class="px-2 py-0.5 text-xs rounded-full bg-gray-100 text-gray-600">Helmet required</span>
                        @endif
                    </div>
                </div>
            @endif
        </div>

        {{-- Region section --}}
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6 mb-6">
            <h2 class="text-base font-semibold text-gray-900 mb-4">Region</h2>

            @if($draft->region)
                {{-- Region already linked --}}
                <div class="flex items-center gap-3 p-3 bg-green-50 border border-green-200 rounded-lg mb-4">
                    <div class="flex-1">
                        <p class="text-sm font-medium text-green-800">{{ $draft->region->name }}</p>
                        <p class="text-xs text-green-600 mt-0.5">Region linked — ready to add hike</p>
                    </div>
                    <span class="text-green-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                    </span>
                </div>

                <a
                    href="{{ route('admin.hikes.create', ['draft_id' => $draft->id]) }}"
                    class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-orange-500 hover:bg-orange-600 rounded-lg transition-colors"
                >
                    Add Hike
                </a>

            @else
                @if($draft->proposed_region_name)
                    <div class="mb-5 p-4 bg-amber-50 border border-amber-200 rounded-lg space-y-2">
                        <p class="text-xs font-medium text-amber-700 uppercase tracking-wide">Proposed region</p>
                        <p class="text-sm font-semibold text-gray-900">{{ $draft->proposed_region_name }}</p>
                        @if($draft->proposed_region_description)
                            <p class="text-sm text-gray-600 break-words">{{ $draft->proposed_region_description }}</p>
                        @endif
                    </div>

                    <a
                        href="{{ route('admin.regions.create', ['draft_id' => $draft->id]) }}"
                        class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-orange-500 hover:bg-orange-600 rounded-lg transition-colors"
                    >
                        Create region from proposal
                    </a>

                    <div class="relative my-5">
                        <div class="absolute inset-0 flex items-center"><div class="w-full border-t border-gray-200"></div></div>
                        <div class="relative flex justify-center"><span class="bg-white px-3 text-xs text-gray-400">or link an existing region instead</span></div>
                    </div>
                @else
                    <p class="text-sm text-gray-500 mb-4">No region was selected or proposed. Link one manually.</p>
                @endif

                <form method="POST" action="{{ route('admin.drafts.bindRegion', $draft) }}" class="flex items-end gap-3">
                    @csrf
                    @method('PATCH')
                    <div class="flex-1">
                        <label for="region_id" class="block text-xs font-medium text-gray-600 mb-1">Select existing region</label>
                        <select
                            id="region_id"
                            name="region_id"
                            required
                            class="border-gray-300 rounded-lg shadow-sm focus:border-orange-500 focus:ring-orange-500 text-sm w-full"
                        >
                            <option value="" disabled selected>— Choose region —</option>
                            @foreach($regions as $region)
                                <option value="{{ $region->id }}">{{ $region->name }}</option>
                            @endforeach
                        </select>
                        @error('region_id')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <button
                        type="submit"
                        class="px-4 py-2 text-sm font-medium text-white bg-gray-700 hover:bg-gray-800 rounded-lg transition-colors whitespace-nowrap"
                    >
                        Link region
                    </button>
                </form>

            @endif
        </div>

    </div>
</x-app-layout>
