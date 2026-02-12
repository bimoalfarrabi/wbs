<header class="border-b border-slate-200 bg-white/90 backdrop-blur shadow-sm sticky top-0 z-50">
    <div class="max-w-6xl mx-auto px-4 py-3 flex items-center justify-between">
        <div class="flex items-center gap-3">
            <a href="{{ url('/') }}" class="flex items-center gap-2">
                <img src="https://rsudblambangan.id/images/navbar/Logo.png" alt="Logo RSUD Blambangan" class="h-10 w-10 object-contain">
                <div>
                    <h1 class="text-lg font-bold text-slate-900 leading-tight">WBS RSUD</h1>
                    <p class="text-[10px] text-slate-500 uppercase tracking-wider font-semibold">Blambangan</p>
                </div>
            </a>
        </div>

        <nav class="hidden md:flex items-center gap-6">
            @auth
                <a href="{{ route('wbs.index') }}" class="text-sm font-medium {{ request()->routeIs('wbs.*') ? 'text-blue-600' : 'text-slate-600 hover:text-blue-600' }}">Dashboard</a>
                @if(auth()->user()->role === 'superadmin')
                    <a href="{{ route('users.index') }}" class="text-sm font-medium {{ request()->routeIs('users.*') ? 'text-blue-600' : 'text-slate-600 hover:text-blue-600' }}">Manajemen User</a>
                @endif
            @endauth
        </nav>

        <div class="flex items-center gap-4">
            @auth
                <div class="flex items-center gap-3 pl-4 border-l border-slate-200">
                    <div class="text-right hidden sm:block">
                        <p class="text-xs font-semibold text-slate-900">{{ auth()->user()->name }}</p>
                        <p class="text-[10px] text-slate-500">{{ ucfirst(auth()->user()->role) }}</p>
                    </div>
                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="p-2 text-slate-400 hover:text-red-600 transition-colors" title="Logout">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                        </button>
                    </form>
                </div>
            @else
                @if (Route::has('login'))
                    <a href="{{ route('login') }}" class="text-sm font-semibold text-slate-600 hover:text-blue-600">Login</a>
                @endif
            @endauth
        </div>
    </div>
</header>
