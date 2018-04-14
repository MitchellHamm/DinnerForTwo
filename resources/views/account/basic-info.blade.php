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
    <link rel="stylesheet" href="{{ URL::asset('css/font-awesome.min.css') }}"/>
    <link rel="stylesheet" href="{{ URL::asset('css/sweetalert.css') }}"/>
</head>
<body>
<div class="position-ref">
    @include('modules.navbar', ['linkStyle' => 'links-dark', 'container' => 'container'])

    <div class="container-fluid">
        <div class="row">
        <div class="col-sm-2" style="text-align:center; margin-top:25px;margin-bottom:25px;">
            <div id="home-tab" class="account-tab account-tab-selected" onclick="window.location.href =  '{{url('/account/basic-info')}}';">
                <i class="fa fa-user" style="font-size:3.25em;" aria-hidden="true"></i>
                <br>
                <span style="font-size:1.25em;">Basic Info</span>
            </div>
            <div id="photos-tab" class="account-tab" onclick="window.location.href =  '{{url('/account/profile-photos')}}';">
                <i class="fa fa-camera" style="font-size:3.25em;" aria-hidden="true"></i>
                <br>
                <span style="font-size:1.25em;">Profile Photos</span>
            </div>
            <div id="messages-tab" class="account-tab" onclick="window.location.href =  '{{url('/account/messages')}}';">
                <i class="fa fa-comments-o" style="font-size:3.25em;" aria-hidden="true"></i>
                <br>
                <span style="font-size:1.25em;">Messages</span>
            </div>
            <div id="privacy-tab" class="account-tab" onclick="window.location.href =  '{{url('/account/privacy')}}';">
                <i class="fa fa-eye" style="font-size:3.25em;" aria-hidden="true"></i>
                <br>
                <span style="font-size:1.25em;">Privacy</span>
            </div>
        </div>

        <div class="col-sm-9 account-content">
            <div class="title-light m-b-md" style="text-align:center;">
                Basic Info
            </div>
            <div class="line-separator">
            </div>
            <div class="padding">
            </div>
            <form id="account-form" method="POST" action="{{ route('basic-info.submit') }}" style="text-align:left;">
                {{ csrf_field() }}
                <div class="col-md-12">
                <div class="form-group">
                    <label for="emailAddress">Email Address</label>
                    <input type="email" class="form-control" id="email" placeholder="Email" name="email" value="{{ old('email') === null ? $email : old('email')}}">
                </div>
                <div class="form-group">
                    <label for="firstName">First Name</label>
                    <input type="text" class="form-control" id="firstName" placeholder="First Name" name="firstName" value="{{ old('firstName') === null ? $firstName : old('firstName')}}">
                </div>
                <div class="form-group">
                    <label for="city">City</label>
                    <input type="text" class="form-control" id="city" placeholder="City" name="city" value="{{ old('city') === null ? $city : old('city')}}">
                </div>
                <div class="form-group">
                    <label for="age">Age</label>
                    <input type="number" class="form-control" id="age" placeholder="0" name="age" value="{{ old('age') === null ? $age : old('email')}}">
                </div>
                    <div class="form-group">
                    <label for="bio">Bio</label>
                    <textarea class="form-control" rows="5" id="bio" name="bio">{{ old('bio') === null ? $bio : old('bio')}}</textarea>
                </div>
                </br>
                <div class="form-group" style="text-align:center">
                <a class="btn green" href="javascript:{}" onclick="document.getElementById('account-form').submit();">Update Account</a>
                </div>
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
