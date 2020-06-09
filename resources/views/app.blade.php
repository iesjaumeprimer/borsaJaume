<!-- <!DOCTYPE html><html lang=en><head><meta charset=utf-8><meta http-equiv=X-UA-Compatible content="IE=edge"><meta name=viewport content="width=device-width,initial-scale=1"><link rel=icon href=/favicon.ico><title>borsabatoi2</title><link rel=stylesheet href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900"><link rel=stylesheet href=https://cdn.jsdelivr.net/npm/@mdi/font@latest/css/materialdesignicons.min.css><link href=/css/app.88c05283.css rel=preload as=style><link href=/css/chunk-vendors.861290e3.css rel=preload as=style><link href=/js/app.c62014d2.js rel=preload as=script><link href=/js/chunk-vendors.5d064197.js rel=preload as=script><link href=/css/chunk-vendors.861290e3.css rel=stylesheet><link href=/css/app.88c05283.css rel=stylesheet></head><body><noscript><strong>We're sorry but borsabatoi2 doesn't work properly without JavaScript enabled. Please enable it to continue.</strong></noscript><div id=app></div><script src=/js/chunk-vendors.5d064197.js></script><script src=/js/app.c62014d2.js></script></body></html> -->

<!DOCTYPE html>
<html lang="{{ str_replace('_','-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Borsa Treball</title>
    <link rel="shortcut icon" type="image/png" href="/favicon.png"/>
    <link href='https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900|Material+Icons' rel="stylesheet">
</head>
<body>
    <div id="app">
        <app></app>
    </div>

    <script src="{{ mix('js/app.js') }}"></script>
</body>
</html>