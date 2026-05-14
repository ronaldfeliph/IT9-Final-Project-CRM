<div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4 mb-6">

    <a href="{{route('customers.index')}}" class="transition duration-300 ease-in-out hover:-translate-y-2 hover:shadow-xl">
        <div class="bg-white rounded-xl p-5 flex items-center gap-4 shadow-sm">
            <div class="w-12 h-12 bg-blue-50 rounded-lg flex items-center justify-center flex-shrink-0">
                <svg class="w-6 h-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
            </div>
            <div>
                <p class="text-sm text-gray-500">Total Customers</p>
                <p class="text-2xl font-bold text-gray-900">{{ $totalCustomers }}</p>
            </div>
        </div>
    </a>
    <a href="{{route('leads.index')}}" class="transition duration-300 ease-in-out hover:-translate-y-2 hover:shadow-xl">
        <div class="bg-white rounded-xl p-5 flex items-center gap-4 shadow-sm">
            <div class="w-12 h-12 bg-yellow-50 rounded-lg flex items-center justify-center flex-shrink-0">
                <svg class="w-6 h-6 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2a1 1 0 01-.293.707L13 13.414V19a1 1 0 01-.553.894l-4 2A1 1 0 017 21v-7.586L3.293 6.707A1 1 0 013 6V4z"/>
                </svg>
            </div>
            <div>
                <p class="text-sm text-gray-500">Active Leads</p>
                <p class="text-2xl font-bold text-gray-900">{{ $totalActiveLeads }}</p>
            </div>
        </div>
    </a>
    <a href="{{route('leads.index')}}" class="transition duration-300 ease-in-out hover:-translate-y-2 hover:shadow-xl">
        <div class="bg-white rounded-xl p-5 flex items-center gap-4 shadow-sm">
            <div class="w-12 h-12 bg-green-50 rounded-lg flex items-center justify-center flex-shrink-0">
                <svg class="w-6 h-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                </svg>
            </div>
            <div>
                <p class="text-sm text-gray-500">Won Leads</p>
                <p class="text-2xl font-bold text-gray-900">{{ $wonLeads }}</p>
            </div>
        </div>
    </a>
    <a href="{{route('follow-ups.index')}}" class="transition duration-300 ease-in-out hover:-translate-y-2 hover:shadow-xl">
        <div class="bg-white rounded-xl p-5 flex items-center gap-4 shadow-sm">
            <div class="w-12 h-12 bg-green-50 rounded-lg flex items-center justify-center flex-shrink-0">
                <svg class="w-6 h-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div>
                <p class="text-sm text-gray-500">Completed Follow-ups</p>
                <p class="text-2xl font-bold text-gray-900">{{ $completedFollowUps }}</p>
            </div>
        </div>
    </a>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-4 mb-6">

    <div class="lg:col-span-2 bg-white rounded-xl shadow-sm">
        <div class="px-5 py-4 border-b border-gray-100">
            <h3 class="font-semibold text-gray-900 text-sm">Staff Performance</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-gray-50 text-xs text-gray-500 uppercase tracking-wider">
                        <th class="px-5 py-3 text-left font-medium">Name</th>
                        <th class="px-5 py-3 text-left font-medium">Customers</th>
                        <th class="px-5 py-3 text-left font-medium">Leads</th>
                        <th class="px-5 py-3 text-left font-medium">Completed</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($staffPerformance as $staff)
                        <tr class="hover:bg-gray-50">
                            <td class="px-5 py-3 font-medium text-gray-800">{{ $staff->name }}</td>
                            <td class="px-5 py-3 text-gray-600">{{ $staff->assigned_customers_count }}</td>
                            <td class="px-5 py-3 text-gray-600">{{ $staff->assigned_leads_count }}</td>
                            <td class="px-5 py-3 text-gray-600">{{ $staff->completed_follow_ups_count }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="px-5 py-6 text-center text-gray-400">No staff found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm">
        <div class="px-5 py-4 border-b border-gray-100">
            <h3 class="font-semibold text-gray-900 text-sm">Leads by Status</h3>
        </div>
        <ul class="divide-y divide-gray-50">
            @forelse($leadsByStatus as $status => $count)
                <li class="flex items-center justify-between px-5 py-3 text-sm">
                    <span class="text-gray-700 capitalize">{{ str_replace('_', ' ', $status) }}</span>
                    <span class="font-semibold text-gray-900 bg-gray-100 px-2 py-0.5 rounded-full text-xs">{{ $count }}</span>
                </li>
            @empty
                <li class="px-5 py-4 text-sm text-gray-400">No leads yet.</li>
            @endforelse
        </ul>
    </div>

</div>

<div class="bg-white rounded-xl shadow-sm">
    <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between">
        <h3 class="font-semibold text-gray-900 text-sm">Upcoming Follow-ups <span class="text-gray-400 font-normal">(Next 7 days)</span></h3>
        <a href="{{ route('follow-ups.index') }}" class="text-xs text-blue-600 hover:underline">View all</a>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-gray-50 text-xs text-gray-500 uppercase tracking-wider">
                    <th class="px-5 py-3 text-left font-medium">Title</th>
                    <th class="px-5 py-3 text-left font-medium">Linked to</th>
                    <th class="px-5 py-3 text-left font-medium">Assigned</th>
                    <th class="px-5 py-3 text-left font-medium">Due Date</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($upcomingFollowUps as $followUp)
                    <tr class="hover:bg-gray-50">
                        <td class="px-5 py-3 font-medium text-gray-800">{{ $followUp->title }}</td>
                        <td class="px-5 py-3">
                            @if($followUp->customer)
                                <a href="{{ route('customers.show', $followUp->customer) }}" class="text-blue-600 hover:underline">{{ $followUp->customer->full_name }}</a>
                            @elseif($followUp->lead)
                                <a href="{{ route('leads.show', $followUp->lead) }}" class="text-blue-600 hover:underline">{{ $followUp->lead->name }}</a>
                            @else
                                <span class="text-gray-400">—</span>
                            @endif
                        </td>
                        <td class="px-5 py-3 text-gray-600">{{ $followUp->user->name ?? '—' }}</td>
                        <td class="px-5 py-3 text-gray-600">{{ $followUp->due_date->format('M d, Y') }}</td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="px-5 py-6 text-center text-gray-400">No upcoming follow-ups.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>