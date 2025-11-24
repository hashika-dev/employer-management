<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <div class="py-12 bg-gray-100">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg p-6 border-l-4 border-blue-500">
                    <div class="text-gray-500 font-bold uppercase text-sm mb-2">Total Employees</div>
                    <div class="text-4xl font-bold text-gray-800">{{ $totalEmployees }}</div>
                    <div class="text-green-500 text-sm mt-2">Active Staff Members</div>
                </div>

                <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg p-6 border-l-4 border-purple-500">
                    <div class="text-gray-500 font-bold uppercase text-sm mb-2">Departments</div>
                    <div class="text-4xl font-bold text-gray-800">{{ count($labels) }}</div>
                    <div class="text-purple-500 text-sm mt-2">Unique Job Titles</div>
                </div>

                <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg p-6 border-l-4 border-green-500">
                    <div class="text-gray-500 font-bold uppercase text-sm mb-2">System Status</div>
                    <div class="text-xl font-bold text-green-600">Online</div>
                    <div class="text-gray-400 text-sm mt-2">All systems operational</div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg p-6">
                <h3 class="text-lg font-bold text-gray-700 mb-4">Employee Distribution by Job Title</h3>
                
                <div class="w-full md:w-1/2 mx-auto">
                    <canvas id="jobChart"></canvas>
                </div>
            </div>

        </div>
    </div>

    <script>
        const ctx = document.getElementById('jobChart');

        new Chart(ctx, {
            type: 'doughnut', // You can change this to 'bar', 'pie', or 'line'
            data: {
                labels: {!! json_encode($labels) !!}, // Get names from PHP
                datasets: [{
                    label: '# of Employees',
                    data: {!! json_encode($data) !!}, // Get numbers from PHP
                    backgroundColor: [
                        '#3B82F6', // Blue
                        '#10B981', // Green
                        '#F59E0B', // Yellow
                        '#EF4444', // Red
                        '#8B5CF6', // Purple
                        '#EC4899'  // Pink
                    ],
                    hoverOffset: 4
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom',
                    }
                }
            }
        });
    </script>
</x-app-layout>