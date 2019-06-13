<!doctype html>
<html class="x-admin-sm">
    <head>
        @include('admin.layout.header')
        @yield('style')
    </head>
    <body>
        @yield('crumbs')
        @yield('content')
    </body>
    @yield('js')
</html>