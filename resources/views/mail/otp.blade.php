@extends('beautymail::templates.widgets')

@section('content')

    @include('beautymail::templates.widgets.articleStart', ['color' => '#bf151f'])

    <h4 class="secondary">Salam, otp kodunu şirfənin bərpası üçün istifadə edin</h4>

    <p><bold>{{$otpCode}}</bold></p>

    <br/>
    <p>Qeyd: Bu e-mail ünvanını cavablamayın.</p>

    @include('beautymail::templates.widgets.articleEnd')

@stop
