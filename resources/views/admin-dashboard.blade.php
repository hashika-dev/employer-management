<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center gap-4">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Admin Dashboard') }}
            </h2>
            
            <form method="GET" action="{{ route('admin.dashboard') }}" class="flex items-center gap-2 w-full md:w-auto">
                <label class="text-sm font-bold text-gray-600 whitespace-nowrap">Filter By Dept:</label>
                <select name="filter_dept" onchange="this.form.submit()" class="w-full md:w-48 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-sm">
                    <option value="">All Departments</option>
                    @foreach($allDepartments as $dept)
                        <option value="{{ $dept->id }}" {{ request('filter_dept') == $dept->id ? 'selected' : '' }}>
                            {{ $dept->name }}
                        </option>
                    @endforeach
                </select>
            </form>
        </div>
    </x-slot>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2"></script>

    <div class="py-12 bg-gray-100">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                
                <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-blue-500 flex items-center justify-between">
                    <div>
                        <p class="text-sm font-bold text-gray-400 uppercase">Total Staff</p>
                        <p class="text-3xl font-bold text-gray-800">{{ $totalEmployees }}</p>
                    </div>
                    <div class="bg-blue-100 p-3 rounded-full text-blue-600">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-purple-500 flex items-center justify-between">
                    <div>
                        <p class="text-sm font-bold text-gray-400 uppercase">Departments</p>
                        <p class="text-3xl font-bold text-gray-800">{{ $totalDepartments }}</p>
                    </div>
                    <div class="bg-purple-100 p-3 rounded-full text-purple-600">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                    </div>
                </div>

                <a href="{{ route('admin.employees.create') }}" class="bg-white rounded-xl shadow-md p-6 border-l-4 border-green-500 flex items-center justify-between hover:bg-green-50 transition cursor-pointer">
                    <div>
                        <p class="text-sm font-bold text-gray-400 uppercase">Quick Action</p>
                        <p class="text-lg font-bold text-green-700">+ Hire Staff</p>
                    </div>
                    <div class="bg-green-100 p-3 rounded-full text-green-600">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
                    </div>
                </a>

                <a href="{{ route('admin.employees.index') }}" class="bg-white rounded-xl shadow-md p-6 border-l-4 border-gray-500 flex items-center justify-between hover:bg-gray-50 transition cursor-pointer">
                    <div>
                        <p class="text-sm font-bold text-gray-400 uppercase">Directory</p>
                        <p class="text-lg font-bold text-gray-700">View All &rarr;</p>
                    </div>
                    <div class="bg-gray-100 p-3 rounded-full text-gray-600">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    </div>
                </a>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-100">
                    <h3 class="text-lg font-bold text-gray-800 mb-4 border-b pb-2">
                        Gender Demographics 
                        @if(request('filter_dept'))
                            <span class="text-xs font-normal text-gray-500">(Filtered)</span>
                        @endif
                    </h3>
                    
                    @if(count($genderData) > 0)
                        <div class="relative h-64 w-full flex justify-center items-center">
                            <canvas id="genderChart"></canvas>
                        </div>
                    @else
                        <p class="text-center text-gray-400 py-10">No gender data available.</p>
                    @endif
                </div>

                <div class="bg-white rounded-xl shadow-lg p-6 lg:col-span-2 border border-gray-100">
                    <h3 class="text-lg font-bold text-gray-800 mb-4 border-b pb-2">Staff per Department</h3>
                    <div class="relative h-64 w-full">
                        <canvas id="deptChart"></canvas>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script>
        // Enable DataLabels
        Chart.register(ChartDataLabels);

        // --- 1. GENDER PIE CHART ---
        const genderCtx = document.getElementById('genderChart');
        const genderLabels = {!! json_encode($genderLabels) !!};

        if(genderCtx) {
            new Chart(genderCtx, {
                type: 'pie',
                data: {
                    labels: genderLabels,
                    datasets: [{
                        data: {!! json_encode($genderData) !!},
                        // DYNAMIC COLORS (UPDATED):
                        backgroundColor: genderLabels.map(label => {
                            if(label === 'Male') return '#3B82F6';   // Gray (was Blue)
                            if(label === 'Female') return '#EC4899'; // Pink (No change)
                            return '#9CA3AF'; // Blue for "Not Set" (was Gray)
                        }), 
                        borderWidth: 2,
                        borderColor: '#ffffff'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { position: 'bottom' },
                        datalabels: {
                            color: '#ffffff',
                            font: {
                                weight: 'bold',
                                size: 16
                            },
                            formatter: (value, ctx) => {
                                return value;
                            }
                        }
                    }
                }
            });
        }

// --- 2. DEPARTMENT BAR CHART ---
        const deptCtx = document.getElementById('deptChart');
        if(deptCtx) {
            new Chart(deptCtx, {
                type: 'bar',
                data: {
                    labels: {!! json_encode($deptLabels) !!},
                    datasets: [{
                        label: 'Number of Staff',
                        data: {!! json_encode($deptData) !!},
                        backgroundColor: '#8B5CF6',
                        borderRadius: 5,
                        // Ensure the bars don't clip the text
                        clip: false 
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    // FIX: Add padding at the top so the numbers don't get cut off
                    layout: {
                        padding: {
                            top: 30 
                        }
                    },
                    scales: {
                        y: { 
                            beginAtZero: true, 
                            // Hide the numbers on the left
                            ticks: { 
                                display: false 
                            },
                            // Hide the grid lines for a cleaner look
                            grid: {
                                display: false,
                                drawBorder: false
                            },
                            // Optional: Add 'grace' to automatically add space at the top
                            grace: '5%' 
                        },
                        x: {
                             grid: {
                                display: false
                             }
                        }
                    },
                    plugins: {
                        legend: { display: false },
                        datalabels: {
                            anchor: 'end',
                            align: 'top',
                            color: '#8B5CF6',
                            font: { 
                                weight: 'bold',
                                size: 14 
                            },
                            // Ensure the number is always visible
                            display: true 
                        }
                    }
                }
            });
        }
    </script>
</x-app-layout>