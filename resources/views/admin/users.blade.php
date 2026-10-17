@extends('layouts.app')

@section('title', 'Admin - User Directory')

@section('content')
<div>
    <!-- Page Header -->
    <div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 2rem; flex-wrap: wrap; gap: 1rem;">
        <div>
            <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.4rem;">
                <span class="badge badge-admin">Administrator View</span>
            </div>
            <h1 style="font-size: 2rem; font-weight: 800; letter-spacing: -0.02em;">All Registered Users</h1>
            <p style="color: var(--text-muted); font-size: 0.95rem;">Monitor all registered user accounts and their latest activity</p>
        </div>

        <!-- Search Form -->
        <form method="GET" action="{{ route('admin.users') }}" style="display: flex; gap: 0.5rem; width: 100%; max-width: 360px;">
            <input 
                type="text" 
                name="search" 
                value="{{ $search ?? '' }}" 
                placeholder="Search name, email, or role..." 
                class="form-input"
                style="padding: 0.55rem 0.85rem;"
            >
            <button type="submit" class="btn btn-secondary btn-sm" style="white-space: nowrap;">Search</button>
            @if(!empty($search))
                <a href="{{ route('admin.users') }}" class="btn btn-secondary btn-sm" title="Clear search">Clear</a>
            @endif
        </form>
    </div>

    <!-- Quick Stats -->
    <div class="stats-grid">
        <div class="glass-card stat-card">
            <span class="stat-title">Total Users</span>
            <span class="stat-value">{{ $stats['total_users'] }}</span>
        </div>
        <div class="glass-card stat-card">
            <span class="stat-title">Admin Accounts</span>
            <span class="stat-value" style="color: #c084fc;">{{ $stats['admins'] }}</span>
        </div>
        <div class="glass-card stat-card">
            <span class="stat-title">Standard Users</span>
            <span class="stat-value" style="color: #60a5fa;">{{ $stats['regular_users'] }}</span>
        </div>
        <div class="glass-card stat-card">
            <span class="stat-title">Active (Last 24h)</span>
            <span class="stat-value" style="color: #34d399;">{{ $stats['recently_logged_in'] }}</span>
        </div>
    </div>

    <!-- User Table -->
    <div class="glass-card table-wrapper">
        <table class="custom-table">
            <thead>
                <tr>
                    <th style="width: 70px;">ID</th>
                    <th>User</th>
                    <th>Role</th>
                    <th>Registered At</th>
                    <th>Last Active / Login</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                    <tr>
                        <td style="color: var(--text-dim); font-weight: 600;">#{{ $user->id }}</td>
                        <td>
                            <div style="display: flex; flex-direction: column;">
                                <strong style="color: #fff; font-size: 0.95rem;">
                                    {{ $user->name }}
                                    @if(auth()->id() === $user->id)
                                        <span style="font-size: 0.7rem; background: rgba(255,255,255,0.1); padding: 0.1rem 0.4rem; border-radius: 4px; margin-left: 0.4rem; color: #a5b4fc;">You</span>
                                    @endif
                                </strong>
                                <span style="color: var(--text-muted); font-size: 0.825rem;">{{ $user->email }}</span>
                            </div>
                        </td>
                        <td>
                            <span class="badge {{ $user->role === 'admin' ? 'badge-admin' : 'badge-user' }}">
                                {{ $user->role }}
                            </span>
                        </td>
                        <td style="color: var(--text-muted); font-size: 0.85rem;">
                            {{ $user->created_at ? $user->created_at->format('M d, Y h:i A') : 'N/A' }}
                        </td>
                        <td>
                            @if($user->last_login_at)
                                <span style="color: #34d399; font-size: 0.85rem; display: flex; align-items: center; gap: 0.4rem;">
                                    <span style="width: 6px; height: 6px; border-radius: 50%; background: #34d399; display: inline-block;"></span>
                                    {{ $user->last_login_at->diffForHumans() }}
                                </span>
                            @else
                                <span style="color: var(--text-dim); font-size: 0.85rem;">Never logged in</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" style="text-align: center; padding: 3rem; color: var(--text-muted);">
                            No users found matching your search.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination links -->
    <div style="margin-top: 1.5rem; display: flex; justify-content: center;">
        {{ $users->links() }}
    </div>
</div>
@endsection
