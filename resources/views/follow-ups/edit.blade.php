@extends('layouts.app')

@section('title', 'Edit Follow-up')

@section('topbar-actions')

@endsection

@section('content')

    <div class="flex justify-end mb-4">
        <a href="{{ route('follow-ups.index') }}"
       class="inline-flex items-center gap-2 px-4 py-2 bg-white hover:bg-gray-50 text-gray-700 text-sm font-medium rounded-lg border border-gray-300 transition-colors">
        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
        </svg>
        Back
    </a>
    </div>

    <div class="max-w-2xl mx-auto">
        <div class="bg-white rounded-xl shadow-sm overflow-hidden">

            <div class="px-6 py-4 border-b border-gray-100">
                <h2 class="font-semibold text-gray-900">Edit Follow-up</h2>
                <p class="text-sm text-gray-500 mt-0.5">{{ $followUp->title }}</p>
            </div>

            <form method="POST" action="{{ route('follow-ups.update', $followUp) }}" class="p-6 space-y-5">
                @csrf
                @method('PUT')

                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700 mb-1">
                        Title <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="title" name="title" value="{{ old('title', $followUp->title) }}" autofocus class="w-full px-3 py-2 text-sm border rounded-lg focus:outline-none focus:ring-2 focus:ring-violet-500 focus:border-transparent transition
                               {{ $errors->has('title') ? 'border-red-400 bg-red-50' : 'border-gray-300' }}">
                    @error('title')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="customer_id" class="block text-sm font-medium text-gray-700 mb-1">Customer</label>
                        <select id="customer_id" name="customer_id" class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-violet-500 focus:border-transparent transition">
                            <option value="">Select customer...</option>
                            @foreach($customers as $customer)
                                <option value="{{ $customer->id }}"
                                    {{ old('customer_id', $followUp->customer_id) == $customer->id ? 'selected' : '' }}>
                                    {{ $customer->full_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="lead_id" class="block text-sm font-medium text-gray-700 mb-1">Lead</label>
                        <select id="lead_id" name="lead_id"
                                class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-violet-500 focus:border-transparent transition">
                            <option value="">Select lead...</option>
                            @foreach($leads as $lead)
                                <option value="{{ $lead->id }}"
                                    {{ old('lead_id', $followUp->lead_id) == $lead->id ? 'selected' : '' }}>
                                    {{ $lead->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                @error('customer_id')
                    <p class="-mt-3 text-xs text-red-600">{{ $message }}</p>
                @enderror

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="due_date" class="block text-sm font-medium text-gray-700 mb-1">
                            Due Date <span class="text-red-500">*</span>
                        </label>
                        <input type="datetime-local" id="due_date" name="due_date" value="{{ old('due_date', $followUp->due_date->format('Y-m-d\TH:i')) }}"class="w-full px-3 py-2 text-sm border rounded-lg focus:outline-none focus:ring-2 focus:ring-violet-500 focus:border-transparent transition
                                   {{ $errors->has('due_date') ? 'border-red-400 bg-red-50' : 'border-gray-300' }}">
                        @error('due_date')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-1">
                            Status <span class="text-red-500">*</span>
                        </label>
                        <select id="status" name="status" class="w-full px-3 py-2 text-sm border rounded-lg focus:outline-none focus:ring-2 focus:ring-violet-500 focus:border-transparent transition
                                    {{ $errors->has('status') ? 'border-red-400 bg-red-50' : 'border-gray-300' }}">
                            <option value="pending"   {{ old('status', $followUp->status) === 'pending'   ? 'selected' : '' }}>Pending</option>
                            <option value="completed" {{ old('status', $followUp->status) === 'completed' ? 'selected' : '' }}>Completed</option>
                        </select>
                    </div>
                </div>

                @if(auth()->user()->isAdmin() || auth()->user()->isManager())
                <div>
                    <label for="user_id" class="block text-sm font-medium text-gray-700 mb-1">
                        Assign To
                    </label>
                    <select id="user_id" name="user_id"
                            class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-violet-500 focus:border-transparent transition">
                        <option value="">Select staff...</option>
                        @foreach($salesStaff as $staff)
                            <option value="{{ $staff->id }}"
                                {{ old('user_id', $followUp->user_id) == $staff->id ? 'selected' : '' }}>
                                {{ $staff->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                @endif

                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-1">
                        Notes
                    </label>
                    <textarea id="description" name="description" rows="3" class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-violet-500 focus:border-transparent transition resize-none">{{ old('description', $followUp->description) }}</textarea>
                </div>

                <div class="flex items-center justify-end gap-3 pt-2">
                    <a href="{{ route('follow-ups.index') }}" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                        Cancel
                    </a>
                    <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-violet-600 hover:bg-violet-700 rounded-lg transition-colors">
                        Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>

@endsection