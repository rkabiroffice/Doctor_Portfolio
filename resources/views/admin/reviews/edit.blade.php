@extends('layouts.admin')

@section('content')
@include('admin.reviews.partials.form', ['action' => route('admin.reviews.update', $review), 'method' => 'PUT', 'review' => $review])
@endsection
