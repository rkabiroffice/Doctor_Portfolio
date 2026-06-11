@extends('layouts.admin')

@section('content')
@include('admin.schedules.partials.form', ['action' => route('admin.schedules.update', $schedule), 'method' => 'PUT', 'schedule' => $schedule, 'clinics' => $clinics])
@endsection
