@extends('admin.v1.layout.app')
@section('title', __('nav.campaigns'))
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
                        <h5>{{ __('nav.campaigns')}}</h5>
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
                                {{__('nav.campaigns')}}
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
                                        <th>{{__('form.title')}}</th>
                                        <th>{{__('form.status')}}</th>
                                        <th>{{__('form.campaigns.rate')}}</th>
                                        <th>{{__('nav.actions')}}</th>

                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($campaigns as $campaign)
                                        <tr>
                                            <th scope="row">{{$campaign->id}}</th>
                                            <td>{{$campaign->translation()->title}}</td>
                                            <td>{{$campaign->status}}</td>
                                            <td>{{$campaign->rate}}</td>
                                            <td>
                                                <div class="label-main" style="margin: 0;">
                                                    <label class="label label-danger" data-campaign-id="{{$campaign->id}}" style="cursor: pointer"
                                                           onclick="deleteEl(
                                                               this,
                                                               {
                                                                   id: '{{$campaign->id}}',
                                                                   url: '{{route('campaigns.delete', $campaign->id)}}',
                                                                   title: '{{__('messages.deleteTitle')}}',
                                                                   confirmText: '{{__('messages.confirmText')}}',
                                                                   cancelText: '{{__('messages.cancelText')}}',
                                                                   successMessage: '{{__('messages.campaignDelete')}}'
                                                               }
                                                           )"
                                                    >
                                                        {{__('form.delete')}}
                                                    </label>
                                                    <a class="label label-warning" href="{{route('campaigns.edit', $campaign->id)}}">{{__('form.edit')}}</a>
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
            let campaignId = $(this).data('campaign-id')
            window.location.href = '/manage/campaigns/'+campaignId+'/edit';
        })
    </script>
@endsection

