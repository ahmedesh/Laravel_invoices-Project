@extends('layouts.master')

{{-- title --}}
@section('title')
    <title> صلاحيات المستخدمين  </title>
@endsection

@section('css')
    <!--Internal   Notify -->
    <link href="{{ URL::asset('assets/plugins/notify/css/notifIt.css') }}" rel="stylesheet" />
@endsection

@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">المستخدمين</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0"> /
                صلاحيات المستخدمين</span>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection
@section('content')

    <!-- row -->
    <div class="row row-sm">

        {{-- errors --}}
        {{--    $errors دي فانكشن متعرفه جاهزه ف لارفيل   --}}
        @if (count($errors) > 0)
            <div class="alert alert-danger">
                <button aria-label="Close" class="close" data-dismiss="alert" type="button">
                    <span aria-hidden="true">&times;</span>
                </button>
                <strong>خطا</strong>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- success  --}}
        @if (session()->has('success'))
            <script>
                window.onload = function() {
                    notif({
                        // msg: "تم حذف الفاتورة بنجاح",
                        msg:'{{session('success')}}',
                        type: "success"
                    })
                }
            </script>
        @endif

        <div class="col-xl-12">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between">
                        <div class="col-lg-12 margin-tb">
                            <div class="pull-right">
                                @can('اضافة صلاحية')
                                    <a class="btn btn-primary btn-sm" href="{{ route('roles.create') }}">اضافة</a>
                                @endcan
                            </div>
                        </div>
                        <br>
                    </div>

                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table mg-b-0 text-md-nowrap table-hover ">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>الاسم</th>
                                <th>العمليات</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($roles as $key => $role)
                                <tr>
                                    <td>{{ ++$i }}</td>
                                    <td>{{ $role->name }}</td>
                                    <td>
                                    @if ($role->name !== 'Admin')
                                        @can('عرض صلاحية')
                                            <a class="btn btn-success btn-sm"
                                               href="{{ route('roles.show', $role->id) }}">عرض</a>
                                        @endcan

                                        @can('تعديل صلاحية')
                                            <a class="btn btn-primary btn-sm"
                                               href="{{ route('roles.edit', $role->id) }}">تعديل</a>
                                        @endcan

{{--                                        @if ($role->name !== 'Admin')--}}
                                            @can('حذف صلاحية')
                                                {!! Form::open(['method' => 'DELETE', 'route' => ['roles.destroy',
                                                $role->id], 'style' => 'display:inline']) !!}
                                                {!! Form::submit('حذف', ['class' => 'btn btn-danger btn-sm']) !!}
                                                {!! Form::close() !!}
                                            @endcan
                                        @endif


                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!--/div-->
    </div>
    <!-- row closed -->
    </div>
    <!-- Container closed -->
    </div>
    <!-- main-content closed -->
@endsection
@section('js')
    <!--Internal  Notify js -->
    <script src="{{ URL::asset('assets/plugins/notify/js/notifIt.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/notify/js/notifit-custom.js') }}"></script>
@endsection
