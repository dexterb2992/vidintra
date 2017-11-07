<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <link rel="stylesheet" type="text/css" href="{{ asset(mix('css/app.css')) }}">
    </head>
    <body>
        <div id="root"></div>
        <script src="https://cdn.ckeditor.com/4.7.3/standard/ckeditor.js"></script>
        <script type="text/javascript" src="{{ asset(mix('js/app.js')) }}"></script>
    </body>
</html>
