@extends('layouts.admin')
@section('title', '新增語系')
@php $breadcrumbs = [['title' => '語系管理', 'url' => route('admin.locales.index')], ['title' => '新增', 'url' => '#']]; @endphp
@section('content')
<div class="row mb-4"><div class="col-12"><h2 class="mb-0">新增語系</h2></div></div>
<form method="POST" action="{{ route('admin.locales.store') }}">
    @csrf
    @include('admin.locales._form', ['locale' => null])
</form>
@endsection
