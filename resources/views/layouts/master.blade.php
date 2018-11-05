<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <meta name="csrf-token" content="{{ csrf_token() }}"/>
        <title>@yield('title')</title>
        <link href="https://fonts.googleapis.com/css?family=PT+Sans:100,300,400,700&amp;subset=cyrillic"
              rel="stylesheet">
        <link rel="shortcut icon" href="/icons/favicon.ico" type="image/x-icon"/>
        <link rel="stylesheet" href="{{ mix('/css/app.css') }}"/>
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css"
              integrity="sha384-5sAR7xN1Nv6T6+dT2mhtzEpVJvfS3NScPQTrOxhwjIuvcA67KV2R5Jz6kr4abQsz"
              crossorigin="anonymous">

    </head>
    <body class="hold-transition skin-green sidebar-collapse sidebar-mini">
        @yield('content')
        <script src="{{ mix('js/app.js') }}"></script>
        @yield('additional_styles')
    </body>
</html>
