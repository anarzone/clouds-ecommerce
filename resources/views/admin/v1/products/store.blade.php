@extends('admin.v1.layout.app')
@section('title','Customer')
@section('style')
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300" rel="stylesheet">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet"
          integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <link rel="stylesheet" href="{{asset('admin/css/dropzone.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('admin/css/bootstrap-tagsinput.css')}}"/>
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
    </style>
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
                        <h5>{{ isset($product) ? __('nav.products.edit') : __('nav.products.create')}}</h5>
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
                            <a href="{{ route('products.index')}}">
                                {{ __('nav.products')}}
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
                                    <div class="row">
                                        <div class="col-sm-12 mobile-inputs m-b-20"
                                             style="border-right: 1px solid #ccc">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <h1>{{__('form.uploadImages')}}</h1>
                                                    <form action="{{route('images.upload')}}"
                                                          enctype="multipart/form-data"
                                                          class="dropzone"
                                                          id="dropzone">
                                                        @csrf
                                                        <input type="hidden" name="path"
                                                               value="{{\App\Models\Products\Product::PATH_PRODUCT_IMAGES}}">
                                                        @error('image_ids')
                                                        <span class="messages">
                                                                <p class="text-danger error"> {{ $message }} </p>
                                                            </span>
                                                        @enderror
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <form method="POST" action="{{route('products.store')}}" style="width: 100%" enctype="multipart/form-data">
                                        <input type="hidden" name="product_id"
                                               value="{{isset($product) ? $product->id : null}}">
                                        <input type="hidden" name="image_ids[]">
                                        @csrf
                                        <div class="row">
                                            <div class="container-fluid">
                                                <div class="row">
                                                    <div class="col-sm-8 mobile-inputs m-b-20"
                                                         style="border-right: 1px solid #ccc">
                                                        <div class="form-group">
                                                            <label for="">{{__('form.products.title')}}</label>
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
                                                                               value="{{isset($product) ? $product->translation($locale->code)->title : old("title[$locale->code]") }}"
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
                                                            <label for="">{{__('form.products.description')}}</label>
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
                                                                                  rows="10">{{isset($product) ? $product->translation($locale->code)->description : old("description[$locale->code]") }}</textarea>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                            @error('description')
                                                            <span class="messages">
                                                                    <p class="text-danger error"> {{ $message }} </p>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-sm-6 mobile-inputs">
                                                                <div class="form-group">
                                                                    <label for="">{{__('form.brands')}}</label>
                                                                    <select name="brand_id" class="form-control fill">
                                                                        @foreach($brands as $brand)
                                                                            <option value="{{$brand->id}}"
                                                                                {{isset($product) && $product->brand_id == $brand->id ? 'selected' : ''}}>
                                                                                {{$brand->name}}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                    @error('brand_id')
                                                                    <span class="messages">
                                                                            <p class="text-danger error"> {{ $message }} </p>
                                                                        </span>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6 mobile-inputs">
                                                                <div class="form-group">
                                                                    <label for="">SKU</label>
                                                                    <input type="text" name="sku" class="form-control"
                                                                           value="{{isset($product) ? $product->sku : old('sku')}}" required>
                                                                    @error('sku')
                                                                    <span class="messages">
                                                                            <p class="text-danger error"> {{ $message }} </p>
                                                                        </span>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <hr>
                                                        <h5 class="title">{{__('form.products.variants')}}</h5>
                                                        <div class="container">
                                                            <div class="form-group row">
                                                                <label
                                                                    class="col-sm-2 col-form-label">{{__('form.products.variants.color')}}</label>
                                                                <div class="col-sm-10">
                                                                    <input class="colors" name="colors" type="text"
                                                                           placeholder="" size="2"
                                                                           value="{{isset($options) ? implode(",", $options['colors']) :  old('optionColors') }}"
                                                                           data-role="tagsinput">
                                                                    @error('optionColors')
                                                                    <span class="messages">
                                                                            <p class="text-danger error"> {{ $message }} </p>
                                                                        </span>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <label
                                                                    class="col-sm-2 col-form-label">{{__('form.products.variants.size')}}</label>
                                                                <div class="col-sm-10">
                                                                    <input class="sizes" name="sizes" type="text"
                                                                           placeholder="" size="2"
                                                                           value="{{ isset($options) ? implode(",", $options['sizes']) : old('optionSizes') }}"
                                                                           data-role="tagsinput">
                                                                    @error('optionSizes')
                                                                    <span class="messages">
                                                                            <p class="text-danger error"> {{ $message }} </p>
                                                                        </span>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="container variantsWrapper">
                                                            <div class="table-responsive">
                                                                <table class="table">
                                                                    <thead>
                                                                    <tr>
                                                                        <th>variant</th>
                                                                        <th>Price</th>
                                                                        <th>Quantity</th>
                                                                        <th>SKU</th>
                                                                    </tr>
                                                                    </thead>
                                                                    <tbody class="variants">

                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-4 mobile-inputs">
                                                        <h4 class="sub-title">{{__('form.products.mainImage')}}</h4>
                                                        <div class="form-group">
                                                            @if(isset($product))
                                                                <img src="{{asset('storage/'.$product->mainImage[0]->path)}}" alt="" style="width: 100px">
                                                            @endif
                                                            <input class="form-control" type="file" name="main_image">
                                                        </div>
                                                        <h4 class="sub-title">{{__('form.products.type')}}</h4>
                                                        <div class="form-group">
                                                            <select name="product_type_id" class="form-control fill">
                                                                @foreach($productTypes as $productType)
                                                                    <option value="{{$productType->id}}"
                                                                        {{isset($product) && $product->product_type_id == $productType->id ? 'selected' : ''}}>
                                                                        {{$productType->translation()->name}}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                            @error('product_type_id')
                                                                <span class="messages">
                                                                    <p class="text-danger error"> {{ $message }} </p>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                        <h4 class="sub-title">{{__('form.products.quantity')}}</h4>
                                                        <div class="form-group">
                                                            <input name="quantity" type="number" class="form-control"
                                                                   value="{{isset($product) ? $product->quantity : old('quantity')}}"
                                                                   placeholder=""
                                                                   required
                                                            >
                                                            @error('quantity')
                                                            <span class="messages">
                                                                    <p class="text-danger error"> {{ $message }} </p>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                        <h4 class="sub-title">{{__('form.products.price')}}</h4>
                                                        <div class="input-group">
                                                            <input name="price" type="text" class="form-control"
                                                                   value="{{isset($product) ? $product->price : old('price')}}">
                                                            <span class="input-group-append">
                                                                <label class="input-group-text">₼</label>
                                                            </span>
                                                            @error('price')
                                                            <span class="messages">
                                                                    <p class="text-danger error"> {{ $message }} </p>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                        <h4 class="sub-title">{{__('form.products.salePrice')}}</h4>
                                                        <div class="input-group">
                                                            <input name="sale_price" type="text" class="form-control"
                                                                   value="{{isset($product) ? $product->sale_price : old('sale_price')}}" required>
                                                            <span class="input-group-append">
                                                                <label class="input-group-text">₼</label>
                                                            </span>
                                                            @error('sale_price')
                                                                <span class="messages">
                                                                    <p class="text-danger error"> {{ $message }} </p>
                                                                </span>
                                                            @enderror
                                                        </div>

                                                        <div class="form-group mt-2">
                                                            <h4 class="sub-title">{{__('form.products.category')}}</h4>
                                                            <div class="categoriesWrapper">

                                                            </div>
                                                            @error('category_id')
                                                            <span class="messages">
                                                                <p class="text-danger error"> {{ $message }} </p>
                                                            </span>
                                                            @enderror
                                                        </div>
                                                        <div class="form-group">
                                                            <button class="btn add-category" style="display: none">Add</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-12 mobile-inputs">
                                                <div class="form-group">
                                                    <button
                                                        class="btn waves-effect waves-light btn-success btn-square btn-block">
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
    <script type="text/javascript" src="{{asset('admin/js/bootstrap-tagsinput.js')}}"></script>
    <script type="text/javascript" src="{{asset('admin/js/hierarchy-select.min.js')}}"></script>
