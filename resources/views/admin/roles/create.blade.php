@extends('layouts.admin')

@section('content')
@include('admin.roles.partials.form', ['action' => route('admin.roles.store'), 'method' => 'POST', 'role' => null, 'permissionOptions' => $permissionOptions])
@endsection
