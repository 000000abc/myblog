<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="{{ $meta_description }}">
    <meta name="author" content="{{ config('blog.author') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? config('blog.title') }}</title>

    {{-- Styles --}}
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    @yield('styles')
</head>
<body>
@include('blog.partials.page-nav')

@yield('page-header')
@yield('page-lefter')
@yield('content')


@include('blog.partials.page-footer')

{{-- Scripts --}}
<script src="{{ asset('js/app.js') }}"></script>
@yield('scripts')
</body>
</html>
