<html>
    <head>
        <body>
            <p>Dear {{$name}},</p>

            @yield('content')
            
            <div class="footer">
                <a href="{{url('/')}}">
                    <svg class="absolute top-12 left-full transform translate-x-32" width="404" height="384" fill="none" viewBox="0 0 404 384"></svg>
                </a>
            </div>
        </body>
</html>