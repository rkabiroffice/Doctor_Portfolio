@extends('layouts.admin')

@section('content')
@include('admin.medicines.partials.form', ['action' => route('admin.medicines.update', $medicine), 'method' => 'PUT', 'medicine' => $medicine])
@endsection
