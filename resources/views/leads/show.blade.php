@extends('layouts.app')

@section('title', $lead->name)

@section('topbar-actions')
    
@endsection

@section('content')

    <div class="flex justify-end mb-4">
        <div class="flex items-center gap-2">
            <a href="{{ route('leads.edit', $lead) }}"
            class="inline-flex items-center gap-2 px-4 py-2 bg-violet-600 hover:bg-violet-700 text-white text-sm font-medium rounded-lg transition-colors">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
                Edit
            </a>
            <a href="{{ route('leads.index') }}"
            class="inline-flex items-center gap-2 px-4 py-2 bg-white hover:bg-gray-50 text-gray-700 text-sm font-medium rounded-lg border border-gray-300 transition-colors">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Back
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <div class="space-y-4">

            <div class="bg-white rounded-xl shadow-sm p-6">

                <div class="flex items-start justify-between mb-4">
                    <div>
                        <h2 class="font-semibold text-gray-900 text-lg leading-tight">{{ $lead->name }}</h2>
                        @if($lead->source)
                            <p class="text-sm text-gray-500 mt-0.5">{{ $lead->source }}</p>
                        @endif
                    </div>
                    @php
                        $priorityColor = match($lead->priority) {
                            'high'   => 'bg-red-100 text-red-700',
                            'medium' => 'bg-yellow-100 text-yellow-700',
                            'low'    => 'bg-gray-100 text-gray-600',
                            default  => 'bg-gray-100 text-gray-600',
                        };
                    @endphp
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium capitalize {{ $priorityColor }}">
                        {{ $lead->priority }}
                    </span>
                </div>

                @if($lead->email || $lead->phone)
                    <dl class="space-y-2 text-sm mb-4">
                        @if($lead->email)
                            <div class="flex items-center gap-3">
                                <svg class="w-4 h-4 text-gray-400 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                                <a href="mailto:{{ $lead->email }}" class="text-violet-600 hover:underline">{{ $lead->email }}</a>
                            </div>
                        @endif
                        @if($lead->phone)
                            <div class="flex items-center gap-3">
                                <svg class="w-4 h-4 text-gray-400 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                </svg>
                                <span class="text-gray-700">{{ $lead->phone }}</span>
                            </div>
                        @endif
                    </dl>
                @endif

                @if($lead->expected_value)
                    <div class="flex items-center justify-between py-3 border-t border-gray-100">
                        <span class="text-xs text-gray-500">Expected Value</span>
                        <span class="text-base font-semibold text-gray-900">₱{{ number_format($lead->expected_value, 2) }}</span>
                    </div>
                @endif

                @if($lead->customer)
                    <div class="flex items-center gap-3 py-3 border-t border-gray-100">
                        <div class="w-7 h-7 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 text-xs font-semibold flex-shrink-0">
                            {{ strtoupper(substr($lead->customer->first_name, 0, 1)) }}
                        </div>
                        <div>
                            <p class="text-xs text-gray-400">Linked customer</p>
                            <a href="{{ route('customers.show', $lead->customer) }}"
                               class="text-sm font-medium text-violet-600 hover:underline">
                                {{ $lead->customer->full_name }}
                            </a>
                        </div>
                    </div>
                @endif

                @if($lead->assignedUser)
                    <div class="flex items-center gap-3 py-3 border-t border-gray-100">
                        <div class="w-7 h-7 rounded-full bg-violet-600 flex items-center justify-center text-white text-xs font-semibold flex-shrink-0">
                            {{ strtoupper(substr($lead->assignedUser->name, 0, 1)) }}
                        </div>
                        <div>
                            <p class="text-xs text-gray-400">Assigned to</p>
                            <p class="text-sm font-medium text-gray-700">{{ $lead->assignedUser->name }}</p>
                        </div>
                    </div>
                @endif

                @if($lead->notes)
                    <div class="mt-3 pt-3 border-t border-gray-100">
                        <p class="text-xs text-gray-500 mb-1">Notes</p>
                        <p class="text-sm text-gray-700">{{ $lead->notes }}</p>
                    </div>
                @endif

            </div>

            <div class="bg-white rounded-xl shadow-sm p-5">
                <p class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-3">Update Status</p>
                <form method="POST" action="{{ route('leads.update-status', $lead) }}">
                    @csrf
                    @method('PATCH')
                    <div class="flex gap-2">
                        <select name="status"
                                class="flex-1 px-3 py-2 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-violet-500 focus:border-transparent">
                            @foreach($statuses as $key => $label)
                                <option value="{{ $key }}" {{ $lead->status === $key ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                        <button type="submit"
                                class="px-3 py-2 text-sm font-medium text-white bg-violet-600 hover:bg-violet-700 rounded-lg transition-colors">
                            Update
                        </button>
                    </div>
                </form>
            </div>

            @if(!$lead->customer_id && $lead->status !== 'lost')
                <div class="bg-white rounded-xl shadow-sm p-5">
                    <p class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-2">Convert Lead</p>
                    <p class="text-xs text-gray-400 mb-3">Convert this lead into a customer record.</p>
                    <form method="POST" action="{{ route('leads.convert', $lead) }}"
                          onsubmit="return confirm('Convert {{ addslashes($lead->name) }} to a customer?')">
                        @csrf
                        <button type="submit"
                                class="w-full px-4 py-2 text-sm font-medium text-green-700 bg-green-50 hover:bg-green-100 border border-green-200 rounded-lg transition-colors">
                            Convert to Customer
                        </button>
                    </form>
                </div>
            @endif

            <div class="bg-white rounded-xl shadow-sm p-4 space-y-1">
                <p class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-3">Quick Actions</p>
                <a href="{{ route('activities.create', ['lead_id' => $lead->id]) }}"
                   class="flex items-center gap-3 w-full px-3 py-2.5 text-sm text-gray-700 hover:bg-gray-50 rounded-lg transition-colors">
                    <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                    Log Activity
                </a>
                <a href="{{ route('follow-ups.create', ['lead_id' => $lead->id]) }}"
                   class="flex items-center gap-3 w-full px-3 py-2.5 text-sm text-gray-700 hover:bg-gray-50 rounded-lg transition-colors">
                    <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                    </svg>
                    Schedule Follow-up
                </a>
            </div>

            <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                <div class="px-5 py-3 border-b border-red-100 bg-red-50">
                    <h3 class="text-sm font-medium text-red-700">Danger Zone</h3>
                </div>
                <div class="p-5">
                    <p class="text-xs text-gray-500 mb-4">Permanently delete this lead and all related records.</p>
                    <form method="POST"
                          action="{{ route('leads.destroy', $lead) }}"
                          onsubmit="return confirm('Delete {{ addslashes($lead->name) }}? This cannot be undone.')">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="w-full px-4 py-2 text-sm font-medium text-red-600 bg-white border border-red-300 rounded-lg hover:bg-red-50 transition-colors">
                            Delete Lead
                        </button>
                    </form>
                </div>
            </div>

        </div>

        <div class="lg:col-span-2 space-y-4">

            <div class="bg-white rounded-xl shadow-sm p-5">
                <p class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-4">Pipeline Stage</p>
                <div class="flex items-center gap-1">
                    @php
                        $stages = ['new', 'contacted', 'qualified', 'proposal_sent', 'negotiation', 'won'];
                        $currentIndex = array_search($lead->status, $stages);
                        $isLost = $lead->status === 'lost';
                    @endphp
                    @foreach($stages as $i => $stage)
                        <div class="flex-1 text-center">
                            <div class="h-2 rounded-full mb-1.5
                                {{ $isLost ? 'bg-red-200' : ($i <= $currentIndex ? 'bg-violet-500' : 'bg-gray-200') }}">
                            </div>
                            <p class="text-xs text-gray-500 capitalize hidden sm:block">{{ str_replace('_', ' ', $stage) }}</p>
                        </div>
                        @if(!$loop->last)
                            <div class="w-1"></div>
                        @endif
                    @endforeach
                </div>
                @if($isLost)
                    <p class="text-xs text-red-500 mt-2 text-center">This lead has been marked as lost.</p>
                @endif
            </div>

            <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                    <h3 class="font-semibold text-gray-900 text-sm">Activities</h3>
                    <a href="{{ route('activities.create', ['lead_id' => $lead->id]) }}"
                       class="text-xs text-violet-600 hover:underline">+ Log</a>
                </div>
                @forelse($lead->activities as $activity)
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
                    <a href="{{ route('follow-ups.create', ['lead_id' => $lead->id]) }}"
                       class="text-xs text-violet-600 hover:underline">+ Schedule</a>
                </div>
                @forelse($lead->followUps as $followUp)
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