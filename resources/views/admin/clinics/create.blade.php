@extends('layouts.admin')

@section('content')
@include('admin.clinics.partials.form', ['action' => route('admin.clinics.store'), 'method' => 'POST', 'clinic' => null])
@endsection
