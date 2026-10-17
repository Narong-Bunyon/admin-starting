@extends('layouts.app')

@section('title', 'Register - CloudAuth')

@section('content')
<div class="auth-wrapper">
    <div class="glass-card auth-card">
        <div style="text-align: center; margin-bottom: 2rem;">
            <h1 style="font-size: 1.75rem; font-weight: 700; margin-bottom: 0.5rem;">Create Account</h1>
            <p style="color: var(--text-muted); font-size: 0.9rem;">Register to access your personal dashboard</p>
        </div>

        <form action="{{ route('register.post') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="name" class="form-label">Full Name</label>
                <input 
                    type="text" 
                    id="name" 
                    name="name" 
                    class="form-input" 
                    value="{{ old('name') }}" 
                    required 
                    autofocus
                    placeholder="John Doe"
                >
                @error('name')
                    <div class="form-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="email" class="form-label">Email Address</label>
                <input 
                    type="email" 
                    id="email" 
                    name="email" 
                    class="form-input" 
                    value="{{ old('email') }}" 
                    required 
                    placeholder="john@example.com"
                >
                @error('email')
                    <div class="form-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="password" class="form-label">Password</label>
                <input 
                    type="password" 
                    id="password" 
                    name="password" 
                    class="form-input" 
                    required
                    placeholder="Minimum 6 characters"
                >
                @error('password')
                    <div class="form-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="password_confirmation" class="form-label">Confirm Password</label>
                <input 
                    type="password" 
                    id="password_confirmation" 
                    name="password_confirmation" 
                    class="form-input" 
                    required
                    placeholder="Re-enter password"
                >
            </div>

            <button type="submit" class="btn btn-primary btn-block" style="padding: 0.8rem; margin-top: 1rem;">
                Create Account
            </button>
        </form>

        <p style="text-align: center; margin-top: 1.5rem; font-size: 0.875rem; color: var(--text-muted);">
            Already have an account? 
            <a href="{{ route('login') }}" style="color: var(--primary); text-decoration: none; font-weight: 600;">Sign in here</a>
        </p>
    </div>
</div>
@endsection
