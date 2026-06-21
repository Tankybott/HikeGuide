<x-app-layout>
    <div class="max-w-2xl mx-auto pt-8">

        <div class="flex items-center gap-3 mb-6">
            @if(($draft ?? null) && !$hike)
                <a href="{{ route('admin.drafts.show', $draft) }}" class="text-sm text-gray-500 hover:text-orange-600 transition-colors">← Draft</a>
            @else
                <a href="{{ route('admin.hikes.index') }}" class="text-sm text-gray-500 hover:text-orange-600 transition-colors">← Hikes</a>
            @endif
            <span class="text-gray-300">/</span>
            <h1 class="text-2xl font-bold text-gray-900">{{ $hike ? 'Edit Hike' : 'Add Hike' }}</h1>
        </div>

        <form
            method="POST"
            action="{{ $hike ? route('admin.hikes.update', $hike) : route('admin.hikes.store') }}"
            enctype="multipart/form-data"
            x-data="{
                previews: [],
                handleFiles(event) {
                    this.previews = [];
                    const files = event.target.files;
                    for (let i = 0; i < files.length; i++) {
                        this.previews.push({ url: URL.createObjectURL(files[i]), index: i });
                    }
                }
            }"
        >
            @csrf
            @if($hike) @method('PATCH') @endif
            @if(($draft ?? null) && !$hike)
                <input type="hidden" name="draft_id" value="{{ $draft->id }}">
            @endif

            {{-- Fields --}}
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6 space-y-5 mb-6">

                <div>
                    <x-input-label for="region_id" :value="__('Region')" />
                    <select
                        id="region_id"
                        name="region_id"
                        required
                        class="mt-1 border-gray-300 rounded-lg shadow-sm focus:border-orange-500 focus:ring-orange-500 text-sm w-full"
                    >
                        <option value="" disabled {{ old('region_id', $hike?->region_id ?? ($draft ?? null)?->region_id) ? '' : 'selected' }}>— Select region —</option>
                        @foreach($regions as $region)
                            <option value="{{ $region->id }}" {{ (int) old('region_id', $hike?->region_id ?? ($draft ?? null)?->region_id) === $region->id ? 'selected' : '' }}>
                                {{ $region->name }}
                            </option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('region_id')" class="mt-1" />
                </div>

                <div>
                    <x-input-label for="title" :value="__('Title')" />
                    <x-text-input id="title" name="title" type="text" class="mt-1" :value="old('title', $hike?->title ?? ($draft ?? null)?->title)" required autofocus minlength="2" maxlength="100" />
                    <p class="mt-1 text-xs text-gray-400">2–100 characters.</p>
                    <x-input-error :messages="$errors->get('title')" class="mt-1" />
                </div>

                <div>
                    <x-input-label for="difficulty" :value="__('Difficulty')" />
                    <select
                        id="difficulty"
                        name="difficulty"
                        required
                        class="mt-1 border-gray-300 rounded-lg shadow-sm focus:border-orange-500 focus:ring-orange-500 text-sm w-full"
                    >
                        <option value="" disabled {{ old('difficulty', $hike?->difficulty ?? ($draft ?? null)?->difficulty) ? '' : 'selected' }}>— Select difficulty —</option>
                        @foreach(['easy', 'moderate', 'hard'] as $level)
                            <option value="{{ $level }}" {{ old('difficulty', $hike?->difficulty ?? ($draft ?? null)?->difficulty) === $level ? 'selected' : '' }}>
                                {{ ucfirst($level) }}
                            </option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('difficulty')" class="mt-1" />
                </div>

                <div>
                    <x-input-label for="length_km" :value="__('Length (km)')" />
                    <x-text-input id="length_km" name="length_km" type="number" step="0.1" min="0.1" class="mt-1" :value="old('length_km', $hike?->length_km ?? ($draft ?? null)?->length_km)" />
                    <p class="mt-1 text-xs text-gray-400">Optional. Must be greater than 0.</p>
                    <x-input-error :messages="$errors->get('length_km')" class="mt-1" />
                </div>

                <div>
                    <x-input-label for="description" :value="__('Description')" />
                    <textarea
                        id="description"
                        name="description"
                        rows="6"
                        required
                        class="mt-1 border-gray-300 rounded-lg shadow-sm focus:border-orange-500 focus:ring-orange-500 text-sm w-full"
                    >{{ old('description', $hike?->description ?? ($draft ?? null)?->description) }}</textarea>
                    <p class="mt-1 text-xs text-gray-400">100–1000 characters.</p>
                    <x-input-error :messages="$errors->get('description')" class="mt-1" />
                </div>

                {{-- Checkboxes --}}
                <div class="space-y-3">
                    <p class="text-sm font-medium text-gray-700">Options</p>

                    <label class="flex items-center gap-2 text-sm text-gray-700 cursor-pointer">
                        <input
                            type="checkbox"
                            name="has_parking"
                            value="1"
                            {{ old('has_parking', $hike?->has_parking ?? ($draft ?? null)?->has_parking) ? 'checked' : '' }}
                            class="rounded border-gray-300 text-orange-500 focus:ring-orange-400"
                        >
                        Has parking
                    </label>

                    <label class="flex items-center gap-2 text-sm text-gray-700 cursor-pointer">
                        <input
                            type="checkbox"
                            name="is_parking_free"
                            value="1"
                            {{ old('is_parking_free', $hike?->is_parking_free ?? ($draft ?? null)?->is_parking_free) ? 'checked' : '' }}
                            class="rounded border-gray-300 text-orange-500 focus:ring-orange-400"
                        >
                        Parking is free
                    </label>

                    <label class="flex items-center gap-2 text-sm text-gray-700 cursor-pointer">
                        <input
                            type="checkbox"
                            name="needs_climbing_equipment"
                            value="1"
                            {{ old('needs_climbing_equipment', $hike?->needs_climbing_equipment ?? ($draft ?? null)?->needs_climbing_equipment) ? 'checked' : '' }}
                            class="rounded border-gray-300 text-orange-500 focus:ring-orange-400"
                        >
                        Needs climbing equipment
                    </label>

                    <label class="flex items-center gap-2 text-sm text-gray-700 cursor-pointer">
                        <input
                            type="checkbox"
                            name="needs_helmet"
                            value="1"
                            {{ old('needs_helmet', $hike?->needs_helmet ?? ($draft ?? null)?->needs_helmet) ? 'checked' : '' }}
                            class="rounded border-gray-300 text-orange-500 focus:ring-orange-400"
                        >
                        Needs helmet
                    </label>
                </div>

            </div>

            {{-- Photos --}}
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6 mb-6">
                <h2 class="text-base font-semibold text-gray-900 mb-4">Photos</h2>

                {{-- Existing photos --}}
                @if($hike && $hike->photos->count())
                    <p class="text-xs font-medium text-gray-500 uppercase tracking-wide mb-3">Current photos</p>
                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-3 mb-6">
                        @foreach($hike->photos as $photo)
                            <div class="rounded-lg overflow-hidden border border-gray-200">
                                <div class="h-36 overflow-hidden bg-gray-100">
                                    <img
                                        src="{{ \Illuminate\Support\Facades\Storage::url($photo->path) }}"
                                        alt=""
                                        class="w-full h-full object-cover"
                                    >
                                </div>
                                <div class="p-2 flex items-center justify-between bg-white">
                                    <label class="flex items-center gap-1.5 text-xs text-gray-700 cursor-pointer">
                                        <input
                                            type="radio"
                                            name="main_photo"
                                            value="{{ $photo->id }}"
                                            {{ $photo->is_main ? 'checked' : '' }}
                                            class="text-orange-500 focus:ring-orange-500"
                                        >
                                        Main
                                    </label>
                                    <label class="flex items-center gap-1.5 text-xs text-red-500 cursor-pointer">
                                        <input
                                            type="checkbox"
                                            name="delete_photos[]"
                                            value="{{ $photo->id }}"
                                            class="rounded border-gray-300 text-red-500 focus:ring-red-400"
                                        >
                                        Delete
                                    </label>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif

                {{-- Upload new --}}
                <p class="text-xs font-medium text-gray-500 uppercase tracking-wide mb-2">
                    {{ $hike && $hike->photos->count() ? 'Add more photos' : 'Upload photos' }}
                </p>
                <input
                    type="file"
                    name="photos[]"
                    multiple
                    accept="image/*"
                    @change="handleFiles($event)"
                    class="block w-full text-sm text-gray-500
                        file:mr-4 file:py-2 file:px-4
                        file:rounded-lg file:border-0
                        file:text-sm file:font-semibold
                        file:bg-orange-50 file:text-orange-600
                        hover:file:bg-orange-100 transition-colors cursor-pointer"
                >
                <x-input-error :messages="$errors->get('photos.*')" class="mt-2" />

                {{-- New photo previews --}}
                <div x-show="previews.length" class="grid grid-cols-2 sm:grid-cols-3 gap-3 mt-4">
                    <template x-for="photo in previews" :key="photo.index">
                        <div class="rounded-lg overflow-hidden border border-orange-200">
                            <div class="h-36 overflow-hidden bg-gray-100">
                                <img :src="photo.url" class="w-full h-full object-cover">
                            </div>
                            <div class="p-2 bg-white">
                                <label class="flex items-center gap-1.5 text-xs text-gray-700 cursor-pointer">
                                    <input
                                        type="radio"
                                        name="main_photo"
                                        :value="'new_' + photo.index"
                                        class="text-orange-500 focus:ring-orange-500"
                                    >
                                    Main
                                </label>
                            </div>
                        </div>
                    </template>
                </div>
            </div>

            {{-- Actions --}}
            <div class="flex items-center justify-between">
                <a href="{{ (($draft ?? null) && !$hike) ? route('admin.drafts.show', $draft) : route('admin.hikes.index') }}" class="text-sm text-gray-500 hover:text-gray-700 transition-colors">
                    Cancel
                </a>
                <x-primary-button>
                    {{ $hike ? 'Save Changes' : 'Add Hike' }}
                </x-primary-button>
            </div>

        </form>
    </div>
</x-app-layout>
