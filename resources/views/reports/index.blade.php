@extends('layouts.app')

@section('title', 'Reports')

@section('topbar-actions')
    
@endsection

@section('content')

    <div class="flex justify-end mb-4">
        <a href="{{ route('reports.export', request()->query()) }}" class="inline-flex items-center gap-2 px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-medium rounded-lg transition-colors">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
            </svg>Export CSV
        </a>
    </div>

    {{-- ── Date Filter ─────────────────────────────────────────── --}}
    <div class="bg-white rounded-xl shadow-sm p-4 mb-6">
        <form method="GET" action="{{ route('reports.index') }}"
              class="flex flex-col sm:flex-row gap-3 items-end">

            <div>
                <label class="block text-xs font-medium text-gray-500 mb-1">From</label>
                <input type="date" name="date_from" value="{{ request('date_from') }}"
                       class="px-3 py-2 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            </div>

            <div>
                <label class="block text-xs font-medium text-gray-500 mb-1">To</label>
                <input type="date" name="date_to" value="{{ request('date_to') }}" class="px-3 py-2 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            </div>

            {{-- Quick ranges --}}
            <div class="flex gap-2 flex-wrap">
                @php
                    $ranges = [
                        'this_month'  => 'This Month',
                        'last_month'  => 'Last Month',
                        'this_year'   => 'This Year',
                    ];
                @endphp
                @foreach($ranges as $key => $label)
                    <a href="{{ route('reports.index', ['range' => $key]) }}" class="px-3 py-2 text-xs font-medium rounded-lg border transition-colors
                           {{ request('range') === $key ? 'bg-blue-600 text-white border-blue-600' : 'bg-white text-gray-600 border-gray-300 hover:bg-gray-50' }}">
                        {{ $label }}
                    </a>
                @endforeach
            </div>

            <div class="flex gap-2">
                <button type="submit" class="px-4 py-2 bg-violet-600 hover:bg-violet-700 text-white text-sm font-medium rounded-lg transition-colors">Apply</button>
                <a href="{{ route('reports.index') }}" class="px-4 py-2 bg-white hover:bg-gray-50 text-gray-700 text-sm font-medium rounded-lg border border-gray-300 transition-colors">Clear</a>
            </div>

        </form>

        {{-- Active filter notice --}}
        @if(request('date_from') || request('date_to') || request('range'))
            <div class="mt-3 flex items-center gap-2 text-xs text-blue-600">
                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2a1 1 0 01-.293.707L13 13.414V19a1 1 0 01-.553.894l-4 2A1 1 0 017 21v-7.586L3.293 6.707A1 1 0 013 6V4z"/>
                </svg>
                Showing data from
                <span class="font-medium">{{ $dateFrom->format('M d, Y') }}</span>
                to
                <span class="font-medium">{{ $dateTo->format('M d, Y') }}</span>
            </div>
        @endif
    </div>

    {{-- ── Summary Stats ───────────────────────────────────────── --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4 mb-6">

        <div class="bg-white rounded-xl p-5 flex items-center gap-4 shadow-sm">
            <div class="w-12 h-12 bg-blue-50 rounded-lg flex items-center justify-center flex-shrink-0">
                <svg class="w-6 h-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
            </div>
            <div>
                <p class="text-sm text-gray-500">Total Customers</p>
                <p class="text-2xl font-bold text-gray-900">{{ $totalCustomers }}</p>
                <p class="text-xs text-gray-400 mt-0.5">{{ $customersThisMonth }} in period</p>
            </div>
        </div>

        <div class="bg-white rounded-xl p-5 flex items-center gap-4 shadow-sm">
            <div class="w-12 h-12 bg-yellow-50 rounded-lg flex items-center justify-center flex-shrink-0">
                <svg class="w-6 h-6 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2a1 1 0 01-.293.707L13 13.414V19a1 1 0 01-.553.894l-4 2A1 1 0 017 21v-7.586L3.293 6.707A1 1 0 013 6V4z"/>
                </svg>
            </div>
            <div>
                <p class="text-sm text-gray-500">Total Leads</p>
                <p class="text-2xl font-bold text-gray-900">{{ $totalLeads }}</p>
                <p class="text-xs text-gray-400 mt-0.5">{{ $leadsThisMonth }} in period</p>
            </div>
        </div>

        <div class="bg-white rounded-xl p-5 flex items-center gap-4 shadow-sm">
            <div class="w-12 h-12 bg-green-50 rounded-lg flex items-center justify-center flex-shrink-0">
                <svg class="w-6 h-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div>
                <p class="text-sm text-gray-500">Won Value</p>
                <p class="text-2xl font-bold text-gray-900">₱{{ number_format($totalWonValue, 0) }}</p>
                <p class="text-xs text-gray-400 mt-0.5">Pipeline: ₱{{ number_format($totalExpectedValue, 0) }}</p>
            </div>
        </div>

        <div class="bg-white rounded-xl p-5 flex items-center gap-4 shadow-sm">
            <div class="w-12 h-12 bg-indigo-50 rounded-lg flex items-center justify-center flex-shrink-0">
                <svg class="w-6 h-6 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                </svg>
            </div>
            <div>
                <p class="text-sm text-gray-500">Total Activities</p>
                <p class="text-2xl font-bold text-gray-900">{{ $totalActivities }}</p>
                <p class="text-xs text-gray-400 mt-0.5">{{ $activitiesThisMonth }} in period</p>
            </div>
        </div>

    </div>

    {{-- ── Leads + Customers Row ────────────────────────────────── --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 mb-6">

        {{-- Leads by Status --}}
        <div class="bg-white rounded-xl shadow-sm overflow-hidden">
            <div class="px-5 py-4 border-b border-gray-100">
                <h3 class="font-semibold text-gray-900 text-sm">Leads by Status</h3>
            </div>
            <div class="p-5 space-y-3">
                @php
                    $statusColors = [
                        'new'           => 'bg-blue-500',
                        'contacted'     => 'bg-indigo-500',
                        'qualified'     => 'bg-cyan-500',
                        'proposal_sent' => 'bg-purple-500',
                        'negotiation'   => 'bg-orange-500',
                        'won'           => 'bg-green-500',
                        'lost'          => 'bg-red-400',
                    ];
                    $maxLeads = $leadsByStatus->max() ?: 1;
                @endphp
                @forelse($leadsByStatus as $status => $count)
                    <div>
                        <div class="flex items-center justify-between mb-1">
                            <span class="text-xs font-medium text-gray-600 capitalize">{{ str_replace('_', ' ', $status) }}</span>
                            <span class="text-xs font-semibold text-gray-900">{{ $count }}</span>
                        </div>
                        <div class="w-full bg-gray-100 rounded-full h-2">
                            <div class="h-2 rounded-full {{ $statusColors[$status] ?? 'bg-gray-400' }} transition-all"
                                 style="width: {{ ($count / $maxLeads) * 100 }}%">
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="text-sm text-gray-400">No leads in this period.</p>
                @endforelse
            </div>
        </div>

        {{-- Customer Breakdown --}}
        <div class="bg-white rounded-xl shadow-sm overflow-hidden">
            <div class="px-5 py-4 border-b border-gray-100">
                <h3 class="font-semibold text-gray-900 text-sm">Customer Breakdown</h3>
            </div>
            <div class="divide-y divide-gray-50">
                <div class="flex items-center justify-between px-5 py-3">
                    <div class="flex items-center gap-2">
                        <div class="w-2.5 h-2.5 rounded-full bg-green-500"></div>
                        <span class="text-sm text-gray-700">Active</span>
                    </div>
                    <div class="text-right">
                        <span class="text-sm font-semibold text-gray-900">{{ $activeCustomers }}</span>
                        <span class="text-xs text-gray-400 ml-1">({{ $totalCustomers > 0 ? round(($activeCustomers / $totalCustomers) * 100) : 0 }}%)</span>
                    </div>
                </div>
                <div class="flex items-center justify-between px-5 py-3">
                    <div class="flex items-center gap-2">
                        <div class="w-2.5 h-2.5 rounded-full bg-gray-400"></div>
                        <span class="text-sm text-gray-700">Inactive</span>
                    </div>
                    <div class="text-right">
                        <span class="text-sm font-semibold text-gray-900">{{ $inactiveCustomers }}</span>
                        <span class="text-xs text-gray-400 ml-1">({{ $totalCustomers > 0 ? round(($inactiveCustomers / $totalCustomers) * 100) : 0 }}%)</span>
                    </div>
                </div>
                <div class="flex items-center justify-between px-5 py-3">
                    <div class="flex items-center gap-2">
                        <div class="w-2.5 h-2.5 rounded-full bg-blue-500"></div>
                        <span class="text-sm text-gray-700">Added in period</span>
                    </div>
                    <span class="text-sm font-semibold text-gray-900">{{ $customersThisMonth }}</span>
                </div>
            </div>
        </div>

        {{-- Activities by Type --}}
        <div class="bg-white rounded-xl shadow-sm overflow-hidden">
            <div class="px-5 py-4 border-b border-gray-100">
                <h3 class="font-semibold text-gray-900 text-sm">Activities by Type</h3>
            </div>
            <div class="divide-y divide-gray-50">
                @php
                    $activityColors = [
                        'call'    => ['dot' => 'bg-blue-500',   'label' => 'Calls'],
                        'email'   => ['dot' => 'bg-purple-500', 'label' => 'Emails'],
                        'meeting' => ['dot' => 'bg-green-500',  'label' => 'Meetings'],
                        'note'    => ['dot' => 'bg-gray-400',   'label' => 'Notes'],
                    ];
                @endphp
                @forelse($activitiesByType as $type => $count)
                    @php $style = $activityColors[$type] ?? ['dot' => 'bg-gray-400', 'label' => ucfirst($type)]; @endphp
                    <div class="flex items-center justify-between px-5 py-3">
                        <div class="flex items-center gap-2">
                            <div class="w-2.5 h-2.5 rounded-full {{ $style['dot'] }}"></div>
                            <span class="text-sm text-gray-700">{{ $style['label'] }}</span>
                        </div>
                        <span class="text-sm font-semibold text-gray-900">{{ $count }}</span>
                    </div>
                @empty
                    <p class="px-5 py-4 text-sm text-gray-400">No activities in this period.</p>
                @endforelse
            </div>
        </div>

    </div>

    {{-- ── Follow-up Summary ────────────────────────────────────── --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <div class="bg-white rounded-xl p-5 shadow-sm">
            <p class="text-xs text-gray-500 mb-1">Total Follow-ups</p>
            <p class="text-2xl font-bold text-gray-900">{{ $totalFollowUps }}</p>
        </div>
        <div class="bg-white rounded-xl p-5 shadow-sm">
            <p class="text-xs text-gray-500 mb-1">Pending</p>
            <p class="text-2xl font-bold text-yellow-600">{{ $pendingFollowUps }}</p>
        </div>
        <div class="bg-white rounded-xl p-5 shadow-sm">
            <p class="text-xs text-gray-500 mb-1">Completed</p>
            <p class="text-2xl font-bold text-green-600">{{ $completedFollowUps }}</p>
            @if($totalFollowUps > 0)
                <p class="text-xs text-gray-400 mt-0.5">{{ round(($completedFollowUps / $totalFollowUps) * 100) }}% completion rate</p>
            @endif
        </div>
        <div class="bg-white rounded-xl p-5 shadow-sm">
            <p class="text-xs text-gray-500 mb-1">Overdue</p>
            <p class="text-2xl font-bold text-red-600">{{ $overdueFollowUps }}</p>
        </div>
    </div>

    {{-- ── Staff Performance (admin + manager only) ────────────── --}}
    @if(isset($staffPerformance) && $staffPerformance->count())
        <div class="bg-white rounded-xl shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100">
                <h3 class="font-semibold text-gray-900 text-sm">Staff Performance</h3>
                <p class="text-xs text-gray-400 mt-0.5">Within selected date range</p>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-gray-50 text-xs text-gray-500 uppercase tracking-wider border-b border-gray-100">
                            <th class="px-6 py-3 text-left font-medium">Staff Member</th>
                            <th class="px-6 py-3 text-left font-medium">Customers</th>
                            <th class="px-6 py-3 text-left font-medium">Leads</th>
                            <th class="px-6 py-3 text-left font-medium">Activities</th>
                            <th class="px-6 py-3 text-left font-medium">Completed</th>
                            <th class="px-6 py-3 text-left font-medium">Pending</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @foreach($staffPerformance as $staff)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-full bg-blue-600 flex items-center justify-center text-white text-xs font-semibold flex-shrink-0">
                                            {{ strtoupper(substr($staff->name, 0, 1)) }}
                                        </div>
                                        <div>
                                            <p class="font-medium text-gray-900">{{ $staff->name }}</p>
                                            <p class="text-xs text-gray-400">{{ $staff->email }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-gray-700">{{ $staff->assigned_customers_count }}</td>
                                <td class="px-6 py-4 text-gray-700">{{ $staff->assigned_leads_count }}</td>
                                <td class="px-6 py-4 font-medium text-gray-900">{{ $staff->activities_this_month_count }}</td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-700">
                                        {{ $staff->completed_follow_ups_count }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                        {{ $staff->pending_follow_ups_count > 0 ? 'bg-yellow-100 text-yellow-700' : 'bg-gray-100 text-gray-500' }}">
                                        {{ $staff->pending_follow_ups_count }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif

@endsection