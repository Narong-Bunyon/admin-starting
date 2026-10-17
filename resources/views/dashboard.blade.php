@extends('layouts.app')

@section('title', 'User Dashboard - CloudAuth')

@section('content')
<div style="max-width: 900px; margin: 0 auto;">
    <!-- Welcome Header Card -->
    <div class="glass-card" style="padding: 2.5rem; margin-bottom: 2rem; position: relative; overflow: hidden;">
        <div style="position: relative; z-index: 2;">
            <div style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 0.75rem;">
                <span class="badge {{ auth()->user()->role === 'admin' ? 'badge-admin' : 'badge-user' }}">
                    {{ strtoupper(auth()->user()->role) }} ACCOUNT
                </span>
                <span style="font-size: 0.85rem; color: var(--text-dim);">ID #{{ auth()->user()->id }}</span>
            </div>
            
            <h1 style="font-size: 2.25rem; font-weight: 800; letter-spacing: -0.02em; margin-bottom: 0.5rem;">
                Hello, <span style="background: linear-gradient(135deg, #818cf8, #38bdf8); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">{{ auth()->user()->name }}</span>! 👋
            </h1>
            <p style="color: var(--text-muted); font-size: 1.05rem;">
                You are successfully logged in to the application.
            </p>

            @if(auth()->user()->role === 'admin')
                <div style="margin-top: 1.5rem;">
                    <a href="{{ route('admin.users') }}" class="btn btn-primary">
                        🛡 Open Admin Panel (View All Users)
                    </a>
                </div>
            @endif
        </div>
    </div>

    <!-- User Information Grid -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 1.5rem;">
        <div class="glass-card" style="padding: 1.75rem;">
            <h2 style="font-size: 1.1rem; font-weight: 700; margin-bottom: 1.25rem; color: #fff;">Account Profile</h2>
            <div style="display: flex; flex-direction: column; gap: 0.85rem;">
                <div>
                    <span style="display: block; font-size: 0.75rem; text-transform: uppercase; color: var(--text-dim); font-weight: 600;">Display Name</span>
                    <strong style="font-size: 1rem; color: var(--text-main);">{{ auth()->user()->name }}</strong>
                </div>
                <div>
                    <span style="display: block; font-size: 0.75rem; text-transform: uppercase; color: var(--text-dim); font-weight: 600;">Email Address</span>
                    <span style="font-size: 0.95rem; color: var(--text-muted);">{{ auth()->user()->email }}</span>
                </div>
                <div>
                    <span style="display: block; font-size: 0.75rem; text-transform: uppercase; color: var(--text-dim); font-weight: 600;">Account Role</span>
                    <span class="badge {{ auth()->user()->role === 'admin' ? 'badge-admin' : 'badge-user' }}" style="margin-top: 0.2rem;">
                        {{ auth()->user()->role }}
                    </span>
                </div>
            </div>
        </div>

        <div class="glass-card" style="padding: 1.75rem;">
            <h2 style="font-size: 1.1rem; font-weight: 700; margin-bottom: 1.25rem; color: #fff;">Session Details</h2>
            <div style="display: flex; flex-direction: column; gap: 0.85rem;">
                <div>
                    <span style="display: block; font-size: 0.75rem; text-transform: uppercase; color: var(--text-dim); font-weight: 600;">Member Since</span>
                    <span style="font-size: 0.95rem; color: var(--text-muted);">{{ auth()->user()->created_at->format('M d, Y h:i A') }}</span>
                </div>
                <div>
                    <span style="display: block; font-size: 0.75rem; text-transform: uppercase; color: var(--text-dim); font-weight: 600;">Last Activity Time</span>
                    <span style="font-size: 0.95rem; color: #34d399;">
                        {{ auth()->user()->last_login_at ? auth()->user()->last_login_at->diffForHumans() : 'Just now' }}
                    </span>
                </div>
                <div>
                    <span style="display: block; font-size: 0.75rem; text-transform: uppercase; color: var(--text-dim); font-weight: 600;">Docker Ready</span>
                    <span style="font-size: 0.85rem; color: #38bdf8;">✓ Ready for Docker container deployment</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
