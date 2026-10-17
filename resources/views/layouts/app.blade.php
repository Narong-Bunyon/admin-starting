<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Admin & Auth System')</title>

    <!-- Vite Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <!-- Top Navigation Bar -->
    <header class="navbar">
        <a href="{{ route('dashboard') }}" class="brand-logo">
            <span class="brand-badge">PRO</span>
            <span>CloudAuth</span>
        </a>

        <nav>
            <ul class="nav-links">
                @auth
                    <li>
                        <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                            Dashboard
                        </a>
                    </li>
                    @if(auth()->user()->role === 'admin')
                        <li>
                            <a href="{{ route('admin.users') }}" class="nav-link {{ request()->routeIs('admin.*') ? 'active' : '' }}">
                                Users Management
                            </a>
                        </li>
                    @endif
                    <li style="display: flex; align-items: center; gap: 0.75rem; margin-left: 0.5rem;">
                        <span style="font-size: 0.85rem; color: var(--text-muted);">
                            {{ auth()->user()->name }} 
                            <span class="badge {{ auth()->user()->role === 'admin' ? 'badge-admin' : 'badge-user' }}">{{ auth()->user()->role }}</span>
                        </span>
                        <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                            @csrf
                            <button type="submit" class="btn btn-secondary btn-sm">Logout</button>
                        </form>
                    </li>
                @else
                    <li>
                        <a href="{{ route('login') }}" class="nav-link {{ request()->routeIs('login') ? 'active' : '' }}">Login</a>
                    </li>
                    <li>
                        <a href="{{ route('register') }}" class="btn btn-primary btn-sm">Get Started</a>
                    </li>
                @endauth
            </ul>
        </nav>
    </header>

    <!-- Flash Messages Container -->
    <main class="container" style="padding-top: 2rem; padding-bottom: 3rem;">
        @if(session('success'))
            <div class="alert alert-success">
                <span>✓</span>
                <div>{{ session('success') }}</div>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">
                <span>⚠</span>
                <div>{{ session('error') }}</div>
            </div>
        @endif

        @if(session('info'))
            <div class="alert alert-info">
                <span>ℹ</span>
                <div>{{ session('info') }}</div>
            </div>
        @endif

        @yield('content')
    </main>
</body>
</html>
