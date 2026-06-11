@extends('layouts.admin')

@section('content')
    @php $title = 'Add Translation'; @endphp
    <form action="{{ route('admin.translations.store') }}" method="POST">
        @csrf
        @include('admin.translations.partials.form')
    </form>
@endsection
