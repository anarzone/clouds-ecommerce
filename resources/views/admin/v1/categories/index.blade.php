@extends('admin.v1.layout.app')
@section('title', __('nav.categories'))

@section('style')
    <link rel="stylesheet" type="text/css" href="{{asset('admin/css/hierarchy-select.min.css')}}"/>
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
                        <h5>{{ __('nav.categories')}}</h5>
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
                            <a href="{{ route('categories.all')}}">
                                {{ __('nav.categories')}}
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
                                    <h5>{{__('nav.categories')}}</h5>
                                </div>
                                <div class="row card-block">
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>{{__('form.name')}}</th>
                                                    <th>{{__('form.parentCategory')}}</th>
                                                    <th>{{__('nav.actions')}}</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($categories as $categoryItem)
                                                    <tr>
                                                        <th scope="row">{{$categoryItem->id}}</th>
                                                        <td>{{$categoryItem->translation->name}}</td>
                                                        <td>{{$categoryItem->parent ? $categoryItem->parent->translation->name : ''}}</td>
                                                        <td>
                                                            <button
                                                                class="btn btn-sm btn-warning p-1 ml-1 editCategory"
                                                                id="{{$categoryItem['id']}}"
                                                            >
                                                                <i class="icofont icofont-edit-alt"></i>Edit
                                                            </button>
                                                            <button
                                                                class="btn btn-sm btn-danger p-1"
                                                                onclick="deleteEl(
                                                                    this,
                                                                    {
                                                                    id: '{{$categoryItem['id']}}',
                                                                    url: '{{route('categories.delete', $categoryItem['id'])}}',
                                                                    title: '{{__('messages.deleteTitle')}}',
                                                                    confirmText: '{{__('messages.confirmText')}}',
                                                                    cancelText: '{{__('messages.cancelText')}}',
                                                                    successMessage: '{{__('messages.deleted')}}',
                                                                    type: 'category'
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
                                    <h5>{{__('nav.categoryCreate')}}</h5>
                                </div>
                                <form action="{{route('categories.store')}}" method="POST"
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
                                                                                       id="categoryName-{{$locale->code}}"
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
                                                                    <h4 class="sub-title">{{__('form.view')}}</h4>
                                                                    <div class="checkbox-zoom zoom-primary">
                                                                        <label>
                                                                            <input id="grid" type="checkbox" data-id="1" name="grid" value="1">
                                                                            <span class="cr">
                                                                                <i class="cr-icon icofont icofont-ui-check txt-default"></i>
                                                                            </span>
                                                                            <span>{{__('form.gridView')}}</span>
                                                                        </label>
                                                                    </div>
                                                                    @error('grid')
                                                                        <span class="messages">
                                                                            <p class="text-danger error"> {{ $message }} </p>
                                                                        </span>
                                                                    @enderror
                                                                </div>
                                                                <div class="form-group">
                                                                    <h4 class="sub-title">{{__('form.genderType')}}</h4>
                                                                    @foreach($genderTypes as $genderType)
                                                                        <div class="checkbox-zoom zoom-primary">
                                                                            <label>
                                                                                <input class="genderType" type="checkbox" data-id="{{$genderType->id}}" name="genderTypes[]" value="{{$genderType->id}}">
                                                                                <span class="cr">
                                                                                    <i class="cr-icon icofont icofont-ui-check txt-default"></i>
                                                                                </span>
                                                                                <span>{{$genderType->translation->name}}</span>
                                                                            </label>
                                                                        </div>
                                                                    @endforeach
                                                                    @error('genderTypes')
                                                                        <span class="messages">
                                                                            <p class="text-danger error"> {{ $message }} </p>
                                                                        </span>
                                                                    @enderror
                                                                </div>
                                                                <div class="form-group">
                                                                    <h4 class="sub-title">{{__('form.ageType')}}</h4>
                                                                    @foreach($ageTypes as $ageType)
                                                                        <div class="checkbox-zoom zoom-primary">
                                                                            <label>
                                                                                <input class="ageType" type="checkbox" data-id="{{$ageType->id}}" name="ageTypes[]" value="{{$ageType->id}}">
                                                                                <span class="cr">
                                                                                    <i class="cr-icon icofont icofont-ui-check txt-default"></i>
                                                                                </span>
                                                                                <span>{{$ageType->translation->name}}</span>
                                                                            </label>
                                                                        </div>
                                                                    @endforeach
                                                                    @error('ageTypes')
                                                                        <span class="messages">
                                                                            <p class="text-danger error"> {{ $message }} </p>
                                                                        </span>
                                                                    @enderror
                                                                </div>

                                                                <div class="form-group">
                                                                    <h4 class="sub-title">{{__('form.parentCategory')}}</h4>
                                                                    <select name="parent_id" class="parentCategories form-control form-control-inverse fill">
                                                                        <option id="defaultOption" value="0">{{__('form.selectCategory')}}</option>
                                                                        @foreach($parentCategories as $parent)
                                                                            <option id="{{$parent->id}}" value="{{$parent->id}}" >{{$parent->translation->name}}</option>
                                                                            @if(count($parent->children))
                                                                                @foreach($parent->children as $child)
                                                                                    <option value="{{$child->id}}" disabled> -- {{$child->translation->name}}</option>
                                                                                @endforeach
                                                                            @endif
                                                                        @endforeach
                                                                    </select>
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
                                                                <div class="form-group">
                                                                    <label for="">{{__('form.coverImage')}}</label>
                                                                    <img src="" alt="" width="100%" id="cover">
                                                                    <input name="cover" type="file" class="form-control"
                                                                           value="" placeholder="">
                                                                    @error('cover')
                                                                    <span class="messages">
                                                                            <p class="text-danger error"> {{ $message }} </p>
                                                                        </span>
                                                                    @enderror
                                                                </div>
                                                                <input type="hidden" value="" name="category_id"
                                                                       id="category_id">
                                                                <input type="hidden" value="" name="image_id"
                                                                       id="image_id">
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
    <script type="text/javascript" src="{{asset('admin/js/moment-with-locales.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('admin/js/bootstrap-datepicker.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('admin/js/bootstrap-datetimepicker.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('admin/js/daterangepicker.js')}}"></script>
    <script type="text/javascript" src="{{asset('admin/js/datedropper.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('admin/js/spectrum.js')}}"></script>
    <script type="text/javascript" src="{{asset('admin/js/custom-picker.js')}}"></script>
    <script type="text/javascript" src="{{asset('admin/js/hierarchy-select.min.js')}}"></script>
@endsection
@section('js')
    <script>
        $("#categoryName-en").keyup(function () {
            $("#slug").val(slugify($(this).val()));
        });

        $('.editCategory').on('click', function () {
            $.ajax({
                'type': 'GET',
                'url': '/manage/categories/' + $(this).attr('id') + '/get',
                success: function (response) {
                    $('#category_id').attr('value', response.data.id);
                    $('#image_id').val(response.data.image_id)
                    $('#slug').val(response.data.slug)
                    response.data.grid ? $('#grid').attr('checked', 'checked') : $('#grid').removeAttr('checked')

                    if(response.data.parent_id){
                        $('option[id="'+response.data.parent_id+'"]').attr('selected', 'selected')
                    }else{
                        $('.parentCategories').find('option:selected').removeAttr('selected')
                        $('option[id="defaultOption"]').attr('selected', 'selected')
                    }

                    $.each({!! $locales !!}, function (i, val) {
                        if (response.data.translations[i].locale_id === val.id) {
                            $('#categoryName-' + val.code).val(response.data.translations[i].name)
                        }
                    })

                    $.each(response.data.age_types, function (i, val) {
                        $('input[data-id="'+ val.id +'"].ageType ').attr('checked','checked')
                    })

                    $.each(response.data.gender_types, function (i, val) {
                        $('input[data-id="'+ val.id +'"].genderType ').attr('checked','checked')
                    })

                    $('#cover').attr('src', '/storage/' + response.data.cover.path)
                }
            })
        })
    </script>
@endsection
