@extends('layouts.admin')

@section('title', '編輯 FAQ')

@php
    $breadcrumbs = [
        ['title' => 'FAQ 管理', 'url' => route('admin.faqs.index')],
        ['title' => '編輯', 'url' => '#'],
    ];
@endphp

@section('content')
<div class="row mb-4"><div class="col-12"><h2 class="mb-0">編輯 FAQ</h2></div></div>

<form method="POST" action="{{ route('admin.faqs.update', $faq) }}">
    @csrf
    @method('PUT')
    @include('admin.faqs._form', ['faq' => $faq])
</form>
@endsection
