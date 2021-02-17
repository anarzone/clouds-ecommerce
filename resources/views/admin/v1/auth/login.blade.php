<!DOCTYPE html>
<html lang="en">
<head>
    <title>Admindek | Admin Template</title>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Quicksand:500,700" rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="{{asset('admin/css/bootstrap.min.css')}}">

    <link rel="stylesheet" href="{{asset('admin/css/waves.min.css')}}" type="text/css" media="all">
    <link rel="stylesheet" type="text/css" href="{{asset('admin/css/feather.css')}}">

    <link rel="stylesheet" type="text/css" href="{{asset('admin/css/themify-icons.css')}}">

    <link rel="stylesheet" type="text/css" href="{{asset('admin/css/icofont.css')}}">

    <link rel="stylesheet" type="text/css" href="{{asset('admin/css/font-awesome.min.css')}}">

    <link rel="stylesheet" type="text/css" href="{{asset('admin/css/style.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('admin/css/pages.css')}}">
</head>
<body themebg-pattern="theme1">
<style>
    #logo{
        width: 10%;
    }
    @media only screen and (max-width: 768px) {
        #logo{
            width:35%;
        }
    }

</style>
<div class="theme-loader">
    <div class="loader-track">
        <div class="preloader-wrapper">
            <div class="spinner-layer spinner-blue">
                <div class="circle-clipper left">
                    <div class="circle"></div>
                </div>
                <div class="gap-patch">
                    <div class="circle"></div>
                </div>
                <div class="circle-clipper right">
                    <div class="circle"></div>
                </div>
            </div>
            <div class="spinner-layer spinner-red">
                <div class="circle-clipper left">
                    <div class="circle"></div>
                </div>
                <div class="gap-patch">
                    <div class="circle"></div>
                </div>
                <div class="circle-clipper right">
                    <div class="circle"></div>
                </div>
            </div>
            <div class="spinner-layer spinner-yellow">
                <div class="circle-clipper left">
                    <div class="circle"></div>
                </div>
                <div class="gap-patch">
                    <div class="circle"></div>
                </div>
                <div class="circle-clipper right">
                    <div class="circle"></div>
                </div>
            </div>
            <div class="spinner-layer spinner-green">
                <div class="circle-clipper left">
                    <div class="circle"></div>
                </div>
                <div class="gap-patch">
                    <div class="circle"></div>
                </div>
                <div class="circle-clipper right">
                    <div class="circle"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<section class="login-block">

    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">

                <form class="md-float-material form-material" method="POST" action="{{route('login')}}">
                    @csrf
                    <div class="text-center">
{{--                        <img src="" alt="logo.png" id="logo">--}}
                    </div>
                    <div class="auth-box card">
                        <div class="card-block">
                            <div class="row m-b-20">
                                <div class="col-md-12">
                                    <h3 class="text-center txt-primary">Sign In</h3>
                                </div>
                            </div>
                            <div class="form-group form-primary">
                                <input type="text" name="email" class="form-control" required="">
                                <span class="form-bar"></span>
                                <label class="float-label">Username / Email</label>
                            </div>
                            <div class="form-group form-primary">
                                <input type="password" name="password" class="form-control" required="">
                                <span class="form-bar"></span>
                                <label class="float-label">Password</label>
                            </div>
                            <div class="row m-t-25 text-left">
{{--                                <div class="col-12">--}}
{{--                                    <div class="checkbox-fade fade-in-primary">--}}
{{--                                        <label>--}}
{{--                                            <input type="checkbox" value="">--}}
{{--                                            <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>--}}
{{--                                            <span class="text-inverse">Remember me</span>--}}
{{--                                        </label>--}}
{{--                                    </div>--}}
{{--                                    <div class="forgot-phone text-right float-right">--}}
{{--                                        <a href="" class="text-right f-w-600"> Forgot Password?</a>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
                            </div>
                            <div class="row m-t-30">
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-primary btn-md btn-block waves-effect text-center m-b-20">LOGIN</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>

            </div>

        </div>

    </div>

</section>

<script type="4878d7dfa7bc22a8dfa99416-text/javascript" src="{{asset('admin/js/jquery.min.js')}}"></script>
<script type="4878d7dfa7bc22a8dfa99416-text/javascript" src="{{asset('admin/js/jquery-ui.min.js')}}"></script>
<script type="4878d7dfa7bc22a8dfa99416-text/javascript" src="{{asset('admin/js/popper.min.js')}}"></script>
<script type="4878d7dfa7bc22a8dfa99416-text/javascript" src="{{asset('admin/js/bootstrap.min.js')}}"></script>

<script src="{{asset('admin/js/waves.min.js')}}" type="4878d7dfa7bc22a8dfa99416-text/javascript"></script>

<script type="4878d7dfa7bc22a8dfa99416-text/javascript" src="{{asset('admin/js/jquery.slimscroll.js')}}"></script>

<script type="4878d7dfa7bc22a8dfa99416-text/javascript" src="{{asset('admin/js/modernizr.js')}}"></script>
<script type="4878d7dfa7bc22a8dfa99416-text/javascript" src="{{asset('admin/js/css-scrollbars.js')}}"></script>
<script type="4878d7dfa7bc22a8dfa99416-text/javascript" src="{{asset('admin/js/common-pages.js')}}"></script>
<script src="{{asset('admin/js/rocket-loader.min.js')}}" data-cf-settings="4878d7dfa7bc22a8dfa99416-|49" defer=""></script>
</body>
</html>
