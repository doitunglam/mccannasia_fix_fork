<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Eji</title>
        @yield('header-script')
    </head>
    <body class="dark__mode">
        @yield('header') @yield('content') @yield('footer')
        <script
            src="https://kit.fontawesome.com/a4a657385d.js"
            crossorigin="anonymous"
        ></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="{{ asset('ckeditor/ckeditor.js') }}"></script>
        <script src="{{ asset('ckfinder/ckfinder.js') }}"></script>
        @yield('script')
    </body>
</html>
