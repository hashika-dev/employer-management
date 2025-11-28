<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Pending Approvals</h2>
    </x-slot>

    <div class="py-12 bg-gray-100">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-lg rounded-lg p-6">
                <h3 class="text-lg font-bold mb-4">New Registrations</h3>
                
                @if($pendingUsers->isEmpty())
                    <p class="text-gray-500">No pending accounts.</p>
                @else
                    <table class="w-full border-collapse">
                        <thead>
                            <tr class="bg-gray-100 text-left">
                                <th class="p-3">Name</th>
                                <th class="p-3">Email</th>
                                <th class="p-3">Joined</th>
                                <th class="p-3">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pendingUsers as $user)
                            <tr class="border-b">
                                <td class="p-3 font-bold">{{ $user->name }}</td>
                                <td class="p-3">{{ $user->email }}</td>
                                <td class="p-3">{{ $user->created_at->diffForHumans() }}</td>
                                <td class="p-3">
                                    <form action="{{ route('admin.approvals.approve', $user->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <button class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 font-bold text-sm">
                                            Approve Access
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>