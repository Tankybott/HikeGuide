@if($hikes->isEmpty())
    <div class="text-center py-20 text-gray-400">
        {{ ($search || $country) ? 'No hikes match your filters.' : 'No hikes available yet.' }}
    </div>
@else
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($hikes as $hike)
            @php
                $photo = $hike->photos->firstWhere('is_main', true) ?? $hike->photos->first();
            @endphp
            <a href="{{ route('hikes.show', $hike) }}" class="group bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden hover:shadow-md hover:border-orange-200 transition-all">
                <div class="h-48 overflow-hidden">
                    @if($photo)
                        <img
                            src="{{ \Illuminate\Support\Facades\Storage::url($photo->path) }}"
                            alt="{{ $hike->title }}"
                            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
                        >
                    @else
                        <div class="w-full h-full bg-gradient-to-br from-orange-100 to-amber-200 flex items-center justify-center">
                            <svg class="w-16 h-16 text-orange-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 17l4-8 4 4 4-6 4 10H3z" />
                            </svg>
                        </div>
                    @endif
                </div>
                <div class="p-5">
                    <h2 class="font-bold text-gray-900 text-lg group-hover:text-orange-600 transition-colors mb-1">
                        {{ $hike->title }}
                    </h2>
                    <p class="text-xs text-gray-400 mb-3">{{ $hike->region->name }}</p>
                    <div class="flex items-center gap-3 text-xs text-gray-500">
                        <span class="capitalize px-2 py-0.5 rounded-full
                            {{ $hike->difficulty === 'easy' ? 'bg-green-100 text-green-700' : ($hike->difficulty === 'moderate' ? 'bg-yellow-100 text-yellow-700' : 'bg-red-100 text-red-700') }}">
                            {{ ucfirst($hike->difficulty) }}
                        </span>
                        @if($hike->length_km)
                            <span>{{ $hike->length_km }} km</span>
                        @endif
                    </div>
                    <span class="mt-3 inline-block text-xs font-semibold text-orange-600 group-hover:underline">View trail →</span>
                </div>
            </a>
        @endforeach
    </div>
@endif
