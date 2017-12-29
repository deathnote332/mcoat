<!DOCTYPE html>
<html>
<head>
    <title>{!! Theme::get('title') !!}</title>
    <link rel="icon" href="../../images/mcoat-logo.jpg" type="image/png"/>
    <meta charset="utf-8">
    <meta name="keywords" content="{!! Theme::get('keywords') !!}">
    <meta name="description" content="{!! Theme::get('description') !!}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0,user-scalable=0">
    <meta name="csrf_token" content="{{ csrf_token() }}">
    {!! Theme::asset()->styles() !!}
    {!! Theme::asset()->scripts() !!}
</head>
<body>

<input type="hidden" id="baseURL" value="{{ url('') }}" >
    {!! Theme::partial('sidebar') !!}

</body>
</html>
