@extends('layouts.admin')

@section('content')
@include('admin.services.partials.form', ['action' => route('admin.services.update', $service), 'method' => 'PUT', 'service' => $service])
@endsection
