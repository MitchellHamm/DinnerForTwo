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
    <script src="{{ URL::asset('js/jquery-3.1.1.min.js') }}"></script>
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
                <div id="photos-tab" class="account-tab account-tab-selected" onclick="window.location.href =  '{{url('/account/profile-photos')}}';">
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
                    Profile Photos
                </div>
                <div class="line-separator">
                </div>
                <div class="padding">
                </div>
                <!-- Need to check amount of photos, if %3 = 0 put upload on new row else group 3 photos together on new rows
                -->
                    @for ($i = 0; $i < count($userData['photos']); $i++)
                        @if($i % 3 == 0)
                            <div class="row" id="images">
                        @endif
                        <div class="col-md-4">
                            <img class="center-block uploaded-image" src="{{URL::asset($userData['photos'][$i])}}" height="200" width="200">
                            <i onclick="deleteImage(this)" class="fa fa-times-circle uploaded-image-x" aria-hidden="true" style="font-size:2.00em;">
                                <form style="display:none;" method="POST" action="{{ route('profile-photos.delete') }}">
                                    {{ csrf_field() }}
                                    <input id="image-delete" type="text" name="pic" value="{{$userData['photos'][$i]}}">
                                </form>
                            </i>
                        </div>
                                @if($i % 3 == 2)
                            </div>
                            <br>
                                        @endif
                    @endfor
                @if (count($userData['photos']) % 3 == 0)
                    <div class="row" id="images">
                @endif
                    <div class="col-md-4">
                        <form enctype="multipart/form-data" id="image-submit" method="POST" action="{{ route('profile-photos.submit') }}">
                            {{ csrf_field() }}
                            <input id="image-upload" style="display:none;" type="file" name="pic" accept="image/*">
                        <div class="upload-photo" id="image-div">
                            <p style="text-align: center; position:relative; top:50%;transform: translateY(-50%); font-size:1.5em;">
                                Upload Image
                            </p>
                        </div>
                        </form>
                    </div>
                    </div>
                <br>
            </div>
        </div>
    </div>
</div>
<script src="{{ URL::asset('js/sweetalert.min.js') }}"></script>
@include('sweet::alert')
<script>
    $("#image-div").click(function() {
        $("#image-upload").click();
    });

    function readURL(input) {

        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#images').prepend('<div class="col-md-4"> <img class="center-block" style="border-radius:25px;" src="' + e.target.result + '" height="200" width="200"> </div>');
            }

            reader.readAsDataURL(input.files[0]);
        }
    }

    $("#image-upload").change(function(){
        readURL(this);
        document.getElementById("image-submit").submit();
    });

    function deleteImage(element) {
        $(element).find("form").submit();
    }
</script>
</body>
</html>
