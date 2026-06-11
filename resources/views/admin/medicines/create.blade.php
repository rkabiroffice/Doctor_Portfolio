@extends('layouts.admin')

@section('content')
@include('admin.medicines.partials.form', ['action' => route('admin.medicines.store'), 'method' => 'POST', 'medicine' => null])
@endsection
