@extends('admin.v1.layout.app')
@section('title',__('nav.campaigns.create'))
@section('style')
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300" rel="stylesheet">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet"
          integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="{{asset('admin/css/bootstrap-tagsinput.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset('admin/css/bootstrap-multiselect.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset('admin/css/switchery.min.css')}}"/>
    <style>
        .checkbox-fade, .checkbox-zoom {
            padding-top: 10px;
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
                        <h5>{{ isset($product) ? __('nav.campaigns.edit') : __('nav.campaigns.create')}}</h5>
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
                            <a href="{{ route('campaigns.index')}}">
                                {{ __('nav.campaigns')}}
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
                                    <form method="POST" action="{{route('campaigns.store')}}" style="width: 100%" enctype="multipart/form-data">
                                        <input type="hidden" name="campaign_id"
                                               value="{{isset($campaign) ? $campaign->id : null}}">
                                        <input type="hidden" name="cover_id">
                                        @csrf
                                        <div class="row">
                                            <div class="container-fluid">
                                                <div class="row">
                                                    <div class="col-sm-8 mobile-inputs m-b-20"
                                                         style="border-right: 1px solid #ccc">
                                                        <div class="form-group">
                                                            <label for="">{{__('form.title')}}</label>
                                                            <ul class="nav nav-tabs md-tabs" role="tablist">
                                                                @foreach($locales as $locale)
                                                                    <li class="nav-item">
                                                                        <a class="nav-link" data-toggle="tab"
                                                                           href="#title{{$locale->code}}" role="tab">
                                                                            {{ucwords($locale->code)}}
                                                                        </a>
                                                                        <div class="slide"></div>
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                            <div class="tab-content card-block">
                                                                @foreach($locales as $locale)
                                                                    <div class="tab-pane" id="title{{$locale->code}}"
                                                                         role="tabpanel">
                                                                        <input name="title[{{$locale->code}}]"
                                                                               type="text" class="form-control"
                                                                               id="title-{{$locale->code}}"
                                                                               value="{{isset($campaign) ? $campaign->translation($locale->code)->title : old("title[$locale->code]") }}"
                                                                               placeholder="">
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                            @error('title')
                                                                <span class="messages">
                                                                    <p class="text-danger error"> {{ $message }} </p>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="">{{__('form.description')}}</label>
                                                            <ul class="nav nav-tabs md-tabs" role="tablist">
                                                                @foreach($locales as $locale)
                                                                    <li class="nav-item">
                                                                        <a class="nav-link" data-toggle="tab"
                                                                           href="#description{{$locale->code}}"
                                                                           role="tab">
                                                                            {{ucwords($locale->code)}}
                                                                        </a>
                                                                        <div class="slide"></div>
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                            <div class="tab-content card-block">
                                                                @foreach($locales as $locale)
                                                                    <div class="tab-pane"
                                                                         id="description{{$locale->code}}"
                                                                         role="tabpanel">
                                                                        <textarea name="description[{{$locale->code}}]"
                                                                                  type="text" class="form-control"
                                                                                  cols="30"
                                                                                  rows="10">{{isset($campaign) ? $campaign->translation($locale->code)->description : old("description[$locale->code]") }}</textarea>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                            @error('description')
                                                                <span class="messages">
                                                                    <p class="text-danger error"> {{ $message }} </p>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-4 mobile-inputs">
                                                        <h4 class="sub-title">{{__('form.campaigns.cover')}}</h4>
                                                        <div class="form-group">
                                                            @if(isset($campaign))
                                                                <img src="{{asset('storage/'.$campaign->cover)}}" alt="" style="width: 100px">
                                                            @endif
                                                            <input class="form-control" type="file" name="cover">
                                                        </div>
                                                        <h4 class="sub-title">{{__('form.campaigns.type')}}</h4>
                                                        <div class="form-radio m-b-30">
                                                            <div class="radio radiofill radio-primary radio-inline">
                                                                <label>
                                                                    <input type="radio"
                                                                           name="campaign_type"
                                                                           value="{{\App\Models\Campaigns\Campaign::BANNER_TYPE}}"
                                                                           {{isset($campaign) && $campaign->campaign_type == \App\Models\Campaigns\Campaign::BANNER_TYPE ? 'checked' : ''}}
                                                                    >
                                                                    <i class="helper"></i>{{__('form.campaigns.type.banner')}}
                                                                </label>
                                                            </div>
                                                            <div class="radio radiofill radio-primary radio-inline">
                                                                <label>
                                                                    <input type="radio"
                                                                           name="campaign_type"
                                                                           value="{{\App\Models\Campaigns\Campaign::PROMOTION_TYPE}}"
                                                                           {{isset($campaign) && $campaign->campaign_type == \App\Models\Campaigns\Campaign::PROMOTION_TYPE ? 'checked' : ''}}
                                                                    >
                                                                    <i class="helper"></i>{{__('form.campaigns.type.promotion')}}
                                                                </label>
                                                            </div>
                                                            @error('rate_type')
                                                                <span class="messages">
                                                                    <p class="text-danger error"> {{ $message }} </p>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                        <h4 class="sub-title">{{__('form.campaigns.rateType')}}</h4>
                                                        <div class="form-radio m-b-30">
                                                            <div class="radio radiofill radio-primary radio-inline">
                                                                <label>
                                                                    <input type="radio"
                                                                           name="rate_type"
                                                                           value="{{\App\Models\Campaigns\Campaign::RATE_TYPE_PERCENTAGE}}"
                                                                           {{isset($campaign) && $campaign->rate_type == \App\Models\Campaigns\Campaign::RATE_TYPE_PERCENTAGE ? 'checked' : ''}}
                                                                    >
                                                                    <i class="helper"></i>{{__('form.campaigns.rate.percentage')}}
                                                                </label>
                                                            </div>
                                                            <div class="radio radiofill radio-primary radio-inline">
                                                                <label>
                                                                    <input type="radio"
                                                                           name="rate_type"
                                                                           value="{{\App\Models\Campaigns\Campaign::RATE_TYPE_FLAT}}"
                                                                           {{isset($campaign) && $campaign->rate_type == \App\Models\Campaigns\Campaign::RATE_TYPE_FLAT ? 'checked' : ''}}
                                                                    >
                                                                    <i class="helper"></i>{{__('form.campaigns.rate.flat')}}
                                                                </label>
                                                            </div>
                                                            @error('rate_type')
                                                                <span class="messages">
                                                                    <p class="text-danger error"> {{ $message }} </p>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                        <h4 class="sub-title">{{__('form.campaigns.rate')}}</h4>
                                                        <div class="input-group">
                                                            <input name="rate" type="text" class="form-control"
                                                                   value="{{isset($campaign) ? $campaign->rate : old('rate')}}">
                                                            @error('rate')
                                                                <span class="messages">
                                                                    <p class="text-danger error"> {{ $message }} </p>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                                <h4 class="sub-title">Filter</h4>
                                                <div class="row">
                                                    <div class="col-sm-7 mobile-inputs">
                                                        <div class="form-group row">
                                                            @foreach($genderTypes as $genderType)
                                                                <div class="checkbox-zoom zoom-primary">
                                                                    <label>
                                                                        <input class="genderType"
                                                                               type="checkbox"
                                                                               data-id="{{$genderType->id}}"
                                                                               value="{{$genderType->id}}"
                                                                               {{isset($filter) && in_array($genderType->id, $filter['gender_type_ids']) ? 'checked' : ''}}
                                                                        >
                                                                        <span class="cr">
                                                                            <i class="cr-icon icofont icofont-ui-check txt-default"></i>
                                                                        </span>
                                                                        <span>{{$genderType->translation->name}}</span>
                                                                    </label>
                                                                </div>
                                                            @endforeach
                                                            @foreach($ageTypes as $ageType)
                                                                <div class="checkbox-zoom zoom-primary">
                                                                    <label>
                                                                        <input class="ageType"
                                                                               type="checkbox"
                                                                               data-id="{{$ageType->id}}"
                                                                               value="{{$ageType->id}}"
                                                                            {{isset($filter) && in_array($ageType->id, $filter['age_type_ids']) ? 'checked' : ''}}
                                                                        >
                                                                        <span class="cr">
                                                                                <i class="cr-icon icofont icofont-ui-check txt-default"></i>
                                                                            </span>
                                                                        <span>{{$ageType->translation->name}}</span>
                                                                    </label>
                                                                </div>
                                                            @endforeach
                                                            <select name="parent_id" class="parentCategories form-control form-control-inverse fill" multiple="multiple" style="display: none">
                                                                <option id="defaultOption" value="0">{{__('form.selectCategory')}}</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-2 mobile-inputs">
                                                        <select class="form-control form-control-inverse fill brands">
                                                            <option value="0">Select brand</option>
                                                            @foreach($brands as $brand)
                                                                <option value="{{$brand->id}}"
                                                                    {{isset($filter) && (int)$brand->id == (int)$filter['brand_id'] ? 'selected' : ''}}
                                                                >{{$brand->name}}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-sm-2 mobile-inputs">
                                                        <select class="form-control form-control-inverse fill productTypes">
                                                            <option value="0">Select product type</option>
                                                            @foreach($productTypes as $productType)
                                                                <option value="{{$productType->id}}"
                                                                    {{isset($filter) && (int)$productType->id == (int)$filter['product_type_id'] ? 'selected' : ''}}
                                                                >
                                                                    {{$productType->translation()->name}}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-sm-1">
                                                        <span class="btn btn-sm btn-success showProducts">Show</span>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="productListWrapper" style="display: none">
                                                        <div class="row card-block">
{{--                                                            <div class="table-responsive">--}}
                                                                <table class="table">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>#</th>
                                                                            <th>
                                                                                <input id="selectAll" type="checkbox">
                                                                            </th>
                                                                            <th>{{__('form.products.title')}}</th>
                                                                            <th>{{__('form.products.price')}}</th>
                                                                            <th>{{__('form.products.quantity')}}</th>
                                                                            <th>SKU</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody class="productList">

                                                                    </tbody>
                                                                </table>
{{--                                                            </div>--}}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-4 mobile-inputs">
                                                <div class="col-sm-12 col-xl-4 m-b-30">
                                                    <h4 class="sub-title">Status</h4>
                                                    <input name="status" type="hidden" id="statusHidden"
                                                           value="{{\App\Models\Campaigns\Campaign::UNPUBLISHED_STATUS}}">
                                                    <input type="checkbox"
                                                           name="status"
                                                           class="js-single"
                                                           value="{{\App\Models\Campaigns\Campaign::PUBLISHED_STATUS}}"
                                                        {{isset($campaign) && $campaign->status ? 'checked' : ''}}
                                                    />
                                                </div>
                                            </div>
                                            <div class="col-sm-8 mobile-inputs">
                                                <div class="form-group">
                                                    <input type="hidden" name="filterQuery">
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
@section('unique-js')
    <script type="text/javascript" src="{{asset('admin/js/bootstrap-multiselect.js')}}"></script>
    <script type="text/javascript" src="{{asset('admin/js/switchery.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('admin/js/swithces.js')}}"></script>

@endsection

@section('js')
    <script>
        let filterQuery = {
            genderTypes: [],
            ageTypes: [],
            categories: [],
            brandId: null,
            productTypeId: null,
        }

        let campaignProducts = []

        $(document).ready(function () {
            @if(isset($filter))
                productCheck = true;

                let filterData = @json($filter);
                campaignProducts = @json($campaignProducts);

                filterQuery = {
                    genderTypes: filterData.gender_type_ids,
                    ageTypes: filterData.age_type_ids,
                    categories: filterData.category_ids,
                    brandId: filterData.brand_id,
                    productTypeId: filterData.product_type_id,
                }

                getCategories({
                    genderTypes: filterQuery.genderTypes,
                    ageTypes: filterQuery.ageTypes,
                }, filterData.category_ids)

                $('.showProducts').trigger('click');
            @endif
        })

        $('.genderType').change(function () {
            if(this.checked){
                filterQuery.genderTypes.push($(this).val())
            }else{
                let checkboxVal = $(this).val()
                filterQuery.genderTypes = $.grep(filterQuery.genderTypes, function (val) {
                    return val !== checkboxVal
                })
            }

            getCategories({
                genderTypes: filterQuery.genderTypes,
                ageTypes: filterQuery.ageTypes,
            })
        })

        $('.ageType').change(function () {
            if(this.checked){
                filterQuery.ageTypes.push($(this).val())
            }else{
                let checkboxVal = $(this).val()
                filterQuery.ageTypes = $.grep(filterQuery.ageTypes, function (val) {
                    return val !== checkboxVal
                })
            }

            getCategories({
                genderTypes: filterQuery.genderTypes,
                ageTypes: filterQuery.ageTypes,
            })
        })

        function getCategories(options, checkedCategories = []){
            let categorySelect = $('.parentCategories').empty()
            $.ajax({
                type: 'POST',
                url: '/manage/campaigns/types',
                data: options,
                success: function (response) {
                    $.each(response.data, function (i, v) {
                        categorySelect.append(`
                            <option value="${v.id}" ${checkedCategories.includes(v.id.toString()) ? 'selected' : ''}>${v.translation.name}</option>
                        `)
                        $.each(v.children, function(key, val){
                            categorySelect.append(`
                                <option value="${val.id}" ${checkedCategories.includes(val.id.toString()) ? 'selected' : ''}> -- ${val.translation.name}</option>
                            `)
                        })
                    })

                    $('.parentCategories').multiselect({
                        onChange: function(option, checked, select) {
                            if(checked){
                                filterQuery.categories.push($(option).val())
                            }else{
                                filterQuery.categories = $.grep(filterQuery.categories, function (val) {
                                    return parseInt(val) !== parseInt($(option).val())
                                })
                            }
                        }
                    });
                }
            })
        }

        $('.showProducts').click(function () {
            let productTypeId = $('.productTypes option:selected').val();
            let brandId = $('.brands option:selected').val();

            filterQuery.brandId = brandId
            filterQuery.productTypeId = productTypeId

            $.ajax({
                type: 'POST',
                url: '/manage/campaigns/filter',
                data: {categories: filterQuery.categories, productTypeId, brandId},
                success: function (response) {
                    $('.productListWrapper').show()
                    $('.productList').empty()
                    $.each(response.data, function (i, v) {
                        $('.productList').append(`
                            <tr>
                                <td>${v.id}</td>
                                <td>
                                    <input type="checkbox" name="product_ids[]" value="${v.id}" ${campaignProducts.includes(v.id) ? 'checked' : ''}>
                                </td>
                                <td>${v.title}</td>
                                <td>${v.price}</td>
                                <td>${v.quantity}</td>
                                <td>${v.sku}</td>
                            </tr>
                        `)
                    })
                }
            })
        })

        $('#selectAll').on('click', function () {
            $('[name="product_ids[]"]').not(this).prop('checked', this.checked);
        })

        $('form').submit(function () {
            let formData = new FormData();
            for(key in filterQuery){
                formData.append(key, filterQuery[key])
            }
            $('[name="filterQuery"]').val(JSON.stringify(filterQuery))
        })
    </script>
@endsection
