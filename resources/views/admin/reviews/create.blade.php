@extends('layouts.admin')

@section('content')
@include('admin.reviews.partials.form', ['action' => route('admin.reviews.store'), 'method' => 'POST', 'review' => null])
@endsection
