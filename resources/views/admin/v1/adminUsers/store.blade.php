@extends('admin.v1.layout.app')
@section('title','Customer')
@section('style')
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300" rel="stylesheet">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <style>
        body {
            background: whitesmoke;
            font-family: 'Open Sans', sans-serif;
        }
        .container {
            max-width: 960px;
            margin: 30px auto;
            padding: 20px;
        }
        h1 {
            font-size: 20px;
            text-align: center;
            margin: 20px 0 20px;
        }
        h1 small {
            display: block;
            font-size: 15px;
            padding-top: 8px;
            color: gray;
        }
        .avatar-upload {
            position: relative;
            max-width: 205px;
            margin: 50px auto;
        }
        .avatar-upload .avatar-edit {
            position: absolute;
            right: 12px;
            z-index: 1;
            top: 10px;
        }
        .avatar-upload .avatar-edit input {
            display: none;
        }
        .avatar-upload .avatar-edit input + label {
            display: inline-block;
            width: 34px;
            height: 34px;
            margin-bottom: 0;
            border-radius: 100%;
            background: #FFFFFF;
            border: 1px solid transparent;
            box-shadow: 0px 2px 4px 0px rgba(0, 0, 0, 0.12);
            cursor: pointer;
            font-weight: normal;
            transition: all 0.2s ease-in-out;
        }
        .avatar-upload .avatar-edit input + label:hover {
            background: #f1f1f1;
            border-color: #d6d6d6;
        }
        .avatar-upload .avatar-edit input + label:after {
            content: "\f040";
            font-family: 'FontAwesome';
            color: #757575;
            position: absolute;
            top: 10px;
            left: 0;
            right: 0;
            text-align: center;
            margin: auto;
        }
        .avatar-upload .avatar-preview {
            width: 192px;
            height: 192px;
            position: relative;
            border-radius: 100%;
            border: 6px solid #F8F8F8;
            box-shadow: 0px 2px 4px 0px rgba(0, 0, 0, 0.1);
        }
        .avatar-upload .avatar-preview > div {
            width: 100%;
            height: 100%;
            border-radius: 100%;
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
        }

    </style>
@endsection

@section('content')
    <div class="page-header card">
        @if(session()->has('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{session()->get('success')}}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
        <div class="row align-items-end">
            <div class="col-lg-8">
                <div class="page-header-title">
                    <i class="feather icon-clipboard bg-c-blue"></i>
                    <div class="d-inline">
                        <h5>{{ isset($adminUser) ? __('nav.userUpdate') : __('nav.userAdd')}}</h5>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="page-header-breadcrumb">
                    <ul class=" breadcrumb breadcrumb-title">
                        <li class="breadcrumb-item">
                            <a href="{{route('dashboard')}}"><i class="feather icon-home"></i></a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('admins.index')}}">
                                {{ __('nav.users')}}
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card">
                                <div class="card-block">
                                    <form action="{{route('admins.store')}}" method="POST" enctype="multipart/form-data">
                                        <input type="hidden" name="user_id" value="{{isset($adminUser) ? $adminUser->user->id : null}}">
                                        @csrf
                                        <div class="row">
                                            <div class="col-sm-6 mobile-inputs">
                                                <div class="form-group">
                                                    <label for="">{{__('form.firstname')}}</label>
                                                    <input name="name" type="text" class="form-control"
                                                           value="{{isset($adminUser) ? $adminUser->name : old('name')}}"
                                                           placeholder="">
                                                    @error('name')
                                                        <span class="messages">
                                                            <p class="text-danger error"> {{ $message }} </p>
                                                        </span>
                                                    @enderror
                                                </div>
                                                <div class="form-group">
                                                    <label for="">{{__('form.email')}}</label>
                                                    <input name="email" type="email" class="form-control"
                                                           value="{{isset($adminUser) ? $adminUser->user->email : old('email')}}"
                                                           placeholder="">
                                                    @error('email')
                                                        <span class="messages">
                                                            <p class="text-danger error"> {{ $message }} </p>
                                                        </span>
                                                    @enderror
                                                </div>
                                                <div class="form-group">
                                                    <label for="">{{__('form.phone')}}</label>
                                                    <input name="phone" type="text" class="form-control"
                                                           value="{{isset($adminUser) ? $adminUser->phone : old('phone')}}"
                                                    >
                                                    @error('phone')
                                                        <span class="messages">
                                                            <p class="text-danger error"> {{ $message }} </p>
                                                        </span>
                                                    @enderror
                                                </div>
                                                <div class="form-group">
                                                    <label for="">{{__('form.roles')}}</label>
                                                    <select name="role_id" class="form-control fill parentCategories">
                                                        <option value="0" disabled selected>Rol seçin</option>
                                                        @foreach($roles as $role)
                                                            <option value="{{$role->id}}" {{isset($adminUser) && $role->id == $adminUser->roles[0]->id ? 'selected' : ''}}>
                                                                {{$role->name}}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    @error('role_id')
                                                        <span class="messages">
                                                            <p class="text-danger error"> {{ $message }} </p>
                                                        </span>
                                                    @enderror
                                                </div>
                                                <div class="form-group">
                                                    <label for="">{{__('form.password')}}</label>
                                                    <input name="password" type="password" class="form-control"
                                                           value="" placeholder="">
                                                    @error('password')
                                                        <span class="messages">
                                                            <p class="text-danger error"> {{ $message }} </p>
                                                        </span>
                                                    @enderror
                                                </div>
                                                <div class="form-group">
                                                    <label for="">{{__('form.passwordConfirm')}}</label>
                                                    <input name="password_confirmation" type="password" class="form-control"
                                                           value="" placeholder="">
                                                    @error('password_confirmation')
                                                        <span class="messages">
                                                            <p class="text-danger error"> {{ $message }} </p>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-12 mobile-inputs">
                                                <div class="form-group">
                                                    <button class="btn waves-effect waves-light btn-success btn-square btn-block">
                                                        {{__('form.save')}}
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script src="{{asset('admin/js/jquery.inputmask.min.js')}}"></script>
    <script src="https://unpkg.com/cropperjs"></script>

    <script>
        $(document).ready(function () {
            $('input[name="phone"]').inputmask({
                mask: "([0]99)-999-99-99"
            })

        })
    </script>
@endsection
