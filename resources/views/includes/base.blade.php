<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>SoulScrypt</title>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    @include('layouts.header')
</head>

<body> 
    @yield('body')
</body>

</html>
