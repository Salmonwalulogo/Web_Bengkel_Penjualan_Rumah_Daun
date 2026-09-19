@extends('backend.layouts.customer')

@section('title', 'Notifikasi')

@section('content')
<div class="container-fluid"><h1 class="h3 mb-4 text-gray-800">Notifikasi</h1><div class="card shadow"><div class="card-body">
@forelse($notifications as $notification)
<div class="d-flex justify-content-between align-items-start gap-3 p-3 mb-2 rounded {{ $notification->is_read ? 'bg-light' : 'bg-success-subtle' }}"><div><h6 class="mb-1">{{ $notification->title }}</h6><p class="mb-1 text-muted">{{ $notification->message }}</p><small class="text-muted">{{ $notification->created_at->format('d/m/Y H:i') }}</small></div>@if(!$notification->is_read)<form action="{{ route('customer.notifications.read', $notification) }}" method="POST">@csrf<button class="btn btn-sm btn-outline-success">Tandai dibaca</button></form>@endif</div>
@empty<div class="text-center text-muted py-4">Belum ada notifikasi.</div>@endforelse
{{ $notifications->links() }}</div></div></div>
@endsection
