@extends('admin.v1.layout.app')
@section('title', __('nav.products.types'))

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
                        <h5>{{ __('nav.products.types')}}</h5>
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
                            <a href="{{ route('products.types.index')}}">
                                {{ __('nav.products.types')}}
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
                                    <h5>{{__('nav.products.types')}}</h5>
                                </div>
                                <div class="row card-block">
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>{{__('form.name')}}</th>
                                                <th>{{__('nav.actions')}}</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($productTypes as $productType)
                                                <tr>
                                                    <th scope="row">{{$productType->id}}</th>
                                                    <td>{{$productType->translation()->name}}</td>
                                                    <td>
                                                        <button
                                                            class="btn btn-sm btn-warning p-1 ml-1 editProductType"
                                                            id="{{$productType->id}}"
                                                        >
                                                            <i class="icofont icofont-edit-alt"></i>Edit
                                                        </button>
                                                        <button
                                                            class="btn btn-sm btn-danger p-1"
                                                            onclick="deleteEl(
                                                                this,
                                                                {
                                                                id: '{{$productType->id}}',
                                                                url: '{{route('products.types.delete', $productType->id)}}',
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
                                    <h5>{{__('nav.products.types.create')}}</h5>
                                </div>
                                <form action="{{route('products.types.store')}}" method="POST"
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

                                                                    <ul class="nav nav-tabs md-tabs" role="tablist">
                                                                        @foreach($locales as $locale)
                                                                            <li class="nav-item">
                                                                                <a class="nav-link" data-toggle="tab"
                                                                                   href="#{{$locale->code}}" role="tab">
                                                                                    {{ucwords($locale->code)}}
                                                                                </a>
                                                                                <div class="slide"></div>
                                                                            </li>
                                                                        @endforeach
                                                                    </ul>
                                                                    <div class="tab-content card-block">
                                                                        @foreach($locales as $locale)
                                                                            <div class="tab-pane" id="{{$locale->code}}"
                                                                                 role="tabpanel">
                                                                                <input name="name[{{$locale->code}}]"
                                                                                       type="text" class="form-control"
                                                                                       id="productTypeName-{{$locale->code}}"
                                                                                       value="{{old("name[$locale->code]") }}"
                                                                                       placeholder="">
                                                                            </div>
                                                                        @endforeach
                                                                    </div>
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
                                                                <input type="hidden" value="" name="product_type_id"
                                                                       id="product_type_id">
                                                                <div class="form-group">
                                                                    <button
                                                                        class="btn btn-success btn-block">{{__('form.save')}}</button>
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
    <script type="text/javascript" src="{{asset('admin/js/spectrum.js')}}"></script>
    <script type="text/javascript" src="{{asset('admin/js/custom-picker.js')}}"></script>
@endsection
@section('js')
    <script>
        $("#productTypeName-en").keyup(function () {
            $("#slug").val(slugify($(this).val()));
        });

        $('.editProductType').on('click', function () {
            $.ajax({
                'type': 'GET',
                'url': '/manage/products/types/' + $(this).attr('id') + '/get',
                success: function (response) {
                    console.log(response)
                    $('#product_type_id').val(response.data.id)
                    $('#slug').val(response.data.slug)

                    $.each({!! $locales !!}, function (i, val) {
                        if (response.data.translations[i].locale_id === val.id) {
                            $('#productTypeName-' + val.code).val(response.data.translations[i].name)
                        }
                    })
                }
            })
        })
    </script>
@endsection
