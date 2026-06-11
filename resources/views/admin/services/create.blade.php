@extends('layouts.admin')

@section('content')
@include('admin.services.partials.form', ['action' => route('admin.services.store'), 'method' => 'POST', 'service' => null])
@endsection
