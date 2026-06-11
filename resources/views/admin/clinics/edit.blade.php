@extends('layouts.admin')

@section('content')
@include('admin.clinics.partials.form', ['action' => route('admin.clinics.update', $clinic), 'method' => 'PUT', 'clinic' => $clinic])
@endsection
