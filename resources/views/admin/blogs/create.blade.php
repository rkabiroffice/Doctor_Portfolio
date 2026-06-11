@extends('layouts.admin')

@section('content')
@include('admin.blogs.partials.form', ['action' => route('admin.blogs.store'), 'method' => 'POST', 'blog' => null])
@endsection
