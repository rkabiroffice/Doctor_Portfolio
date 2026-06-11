@extends('layouts.admin')

@section('content')
@include('admin.education.partials.form', ['action' => route('admin.education.store'), 'method' => 'POST', 'education' => null])
@endsection
