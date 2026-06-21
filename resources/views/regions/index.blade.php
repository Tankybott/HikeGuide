<x-app-layout>
    <div x-data="{
        timer: null,
        loading: false,
        search: '{{ $search }}',
        country: '{{ $country }}',
        async load() {
            this.loading = true;
            const url = new URL(window.location.href);
            this.search  ? url.searchParams.set('search', this.search)   : url.searchParams.delete('search');
            this.country ? url.searchParams.set('country', this.country) : url.searchParams.delete('country');
            const res = await window.fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } });
            document.getElementById('regions-grid').innerHTML = await res.text();
            history.replaceState({}, '', url);
            this.loading = false;
        },
        debounce() {
            this.loading = true;
            clearTimeout(this.timer);
            this.timer = setTimeout(() => this.load(), 400);
        },
    }">

        <x-parallax-hero
            image="/storage/photos/hero1.jpg"
            title="Explore Regions"
            subtitle="Discover hiking destinations across all regions."
        />

        <div class="mb-8">
            <h1 class="sm:hidden text-3xl font-bold text-gray-900 mb-1 mt-2">Explore Regions</h1>
            <p class="sm:hidden text-gray-500 mb-6">Discover hiking destinations across all regions.</p>

            <div class="flex flex-wrap gap-2 mt-6">
                <input
                    type="text"
                    x-model="search"
                    @input="debounce()"
                    @keydown.enter.prevent="clearTimeout(timer); load()"
                    placeholder="Search regions…"
                    class="border-gray-300 rounded-lg shadow-sm focus:border-orange-500 focus:ring-orange-500 text-sm w-full sm:w-64"
                >

                @if(count($countries))
                    <select
                        x-model="country"
                        @change="load()"
                        class="border-gray-300 rounded-lg shadow-sm focus:border-orange-500 focus:ring-orange-500 text-sm"
                    >
                        <option value="">All countries</option>
                        @foreach($countries as $code => $name)
                            <option value="{{ $code }}" {{ $country === $code ? 'selected' : '' }}>{{ $name }}</option>
                        @endforeach
                    </select>
                @endif

                <button
                    type="button"
                    x-show="search || country"
                    @click="search = ''; country = ''; load()"
                    class="px-3 py-2 text-sm text-gray-500 hover:text-gray-700 transition-colors whitespace-nowrap"
                >
                    Clear
                </button>
            </div>
        </div>

        <div x-show="loading" class="mb-4 text-sm text-orange-500 font-medium">Loading...</div>

        <div
            id="regions-grid"
            class="transition-opacity"
            :class="{ 'opacity-40 pointer-events-none': loading }"
        >
            @include('regions.partials.grid')
        </div>

    </div>
</x-app-layout>
