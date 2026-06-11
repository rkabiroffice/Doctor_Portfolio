@extends('layouts.admin')

@section('content')
@include('admin.blogs.partials.form', ['action' => route('admin.blogs.update', $blog), 'method' => 'PUT', 'blog' => $blog])
@endsection
