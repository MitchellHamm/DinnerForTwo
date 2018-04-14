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
    <script src="{{ URL::asset('js/bootstrap.min.js') }}"></script>
</head>
<body>
<div class="position-ref">
    @include('modules.navbar', ['linkStyle' => 'links-dark', 'container' => 'container'])

    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-10 col-sm-offset-1 account-content-no-margin">
                <div class="title-light m-b-md" style="text-align:center;">
                    Results
                </div>
                <div class="line-separator">
                </div>
                <div class="padding">
                </div>
                <div class="sub-title-light m-b-md" style="text-align:center;">
                    Searching For:
                </div>
                <form id="activity-form" method="POST" action="{{ route('night-out.update') }}">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label for="activity">Activity</label>
                        <select class="form-control" id="activity" name="activity">
                            <option value="dinner">Dinner</option>
                            <option value="movie">Movie</option>
                            <option value="anything">Anything</option>
                        </select>
                    </div>
                </form>
                <br>
                <div id="searchResults">
                    @for ($i = 0; $i < count($results); $i++)
                        @if($i % 3 == 0)
                            <div class="row">
                                @endif
                        <div class="col-lg-4 col-sm-6">

                            <div class="card hovercard">
                                <div class="cardheader">

                                </div>
                                <div class="avatar">
                                    <img id="rotating-image" alt="" src="{{ URL::asset($results[$i]['images'][0]) }}">
                                </div>
                                <ul class="pagination" style="margin-top:-20px;">
                                    <li>
                                        <a aria-label="Previous" style="cursor:pointer;">
                                            <span aria-hidden="true">&laquo;</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a aria-label="Next" style="cursor:pointer;">
                                            <span aria-hidden="true">&raquo;</span>
                                        </a>
                                    </li>
                                </ul>
                                <div class="info">
                                    <div class="title">
                                        {{ $results[$i]['firstName'] }}
                                    </div>
                                    <div class="desc">Age: {{ $results[$i]['age'] }}</div>
                                    <div class="desc">{{ $results[$i]['city'] }}</div>
                                    <div class="desc">Interests</div>
                                </div>
                                <div class="bottom">
                                    <p>Bio: {{ $results[$i]['bio'] }}</p>
                                    <a class="btn green" href="#messageModal" data-toggle="modal" data-user-id="{{ $results[$i]['id'] }}">Send Message</a>
                                </div>
                            </div>

                        </div>
                                @if($i % 3 == 2)
                            </div>
                            <br>
                        @endif
                    @endfor
                </div>
            </div>
        </div>
    </div>
</div>
<script src="{{ URL::asset('js/sweetalert.min.js') }}"></script>
@include('sweet::alert')
@include('modules.message_modal')
<script>
    $( document ).ready(function() {
        $('#activity-form option').eq({{ $currentActivity-1 }}).prop('selected', true);
    });
    $('#activity-form').change(function() {
        this.submit();
    });
</script>
</body>
</html>
