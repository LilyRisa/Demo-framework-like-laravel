<!DOCTYPE html>
<html lang="en">
<head>
@include('layout.head')
</head>
<body>
    <div id="preloader">
        <div id="status">&nbsp;</div>
    </div>

    @include('layout.header')
    
    @yield('content')

    @include('layout.footer')
    @yield('script')
</body>
</html>