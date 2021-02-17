@extends('admin.v1.layout.app')
@section('title', __('nav.customers'))
@section('style')
    <style>
        @media (min-width: 992px){
            .modal-lg {
                max-width: 1165px;
            }
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
                        <h5>{{ __('nav.customers')}}</h5>
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
                            <a href="{{ route('customers.index')}}">
                                {{__('nav.customers')}}
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
                                            <th>{{__('form.firstname')}} {{__('form.lastname')}}</th>
                                            <th>{{__('form.phone')}}</th>
                                            <th>{{__('form.email')}}</th>
                                            <th>{{__('nav.addresses')}}</th>
                                            <th>{{__('nav.actions')}}</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($customers as $customer)
                                        <tr>
                                            <th scope="row">{{$customer->id}}</th>
                                            <td>{{$customer->firstname}} {{$customer->lastname}}</td>
                                            <td>{{$customer->user->phone}}</td>
                                            <td>{{$customer->user->email}}</td>
                                            <td>
                                                <label class="label label-default" style="cursor: pointer"
                                                        data-toggle="modal" data-target="#large-Modal"
                                                        onclick="getCustomerAddresses({{$customer->id}})"
                                                >
                                                    <i class="feather icon-eye"></i>
                                                </label>
                                            </td>
                                            <td>
                                                <div class="label-main" style="margin: 0;">
                                                    <label class="label label-danger" data-post-id="{{$customer->id}}" style="cursor: pointer"
                                                           onclick="deleteEl(
                                                                   this,
                                                                   {
                                                                       id: '{{$customer->id}}',
                                                                       url: '{{route('customers.delete', $customer->id)}}',
                                                                       title: '{{__('messages.deleteTitle')}}',
                                                                       confirmText: '{{__('messages.confirmText')}}',
                                                                       cancelText: '{{__('messages.cancelText')}}',
                                                                       successMessage: '{{__('messages.customerDelete')}}'
                                                                   }
                                                               )"
                                                    >
                                                        {{__('form.delete')}}
                                                    </label>
                                                    <a class="label label-warning" href="{{route('customers.edit', $customer->id)}}">{{__('form.edit')}}</a>
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
    <div class="modal fade" id="large-Modal" tabindex="-1"
         role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Ünvanlar</h4>
                    <button type="button" class="close"
                            data-dismiss="modal"
                            aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table table-styling">
                        <thead>
                            <tr class="table-primary">
                                <th>#</th>
                                <th>{{__('form.firstname')}} {{__('form.lastname')}}</th>
                                <th>{{__('form.phone')}}</th>
                                <th>{{__('nav.addresses')}}</th>
                                <th>{{__('nav.addresses.city')}}</th>
                                <th>{{__('nav.addresses.deliveryNote')}}</th>
                            </tr>
                        </thead>
                        <tbody class="addresses">

                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button"
                            class="btn btn-default waves-effect "
                            data-dismiss="modal">Bağla
                    </button>
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

        function getCustomerAddresses(customerId){
            $('.addresses').empty();
            $.ajax({
                type: "GET",
                url: "/manage/"+customerId+'/addresses',
                success: function (response) {
                    if(response.data !== []){
                        console.log(response.data)
                        $.each(response.data, function (i, val) {
                            $('.addresses').append(`
                                <tr>
                                    <th>${val.id}</th>
                                    <td>${val.firstname} ${val.lastname}</td>
                                    <td>${val.phone}</td>
                                    <td>
                                       Address 1: ${val.address1} / Address 2: ${val.address1}
                                    </td>
                                    <td>${val.city}</td>
                                    <td>${val.delivery_note}</td>
                                </tr>
                            `);
                        })
                    }
                }
            })
        }
    </script>
@endsection
