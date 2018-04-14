<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Dinner For Two</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

        <!-- Styles -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        <link rel="stylesheet" href="{{ URL::asset('css/dft.css') }}"/>
        <link rel="stylesheet" href="{{ URL::asset('css/sweetalert.css') }}"/>
    </head>
    <body>
        <div class="position-ref full-height">
            <div class="welcome-header full-height">
                <img class="full-image" src="{{ URL::asset('images/welcome_header.jpg') }}" />
            @include('modules/navbar', ['linkStyle' => 'links-light', 'container' => 'container-welcome'])

            <div class="content fade-in-2">
                <div class="title-light m-b-md">
                    Sign In
                </div>
                <div class="line-separator">
                </div>
                <div class="padding">
                </div>
                <div style="width:50%; margin: 0 auto; text-align: left;">
                    <form id="login-form" method="POST" action="{{ route('login.submit') }}">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="emailAddress">Email Address</label>
                            <input type="email" class="form-control" id="email" placeholder="Email" name="email" value="{{ old('email') }}">
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" id="password" placeholder="Password" name="password" value="{{ old('password') }}">
                        </div>
                        </br>
                        <div class="form-group" style="text-align:center">
                            <a class="btn green" href="javascript:{}" onclick="document.getElementById('login-form').submit();">Login</a>
                        </div>
                    </form>
                </div>
            </div>
            </div>
        </div>

        <script src="{{ URL::asset('js/sweetalert.min.js') }}"></script>
        @include('sweet::alert')
    </body>
</html>
