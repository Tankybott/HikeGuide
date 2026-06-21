<x-app-layout>
    <div class="max-w-2xl mx-auto pt-8">

        <div class="flex items-center gap-3 mb-6">
            <a href="{{ route('hikes.index') }}" class="text-sm text-gray-500 hover:text-orange-600 transition-colors">← Hikes</a>
            <span class="text-gray-300">/</span>
            <h1 class="text-2xl font-bold text-gray-900">Propose a Hike</h1>
        </div>

        <form
            method="POST"
            action="{{ route('drafts.store') }}"
            x-data="{ proposeRegion: {{ old('proposed_region_name') ? 'true' : 'false' }} }"
        >
            @csrf

            {{-- Hike details --}}
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6 space-y-5 mb-6">
                <h2 class="text-base font-semibold text-gray-900">Hike Details</h2>

                <div>
                    <x-input-label for="title" :value="__('Title')" />
                    <x-text-input id="title" name="title" type="text" class="mt-1" :value="old('title')" required autofocus minlength="2" maxlength="100" />
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
                        <option value="" disabled {{ old('difficulty') ? '' : 'selected' }}>— Select difficulty —</option>
                        @foreach(['easy', 'moderate', 'hard'] as $level)
                            <option value="{{ $level }}" {{ old('difficulty') === $level ? 'selected' : '' }}>
                                {{ ucfirst($level) }}
                            </option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('difficulty')" class="mt-1" />
                </div>

                <div>
                    <x-input-label for="length_km" :value="__('Length (km)')" />
                    <x-text-input id="length_km" name="length_km" type="number" step="0.1" min="0.1" class="mt-1" :value="old('length_km')" />
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
                    >{{ old('description') }}</textarea>
                    <p class="mt-1 text-xs text-gray-400">100–1000 characters.</p>
                    <x-input-error :messages="$errors->get('description')" class="mt-1" />
                </div>

                <div class="space-y-3">
                    <p class="text-sm font-medium text-gray-700">Options</p>

                    <label class="flex items-center gap-2 text-sm text-gray-700 cursor-pointer">
                        <input type="checkbox" name="has_parking" value="1" {{ old('has_parking') ? 'checked' : '' }} class="rounded border-gray-300 text-orange-500 focus:ring-orange-400">
                        Has parking
                    </label>
                    <label class="flex items-center gap-2 text-sm text-gray-700 cursor-pointer">
                        <input type="checkbox" name="is_parking_free" value="1" {{ old('is_parking_free') ? 'checked' : '' }} class="rounded border-gray-300 text-orange-500 focus:ring-orange-400">
                        Parking is free
                    </label>
                    <label class="flex items-center gap-2 text-sm text-gray-700 cursor-pointer">
                        <input type="checkbox" name="needs_climbing_equipment" value="1" {{ old('needs_climbing_equipment') ? 'checked' : '' }} class="rounded border-gray-300 text-orange-500 focus:ring-orange-400">
                        Needs climbing equipment
                    </label>
                    <label class="flex items-center gap-2 text-sm text-gray-700 cursor-pointer">
                        <input type="checkbox" name="needs_helmet" value="1" {{ old('needs_helmet') ? 'checked' : '' }} class="rounded border-gray-300 text-orange-500 focus:ring-orange-400">
                        Needs helmet
                    </label>
                </div>
            </div>

            {{-- Region --}}
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6 space-y-5 mb-6">
                <h2 class="text-base font-semibold text-gray-900">Region</h2>

                <div x-show="!proposeRegion">
                    <x-input-label for="region_id" :value="__('Select existing region')" />
                    <select
                        id="region_id"
                        name="region_id"
                        class="mt-1 border-gray-300 rounded-lg shadow-sm focus:border-orange-500 focus:ring-orange-500 text-sm w-full"
                    >
                        <option value="">— None / I want to propose a new one —</option>
                        @foreach($regions as $region)
                            <option value="{{ $region->id }}" {{ (int) old('region_id') === $region->id ? 'selected' : '' }}>
                                {{ $region->name }}
                            </option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('region_id')" class="mt-1" />
                </div>

                <div>
                    <label class="flex items-center gap-2 text-sm text-gray-700 cursor-pointer">
                        <input
                            type="checkbox"
                            x-model="proposeRegion"
                            class="rounded border-gray-300 text-orange-500 focus:ring-orange-400"
                        >
                        Propose a new region
                    </label>
                </div>

                <div x-show="proposeRegion" class="space-y-4">
                    <div>
                        <x-input-label for="proposed_region_name" :value="__('Region name')" />
                        <x-text-input id="proposed_region_name" name="proposed_region_name" type="text" class="mt-1" :value="old('proposed_region_name')" maxlength="255" />
                        <x-input-error :messages="$errors->get('proposed_region_name')" class="mt-1" />
                    </div>
                    <div>
                        <x-input-label for="proposed_region_description" :value="__('Region description')" />
                        <textarea
                            id="proposed_region_description"
                            name="proposed_region_description"
                            rows="4"
                            class="mt-1 border-gray-300 rounded-lg shadow-sm focus:border-orange-500 focus:ring-orange-500 text-sm w-full"
                        >{{ old('proposed_region_description') }}</textarea>
                        <x-input-error :messages="$errors->get('proposed_region_description')" class="mt-1" />
                    </div>
                </div>
            </div>

            {{-- Actions --}}
            <div class="flex items-center justify-between">
                <a href="{{ route('hikes.index') }}" class="text-sm text-gray-500 hover:text-gray-700 transition-colors">
                    Cancel
                </a>
                <x-primary-button>
                    Submit Proposal
                </x-primary-button>
            </div>

        </form>
    </div>
</x-app-layout>
