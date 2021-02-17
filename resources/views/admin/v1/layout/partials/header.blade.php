<head>
    <title> {{env('APP_NAME')}} - @yield('title')</title>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">

    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Quicksand:500,700" rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="{{asset('admin/css/bootstrap.min.css')}}">

    <link rel="stylesheet" href="{{asset('admin/css/waves.min.cs')}}s" type="text/css" media="all">

    <link rel="stylesheet" type="text/css" href="{{asset('admin/css/feather.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('admin/css/themify-icons.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('admin/css/icofont.css')}}">

    <link rel="stylesheet" type="text/css" href="{{asset('admin/css/font-awesome-n.min.css')}}">
    @yield('style')
    <link rel="stylesheet" type="text/css" href="{{asset('admin/css/style.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('admin/css/pages.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('admin/css/widget.css')}}">
</head>
