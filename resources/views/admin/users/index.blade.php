<x-app-layout>
    <div class="pt-8">

        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold text-gray-900">Users</h1>
        </div>

        <form method="GET" action="{{ route('admin.users.index') }}" class="mb-4 flex gap-2">
            <input
                type="text"
                name="search"
                value="{{ $search }}"
                placeholder="Search by nickname or email…"
                class="border-gray-300 rounded-lg shadow-sm focus:border-orange-500 focus:ring-orange-500 text-sm w-full sm:w-80"
            >
            <button type="submit" class="px-4 py-2 bg-orange-500 hover:bg-orange-600 text-white text-sm font-semibold rounded-lg transition-colors">
                Search
            </button>
            @if($search)
                <a href="{{ route('admin.users.index') }}" class="px-4 py-2 text-sm text-gray-500 hover:text-gray-700 transition-colors">
                    Clear
                </a>
            @endif
        </form>

        <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
            @if($users->isEmpty())
                <div class="px-6 py-12 text-center text-gray-400 text-sm">
                    {{ $search ? 'No users match your search.' : 'No users found.' }}
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="border-b border-gray-100 bg-gray-50 text-left">
                                <th class="px-6 py-3 font-semibold text-gray-600">Nickname</th>
                                <th class="px-6 py-3 font-semibold text-gray-600">Email</th>
                                <th class="px-6 py-3 font-semibold text-gray-600">Joined</th>
                                <th class="px-6 py-3 font-semibold text-gray-600">Status</th>
                                <th class="px-6 py-3 font-semibold text-gray-600 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($users as $user)
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-6 py-4 font-medium text-gray-900">{{ $user->nickname }}</td>
                                    <td class="px-6 py-4 text-gray-500">{{ $user->email }}</td>
                                    <td class="px-6 py-4 text-gray-400 text-xs">{{ $user->created_at->format('d M Y') }}</td>
                                    <td class="px-6 py-4">
                                        @if($user->is_banned)
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-700">Banned</span>
                                        @else
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-700">Active</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        @if($user->is_banned)
                                            <form method="POST" action="{{ route('admin.users.unban', $user) }}">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="px-3 py-1.5 text-xs font-medium text-green-700 bg-green-50 hover:bg-green-100 rounded-md transition-colors">
                                                    Unban
                                                </button>
                                            </form>
                                        @else
                                            <form method="POST" action="{{ route('admin.users.ban', $user) }}">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="px-3 py-1.5 text-xs font-medium text-red-600 bg-red-50 hover:bg-red-100 rounded-md transition-colors">
                                                    Ban
                                                </button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>

    </div>
</x-app-layout>
