<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Attendance History: <span class="text-indigo-600">{{ $employee->name }}</span>
            </h2>
            <a href="{{ route('admin.attendance.index') }}" class="text-sm text-gray-600 hover:text-gray-900 underline">
                &larr; Back to Employee List
            </a>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-100">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="bg-white p-4 rounded-lg shadow border-l-4 border-green-500">
                    <p class="text-sm text-gray-500">Days Present (Selected Month)</p>
                    <p class="text-2xl font-bold">{{ $daysPresent }}</p>
                </div>
                <div class="bg-white p-4 rounded-lg shadow border-l-4 border-red-500">
                    <p class="text-sm text-gray-500">Late Arrivals (Selected Month)</p>
                    <p class="text-2xl font-bold">{{ $lates }}</p>
                </div>
            </div>

            <div class="bg-white p-4 rounded-lg shadow flex flex-col md:flex-row gap-4 items-center justify-between">
                <form method="GET" action="{{ route('admin.attendance.show', $employee->id) }}" class="flex items-center gap-3 w-full md:w-auto">
                    
                    <div>
                        <label class="text-xs font-bold text-gray-500 uppercase">Month</label>
                        <select name="month" class="block w-32 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-sm">
                            @for($m = 1; $m <= 12; $m++)
                                <option value="{{ $m }}" {{ $month == $m ? 'selected' : '' }}>
                                    {{ date('F', mktime(0, 0, 0, $m, 1)) }}
                                </option>
                            @endfor
                        </select>
                    </div>

                    <div>
                        <label class="text-xs font-bold text-gray-500 uppercase">Year</label>
                        <select name="year" class="block w-24 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-sm">
                            @for($y = 2023; $y <= date('Y'); $y++)
                                <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>{{ $y }}</option>
                            @endfor
                        </select>
                    </div>

                    <div class="pt-4">
                        <button type="submit" class="bg-gray-800 text-white px-4 py-2 rounded-md hover:bg-gray-700 text-sm">Filter</button>
                    </div>
                </form>

                <div class="text-sm text-gray-500">
                    Sort by: 
                    <a href="{{ request()->fullUrlWithQuery(['sort' => 'date', 'direction' => 'desc']) }}" class="underline hover:text-indigo-600">Newest</a> | 
                    <a href="{{ request()->fullUrlWithQuery(['sort' => 'date', 'direction' => 'asc']) }}" class="underline hover:text-indigo-600">Oldest</a>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Date</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Time In</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Time Out</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Late Status</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($attendances as $record)
                        @php
                            $timeIn = \Carbon\Carbon::parse($record->time_in);
                            $isLate = $timeIn->gt(\Carbon\Carbon::parse('09:00:00'));
                        @endphp
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-medium">
                                {{ \Carbon\Carbon::parse($record->date)->format('M d, Y') }}
                                <span class="text-gray-400 text-xs block">{{ \Carbon\Carbon::parse($record->date)->format('l') }}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-green-700 font-mono">
                                {{ $timeIn->format('h:i A') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-red-600 font-mono">
                                {{ $record->time_out ? \Carbon\Carbon::parse($record->time_out)->format('h:i A') : '--:--' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($isLate)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                        Late
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        On Time
                                    </span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-6 py-10 text-center text-gray-500">
                                No attendance records found for this month.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</x-app-layout>