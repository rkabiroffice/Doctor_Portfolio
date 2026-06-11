@extends('layouts.admin')

@section('content')
@include('admin.education.partials.form', ['action' => route('admin.education.update', $education), 'method' => 'PUT', 'education' => $education])
@endsection
