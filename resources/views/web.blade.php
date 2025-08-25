<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name' . ' - Oops!', 'Contact Me') }}</title>

    </head>
    <body>
        <h1>Oops! This isn't the page you're looking for.</h1>
        <p>Looking for <a href='https://annikaharmsen.com'>{{  config('app.request_domain') }}</a> instead?</p>
    </body>
</html>
