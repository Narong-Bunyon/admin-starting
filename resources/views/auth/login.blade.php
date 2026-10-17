@extends('layouts.app')

@section('title', 'Login - CloudAuth')

@section('content')
<div class="auth-wrapper">
    <div class="glass-card auth-card">
        <div style="text-align: center; margin-bottom: 2rem;">
            <h1 style="font-size: 1.75rem; font-weight: 700; margin-bottom: 0.5rem;">Sign In</h1>
            <p style="color: var(--text-muted); font-size: 0.9rem;">Enter your credentials to access your account</p>
        </div>

        <form action="{{ route('login.post') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="email" class="form-label">Email Address</label>
                <input 
                    type="email" 
                    id="email" 
                    name="email" 
                    class="form-input" 
                    value="{{ old('email') }}" 
                    required 
                    autofocus
                    placeholder="name@example.com"
                >
                @error('email')
                    <div class="form-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.45rem;">
                    <label for="password" class="form-label" style="margin-bottom: 0;">Password</label>
                </div>
                <input 
                    type="password" 
                    id="password" 
                    name="password" 
                    class="form-input" 
                    required
                    placeholder="••••••••"
                >
                @error('password')
                    <div class="form-error">{{ $message }}</div>
                @enderror
            </div>

            <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 1.5rem;">
                <label style="display: flex; align-items: center; gap: 0.5rem; font-size: 0.85rem; color: var(--text-muted); cursor: pointer;">
                    <input type="checkbox" name="remember" style="accent-color: var(--primary);">
                    Remember me
                </label>
            </div>

            <button type="submit" class="btn btn-primary btn-block" style="padding: 0.8rem;">
                Sign In
            </button>
        </form>

        <p style="text-align: center; margin-top: 1.5rem; font-size: 0.875rem; color: var(--text-muted);">
            Don't have an account? 
            <a href="{{ route('register') }}" style="color: var(--primary); text-decoration: none; font-weight: 600;">Register here</a>
        </p>

        <!-- Quick Demo Credentials for Multi-User Testing -->
        <div class="demo-accounts">
            <div class="demo-title">⚡ Multi-User Testing Accounts:</div>
            <div class="demo-item">👑 Admin: <b>admin@example.com</b> / <code>admin123</code></div>
            <div class="demo-item">👤 User 1: <b>alice@example.com</b> / <code>password123</code></div>
            <div class="demo-item">👤 User 2: <b>bob@example.com</b> / <code>password123</code></div>
        </div>
    </div>
</div>
@endsection
