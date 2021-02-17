@extends('admin.v1.layout.app')
@section('title', __('nav.products'))
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
                        <h5>{{ __('nav.products')}}</h5>
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
                                {{__('nav.products')}}
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
                    <div class="card">
                        <div class="card-block table-border-style">
                            <div class="table-responsive">
                                <table class="table table-styling">
                                    <thead>
                                    <tr class="table-primary">
                                        <th>#</th>
                                        <th>{{__('form.products.title')}}</th>
                                        <th>{{__('form.products.description')}}</th>
                                        <th>{{__('form.products.price')}}</th>
                                        <th>{{__('form.products.quantity')}}</th>
                                        <th>{{__('nav.actions')}}</th>

                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($products as $product)
                                        <tr>
                                            <th scope="row">{{$product->id}}</th>
                                            <td>{{$product->translation()->title}}</td>
                                            <td>{{$product->translation()->description}}</td>
                                            <td>{{$product->price}}</td>
                                            <td>{{$product->quantity}}</td>
                                            <td>
                                                <div class="label-main" style="margin: 0;">
                                                    <label class="label label-danger" data-post-id="{{$product->id}}" style="cursor: pointer"
                                                           onclick="deleteEl(
                                                               this,
                                                               {
                                                                   id: '{{$product->id}}',
                                                                   url: '{{route('products.delete', $product->id)}}',
                                                                   title: '{{__('messages.deleteTitle')}}',
                                                                   confirmText: '{{__('messages.confirmText')}}',
                                                                   cancelText: '{{__('messages.cancelText')}}',
                                                                   successMessage: '{{__('messages.productDelete')}}'
                                                               }
                                                               )"
                                                    >
                                                        {{__('form.delete')}}
                                                    </label>
                                                    <a class="label label-warning" href="{{route('products.edit', $product->id)}}">{{__('form.edit')}}</a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('unique-js')
    <script>
        $('.editPost').on('click', function () {
            let postId = $(this).data('post-id')
            window.location.href = '/manage/posts/'+postId+'/edit';
        })
    </script>
@endsection
