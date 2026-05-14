@extends('layouts.app')

@section('title', 'Activities')

@section('topbar-actions')
    
@endsection

@section('content')

    <div class="flex justify-end mb-4">
        <a href="{{ route('activities.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-violet-600 hover:bg-violet-700 text-white text-sm font-medium rounded-lg transition-colors">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
            </svg>Log Activity
        </a>
    </div>

    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-6">
        @php
            $typeCounts = $activities->groupBy('activity_type');
            $statsConfig = [
                'call'    => ['label' => 'Calls',    'bg' => 'bg-blue-50',   'text' => 'text-blue-600',   'icon' => 'M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z'],
                'email'   => ['label' => 'Emails',   'bg' => 'bg-purple-50', 'text' => 'text-purple-600', 'icon' => 'M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z'],
                'meeting' => ['label' => 'Meetings', 'bg' => 'bg-green-50',  'text' => 'text-green-600',  'icon' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z'],
                'note'    => ['label' => 'Notes',    'bg' => 'bg-gray-100',  'text' => 'text-gray-600',   'icon' => 'M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z'],
            ];
        @endphp
        @foreach($statsConfig as $type => $config)
            <div class="bg-white rounded-xl p-4 shadow-sm flex items-center gap-3">
                <div class="w-10 h-10 {{ $config['bg'] }} rounded-lg flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 {{ $config['text'] }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="{{ $config['icon'] }}"/>
                    </svg>
                </div>
                <div>
                    <p class="text-xs text-gray-500">{{ $config['label'] }}</p>
                    <p class="text-xl font-bold text-gray-900">{{ $activities->where('activity_type', $type)->count() }}</p>
                </div>
            </div>
        @endforeach
    </div>

    <div class="bg-white rounded-xl shadow-sm p-4 mb-6">
        <form method="GET" action="{{ route('activities.index') }}"
              class="flex flex-col sm:flex-row gap-3 items-end">
            <div class="w-full sm:w-44">
                <label class="block text-xs font-medium text-gray-500 mb-1">Type</label>
                <select name="type"
                        class="w-full px-3 py-2 text-sm text-gray-900 bg-white border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <option value="">All Types</option>
                    @foreach($types as $key => $label)
                        <option value="{{ $key }}" class="text-gray-900" {{ request('type') === $key ? 'selected' : '' }}>
                            {{ $label }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="flex gap-2">
                <button type="submit" class="px-4 py-2 bg-violet-600 hover:bg-violet-700 text-white text-sm font-medium rounded-lg transition-colors">
                    Filter
                </button>
                <a href="{{ route('activities.index') }}"
                   class="px-4 py-2 bg-white hover:bg-gray-50 text-gray-700 text-sm font-medium rounded-lg border border-gray-300 transition-colors">
                    Clear
                </a>
            </div>
        </form>
    </div>
 
    @forelse($activities as $activity)
        @php
            $typeConfig = match($activity->activity_type) {
                'call'    => ['bg' => 'bg-blue-100',   'text' => 'text-blue-600',   'badge' => 'bg-blue-100 text-blue-700',   'icon' => 'M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z'],
                'email'   => ['bg' => 'bg-purple-100', 'text' => 'text-purple-600', 'badge' => 'bg-purple-100 text-purple-700', 'icon' => 'M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z'],
                'meeting' => ['bg' => 'bg-green-100',  'text' => 'text-green-600',  'badge' => 'bg-green-100 text-green-700',  'icon' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z'],
                'note'    => ['bg' => 'bg-gray-100',   'text' => 'text-gray-500',   'badge' => 'bg-gray-100 text-gray-600',    'icon' => 'M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z'],
                default   => ['bg' => 'bg-gray-100',   'text' => 'text-gray-500',   'badge' => 'bg-gray-100 text-gray-600',    'icon' => ''],
            };
        @endphp
 
        <div class="bg-white rounded-xl shadow-sm mb-3 overflow-hidden hover:shadow-md transition-shadow">
            <div class="flex items-start gap-4 p-5">
 
                {{-- Type Icon --}}
                <div class="w-10 h-10 {{ $typeConfig['bg'] }} rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">
                    <svg class="w-5 h-5 {{ $typeConfig['text'] }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="{{ $typeConfig['icon'] }}"/>
                    </svg>
                </div>
 
                {{-- Content --}}
                <div class="flex-1 min-w-0">
                    <div class="flex items-start justify-between gap-4 flex-wrap">
                        <div class="flex items-center gap-2 flex-wrap">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium capitalize {{ $typeConfig['badge'] }}">
                                {{ ucfirst($activity->activity_type) }}
                            </span>
 
                            {{-- Linked to --}}
                            @if($activity->customer)
                                <span class="text-xs text-gray-400">→</span>
                                <a href="{{ route('customers.show', $activity->customer) }}"
                                   class="text-xs text-violet-600 hover:underline font-medium">
                                    {{ $activity->customer->full_name }}
                                </a>
                            @endif
                            @if($activity->lead)
                                <span class="text-xs text-gray-400">→</span>
                                <a href="{{ route('leads.show', $activity->lead) }}"
                                   class="text-xs text-indigo-600 hover:underline font-medium">
                                    {{ $activity->lead->name }}
                                </a>
                            @endif
                        </div>
 
                        <div class="flex items-center gap-3 flex-shrink-0">
                            <span class="text-xs text-gray-400">
                                {{ $activity->activity_date->format('M d, Y · h:i A') }}
                            </span>
 
                            {{-- Actions --}}
                            @if(auth()->user()->isAdmin() || $activity->user_id === auth()->id())
                                <a href="{{ route('activities.edit', $activity) }}"
                                   class="p-1.5 text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors"
                                   title="Edit">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                </a>
                                <form method="POST"
                                      action="{{ route('activities.destroy', $activity) }}"
                                      onsubmit="return confirm('Delete this activity?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="p-1.5 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors"
                                            title="Delete">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
 
                    {{-- Description --}}
                    <p class="text-sm text-gray-700 mt-2 leading-relaxed">{{ $activity->description }}</p>
 
                    {{-- Logged by --}}
                    <div class="flex items-center gap-2 mt-3">
                        <div class="w-5 h-5 rounded-full bg-blue-600 flex items-center justify-center text-white text-xs font-semibold flex-shrink-0">
                            {{ strtoupper(substr($activity->user->name ?? '?', 0, 1)) }}
                        </div>
                        <span class="text-xs text-gray-400">Logged by <span class="text-gray-600 font-medium">{{ $activity->user->name ?? '—' }}</span></span>
                    </div>
                </div>
 
            </div>
        </div>
 
    @empty
        <div class="bg-white rounded-xl shadow-sm p-12 text-center text-gray-400">
            <svg class="w-12 h-12 mx-auto mb-3 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1">
                <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/>
            </svg>
            <p class="font-medium text-gray-500">No activities logged yet.</p>
            <p class="text-sm mt-1">Start by logging a call, email, meeting, or note.</p>
        </div>
    @endforelse

    @if($activities->hasPages())
        <div class="mt-4">
            {{ $activities->links() }}
        </div>
    @endif
 
@endsection