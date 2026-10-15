@extends('layouts.admin')

@section('content')
    <h1>Audit log</h1>
    <p class="muted">A record of important actions on the site: who did what, and when.</p>

    <div class="tabs">
        @foreach([null => 'All', 'order' => 'Orders', 'product' => 'Products', 'option' => 'Add-ons', 'settings' => 'Settings', 'account' => 'Account'] as $key => $label)
            <a href="{{ route('admin.audit', $key ? ['g' => $key] : []) }}" class="{{ $group == $key ? 'on' : '' }}">{{ $label }}</a>
        @endforeach
    </div>

    <div class="tscroll">
        <table>
            <tr><th>When</th><th>Who</th><th>Action</th><th>Details</th><th>IP</th></tr>
            @forelse($logs as $log)
                <tr>
                    <td style="white-space:nowrap">{{ $log->created_at->format('M j, Y g:i A') }}</td>
                    <td>{{ $log->user?->name ?? 'System' }}</td>
                    <td><span class="tag">{{ ucfirst(str_replace(['.', '_'], ' ', $log->action)) }}</span></td>
                    <td>{{ $log->description }}</td>
                    <td class="muted">{{ $log->ip_address }}</td>
                </tr>
            @empty
                <tr><td colspan="5" class="muted">Nothing logged yet.</td></tr>
            @endforelse
        </table>
    </div>

    <div class="acts" style="margin-top:1rem">
        @if($logs->previousPageUrl())
            <a class="btn ghost sm" href="{{ $logs->previousPageUrl() }}">← Newer</a>
        @endif
        @if($logs->hasMorePages())
            <a class="btn ghost sm" href="{{ $logs->nextPageUrl() }}">Older →</a>
        @endif
    </div>
@endsection
