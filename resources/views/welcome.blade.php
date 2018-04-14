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
                <div class="content-welcome">
                    <div class="title-dark m-b-md fade-in-3">
                        Dinner For Two
                    </div>
                    <div class="line-separator fade-in-3">
                    </div>
                    <div class="padding">
                    </div>
                    <div class="sub-title-dark m-b-md fade-in-3">
                        Meet New People
                    </div>
                    @if (Auth::check())
                        <br>
                        <div class="sub-title-dark m-b-md fade-in-3">
                            <a class="btn green" href="{{ url('/night-out') }}">Find a Night Out</a>
                        </div>
                    @else
                        <br>
                        <div class="sub-title-dark m-b-md fade-in-3">
                            <a class="btn green" href="{{ url('/register') }}">Signup For Free</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <script src="{{ URL::asset('js/sweetalert.min.js') }}"></script>
        @include('sweet::alert')
    </body>
</html>
