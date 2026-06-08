@extends('layouts.admin')

@section('title', '聯絡訊息')

@php
    $breadcrumbs = [
        ['title' => '聯絡訊息', 'url' => '#'],
    ];
@endphp

@section('content')
<div class="row mb-4">
    <div class="col-12 d-flex justify-content-between align-items-center">
        <div>
            <h2 class="mb-0">聯絡訊息</h2>
            <p class="text-muted mb-0">官網聯絡表單收件（未讀 {{ $unreadCount }} 筆）</p>
        </div>
        <form method="GET" class="d-flex gap-2">
            <input type="text" name="search" value="{{ request('search') }}" class="form-control form-control-sm" placeholder="搜尋姓名/Email/主旨">
            <select name="filter" class="form-select form-select-sm" onchange="this.form.submit()">
                <option value="">全部</option>
                <option value="unread" {{ request('filter') === 'unread' ? 'selected' : '' }}>僅未讀</option>
            </select>
            <button class="btn btn-sm btn-primary">搜尋</button>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0 align-middle">
                <thead>
                    <tr>
                        <th>狀態</th>
                        <th>姓名</th>
                        <th>主旨</th>
                        <th>Email</th>
                        <th>語系</th>
                        <th>送出時間</th>
                        <th class="text-end">操作</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($contacts as $contact)
                    <tr class="{{ $contact->is_read ? '' : 'fw-bold' }}">
                        <td>
                            @if($contact->is_read)
                                <span class="badge bg-secondary">已讀</span>
                            @else
                                <span class="badge bg-warning text-dark">未讀</span>
                            @endif
                        </td>
                        <td>{{ $contact->name }}</td>
                        <td>{{ $contact->subject ?: '—' }}</td>
                        <td>{{ $contact->email }}</td>
                        <td>{{ $contact->locale ?: '—' }}</td>
                        <td>{{ $contact->created_at->format('Y-m-d H:i') }}</td>
                        <td class="text-end">
                            <a href="{{ route('admin.contacts.show', $contact) }}" class="btn btn-sm btn-outline-primary">檢視</a>
                            <form method="POST" action="{{ route('admin.contacts.destroy', $contact) }}" class="d-inline"
                                  onsubmit="return confirm('確定刪除此訊息？');">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger">刪除</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="7" class="text-center text-muted py-4">目前沒有聯絡訊息</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($contacts->hasPages())
    <div class="card-footer">{{ $contacts->links() }}</div>
    @endif
</div>
@endsection
