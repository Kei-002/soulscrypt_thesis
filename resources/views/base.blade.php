<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>SoulScrypt</title>
    
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">

    @vite(['resources/css/app.css','resources/js/app.js'])
    
    {{-- <script src="{{url('/js/jquery-3.7.1.min.js')}}"></script> --}}
    
    
</head>

<body> 
    <script src="{{url('/js/assets/jquery-3.7.1.min.js')}}"></script>
    @include('layouts.header')
    @yield('body')
    @yield('script')
</body>

</html>