@endsection
@section('js')
    <script src="{{asset('admin/js/dropzone.min.js')}}"></script>
    <script>
        let image_ids = []
        generatedOptions = []

        let categories = @json($categories);
        let ageTypes = @json($ageTypes);
        let genderTypes = @json($genderTypes);

        Dropzone.options.dropzone =
            {
                maxFilesize: 10,
                renameFile: function (file) {
                    var dt = new Date();
                    var time = dt.getTime();
                    return time + file.name;
                },
                acceptedFiles: ".jpeg,.jpg,.png,.gif",
                addRemoveLinks: true,
                removedfile: function (file) {
                    let imageName = file.previewElement.querySelector("img").src.split('storage/')[1];
                    $.ajax({
                        type: "POST",
                        url: "/images/remove",
                        data: {imageName, 'path': '{{\App\Models\Products\Product::PATH_PRODUCT_IMAGES}}'},
                        success: function (response) {

                        }
                    })
                    var _ref;
                    return (_ref = file.previewElement) != null ? _ref.parentNode.removeChild(file.previewElement) : void 0;
                },
                timeout: 60000,
                success: function (file, response) {
                    image_ids.push(response.data.id)
                    $("input[name='image_ids[]']").val(image_ids)
                    file.previewElement.querySelector("img").src = '{{asset('storage')}}' + '/' + response.data.path
                },
                error: function (file, response) {
                    return false;
                },
                init: function () {
                    thisDropzone = this;
                    @if(isset($product))
                    $.ajax({
                        type: "GET",
                        url: "/manage/products/" + '{{$product->id}}' + "/images",
                        success: function (response) {
                            $.each(response.data, function (i, val) {
                                let mockFile = {name: val.path, size: 640, accepted: true}

                                thisDropzone.files.push(mockFile);

                                thisDropzone.emit("addedfile", mockFile);
                                thisDropzone.emit("thumbnail", mockFile, '{{url('storage/')}}/' + val.path);
                                thisDropzone.emit("complete", mockFile);
                            })
                        }
                    })
                    @endif
                }
            };


        $(document).ready(function () {
            let options = {
                colors: [],
                sizes: []
            }

            $('.colors').prev('div').find('input').focusout(function () {
                let spans = $('.colors').prev('div').find('span.tag')

                options.colors = []
                $.each(spans, function (i, val) {
                    options.colors.push(spans.eq(i).text())
                })

                generateVariants(options)
            })

            $('.sizes').prev('div').find('input').focusout(function () {
                let spans = $('.sizes').prev('div').find('span.tag')
                options.sizes = []
                $.each(spans, function (i, val) {
                    options.sizes.push(spans.eq(i).text())
                })
                generateVariants(options)
            })

            function generateVariants(options, variantValues = null) {
                let variants = {};
                let counter = 0;
                $('.variants').empty();

                $.each(options.sizes, function (i, sizeVal) {
                    variants[counter] = sizeVal

                    $.each(options.colors, function (j, colorVal) {
                        variants[counter] = sizeVal + '/' + colorVal
                        variants[counter] = sizeVal + '/' + colorVal

                        counter++;
                    })
                })

                $.each(variants, function (i, val) {
                    $('.variants').append(`
                        <tr>
                            <td>
                                ${val}
                            </td>
                            <td>
                                <div class="form-group">
                                    <input class="form-control"
                                            name="variants[${val}][price]"
                                            type="text"
                                            value="${variantValues ? variantValues[parseInt(i)].price : $('input[name="price"]').val()}">
                                </div>
                            </td>
                            <td>
                                <div class="form-group">
                                    <input class="form-control"
                                            name="variants[${val}][quantity]"
                                            type="text"
                                            value="${variantValues ? variantValues[parseInt(i)].quantity : ''}"
                                            required
                                    >
                                </div>
                            </td>
                            <td>
                                <div class="form-group">
                                    <input class="form-control"
                                            name="variants[${val}][sku]"
                                            type="text"
                                            value="${variantValues && variantValues[parseInt(i)].sku ? variantValues[parseInt(i)].sku : ''}"
                                    >
                                </div>
                            </td>
                        </tr>
                    `)
                })
            }

            @if(isset($product))
                var variants = @json($product->variants);
                let variantValues = {}
                $('.add-category').show()

                $.each(variants, function (i, val) {
                    variantValues[i] = {
                        id: val.id,
                        price: val.price,
                        quantity: val.quantity,
                        sku: val.sku
                    }

                    if (!options.sizes.includes(val.option_1)) {
                        options.sizes.push(val.option_1)
                    }

                    if (!options.colors.includes(val.option_2)) {
                        options.colors.push(val.option_2)
                    }
                })

                generateVariants(options, variantValues)

                let productCategories = @json($product->categories);

                $.each(productCategories, function(key, val){
                    addCategories({
                        categories,
                        ageTypes,
                        genderTypes,
                        productCategory: val
                    })
                })

            @else
                addCategories({
                    categories,
                    ageTypes,
                    genderTypes,
                    productCategory: null
                })
            @endif
        })

        let counter = 0;
        function addCategories(options){
            console.log(options)
            let html = `
                <div class="categoryRow mt-2" style="border: 1px solid #eee; padding: 10px">
                    <select name="categoryData[${counter}][category_id]" class="form-control form-control-inverse fill categories">
                        <option value="0">{{__('form.selectCategory')}}</option>
            `;

            let ageTypeRadios = generateTypes(
                options.ageTypes,
                {
                    type: 'age_type_id',
                    title: "{{__('form.ageType')}}",
                    counter,
                    typeId: options.productCategory ? options.productCategory.pivot.age_type_id : null
                }
            )
            let genderTypeRadios = generateTypes(
                options.genderTypes,
                {
                    type: 'gender_type_id',
                    title: "{{__('form.genderType')}}",
                    counter,
                    typeId: options.productCategory ? options.productCategory.pivot.gender_type_id : null
                }
            )
            counter++;

            let selectOptions = '';

            $.each(options.categories, function (key, val) {
                selectOptions +=`
                        <option value="${val.id}" disabled>${val.translation.name}</option>
                    `;
                if(val.children.length > 0){
                    $.each(val.children, function (k, v) {
                        let selected = options.productCategory && parseInt(options.productCategory.pivot.category_id) === parseInt(v.id) ? 'selected' : ''
                        selectOptions +=`
                            <option value="${v.id}" ${selected}> -- ${v.translation.name}</option>
                        `;
                    })

                }
            })

            html += `
                            ${selectOptions}
                     </select>
                        ${genderTypeRadios}
                        ${ageTypeRadios}
                    <div>
                        <span class="btn btn-danger btn-block btn-sm mt-2 delete-category">Sil</span>
                    </div>
                </div>
            `

            $('.categoriesWrapper').append(html)
        }

        function generateTypes(data, options){
            let typeRadios = `<div class="form-radio mt-3">
                                    <h4 class="sub-title">${options.title}</h4>
                                `
            $.each(data, function (key, val) {
                let checked = parseInt(options.typeId) === parseInt(val.id) ? 'checked' : ''
                typeRadios += `
                    <div class="radio radio-inline">
                        <label>
                            <input type="radio"
                                   name="categoryData[${options.counter}][${options.type}]"
                                   data-id="${val.id}"
                                   value="${val.id}"
                                   ${checked}
                            >
                            <i class="helper"></i>${val.translation.name}
                        </label>
                    </div>
                `
            })

            typeRadios += '</div>'

            return typeRadios
        }

        $(document).on('change', 'select.categories', function(e){
            $('.add-category').show()
        })

        $(document).on('click', '.add-category', function (e) {
            e.preventDefault();
            addCategories({
                categories,
                ageTypes,
                genderTypes,
                productCategory: null
            })
        })

        $(document).on('click', '.delete-category', function (e) {
            e.preventDefault()
            if($('.categories').length > 1){
                $(this).parents('.categoryRow').remove()
            }
        })
    </script>
@endsection
