@extends('admin.v1.layout.app')
@section('title', __('nav.categories'))

@section('style')
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
                        <h5>{{ __('nav.brands')}}</h5>
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
                            <a href="{{ route('brands.all')}}">
                                {{ __('nav.brands')}}
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
                        <div class="col-sm-6">
                            <div class="card">
                                <div class="card-header">
                                    <h5>{{__('nav.brands')}}</h5>
                                </div>
                                <div class="row card-block">
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Name</th>
                                                    <th>{{__('nav.actions')}}</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($brands as $brandItem)
                                                    <tr>
                                                        <th scope="row">{{$brandItem->id}}</th>
                                                        <td>{{$brandItem->name}}</td>
                                                        <td>
                                                            <button
                                                                class="btn btn-sm btn-warning p-1 f ml-1 editBrand"
                                                                id="{{$brandItem->id}}"
                                                            >
                                                                <i class="icofont icofont-edit-alt"></i>Edit
                                                            </button>
                                                            <button
                                                                class="btn btn-sm btn-danger p-1"
                                                                onclick="deleteEl(
                                                                    this,
                                                                    {
                                                                        id: '{{$brandItem->id}}',
                                                                        url: '{{route('brands.delete', $brandItem->id)}}',
                                                                        title: '{{__('messages.deleteTitle')}}',
                                                                        confirmText: '{{__('messages.confirmText')}}',
                                                                        cancelText: '{{__('messages.cancelText')}}',
                                                                        successMessage: '{{__('messages.deleted')}}',
                                                                    }
                                                                )
                                                            ">
                                                                <i class="icofont icofont-delete-alt"></i>Delete
                                                            </button>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="card">
                                <div class="card-header">
                                    <h5>{{__('nav.brands.create')}}</h5>
                                </div>
                                <form action="{{route('brands.store')}}" method="POST"
                                      enctype="multipart/form-data">

                                    <div class="row card-block">
                                        @csrf
                                        <div class="col-md-12">
                                            <ul class="list-view">
                                                <li>
                                                    <div class="card list-view-media">
                                                        <div class="card-block">
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label for="">{{__('form.title')}}</label>

                                                                    <input name="name"
                                                                           type="text" class="form-control"
                                                                           value="{{old("name")}}"
                                                                           placeholder="">
                                                                    @error('name')
                                                                        <span class="messages">
                                                                            <p class="text-danger error"> {{ $message }} </p>
                                                                        </span>
                                                                    @enderror
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="">{{__('form.slug')}}</label>
                                                                    <input name="slug" type="text" class="form-control"
                                                                           id="slug"
                                                                           value="{{old('slug') }}" placeholder="">
                                                                    @error('slug')
                                                                        <span class="messages">
                                                                            <p class="text-danger error"> {{ $message }} </p>
                                                                        </span>
                                                                    @enderror
                                                                </div>
                                                                <input type="hidden" value="" name="brand_id"
                                                                       id="brand_id">
                                                                <div class="form-group">
                                                                    <button class="btn btn-success btn-block">{{__('form.save')}}</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </li>
                                            </ul>
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
@endsection
@section('unique-js')
    <script type="text/javascript" src="{{asset('admin/js/moment-with-locales.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('admin/js/bootstrap-datepicker.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('admin/js/bootstrap-datetimepicker.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('admin/js/daterangepicker.js')}}"></script>
    <script type="text/javascript" src="{{asset('admin/js/datedropper.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('admin/js/spectrum.js')}}"></script>
    <script type="text/javascript" src="{{asset('admin/js/custom-picker.js')}}"></script>
@endsection
@section('js')
    <script>
        $("input[name='name']").keyup(function () {
            $("#slug").val(slugify($(this).val()));
        });

        $('.editBrand').on('click', function () {
            $.ajax({
                'type': 'GET',
                'url': '/manage/brands/' + $(this).attr('id') + '/get',
                success: function (response) {
                    $('#brand_id').val(response.data.id)
                    $('#slug').val(response.data.slug)
                    $('input[name="name"]').val(response.data.name)
                }
            })
        })

    </script>
@endsection
