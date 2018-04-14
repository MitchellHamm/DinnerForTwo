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
                <div id="home-tab" class="account-tab" onclick="window.location.href =  '{{url('/account/basic-info')}}';">
                    <i class="fa fa-user" style="font-size:3.25em;" aria-hidden="true"></i>
                    <br>
                    <span style="font-size:1.25em;">Basic Info</span>
                </div>
                <div id="photos-tab" class="account-tab" onclick="window.location.href =  '{{url('/account/profile-photos')}}';">
                    <i class="fa fa-camera" style="font-size:3.25em;" aria-hidden="true"></i>
                    <br>
                    <span style="font-size:1.25em;">Profile Photos</span>
                </div>
                <div id="messages-tab" class="account-tab account-tab-selected" onclick="window.location.href =  '{{url('/account/messages')}}';">
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
                    Message
                </div>
                <div class="line-separator">
                </div>
                <div class="padding">
                </div>

                <div class="row">
                    <div class="col-xs-12">
                        <div class="account-content">
                            @foreach($messages as $message)
                                <div class="row">
                                    @if($message['user_id'] == $currentUser)
                                        <div class="col-xs-12 text-right">
                                            {{ $message['body'] }}
                                        </div>
                                    @else
                                        <div class="col-xs-12 text-left">
                                            {{ $message['body'] }}
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <br>
                <br>
                <form id="sendMessage-form" method="POST" action="{{ route('view-message.submit', $message['thread_id']) }}" class="text-center">
                    {{ csrf_field() }}
                    <input type="text" class="form-control" id="userId" name="userId" value="{{ $otherUser }}" style="display:none">
                    <textarea rows="4" style="width:75%;" name="message"></textarea>
                </form>
                <div class="text-right" style="width:90%;">
                    <a class="btn green" href="javascript:{}" onclick="document.getElementById('sendMessage-form').submit();">Send Message</a>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="{{ URL::asset('js/sweetalert.min.js') }}"></script>
@include('sweet::alert')
</body>
</html>
