<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>My Dictionary</title>

    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
    <link rel="icon" href="/favicon.ico" type="image/x-icon">
    
    <link rel="stylesheet" type="text/css" href="/css/semantic.min.css">
    <link rel="stylesheet" href="{{ mix('/css/application.css') }}">

    <script src="/js/jquery.min.js"></script>
    <script src="/js/semantic.min.js"></script>

    @stack('scripts')
</head>
<body>

@include('modals.error')

<div id="main-menu" class="ui vertical labeled icon menu">
    <a class="item" href="/">
        <i class="home icon"></i>
        Practice
    </a>
    <a class="item" href="/edit">
        <i class="edit icon"></i>
        Edit
    </a>
</div>

<div class="ui container">

    @yield('content')

</div>

</body>
</html>
