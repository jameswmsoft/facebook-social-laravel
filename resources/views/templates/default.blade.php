<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Facebook</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <link rel="stylesheet" href="{{asset('assets/bootstrap-fileinput/bootstrap-fileinput.css')}}">
    <link rel="stylesheet" href="{{asset('style.css')}}">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
    <script src="{{asset('assets/bootstrap-fileinput/bootstrap-fileinput.js')}}"></script>
</head>
<body>
    @include('templates.partials.navigation')
    <div class="container">
        @include('templates.partials.alerts')
        @yield('content')

        @if(!Auth::guest())
            <div class="row" style="margin-top: 20px;background: white;">
                <div class="container" style="padding: 20px 30px;text-align: center">
                    All rights reserved to Hassan Alshamrani
                </div>
            </div>
        @endif
    </div>
    @yield('script')


</body>
</html>