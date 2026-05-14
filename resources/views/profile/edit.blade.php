@extends('layouts.app')

@section('title', 'My Profile')

@section('content')

    <div class="max-w-3xl mx-auto space-y-6">

        <div class="bg-white rounded-xl shadow-sm p-6 flex items-center gap-5">
            <div class="w-16 h-16 rounded-full bg-blue-600 flex items-center justify-center text-white text-2xl font-bold flex-shrink-0">
                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
            </div>
            <div>
                <h2 class="text-lg font-semibold text-gray-900">{{ auth()->user()->name }}</h2>
                <p class="text-sm text-gray-500">{{ auth()->user()->email }}</p>
                @php
                    $badge = match(auth()->user()->role) {
                        'admin'       => 'bg-red-100 text-red-700',
                        'manager'     => 'bg-yellow-100 text-yellow-700',
                        'sales_staff' => 'bg-blue-100 text-blue-700',
                        default       => 'bg-gray-100 text-gray-600',
                    };
                @endphp
                <span class="inline-flex items-center mt-1.5 px-2.5 py-0.5 rounded-full text-xs font-medium capitalize {{ $badge }}">
                    {{ str_replace('_', ' ', auth()->user()->role) }}
                </span>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100">
                <h3 class="font-semibold text-gray-900">Profile Information</h3>
                <p class="text-sm text-gray-500 mt-0.5">Update your name and email address.</p>
            </div>

            <form method="POST" action="{{ route('profile.update') }}" class="p-6 space-y-5">
                @csrf
                @method('PATCH')

                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Full Name <span class="text-red-500">*</span></label>
                    <input type="text" id="name" name="name" value="{{ old('name', auth()->user()->name) }}" autofocus autocomplete="name" class="w-full px-3 py-2 text-sm border rounded-lg focus:outline-none focus:ring-2 focus:ring-violet-500 focus:border-transparent transition
                               {{ $errors->get('name') ? 'border-red-400 bg-red-50' : 'border-gray-300' }}">
                    @if($errors->get('name'))
                        <p class="mt-1 text-xs text-red-600">{{ $errors->first('name') }}</p>
                    @endif
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address <span class="text-red-500">*</span></label>
                    <input type="email" id="email" name="email" value="{{ old('email', auth()->user()->email) }}" autocomplete="username" class="w-full px-3 py-2 text-sm border rounded-lg focus:outline-none focus:ring-2 focus:ring-violet-500 focus:border-transparent transition
                               {{ $errors->get('email') ? 'border-red-400 bg-red-50' : 'border-gray-300' }}">
                    @if($errors->get('email'))
                        <p class="mt-1 text-xs text-red-600">{{ $errors->first('email') }}</p>
                    @endif
                </div>

                @if(auth()->user() instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! auth()->user()->hasVerifiedEmail())
                    <div class="flex items-start gap-3 px-4 py-3 bg-yellow-50 border border-yellow-200 rounded-lg text-sm text-yellow-800">
                        <svg class="w-5 h-5 text-yellow-500 flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                        <div>Your email address is unverified.
                            <form method="POST" action="{{ route('verification.send') }}" class="inline">
                                @csrf
                                <button type="submit" class="underline text-yellow-700 hover:text-yellow-900 ml-1">Click here to re-send the verification email.</button>
                            </form>
                            @if(session('status') === 'verification-link-sent')
                                <p class="mt-1 font-medium text-green-700">A new verification link has been sent.</p>
                            @endif
                        </div>
                    </div>
                @endif

                <div class="flex items-center justify-between pt-2">
                    @if(session('status') === 'profile-updated')
                        <p class="text-sm text-green-600 flex items-center gap-1.5">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                            </svg>Profile updated successfully.
                        </p>
                    @else
                        <span></span>
                    @endif
                    <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-violet-600 hover:bg-violet-700 rounded-lg transition-colors">Save Changes</button>
                </div>

            </form>
        </div>

        {{-- ── Update Password ──────────────────────────────────── --}}
        <div class="bg-white rounded-xl shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100">
                <h3 class="font-semibold text-gray-900">Update Password</h3>
                <p class="text-sm text-gray-500 mt-0.5">Use a strong password to keep your account secure.</p>
            </div>

            <form method="POST" action="{{ route('password.update') }}" class="p-6 space-y-5">
                @csrf
                @method('PUT')

                <div>
                    <label for="current_password" class="block text-sm font-medium text-gray-700 mb-1">Current Password <span class="text-red-500">*</span></label>
                    <input type="password" id="current_password" name="current_password" autocomplete="current-password" placeholder="Enter current password" class="w-full px-3 py-2 text-sm border rounded-lg focus:outline-none focus:ring-2 focus:ring-violet-500 focus:border-transparent transition
                               {{ $errors->updatePassword->get('current_password') ? 'border-red-400 bg-red-50' : 'border-gray-300' }}">
                    @if($errors->updatePassword->get('current_password'))
                        <p class="mt-1 text-xs text-red-600">{{ $errors->updatePassword->first('current_password') }}</p>
                    @endif
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">New Password <span class="text-red-500">*</span></label>
                    <input type="password" id="password" name="password" autocomplete="new-password" placeholder="Minimum 8 characters"class="w-full px-3 py-2 text-sm border rounded-lg focus:outline-none focus:ring-2 focus:ring-violet-500 focus:border-transparent transition
                               {{ $errors->updatePassword->get('password') ? 'border-red-400 bg-red-50' : 'border-gray-300' }}">
                    @if($errors->updatePassword->get('password'))
                        <p class="mt-1 text-xs text-red-600">{{ $errors->updatePassword->first('password') }}</p>
                    @endif
                </div>

                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Confirm New Password <span class="text-red-500">*</span></label>
                    <input type="password" id="password_confirmation" name="password_confirmation" autocomplete="new-password" placeholder="Re-enter new password" class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-violet-500 focus:border-transparent transition">
                    @if($errors->updatePassword->get('password_confirmation'))
                        <p class="mt-1 text-xs text-red-600">{{ $errors->updatePassword->first('password_confirmation') }}</p>
                    @endif
                </div>

                <div class="flex items-center justify-between pt-2">
                    @if(session('status') === 'password-updated')
                        <p class="text-sm text-green-600 flex items-center gap-1.5">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                            </svg>Password updated successfully.
                        </p>
                    @else
                        <span></span>
                    @endif
                    <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-violet-600 hover:bg-violet-700 rounded-lg transition-colors">Update Password</button>
                </div>

            </form>
        </div>

        <div class="bg-white rounded-xl shadow-sm overflow-hidden">
            <div class="px-6 py-3 border-b border-red-100 bg-red-50">
                <h3 class="font-semibold text-red-700 text-sm">Danger Zone</h3>
            </div>
            <div class="p-6">
                <p class="text-sm text-gray-600 mb-4">
                    Once your account is deleted, all data associated with it will be permanently removed.
                    This action cannot be undone.
                </p>
                <button type="button" onclick="document.getElementById('delete-modal').classList.remove('hidden')" class="px-4 py-2 text-sm font-medium text-red-600 bg-white border border-red-300 rounded-lg hover:bg-red-50 transition-colors">Delete Account</button>
            </div>
        </div>

    </div>

    <div id="delete-modal"
         class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 px-4">
        <div class="bg-white rounded-xl shadow-xl w-full max-w-md p-6">

            <div class="flex items-center gap-3 mb-4">
                <div class="w-10 h-10 rounded-full bg-red-100 flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-900">Delete Account</h3>
                    <p class="text-xs text-gray-500">This cannot be undone.</p>
                </div>
            </div>

            <p class="text-sm text-gray-600 mb-5">Please enter your password to confirm you want to permanently delete your account.</p>

            <form method="POST" action="{{ route('profile.destroy') }}" class="space-y-4">
                @csrf
                @method('DELETE')

                <div>
                    <label for="delete_password" class="block text-sm font-medium text-gray-700 mb-1">
                        Password
                    </label>
                    <input type="password" id="delete_password" name="password" placeholder="Enter your password" class="w-full px-3 py-2 text-sm border rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent transition
                               {{ $errors->userDeletion->get('password') ? 'border-red-400 bg-red-50' : 'border-gray-300' }}">
                    @if($errors->userDeletion->get('password'))
                        <p class="mt-1 text-xs text-red-600">{{ $errors->userDeletion->first('password') }}</p>
                    @endif
                </div>

                <div class="flex items-center justify-end gap-3 pt-2">
                    <button type="button" onclick="document.getElementById('delete-modal').classList.add('hidden')" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">Cancel</button>
                    <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-red-600 hover:bg-red-700 rounded-lg transition-colors">Yes, Delete My Account</button>
                </div>

            </form>
        </div>
    </div>

    @if($errors->userDeletion->isNotEmpty())
        <script>
            document.getElementById('delete-modal').classList.remove('hidden');
        </script>
    @endif

@endsection