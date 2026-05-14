@extends('layouts.app')

@section('title', 'Follow-ups')

@section('topbar-actions')
    
@endsection

@section('content')

    <div class="flex justify-end mb-4">
        <a href="{{ route('follow-ups.create') }}"
       class="inline-flex items-center gap-2 px-4 py-2 bg-violet-600 hover:bg-violet-700 text-white text-sm font-medium rounded-lg transition-colors">
        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
        </svg>
        Schedule Follow-up
    </a>
    </div>

    <div class="bg-white rounded-xl shadow-sm p-4 mb-6">
        <form method="GET" action="{{ route('follow-ups.index') }}"
              class="flex flex-col sm:flex-row gap-3 items-end">
            <div class="w-full sm:w-44">
                <label class="block text-xs font-medium text-gray-500 mb-1">Status</label>
                <select name="status"
                        class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-violet-500 focus:border-transparent">
                    <option value="">All</option>
                    <option value="pending"   {{ request('status') === 'pending'   ? 'selected' : '' }}>Pending</option>
                    <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Completed</option>
                </select>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('follow-ups.index', ['overdue' => 1]) }}"
                   class="px-4 py-2 text-sm font-medium rounded-lg border transition-colors
                       {{ request('overdue') ? 'bg-red-600 text-white border-red-600' : 'bg-white text-gray-700 border-gray-300 hover:bg-gray-50' }}">
                    Overdue
                </a>
                <a href="{{ route('follow-ups.index', ['upcoming' => 1]) }}"
                   class="px-4 py-2 text-sm font-medium rounded-lg border transition-colors
                       {{ request('upcoming') ? 'bg-violet-600 text-white border-violet-600' : 'bg-white text-gray-700 border-gray-300 hover:bg-gray-50' }}">
                    Upcoming
                </a>
                <button type="submit"
                        class="px-4 py-2 bg-violet-600 hover:bg-violet-700 text-white text-sm font-medium rounded-lg transition-colors">
                    Filter
                </button>
                <a href="{{ route('follow-ups.index') }}"
                   class="px-4 py-2 bg-white hover:bg-gray-50 text-gray-700 text-sm font-medium rounded-lg border border-gray-300 transition-colors">
                    Clear
                </a>
            </div>
        </form>
    </div>

    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-gray-50 text-xs text-gray-500 uppercase tracking-wider border-b border-gray-100">
                        <th class="px-6 py-3 text-left font-medium">Title</th>
                        <th class="px-6 py-3 text-left font-medium">Linked to</th>
                        <th class="px-6 py-3 text-left font-medium">Assigned</th>
                        <th class="px-6 py-3 text-left font-medium">Due Date</th>
                        <th class="px-6 py-3 text-left font-medium">Status</th>
                        <th class="px-6 py-3 text-right font-medium">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($followUps as $followUp)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4">
                                <p class="font-medium text-gray-900">{{ $followUp->title }}</p>
                                @if($followUp->description)
                                    <p class="text-xs text-gray-400 truncate max-w-xs mt-0.5">{{ $followUp->description }}</p>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                @if($followUp->customer)
                                    <p class="text-xs text-gray-400">Customer</p>
                                    <a href="{{ route('customers.show', $followUp->customer) }}" class="text-sm text-violet-600 hover:underline">{{ $followUp->customer->full_name }}</a>
                                @elseif($followUp->lead)
                                    <p class="text-xs text-gray-400">Lead</p>
                                    <a href="{{ route('leads.show', $followUp->lead) }}" class="text-sm text-violet-600 hover:underline">{{ $followUp->lead->name }}</a>
                                @else
                                    <span class="text-gray-400">—</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                @if($followUp->user)
                                    <div class="flex items-center gap-2">
                                        <div class="w-6 h-6 rounded-full bg-violet-600 flex items-center justify-center text-white text-xs font-semibold flex-shrink-0">
                                            {{ strtoupper(substr($followUp->user->name, 0, 1)) }}
                                        </div>
                                        <span class="text-gray-600 text-sm">{{ $followUp->user->name }}</span>
                                    </div>
                                @else
                                    <span class="text-gray-400">—</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <p class="text-sm {{ $followUp->isOverdue() ? 'text-red-600 font-semibold' : 'text-gray-700' }}">
                                    {{ $followUp->due_date->format('M d, Y') }}
                                </p>
                                <p class="text-xs text-gray-400">{{ $followUp->due_date->format('h:i A') }}</p>
                            </td>
                            <td class="px-6 py-4">
                                @if($followUp->isCompleted())
                                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-700">
                                        Completed
                                    </span>
                                @elseif($followUp->isOverdue())
                                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-700">
                                        Overdue
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-700">
                                        Pending
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center justify-end gap-2">
                                    @if(!$followUp->isCompleted())
                                        <form method="POST" action="{{ route('follow-ups.complete', $followUp) }}">
                                            @csrf @method('PATCH')
                                            <button type="submit" class="p-1.5 text-gray-400 hover:text-green-600 hover:bg-green-50 rounded-lg transition-colors" title="Mark Complete">
                                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                            </button>
                                        </form>
                                        <a href="{{ route('follow-ups.edit', $followUp) }}" class="p-1.5 text-gray-400 hover:text-violet-600 hover:bg-violet-50 rounded-lg transition-colors" title="Edit">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                        </a>
                                    @else
                                        <form method="POST" action="{{ route('follow-ups.reopen', $followUp) }}">
                                            @csrf @method('PATCH')
                                            <button type="submit" class="p-1.5 text-gray-400 hover:text-yellow-600 hover:bg-yellow-50 rounded-lg transition-colors" title="Reopen">
                                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                                            </button>
                                        </form>
                                    @endif
                                    <form method="POST" action="{{ route('follow-ups.destroy', $followUp) }}" onsubmit="return confirm('Delete this follow-up?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="p-1.5 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors" title="Delete">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-gray-400">
                                <svg class="w-10 h-10 mx-auto mb-3 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                                </svg>
                                No follow-ups found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($followUps->hasPages())
            <div class="px-6 py-4 border-t border-gray-100">{{ $followUps->links() }}</div>
        @endif
    </div>

@endsection