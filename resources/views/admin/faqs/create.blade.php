@extends('layouts.admin')

@section('title', '新增 FAQ')

@php
    $breadcrumbs = [
        ['title' => 'FAQ 管理', 'url' => route('admin.faqs.index')],
        ['title' => '新增', 'url' => '#'],
    ];
@endphp

@section('content')
<div class="row mb-4"><div class="col-12"><h2 class="mb-0">新增 FAQ</h2></div></div>

<form method="POST" action="{{ route('admin.faqs.store') }}">
    @csrf
    @include('admin.faqs._form', ['faq' => null])
</form>
@endsection
