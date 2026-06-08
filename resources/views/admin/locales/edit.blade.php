@extends('layouts.admin')
@section('title', '編輯語系')
@php $breadcrumbs = [['title' => '語系管理', 'url' => route('admin.locales.index')], ['title' => '編輯', 'url' => '#']]; @endphp
@section('content')
<div class="row mb-4"><div class="col-12"><h2 class="mb-0">編輯語系：{{ $locale->name }}</h2></div></div>
<form method="POST" action="{{ route('admin.locales.update', $locale) }}">
    @csrf
    @method('PUT')
    @include('admin.locales._form', ['locale' => $locale])
</form>
@endsection
