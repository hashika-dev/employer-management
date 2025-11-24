<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <div class="py-12 bg-gray-100">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                
                <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-blue-500 flex items-center justify-between hover:shadow-lg transition duration-300">
                    <div>
                        <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">Total Staff</p>
                        <p class="text-4xl font-bold text-gray-800 mt-1">{{ $totalEmployees }}</p>
                        <p class="text-xs text-green-600 font-semibold mt-2">▲ Active Workforce</p>
                    </div>
                    <div class="bg-blue-100 p-3 rounded-full">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-purple-500 flex items-center justify-between hover:shadow-lg transition duration-300">
                    <div>
                        <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">Departments</p>
                        <p class="text-4xl font-bold text-gray-800 mt-1">{{ count($labels) }}</p>
                        <p class="text-xs text-purple-600 font-semibold mt-2">Unique Job Titles</p>
                    </div>
                    <div class="bg-purple-100 p-3 rounded-full">
                        <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-green-500 flex items-center justify-between hover:shadow-lg transition duration-300 cursor-pointer" onclick="window.location='{{ route('admin.employees.create') }}'">
                    <div>
                        <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">Quick Action</p>
                        <p class="text-xl font-bold text-gray-800 mt-1">Hire Employee</p>
                        <p class="text-xs text-gray-400 mt-2">Click to add new staff</p>
                    </div>
                    <div class="bg-green-100 p-3 rounded-full">
                        <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                    </div>
                </div>

            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                <div class="bg-white rounded-xl shadow-lg p-6 lg:col-span-2 border border-gray-100">
                    <h3 class="text-lg font-bold text-gray-800 mb-4 border-b pb-2">Employee Distribution</h3>
                    <div class="relative h-80 w-full flex justify-center items-center">
                        <canvas id="jobChart"></canvas>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-100">
                    <h3 class="text-lg font-bold text-gray-800 mb-4 border-b pb-2">System Health</h3>
                    
                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <span class="text-gray-600">Server Status</span>
                            <span class="px-2 py-1 text-xs font-bold text-green-700 bg-green-100 rounded-full">Online</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-gray-600">Database</span>
                            <span class="px-2 py-1 text-xs font-bold text-green-700 bg-green-100 rounded-full">Connected</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-gray-600">Last Login</span>
                            <span class="text-sm font-mono text-gray-800">{{ now()->format('h:i A') }}</span>
                        </div>
                        
                        <div class="mt-6 pt-6 border-t">
                            <p class="text-sm text-gray-500 mb-3">Admin Shortcuts</p>
                            <a href="{{ route('admin.employees.index') }}" class="block w-full text-center bg-slate-800 hover:bg-slate-700 text-white font-bold py-2 rounded transition">
                                View Staff Directory
                            </a>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>

    <script>
        const ctx = document.getElementById('jobChart');

        new Chart(ctx, {
            type: 'doughnut', 
            data: {
                labels: {!! json_encode($labels) !!}, 
                datasets: [{
                    label: 'Staff Count',
                    data: {!! json_encode($data) !!},
                    backgroundColor: [
                        '#3B82F6', '#10B981', '#F59E0B', '#EF4444', '#8B5CF6', '#EC4899', '#6366F1'
                    ],
                    borderWidth: 2,
                    borderColor: '#ffffff'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'right',
                        labels: {
                            font: { size: 12 },
                            usePointStyle: true,
                        }
                    }
                },
                layout: {
                    padding: 20
                }
            }
        });
    </script>
</x-app-layout>