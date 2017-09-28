<!DOCTYPE html>
<html>
    <head>
        <title>{!! Theme::get('title') !!}</title>
        <link rel="icon" href="../images/mcoat-logo.png.png" type="image/png"/>
        <meta charset="utf-8">
        <meta name="keywords" content="{!! Theme::get('keywords') !!}">
        <meta name="description" content="{!! Theme::get('description') !!}">
        <meta name="viewport" content="width=device-width, initial-scale=1.0,user-scalable=0">

        {!! Theme::asset()->styles() !!}
        {!! Theme::asset()->scripts() !!}
    </head>
    <body>

        {!! Theme::content() !!}

    </body>
</html>
