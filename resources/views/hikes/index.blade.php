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
            document.getElementById('hikes-grid').innerHTML = await res.text();
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
            title="Explore Hikes"
            subtitle="Browse all available hiking trails."
        />

        <div class="mb-8 mt-6">
            <h1 class="sm:hidden text-3xl font-bold text-gray-900 mb-1 mt-2">Explore Hikes</h1>
            <p class="sm:hidden text-gray-500 mb-4">Browse all available hiking trails.</p>

            @auth
                <a href="{{ route('drafts.create') }}" class="sm:hidden block w-full text-center px-4 py-2 bg-orange-500 hover:bg-orange-600 text-white text-sm font-semibold rounded-lg transition-colors mb-3">
                    + Propose a Hike
                </a>
            @endauth

            <div class="flex flex-wrap gap-2 items-center">
                <input
                    type="text"
                    x-model="search"
                    @input="debounce()"
                    @keydown.enter.prevent="clearTimeout(timer); load()"
                    placeholder="Search hikes…"
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

                @auth
                    <a href="{{ route('drafts.create') }}" class="hidden sm:inline-flex ml-auto px-4 py-2 bg-orange-500 hover:bg-orange-600 text-white text-sm font-semibold rounded-lg transition-colors whitespace-nowrap">
                        + Propose a Hike
                    </a>
                @endauth
            </div>
        </div>

        <div x-show="loading" class="mb-4 text-sm text-orange-500 font-medium">Loading...</div>

        <div
            id="hikes-grid"
            class="transition-opacity"
            :class="{ 'opacity-40 pointer-events-none': loading }"
        >
            @include('hikes.partials.grid')
        </div>

    </div>
</x-app-layout>
