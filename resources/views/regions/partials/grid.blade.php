@if($regions->isEmpty())
    <div class="text-center py-20 text-gray-400">
        {{ ($search || $country) ? 'No regions match your filters.' : 'No regions available yet.' }}
    </div>
@else
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($regions as $region)
            @php
                $photo = $region->photos->firstWhere('is_main', true) ?? $region->photos->first();
            @endphp
            <a href="{{ route('regions.show', $region) }}" class="group bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden hover:shadow-md hover:border-orange-200 transition-all">
                <div class="h-48 overflow-hidden">
                    @if($photo)
                        <img
                            src="{{ \Illuminate\Support\Facades\Storage::url($photo->path) }}"
                            alt="{{ $region->name }}"
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
                    <div class="flex items-center justify-between mb-1">
                        <h2 class="font-bold text-gray-900 text-lg group-hover:text-orange-600 transition-colors">
                            {{ $region->name }}
                        </h2>
                        <span class="text-xs font-medium text-gray-400">{{ $region->country }}</span>
                    </div>
                    <p class="text-sm text-gray-500 line-clamp-2">{{ $region->short_description }}</p>
                    <span class="mt-3 inline-block text-xs font-semibold text-orange-600 group-hover:underline">Explore →</span>
                </div>
            </a>
        @endforeach
    </div>
@endif
