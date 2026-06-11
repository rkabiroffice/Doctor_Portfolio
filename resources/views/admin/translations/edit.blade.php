@extends('layouts.admin')

@section('content')
    @php $title = 'Edit Translation'; @endphp
    <form action="{{ route('admin.translations.update', $translation) }}" method="POST">
        @csrf
        @method('PUT')
        @include('admin.translations.partials.form')
    </form>
@endsection
