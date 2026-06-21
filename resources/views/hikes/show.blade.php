<x-app-layout>
    <div class="max-w-4xl mx-auto pt-8">

        {{-- Back --}}
        <div class="mb-5">
            <a href="{{ route('hikes.index') }}" class="text-sm text-gray-500 hover:text-orange-600 transition-colors">← All hikes</a>
        </div>

        {{-- Title --}}
        <div class="flex flex-wrap items-start justify-between gap-3 mb-6">
            <h1 class="text-3xl font-bold text-gray-900">{{ $hike->title }}</h1>
            @php
                $difficultyColor = match($hike->difficulty) {
                    'easy'     => 'bg-green-100 text-green-700',
                    'moderate' => 'bg-amber-100 text-amber-700',
                    'hard'     => 'bg-red-100 text-red-700',
                    default    => 'bg-gray-100 text-gray-600',
                };
            @endphp
            <span class="mt-1 flex-shrink-0 inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $difficultyColor }}">
                {{ ucfirst($hike->difficulty) }}
            </span>
        </div>

        {{-- Photo gallery --}}
        @if($photos->count())
            @php
                $photoUrls  = $photos->map(fn($p) => \Illuminate\Support\Facades\Storage::url($p->path))->values();
                $mainIndex  = $photos->search(fn($p) => $p->id === $mainPhoto->id);
            @endphp
            <div
                class="mb-8"
                x-data='{ "current": {{ $mainIndex }}, "photos": @json($photoUrls) }'
            >
                <div class="rounded-xl overflow-hidden h-64 sm:h-80 lg:h-[60vh] bg-gray-100 mb-4">
                    <img
                        :src="photos[current]"
                        alt="{{ $hike->title }}"
                        class="w-full h-full object-contain"
                    >
                </div>

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

        {{-- Meta & description --}}
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6 mb-8">
            <div class="flex flex-wrap gap-x-6 gap-y-2 text-sm text-gray-500 mb-4">
                @if($hike->region)
                    <a href="{{ route('regions.show', $hike->region) }}" class="hover:text-orange-600 transition-colors font-medium">
                        Region: {{ $hike->region->name }}
                    </a>
                @endif
                @if($hike->length_km)
                    <span>{{ $hike->length_km }} km</span>
                @endif
                @if($hike->has_parking)
                    <span>Parking available{{ $hike->is_parking_free ? ' (free)' : '' }}</span>
                @endif
                @if($hike->needs_climbing_equipment)
                    <span>Climbing gear required</span>
                @endif
                @if($hike->needs_helmet)
                    <span>Helmet required</span>
                @endif
            </div>
            <p class="text-gray-700 leading-relaxed">{{ $hike->description }}</p>
        </div>

        {{-- Reviews --}}
        <div>
            <h2 class="text-xl font-bold text-gray-900 mb-5 flex items-baseline gap-3">
                Reviews
                @if($hike->reviews->isNotEmpty())
                    <span class="text-amber-400 font-semibold text-base">★ {{ number_format($hike->reviews->avg('rate'), 1) }}</span>
                    <span class="text-gray-400 text-sm font-normal">({{ $hike->reviews->count() }})</span>
                @endif
            </h2>

            {{-- Add review form --}}
            @auth
                @if(!$userReview)
                    <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6 mb-6"
                         x-data="{ stars: {{ old('rate', 0) }} }">
                        <h3 class="text-sm font-semibold text-gray-700 mb-4">Leave a review</h3>

                        <form method="POST" action="{{ route('reviews.store', $hike) }}" enctype="multipart/form-data">
                            @csrf

                            <div class="mb-4">
                                <div class="flex gap-1 mb-1">
                                    @for($s = 1; $s <= 5; $s++)
                                        <button
                                            type="button"
                                            @click="stars = {{ $s }}"
                                            :class="stars >= {{ $s }} ? 'text-amber-400' : 'text-gray-300'"
                                            class="text-3xl leading-none transition-colors"
                                        >★</button>
                                    @endfor
                                </div>
                                <input type="hidden" name="rate" :value="stars">
                                @error('rate') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                            </div>

                            <div class="mb-4">
                                <textarea
                                    name="message"
                                    rows="4"
                                    placeholder="Share your experience…"
                                    class="border-gray-300 rounded-lg shadow-sm focus:border-orange-500 focus:ring-orange-500 text-sm w-full"
                                >{{ old('message') }}</textarea>
                                <p class="mt-1 text-xs text-gray-400">10–1000 characters.</p>
                                @error('message') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                            </div>

                            <div class="mb-4">
                                <label class="block text-xs text-gray-500 mb-1">Photos · optional, up to 5, max 10 MB each</label>
                                <input
                                    type="file"
                                    name="photos[]"
                                    multiple
                                    accept="image/*"
                                    class="text-sm text-gray-500 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-orange-50 file:text-orange-700 hover:file:bg-orange-100 cursor-pointer"
                                >
                                @error('photos') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                                @error('photos.*') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                            </div>

                            <x-primary-button>Submit review</x-primary-button>
                        </form>
                    </div>
                @endif
            @else
                <div class="bg-gray-50 border border-gray-200 rounded-xl px-5 py-4 text-sm text-gray-500 mb-6">
                    <a href="{{ route('login') }}" class="text-orange-600 hover:underline font-medium">Log in</a> to leave a review.
                </div>
            @endauth

            {{-- User's own review --}}
            @if($userReview)
                <div
                    class="bg-white rounded-xl border-2 border-orange-200 shadow-sm p-6 mb-4"
                    x-data="{ editing: {{ $errors->any() && old('_method') === 'PATCH' ? 'true' : 'false' }} }"
                >
                    {{-- View mode --}}
                    <div x-show="!editing">
                        <div class="flex items-start justify-between gap-3 mb-3">
                            <div>
                                <div class="flex gap-0.5 mb-1">
                                    @for($s = 1; $s <= 5; $s++)
                                        <span class="text-lg {{ $userReview->rate >= $s ? 'text-amber-400' : 'text-gray-300' }}">★</span>
                                    @endfor
                                </div>
                                <p class="text-xs text-gray-400">You · {{ $userReview->created_at->format('d M Y') }}</p>
                            </div>
                            <div class="flex gap-2 flex-shrink-0">
                                <button
                                    @click="editing = true"
                                    class="text-xs text-gray-500 hover:text-gray-700 px-2 py-1 rounded transition-colors"
                                >Edit</button>
                                <form method="POST" action="{{ route('reviews.destroy', $userReview) }}">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-xs text-red-500 hover:text-red-700 px-2 py-1 rounded transition-colors">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                        <p class="text-sm text-gray-700">{{ $userReview->message }}</p>
                        @if($userReview->photos->isNotEmpty())
                            <div class="flex flex-wrap gap-2 mt-3">
                                @foreach($userReview->photos as $photo)
                                    <a href="{{ \Illuminate\Support\Facades\Storage::url($photo->path) }}" class="glightbox" data-gallery="review-{{ $userReview->id }}">
                                        <img src="{{ \Illuminate\Support\Facades\Storage::url($photo->path) }}" class="w-20 h-20 rounded-lg object-cover" alt="">
                                    </a>
                                @endforeach
                            </div>
                        @endif
                    </div>

                    {{-- Edit mode --}}
                    <div x-show="editing" x-data="{ stars: {{ old('rate', $userReview->rate) }} }">
                        <form method="POST" action="{{ route('reviews.update', $userReview) }}" enctype="multipart/form-data">
                            @csrf @method('PATCH')

                            <div class="mb-4">
                                <div class="flex gap-1 mb-1">
                                    @for($s = 1; $s <= 5; $s++)
                                        <button
                                            type="button"
                                            @click="stars = {{ $s }}"
                                            :class="stars >= {{ $s }} ? 'text-amber-400' : 'text-gray-300'"
                                            class="text-3xl leading-none transition-colors"
                                        >★</button>
                                    @endfor
                                </div>
                                <input type="hidden" name="rate" :value="stars">
                                @error('rate') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                            </div>

                            <div class="mb-4">
                                <textarea
                                    name="message"
                                    rows="4"
                                    class="border-gray-300 rounded-lg shadow-sm focus:border-orange-500 focus:ring-orange-500 text-sm w-full"
                                >{{ old('message', $userReview->message) }}</textarea>
                                @error('message') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                            </div>

                            <div class="mb-4">
                                @if($userReview->photos->isNotEmpty())
                                    <p class="text-xs text-gray-400 mb-2">Current photos — upload below to replace them</p>
                                    <div class="flex flex-wrap gap-2 mb-3">
                                        @foreach($userReview->photos as $photo)
                                            <img src="{{ \Illuminate\Support\Facades\Storage::url($photo->path) }}" class="w-16 h-16 rounded-lg object-cover" alt="">
                                        @endforeach
                                    </div>
                                @endif
                                <label class="block text-xs text-gray-500 mb-1">
                                    {{ $userReview->photos->isNotEmpty() ? 'New photos · replaces existing set, up to 5, max 10 MB each' : 'Photos · optional, up to 5, max 10 MB each' }}
                                </label>
                                <input
                                    type="file"
                                    name="photos[]"
                                    multiple
                                    accept="image/*"
                                    class="text-sm text-gray-500 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-orange-50 file:text-orange-700 hover:file:bg-orange-100 cursor-pointer"
                                >
                                @error('photos') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                                @error('photos.*') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                            </div>

                            <div class="flex gap-3">
                                <x-primary-button>Save</x-primary-button>
                                <button
                                    type="button"
                                    @click="editing = false"
                                    class="text-sm text-gray-500 hover:text-gray-700 transition-colors"
                                >Cancel</button>
                            </div>
                        </form>
                    </div>
                </div>
            @endif

            {{-- Other reviews --}}
            @if($otherReviews->isEmpty() && !$userReview)
                <div class="bg-white rounded-xl border border-gray-200 px-6 py-12 text-center text-gray-400 text-sm">
                    No reviews yet. Be the first!
                </div>
            @elseif($otherReviews->isNotEmpty())
                <div x-data="{ showAll: false }">
                    @foreach($otherReviews as $i => $review)
                        <div
                            class="bg-white rounded-xl border border-gray-200 shadow-sm p-5 mb-3"
                            @if($i >= 5) x-show="showAll" style="display:none" @endif
                        >
                            <div class="flex items-start justify-between gap-3 mb-2">
                                <div>
                                    <div class="flex gap-0.5 mb-1">
                                        @for($s = 1; $s <= 5; $s++)
                                            <span class="text-base {{ $review->rate >= $s ? 'text-amber-400' : 'text-gray-300' }}">★</span>
                                        @endfor
                                    </div>
                                    <p class="text-xs text-gray-400">{{ $review->user->nickname }} · {{ $review->created_at->format('d M Y') }}</p>
                                </div>
                                @if(Auth::check() && Auth::user()->is_admin)
                                    <form method="POST" action="{{ route('reviews.destroy', $review) }}" class="flex-shrink-0">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-xs text-red-500 hover:text-red-700 px-2 py-1 rounded transition-colors">
                                            Delete
                                        </button>
                                    </form>
                                @endif
                            </div>
                            <p class="text-sm text-gray-700">{{ $review->message }}</p>
                            @if($review->photos->isNotEmpty())
                                <div class="flex flex-wrap gap-2 mt-3">
                                    @foreach($review->photos as $photo)
                                        <a href="{{ \Illuminate\Support\Facades\Storage::url($photo->path) }}" class="glightbox" data-gallery="review-{{ $review->id }}">
                                            <img src="{{ \Illuminate\Support\Facades\Storage::url($photo->path) }}" class="w-20 h-20 rounded-lg object-cover" alt="">
                                        </a>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    @endforeach

                    @if($otherReviews->count() > 5)
                        <button
                            x-show="!showAll"
                            @click="showAll = true"
                            class="w-full mt-1 py-3 text-sm font-medium text-orange-600 hover:text-orange-700 bg-white border border-gray-200 rounded-xl hover:border-orange-200 transition-colors"
                        >
                            Show all {{ $otherReviews->count() }} reviews
                        </button>
                    @endif
                </div>
            @endif
        </div>

    </div>

    <link href="https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/glightbox/dist/js/glightbox.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            GLightbox({ selector: '.glightbox' });
        });
    </script>
</x-app-layout>
