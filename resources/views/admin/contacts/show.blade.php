@extends('layouts.admin')

@section('title', '聯絡訊息 - ' . $contact->name)

@php
    $breadcrumbs = [
        ['title' => '聯絡訊息', 'url' => route('admin.contacts.index')],
        ['title' => $contact->name, 'url' => '#'],
    ];
@endphp

@section('content')
<div class="row mb-4">
    <div class="col-12 d-flex justify-content-between align-items-center">
        <h2 class="mb-0">聯絡訊息</h2>
        <a href="{{ route('admin.contacts.index') }}" class="btn btn-light">返回列表</a>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header"><strong>訊息內容</strong></div>
            <div class="card-body">
                <table class="table">
                    <tr><th style="width:140px;">姓名</th><td>{{ $contact->name }}</td></tr>
                    <tr><th>電子郵件</th><td><a href="mailto:{{ $contact->email }}">{{ $contact->email }}</a></td></tr>
                    <tr><th>聯絡電話</th><td>{{ $contact->phone ?: '—' }}</td></tr>
                    <tr><th>主旨</th><td>{{ $contact->subject ?: '—' }}</td></tr>
                    <tr><th>訊息</th><td>{!! nl2br(e($contact->message)) !!}</td></tr>
                    <tr><th>來源語系</th><td>{{ $contact->locale ?: '—' }}</td></tr>
                    <tr><th>IP</th><td>{{ $contact->ip ?: '—' }}</td></tr>
                    <tr><th>送出時間</th><td>{{ $contact->created_at->format('Y-m-d H:i:s') }}</td></tr>
                </table>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card">
            <div class="card-body d-grid gap-2">
                <a href="mailto:{{ $contact->email }}?subject=Re: {{ $contact->subject }}" class="btn btn-primary">回覆寄件人</a>
                <form method="POST" action="{{ route('admin.contacts.mark-read', $contact) }}">
                    @csrf
                    <button class="btn btn-light w-100">{{ $contact->is_read ? '標記為未讀' : '標記為已讀' }}</button>
                </form>
                <form method="POST" action="{{ route('admin.contacts.destroy', $contact) }}"
                      onsubmit="return confirm('確定刪除此訊息？');">
                    @csrf @method('DELETE')
                    <button class="btn btn-outline-danger w-100">刪除訊息</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
