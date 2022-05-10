<!DOCTYPE html>
<html lang="en">
<head>
@include('layout.head')
</head>
<body>
    
    @yield('content')

    @include('layout.footer')
    @yield('script')
</body>
</html>