<aside class="fixed inset-y-0 left-0 w-64 h-screen bg-white border-r border-gray-200 text-white flex flex-col">
    <nav class="flex-1 px-4 pt-0 pb-4 space-y-1 overflow-y-auto">

        <div class="flex items-center">
            <img src="{{ asset('images/opulync-logo.svg') }}" alt="Logo" class="h-full w-auto block">
        </div>
        
        <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg text-base font-medium transition-colors
               {{ request()->routeIs('dashboard') ? 'bg-violet-50 text-violet-600' : 'text-gray-700 hover:bg-gray-100' }}">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 fill-current shrink-0" viewBox="0 -960 960 960">
                <path d="M520-600v-240h320v240H520ZM120-440v-400h320v400H120Zm400 320v-400h320v400H520Zm-400 0v-240h320v240H120Zm80-400h160v-240H200v240Zm400 320h160v-240H600v240Zm0-480h160v-80H600v80ZM200-200h160v-80H200v80Zm160-320Zm240-160Zm0 240ZM360-280Z"/>
            </svg>Dashboard
        </a>

        <a href="{{ route('customers.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg text-base font-medium transition-colors
               {{ request()->routeIs('customers.*') ? 'bg-violet-50 text-violet-600' : 'text-gray-700 hover:bg-gray-100' }}">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
            </svg>Customers
        </a>

        <a href="{{ route('leads.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg text-base font-medium transition-colors
               {{ request()->routeIs('leads.*') ? 'bg-violet-50 text-violet-600' : 'text-gray-700 hover:bg-gray-100' }}">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2a1 1 0 01-.293.707L13 13.414V19a1 1 0 01-.553.894l-4 2A1 1 0 017 21v-7.586L3.293 6.707A1 1 0 013 6V4z"/>
            </svg>Leads
        </a>

        <a href="{{ route('activities.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg text-base font-medium transition-colors
               {{ request()->routeIs('activities.*') ? 'bg-violet-50 text-violet-600' : 'text-gray-700 hover:bg-gray-100' }}">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/>
            </svg>Activities
        </a>

        <a href="{{ route('follow-ups.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg text-base font-medium transition-colors
               {{ request()->routeIs('follow-ups.*') ? 'bg-violet-50 text-violet-600' : 'text-gray-700 hover:bg-gray-100' }}">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
            </svg>Follow-ups
        </a>

        {{-- manager & admin --}}
        @if(auth()->user()->isAdmin() || auth()->user()->isManager())
        <a href="{{ route('reports.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg text-base font-medium transition-colors
               {{ request()->routeIs('reports.*') ? 'bg-violet-50 text-violet-600' : 'text-gray-700 hover:bg-gray-100' }}">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
            </svg>Reports
        </a>
        @endif

        {{-- Admin only section --}}
        @if(auth()->user()->isAdmin())
        <div>
            <a href="{{ route('users.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg text-base font-medium transition-colors
                   {{ request()->routeIs('users.*') ? 'bg-violet-50 text-violet-600' : 'text-gray-700 hover:bg-gray-100' }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                </svg>User Management
            </a>
        </div>
        @endif
    </nav>

</aside>