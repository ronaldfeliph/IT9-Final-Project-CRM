@extends('layouts.app')

@section('title', $user->name)

@section('topbar-actions')
    
@endsection

@section('content')
    <div class="flex justify-end mb-4">
        <div class="flex items-center gap-2">
            <a href="{{ route('users.edit', $user) }}"
            class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
                Edit
            </a>
            <a href="{{ route('users.index') }}"
            class="inline-flex items-center gap-2 px-4 py-2 bg-white hover:bg-gray-50 text-gray-700 text-sm font-medium rounded-lg border border-gray-300 transition-colors">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Back
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- ── Profile Card ─────────────────────────────────────── --}}
        <div class="space-y-4">

            <div class="bg-white rounded-xl shadow-sm p-6 text-center">
                {{-- Avatar --}}
                <div class="w-16 h-16 rounded-full bg-blue-600 flex items-center justify-center text-white text-2xl font-bold mx-auto mb-4">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>

                <h2 class="font-semibold text-gray-900 text-lg">{{ $user->name }}</h2>
                <p class="text-sm text-gray-500 mt-0.5">{{ $user->email }}</p>

                @php
                    $badge = match($user->role) {
                        'admin'       => 'bg-red-100 text-red-700',
                        'manager'     => 'bg-yellow-100 text-yellow-700',
                        'sales_staff' => 'bg-blue-100 text-blue-700',
                        default       => 'bg-gray-100 text-gray-600',
                    };
                @endphp
                <span class="inline-flex items-center mt-3 px-3 py-1 rounded-full text-xs font-medium capitalize {{ $badge }}">
                    {{ str_replace('_', ' ', $user->role) }}
                </span>

                <p class="text-xs text-gray-400 mt-4">
                    Member since {{ $user->created_at->format('M d, Y') }}
                </p>
            </div>

            {{-- Danger Zone --}}
            @if($user->id !== auth()->id())
                <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                    <div class="px-5 py-3 border-b border-red-100 bg-red-50">
                        <h3 class="text-sm font-medium text-red-700">Danger Zone</h3>
                    </div>
                    <div class="p-5">
                        <p class="text-xs text-gray-500 mb-4">
                            Permanently delete this user account. This action cannot be undone.
                        </p>
                        <form method="POST"
                              action="{{ route('users.destroy', $user) }}"
                              onsubmit="return confirm('Are you sure you want to delete {{ addslashes($user->name) }}?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="w-full px-4 py-2 text-sm font-medium text-red-600 bg-white border border-red-300 rounded-lg hover:bg-red-50 transition-colors">
                                Delete User
                            </button>
                        </form>
                    </div>
                </div>
            @endif

        </div>

        {{-- ── Stats + Details ──────────────────────────────────── --}}
        <div class="lg:col-span-2 space-y-4">

            {{-- Stats --}}
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                <div class="bg-white rounded-xl shadow-sm p-4 text-center">
                    <p class="text-2xl font-bold text-gray-900">{{ $user->assigned_customers_count }}</p>
                    <p class="text-xs text-gray-500 mt-1">Customers</p>
                </div>
                <div class="bg-white rounded-xl shadow-sm p-4 text-center">
                    <p class="text-2xl font-bold text-gray-900">{{ $user->assigned_leads_count }}</p>
                    <p class="text-xs text-gray-500 mt-1">Leads</p>
                </div>
                <div class="bg-white rounded-xl shadow-sm p-4 text-center">
                    <p class="text-2xl font-bold text-gray-900">{{ $user->activities_count }}</p>
                    <p class="text-xs text-gray-500 mt-1">Activities</p>
                </div>
                <div class="bg-white rounded-xl shadow-sm p-4 text-center">
                    <p class="text-2xl font-bold text-gray-900">{{ $user->follow_ups_count }}</p>
                    <p class="text-xs text-gray-500 mt-1">Follow-ups</p>
                </div>
            </div>

            {{-- Account Details --}}
            <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100">
                    <h3 class="font-semibold text-gray-900 text-sm">Account Details</h3>
                </div>
                <dl class="divide-y divide-gray-50">
                    <div class="px-6 py-3 flex items-center gap-4">
                        <dt class="w-36 text-xs text-gray-500 flex-shrink-0">Full Name</dt>
                        <dd class="text-sm text-gray-900">{{ $user->name }}</dd>
                    </div>
                    <div class="px-6 py-3 flex items-center gap-4">
                        <dt class="w-36 text-xs text-gray-500 flex-shrink-0">Email</dt>
                        <dd class="text-sm text-gray-900">{{ $user->email }}</dd>
                    </div>
                    <div class="px-6 py-3 flex items-center gap-4">
                        <dt class="w-36 text-xs text-gray-500 flex-shrink-0">Role</dt>
                        <dd class="text-sm text-gray-900 capitalize">{{ str_replace('_', ' ', $user->role) }}</dd>
                    </div>
                    <div class="px-6 py-3 flex items-center gap-4">
                        <dt class="w-36 text-xs text-gray-500 flex-shrink-0">Email Verified</dt>
                        <dd class="text-sm">
                            @if($user->email_verified_at)
                                <span class="text-green-600 flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    {{ $user->email_verified_at->format('M d, Y') }}
                                </span>
                            @else
                                <span class="text-red-500 flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    Not verified
                                </span>
                            @endif
                        </dd>
                    </div>
                    <div class="px-6 py-3 flex items-center gap-4">
                        <dt class="w-36 text-xs text-gray-500 flex-shrink-0">Created At</dt>
                        <dd class="text-sm text-gray-900">{{ $user->created_at->format('M d, Y h:i A') }}</dd>
                    </div>
                    <div class="px-6 py-3 flex items-center gap-4">
                        <dt class="w-36 text-xs text-gray-500 flex-shrink-0">Last Updated</dt>
                        <dd class="text-sm text-gray-900">{{ $user->updated_at->format('M d, Y h:i A') }}</dd>
                    </div>
                </dl>
            </div>

        </div>
    </div>

@endsection