@extends('backend.layouts.admin')

@section('title', 'Detail Pesan Kontak')

@section('content')
<div class="container-fluid py-4">
    <a href="{{ route('admin.contact-messages.index') }}" class="btn btn-link px-0 mb-3">← Kembali</a>
    <div class="card">
        <div class="card-body">
            <h1 class="h4 mb-4">{{ $contactMessage->name }}</h1>
            <dl class="row">
                <dt class="col-sm-3">Email</dt><dd class="col-sm-9">{{ $contactMessage->email }}</dd>
                <dt class="col-sm-3">Telepon</dt><dd class="col-sm-9">{{ $contactMessage->phone }}</dd>
                <dt class="col-sm-3">Waktu</dt><dd class="col-sm-9">{{ $contactMessage->created_at->format('d/m/Y H:i') }}</dd>
                <dt class="col-sm-3">Pesan</dt><dd class="col-sm-9 text-break">{!! nl2br(e($contactMessage->message)) !!}</dd>
            </dl>
            <a href="mailto:{{ $contactMessage->email }}" class="btn btn-primary">Balas melalui email</a>
        </div>
    </div>
</div>
@endsection
