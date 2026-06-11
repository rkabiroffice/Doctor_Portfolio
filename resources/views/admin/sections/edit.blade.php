@extends('layouts.admin')

@section('content')
@include('admin.sections.partials.form', ['action' => route('admin.sections.update', $section), 'method' => 'PUT', 'section' => $section])
@endsection
