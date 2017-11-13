<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>
        <link rel="stylesheet" href="//cdn.ckeditor.com/4.7.3/full/contents.css?t=H8DA">
        <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-colorpicker/2.5.1/css/bootstrap-colorpicker.min.css">
        <link rel="stylesheet" href="{{ asset(mix('css/app.css')) }}">
    </head>
    <body>
        <script>
            window.base_url = "{{ env('VUE_BASE_URL', '/') }}";
        </script>
        <div id="root"></div>
        <script src="//cdn.ckeditor.com/4.7.3/full/ckeditor.js"></script>
        <script type="text/javascript" src="{{ asset(mix('js/app.js')) }}"></script>
    </body>
</html>
