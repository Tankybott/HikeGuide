<x-app-layout>
    <div class="pt-8" x-data="{
        timer: null,
        loading: false,
        showDelete: false,
        deleteId: null,
        deleteName: '',
        async load(query) {
            this.loading = true;
            const url = new URL(window.location.href);
            query ? url.searchParams.set('search', query) : url.searchParams.delete('search');
            const res = await window.fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } });
            document.getElementById('regions-results').innerHTML = await res.text();
            history.replaceState({}, '', url);
            this.loading = false;
        },
        debounce(query) {
            this.loading = true;
            clearTimeout(this.timer);
            this.timer = setTimeout(() => this.load(query), 2000);
        },
        openDelete(id, name) {
            this.deleteId = id;
            this.deleteName = name;
            this.showDelete = true;
        },
    }">

        {{-- Header --}}
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold text-gray-900">Regions</h1>
            <a href="{{ route('admin.regions.create') }}" class="px-4 py-2 bg-orange-500 hover:bg-orange-600 text-white text-sm font-semibold rounded-lg transition-colors">
                + Add Region
            </a>
        </div>

        {{-- Search --}}
        <div class="mb-6 flex gap-2 max-w-sm">
            <input
                type="text"
                value="{{ $search }}"
                placeholder="Search by name…"
                class="border-gray-300 rounded-lg shadow-sm focus:border-orange-500 focus:ring-orange-500 text-sm w-full"
                @input="debounce($el.value)"
                @keydown.enter.prevent="clearTimeout(timer); load($el.value)"
            >
            @if($search)
                <button
                    type="button"
                    @click="$el.previousElementSibling.value = ''; load('')"
                    class="px-3 py-2 text-sm text-gray-500 hover:text-gray-700 transition-colors whitespace-nowrap"
                >
                    Clear
                </button>
            @endif
        </div>

        {{-- Loading indicator --}}
        <div x-show="loading" class="mb-2 text-sm text-orange-500 font-medium">Loading...</div>

        {{-- Results --}}
        <div
            id="regions-results"
            class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden transition-opacity"
            :class="{ 'opacity-40 pointer-events-none': loading }"
        >
            @include('admin.regions.partials.table')
        </div>

        {{-- Delete Modal --}}
        <div
            x-show="showDelete"
            x-cloak
            @keydown.escape.window="showDelete = false"
            class="fixed inset-0 z-50 flex items-center justify-center"
        >
            <div class="absolute inset-0 bg-black/40" @click="showDelete = false"></div>
            <div
                x-transition:enter="transition ease-out duration-150"
                x-transition:enter-start="opacity-0 scale-95"
                x-transition:enter-end="opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-100"
                x-transition:leave-start="opacity-100 scale-100"
                x-transition:leave-end="opacity-0 scale-95"
                class="relative bg-white rounded-xl shadow-xl w-full max-w-sm mx-4 p-6"
            >
                <h2 class="text-lg font-semibold text-gray-900 mb-2">Delete Region</h2>
                <p class="text-sm text-gray-500 mb-6">
                    Are you sure you want to delete <span class="font-medium text-gray-800" x-text="deleteName"></span>?
                    This cannot be undone.
                </p>
                <form :action="'/admin/regions/' + deleteId" method="POST">
                    @csrf
                    @method('DELETE')
                    <div class="flex justify-end gap-3">
                        <button type="button" @click="showDelete = false" class="px-4 py-2 text-sm font-medium text-gray-600 hover:text-gray-800 transition-colors">
                            Cancel
                        </button>
                        <button type="submit" class="px-4 py-2 bg-red-500 hover:bg-red-600 text-white text-sm font-semibold rounded-lg transition-colors">
                            Delete
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</x-app-layout>
