@extends('layouts.admin')

@section('content')
@include('admin.roles.partials.form', ['action' => route('admin.roles.update', $role), 'method' => 'PUT', 'role' => $role, 'permissionOptions' => $permissionOptions])
@endsection
