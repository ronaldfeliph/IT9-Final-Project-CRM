@extends('layouts.app')

@section('title', $customer->full_name)

@section('topbar-actions')
    
@endsection

@section('content')

    <div class="flex justify-end mb-4">
        <div class="flex items-center gap-2">
            <a href="{{ route('customers.edit', $customer) }}" class="inline-flex items-center gap-2 px-4 py-2 bg-violet-600 hover:bg-violet-700 text-white text-sm font-medium rounded-lg transition-colors">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>Edit
            </a>
            <a href="{{ route('customers.index') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-white hover:bg-gray-50 text-gray-700 text-sm font-medium rounded-lg border border-gray-300 transition-colors">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>Back
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <div class="space-y-4">

            <div class="bg-white rounded-xl shadow-sm p-6">
                <div class="flex items-center gap-4 mb-4">
                    <div class="w-14 h-14 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 text-xl font-bold flex-shrink-0">
                        {{ strtoupper(substr($customer->first_name, 0, 1)) }}
                    </div>
                    <div>
                        <h2 class="font-semibold text-gray-900 text-lg leading-tight">{{ $customer->full_name }}</h2>
                        @if($customer->company)
                            <p class="text-sm text-gray-500">{{ $customer->company }}</p>
                        @endif
                        <span class="inline-flex items-center mt-1 px-2.5 py-0.5 rounded-full text-xs font-medium
                            {{ $customer->status === 'active' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' }}">
                            {{ ucfirst($customer->status) }}
                        </span>
                    </div>
                </div>

                <dl class="space-y-2.5 text-sm">
                    <div class="flex items-center gap-3">
                        <svg class="w-4 h-4 text-gray-400 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                        <a href="mailto:{{ $customer->email }}" class="text-violet-600 hover:underline">{{ $customer->email }}</a>
                    </div>
                    <div class="flex items-center gap-3">
                        <svg class="w-4 h-4 text-gray-400 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                        </svg>
                        <span class="text-gray-700">{{ $customer->phone }}</span>
                    </div>
                    @if($customer->address)
                    <div class="flex items-start gap-3">
                        <svg class="w-4 h-4 text-gray-400 flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        <span class="text-gray-700">{{ $customer->address }}</span>
                    </div>
                    @endif
                </dl>

                @if($customer->assignedUser)
                    <div class="mt-4 pt-4 border-t border-gray-100 flex items-center gap-2">
                        <div class="w-6 h-6 rounded-full bg-violet-600 flex items-center justify-center text-white text-xs font-semibold flex-shrink-0">
                            {{ strtoupper(substr($customer->assignedUser->name, 0, 1)) }}
                        </div>
                        <div>
                            <p class="text-xs text-gray-400">Assigned to</p>
                            <p class="text-sm font-medium text-gray-700">{{ $customer->assignedUser->name }}</p>
                        </div>
                    </div>
                @endif
            </div>

            <div class="bg-white rounded-xl shadow-sm p-4 space-y-2">
                <p class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-3">Quick Actions</p>

                <a href="{{ route('activities.create', ['customer_id' => $customer->id]) }}"
                   class="flex items-center gap-3 w-full px-3 py-2.5 text-sm text-gray-700 hover:bg-gray-50 rounded-lg transition-colors">
                    <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                    Log Activity
                </a>

                <a href="{{ route('follow-ups.create', ['customer_id' => $customer->id]) }}"
                   class="flex items-center gap-3 w-full px-3 py-2.5 text-sm text-gray-700 hover:bg-gray-50 rounded-lg transition-colors">
                    <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                    </svg>
                    Schedule Follow-up
                </a>

                <a href="{{ route('leads.create', ['customer_id' => $customer->id]) }}"
                   class="flex items-center gap-3 w-full px-3 py-2.5 text-sm text-gray-700 hover:bg-gray-50 rounded-lg transition-colors">
                    <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2a1 1 0 01-.293.707L13 13.414V19a1 1 0 01-.553.894l-4 2A1 1 0 017 21v-7.586L3.293 6.707A1 1 0 013 6V4z"/>
                    </svg>
                    Add Lead
                </a>
            </div>

            <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                <div class="px-5 py-3 border-b border-red-100 bg-red-50">
                    <h3 class="text-sm font-medium text-red-700">Danger Zone</h3>
                </div>
                <div class="p-5">
                    <p class="text-xs text-gray-500 mb-4">
                        Deleting this customer will also remove all related activities and follow-ups.
                    </p>
                    <form method="POST"
                          action="{{ route('customers.destroy', $customer) }}"
                          onsubmit="return confirm('Delete {{ addslashes($customer->full_name) }}? This cannot be undone.')">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="w-full px-4 py-2 text-sm font-medium text-red-600 bg-white border border-red-300 rounded-lg hover:bg-red-50 transition-colors">
                            Delete Customer
                        </button>
                    </form>
                </div>
            </div>

        </div>

        <div class="lg:col-span-2 space-y-4">

            <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                    <h3 class="font-semibold text-gray-900 text-sm">Leads</h3>
                    <a href="{{ route('leads.create', ['customer_id' => $customer->id]) }}"
                       class="text-xs text-violet-600 hover:underline">+ Add Lead</a>
                </div>
                @forelse($customer->leads as $lead)
                    <div class="px-6 py-3 flex items-center justify-between border-b border-gray-50 last:border-0">
                        <div>
                            <a href="{{ route('leads.show', $lead) }}"
                               class="text-sm font-medium text-gray-800 hover:text-violet-600 transition-colors">
                                {{ $lead->name }}
                            </a>
                            <p class="text-xs text-gray-400">{{ $lead->source ?? 'No source' }}</p>
                        </div>
                        <div class="flex items-center gap-3">
                            @if($lead->expected_value)
                                <span class="text-sm font-medium text-gray-700">₱{{ number_format($lead->expected_value, 2) }}</span>
                            @endif
                            @php
                                $statusColor = match($lead->status) {
                                    'won'      => 'bg-green-100 text-green-700',
                                    'lost'     => 'bg-red-100 text-red-700',
                                    'new'      => 'bg-blue-100 text-blue-700',
                                    default    => 'bg-yellow-100 text-yellow-700',
                                };
                            @endphp
                            <span class="px-2 py-0.5 rounded-full text-xs font-medium capitalize {{ $statusColor }}">
                                {{ str_replace('_', ' ', $lead->status) }}
                            </span>
                        </div>
                    </div>
                @empty
                    <p class="px-6 py-4 text-sm text-gray-400">No leads yet.</p>
                @endforelse
            </div>

            <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                    <h3 class="font-semibold text-gray-900 text-sm">Recent Activities</h3>
                    <a href="{{ route('activities.create', ['customer_id' => $customer->id]) }}"
                       class="text-xs text-violet-600 hover:underline">+ Log</a>
                </div>
                @forelse($customer->activities as $activity)
                    <div class="px-6 py-3 border-b border-gray-50 last:border-0">
                        <div class="flex items-start justify-between gap-4">
                            <div class="flex items-start gap-3">
                                <span class="mt-0.5 px-2 py-0.5 bg-gray-100 text-gray-600 rounded text-xs capitalize flex-shrink-0">
                                    {{ $activity->activity_type }}
                                </span>
                                <p class="text-sm text-gray-700">{{ $activity->description }}</p>
                            </div>
                            <p class="text-xs text-gray-400 flex-shrink-0">
                                {{ $activity->activity_date->format('M d, Y') }}
                            </p>
                        </div>
                    </div>
                @empty
                    <p class="px-6 py-4 text-sm text-gray-400">No activities logged yet.</p>
                @endforelse
            </div>

            <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                    <h3 class="font-semibold text-gray-900 text-sm">Follow-ups</h3>
                    <a href="{{ route('follow-ups.create', ['customer_id' => $customer->id]) }}"
                       class="text-xs text-violet-600 hover:underline">+ Schedule</a>
                </div>
                @forelse($customer->followUps as $followUp)
                    <div class="px-6 py-3 flex items-center justify-between border-b border-gray-50 last:border-0">
                        <div>
                            <p class="text-sm font-medium text-gray-800">{{ $followUp->title }}</p>
                            @if($followUp->description)
                                <p class="text-xs text-gray-400 mt-0.5">{{ $followUp->description }}</p>
                            @endif
                        </div>
                        <div class="flex items-center gap-3 flex-shrink-0">
                            <span class="text-xs text-gray-400">{{ $followUp->due_date->format('M d, Y') }}</span>
                            <span class="px-2 py-0.5 rounded-full text-xs font-medium
                                {{ $followUp->isCompleted() ? 'bg-green-100 text-green-700' : ($followUp->isOverdue() ? 'bg-red-100 text-red-700' : 'bg-yellow-100 text-yellow-700') }}">
                                {{ $followUp->isCompleted() ? 'Done' : ($followUp->isOverdue() ? 'Overdue' : 'Pending') }}
                            </span>
                        </div>
                    </div>
                @empty
                    <p class="px-6 py-4 text-sm text-gray-400">No follow-ups scheduled.</p>
                @endforelse
            </div>

        </div>
    </div>

@endsection