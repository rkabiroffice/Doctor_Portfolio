@extends('layouts.admin')

@section('content')
@include('admin.sections.partials.form', ['action' => route('admin.sections.store'), 'method' => 'POST', 'section' => null])
@endsection
