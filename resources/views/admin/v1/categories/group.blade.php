@extends('admin.v1.layout.app')
@section('title', __('nav.categoriesGroup'))

@section('style')
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
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
                        <div class="col-sm-8">
                            <div class="card">
                                <div class="card-header">
                                    <h5>{{__('nav.categoriesGroup')}}</h5>
                                </div>
                                <div class="row card-block">
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>{{__('form.name')}}</th>
                                                </tr>
                                            </thead>
                                            <tbody class="categoryGroups">
                                                @foreach($categoryGroups as $key => $categoryItem)
                                                    <tr data-slug="{{$categoryItem['slug']}}" data-position="{{$categoryItem->position}}">
                                                        <th scope="row">{{++$key}}</th>
                                                        <td>{{$categoryItem['slug']}}</td>
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
        </div>
    </div>
@endsection
@section('js')
    <script type="text/javascript" src="{{asset('admin/js/jquery-ui.min.js')}}"></script>
    <script>
        $(function () {
            $('.categoryGroups').sortable({
                update: function (event, ui) {
                    let slug = ui.item.data('slug');
                    let position = ui.item.index();

                    let slugs = $.map($(this).find('tr'), function(el) {
                        return {'slug': $(el).data('slug'), 'index': $(el).index()}
                    })

                    let positions = $.map($(this).find('tr'), function(el) {
                        return {'position': $(el).data('position')}
                    })

                    positions.sort((a, b) => a.position - b.position)

                    $.ajax({
                        type: "POST",
                        url: "/manage/categories/groups/positions/update",
                        data: {slugs, positions},
                        success: function (response) {
                            console.log(response)
                        }
                    })
                }
            }).disableSelection();
        })
    </script>
@endsection
