@extends('layouts.app')

@section('title', 'Edit Activity')

@section('topbar-actions')
    <a href="{{ route('activities.index') }}"
       class="inline-flex items-center gap-2 px-4 py-2 bg-white hover:bg-gray-50 text-gray-700 text-sm font-medium rounded-lg border border-gray-300 transition-colors">
        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
        </svg>
        Back
    </a>
@endsection

@section('content')

    <div class="max-w-2xl mx-auto">
        <div class="bg-white rounded-xl shadow-sm overflow-hidden">

            <div class="px-6 py-4 border-b border-gray-100">
                <h2 class="font-semibold text-gray-900">Edit Activity</h2>
                <p class="text-sm text-gray-500 mt-0.5">Update the details of this logged activity.</p>
            </div>

            <form method="POST" action="{{ route('activities.update', $activity) }}" class="p-6 space-y-5">
                @csrf
                @method('PUT')

                {{-- Activity Type --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Activity Type <span class="text-red-500">*</span>
                    </label>
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-2"
                         x-data="{ selected: '{{ old('activity_type', $activity->activity_type) }}' }">
                        @foreach($types as $key => $label)
                            @php
                                $activeClass = match($key) {
                                    'call'    => 'bg-blue-50 border-blue-500 text-blue-700',
                                    'email'   => 'bg-purple-50 border-purple-500 text-purple-700',
                                    'meeting' => 'bg-green-50 border-green-500 text-green-700',
                                    'note'    => 'bg-gray-100 border-gray-500 text-gray-700',
                                    default   => '',
                                };
                                $icon = match($key) {
                                    'call'    => 'M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z',
                                    'email'   => 'M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z',
                                    'meeting' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z',
                                    'note'    => 'M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z',
                                    default   => '',
                                };
                            @endphp
                            <label class="cursor-pointer" @click="selected = '{{ $key }}'">
                                <input type="radio"
                                       name="activity_type"
                                       value="{{ $key }}"
                                       class="sr-only"
                                       {{ old('activity_type', $activity->activity_type) === $key ? 'checked' : '' }}>
                                <div class="flex flex-col items-center gap-2 p-3 border-2 rounded-lg transition-colors"
                                     :class="selected === '{{ $key }}'
                                         ? '{{ $activeClass }}'
                                         : 'border-gray-300 text-gray-600 hover:bg-gray-50'">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="{{ $icon }}"/>
                                    </svg>
                                    <span class="text-xs font-medium">{{ $label }}</span>
                                </div>
                            </label>
                        @endforeach
                    </div>
                    @error('activity_type')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Customer + Lead --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="customer_id" class="block text-sm font-medium text-gray-700 mb-1">Customer</label>
                        <select id="customer_id" name="customer_id"
                                class="w-full px-3 py-2 text-sm text-gray-900 bg-white border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-violet-500 focus:border-transparent transition">
                            <option value="" class="text-gray-900">Select customer...</option>
                            @foreach($customers as $customer)
                                <option value="{{ $customer->id }}"
                                        class="text-gray-900 bg-white"
                                        {{ old('customer_id', $activity->customer_id) == $customer->id ? 'selected' : '' }}>
                                    {{ $customer->full_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="lead_id" class="block text-sm font-medium text-gray-700 mb-1">Lead</label>
                        <select id="lead_id" name="lead_id"
                                class="w-full px-3 py-2 text-sm text-gray-900 bg-white border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-violet-500 focus:border-transparent transition">
                            <option value="" class="text-gray-900">Select lead...</option>
                            @foreach($leads as $lead)
                                <option value="{{ $lead->id }}"
                                        class="text-gray-900 bg-white"
                                        {{ old('lead_id', $activity->lead_id) == $lead->id ? 'selected' : '' }}>
                                    {{ $lead->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                @error('customer_id')
                    <p class="-mt-3 text-xs text-red-600">{{ $message }}</p>
                @enderror

                {{-- Activity Date --}}
                <div>
                    <label for="activity_date" class="block text-sm font-medium text-gray-700 mb-1">
                        Date & Time <span class="text-red-500">*</span>
                    </label>
                    <input type="datetime-local"
                           id="activity_date"
                           name="activity_date"
                           value="{{ old('activity_date', $activity->activity_date->format('Y-m-d\TH:i')) }}"
                           class="w-full px-3 py-2 text-sm border rounded-lg focus:outline-none focus:ring-2 focus:ring-violet-500 focus:border-transparent transition
                               {{ $errors->has('activity_date') ? 'border-red-400 bg-red-50' : 'border-gray-300' }}">
                    @error('activity_date')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Description --}}
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-1">
                        Description <span class="text-red-500">*</span>
                    </label>
                    <textarea id="description"
                              name="description"
                              rows="4"
                              placeholder="Describe what happened during this activity..."
                              class="w-full px-3 py-2 text-sm border rounded-lg focus:outline-none focus:ring-2 focus:ring-violet-500 focus:border-transparent transition resize-none
                                  {{ $errors->has('description') ? 'border-red-400 bg-red-50' : 'border-gray-300' }}">{{ old('description', $activity->description) }}</textarea>
                    @error('description')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Actions --}}
                <div class="flex items-center justify-end gap-3 pt-2">
                    <a href="{{ route('activities.index') }}"
                       class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                        Cancel
                    </a>
                    <button type="submit"
                            class="px-4 py-2 text-sm font-medium text-white bg-violet-600 hover:bg-violet-700 rounded-lg transition-colors">
                        Save Changes
                    </button>
                </div>

            </form>
        </div>
    </div>

@endsection