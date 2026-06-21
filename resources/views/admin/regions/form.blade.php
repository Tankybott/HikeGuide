<x-app-layout>
    <div class="max-w-2xl mx-auto pt-8">

        <div class="flex items-center gap-3 mb-6">
            @if($draft ?? null)
                <a href="{{ route('admin.drafts.show', $draft) }}" class="text-sm text-gray-500 hover:text-orange-600 transition-colors">← Draft</a>
            @else
                <a href="{{ route('admin.regions.index') }}" class="text-sm text-gray-500 hover:text-orange-600 transition-colors">← Regions</a>
            @endif
            <span class="text-gray-300">/</span>
            <h1 class="text-2xl font-bold text-gray-900">{{ $region ? 'Edit Region' : 'Add Region' }}</h1>
        </div>

        <form
            method="POST"
            action="{{ $region ? route('admin.regions.update', $region) : route('admin.regions.store') }}"
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
            @if($region) @method('PATCH') @endif
            @if(($draft ?? null) && !$region)
                <input type="hidden" name="draft_id" value="{{ $draft->id }}">
            @endif

            {{-- Fields --}}
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6 space-y-5 mb-6">
                <div>
                    <x-input-label for="name" :value="__('Name')" />
                    <x-text-input id="name" name="name" type="text" class="mt-1" :value="old('name', $region?->name ?? ($draft ?? null)?->proposed_region_name)" required autofocus />
                    <x-input-error :messages="$errors->get('name')" class="mt-1" />
                </div>

                <div>
                    <x-input-label for="country" :value="__('Country')" />
                    <select
                        id="country"
                        name="country"
                        class="mt-1 border-gray-300 rounded-lg shadow-sm focus:border-orange-500 focus:ring-orange-500 text-sm w-full"
                    >
                        <option value="" disabled {{ old('country', $region?->country) ? '' : 'selected' }}>— Select country —</option>
                        @foreach($countries as $code => $name)
                            <option value="{{ $code }}" {{ old('country', $region?->country) === $code ? 'selected' : '' }}>
                                {{ $name }}
                            </option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('country')" class="mt-1" />
                </div>

                <div>
                    <x-input-label for="short_description" :value="__('Short Description')" />
                    <x-text-input id="short_description" name="short_description" type="text" class="mt-1" :value="old('short_description', $region?->short_description)" required />
                    <p class="mt-1 text-xs text-gray-400">Shown on region tiles. Max 500 characters.</p>
                    <x-input-error :messages="$errors->get('short_description')" class="mt-1" />
                </div>

                <div>
                    <x-input-label for="description" :value="__('Description')" />
                    <textarea
                        id="description"
                        name="description"
                        rows="6"
                        required
                        class="mt-1 border-gray-300 rounded-lg shadow-sm focus:border-orange-500 focus:ring-orange-500 text-sm w-full"
                    >{{ old('description', $region?->description ?? ($draft ?? null)?->proposed_region_description) }}</textarea>
                    <x-input-error :messages="$errors->get('description')" class="mt-1" />
                </div>
            </div>

            {{-- Photos --}}
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6 mb-6">
                <h2 class="text-base font-semibold text-gray-900 mb-4">Photos</h2>

                {{-- Existing photos --}}
                @if($region && $region->photos->count())
                    <p class="text-xs font-medium text-gray-500 uppercase tracking-wide mb-3">Current photos</p>
                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-3 mb-6">
                        @foreach($region->photos as $photo)
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
                    {{ $region && $region->photos->count() ? 'Add more photos' : 'Upload photos' }}
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
                <a href="{{ (($draft ?? null) && !$region) ? route('admin.drafts.show', $draft) : route('admin.regions.index') }}" class="text-sm text-gray-500 hover:text-gray-700 transition-colors">
                    Cancel
                </a>
                <x-primary-button>
                    {{ $region ? 'Save Changes' : 'Add Region' }}
                </x-primary-button>
            </div>

        </form>
    </div>
</x-app-layout>
