@extends('layouts.admin')

@section('content')
@include('admin.schedules.partials.form', ['action' => route('admin.schedules.store'), 'method' => 'POST', 'schedule' => null, 'clinics' => $clinics])
@endsection
