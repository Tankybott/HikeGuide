<x-app-layout>
    <div class="max-w-5xl mx-auto pt-8">

        {{-- Back --}}
        <div class="mb-5">
            <a href="{{ route('regions.index') }}" class="text-sm text-gray-500 hover:text-orange-600 transition-colors">← All regions</a>
        </div>

        {{-- Title --}}
        <div class="flex items-start justify-between gap-4 mb-6">
            <h1 class="text-3xl font-bold text-gray-900">{{ $region->name }}</h1>
            <span class="mt-1 flex-shrink-0 text-sm font-medium text-gray-400 bg-gray-100 px-3 py-1 rounded-full">{{ $region->country }}</span>
        </div>

        {{-- Photo gallery --}}
        @if($photos->count())
            @php
                $photoUrls = $photos->map(fn($p) => \Illuminate\Support\Facades\Storage::url($p->path))->values();
                $mainIndex = $photos->search(fn($p) => $p->id === $mainPhoto->id);
            @endphp
            <div
                class="mb-8 h-full"
                x-data='{ "current": {{ $mainIndex }}, "photos": @json($photoUrls) }'
            >
                {{-- Main photo --}}
                <div class="rounded-xl overflow-hidden h-64 sm:h-80 lg:h-[60vh] bg-gray-100 mb-4">
                    <img
                        :src="photos[current]"
                        alt="{{ $region->name }}"
                        class="w-full h-full object-contain"
                    >
                </div>

                {{-- Thumbnails --}}
                @if($photos->count() > 1)
                    <div class="flex gap-2 overflow-x-auto p-3 pl-1">
                        @foreach($photos as $i => $photo)
                            <button
                                type="button"
                                @click="current = {{ $i }}"
                                :class="current === {{ $i }}
                                    ? 'ring-2 ring-offset-1 ring-green-500'
                                    : 'ring-1 ring-gray-200 opacity-70 hover:opacity-100'"
                                class="flex-shrink-0 w-16 h-16 sm:w-20 sm:h-20 rounded-lg overflow-hidden bg-gray-100 transition-all duration-150 cursor-pointer focus:outline-none"
                            >
                                <img
                                    src="{{ \Illuminate\Support\Facades\Storage::url($photo->path) }}"
                                    alt=""
                                    class="w-full h-full object-cover"
                                >
                            </button>
                        @endforeach
                    </div>
                @endif
            </div>
        @else
            <div class="rounded-xl h-56 sm:h-72 bg-gradient-to-br from-orange-100 to-amber-200 flex items-center justify-center mb-8">
                <svg class="w-20 h-20 text-orange-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 17l4-8 4 4 4-6 4 10H3z" />
                </svg>
            </div>
        @endif

        {{-- Description --}}
        <div class="mb-10">
            <p class="text-gray-600 leading-relaxed">{{ $region->description }}</p>
        </div>

        {{-- Hikes --}}
        <div>
            <h2 class="text-xl font-bold text-gray-900 mb-4">
                Hikes in this region
                <span class="ml-2 text-base font-normal text-gray-400">({{ $region->hikes->count() }})</span>
            </h2>

            @if($region->hikes->isEmpty())
                <div class="bg-white rounded-xl border border-gray-200 px-6 py-12 text-center text-gray-400 text-sm">
                    No hikes listed for this region yet.
                </div>
            @else
                <div class="space-y-4">
                    @foreach($region->hikes as $hike)
                        @php
                            $hikePhoto = $hike->photos->firstWhere('is_main', true) ?? $hike->photos->first();
                            $difficultyColor = match($hike->difficulty) {
                                'easy'     => 'bg-green-100 text-green-700',
                                'moderate' => 'bg-amber-100 text-amber-700',
                                'hard'     => 'bg-red-100 text-red-700',
                                default    => 'bg-gray-100 text-gray-600',
                            };
                        @endphp
                        <a href="{{ route('hikes.show', $hike) }}" class="group flex gap-4 bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden hover:shadow-md hover:border-orange-200 transition-all">
                            <div class="flex-shrink-0 w-28 sm:w-36 bg-gray-100 overflow-hidden">
                                @if($hikePhoto)
                                    <img
                                        src="{{ \Illuminate\Support\Facades\Storage::url($hikePhoto->path) }}"
                                        alt="{{ $hike->title }}"
                                        class="w-full h-full object-cover"
                                    >
                                @else
                                    <div class="w-full h-full min-h-[90px] bg-gradient-to-br from-orange-100 to-amber-100 flex items-center justify-center">
                                        <svg class="w-8 h-8 text-orange-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 7l4.5 4.5L12 6l4.5 5.5L21 7v10H4V7z" />
                                        </svg>
                                    </div>
                                @endif
                            </div>

                            <div class="flex-1 py-4 pr-4 min-w-0">
                                <div class="flex flex-wrap items-center gap-2 mb-1">
                                    <h3 class="font-semibold text-gray-900 group-hover:text-orange-600 transition-colors truncate">{{ $hike->title }}</h3>
                                    <span class="flex-shrink-0 inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium {{ $difficultyColor }}">
                                        {{ ucfirst($hike->difficulty) }}
                                    </span>
                                    @if($hike->length_km)
                                        <span class="flex-shrink-0 text-xs text-gray-400">{{ $hike->length_km }} km</span>
                                    @endif
                                </div>
                                <p class="text-sm text-gray-500 line-clamp-2">{{ $hike->description }}</p>

                                @if($hike->has_parking || $hike->needs_climbing_equipment || $hike->needs_helmet)
                                    <div class="flex flex-wrap gap-1.5 mt-2">
                                        @if($hike->has_parking)
                                            <span class="text-xs text-gray-400 bg-gray-50 border border-gray-200 rounded px-1.5 py-0.5">Parking</span>
                                        @endif
                                        @if($hike->needs_climbing_equipment)
                                            <span class="text-xs text-gray-400 bg-gray-50 border border-gray-200 rounded px-1.5 py-0.5">Climbing gear</span>
                                        @endif
                                        @if($hike->needs_helmet)
                                            <span class="text-xs text-gray-400 bg-gray-50 border border-gray-200 rounded px-1.5 py-0.5">Helmet</span>
                                        @endif
                                    </div>
                                @endif
                            </div>
                        </a>
                    @endforeach
                </div>
            @endif
        </div>

    </div>
</x-app-layout>
