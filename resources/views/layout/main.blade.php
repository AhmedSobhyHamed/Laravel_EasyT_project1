<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="{{$pageDescription}}">
        <meta name="keywords" content="{{$pageKeywords}}">
        <meta name="og-image" content="{{$pageOGimg}}">
        <title>{{$title}}</title>
        <link rel="icon" href="{{$pageicon}}" type="image/x-icon">
        <link rel="stylesheet" href="{{url('storage/fontawesome/css/all.min.css')}}">
        <link href="{{url('storage/bootstrap/bootstrap.min.css')}}" rel="stylesheet">
        <link rel="stylesheet" href="{{$pageStyle}}">
    </head>
    <body>
        @yield('body')
        <script src="{{url('storage/bootstrap/bootstrap.bundle.min.js')}}"></script>
        <script src="{{$pageScript}}"></script>
    </body>
</html>