@extends('layouts.master')

{{-- title --}}
@section('title')
    <title> قائمة الفواتير المدفوعه جزئيا </title>
@endsection

@section('css')
    /*<!-- Internal Data table css -->*/
    <link href="{{URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" />
    <link href="{{URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css')}}" rel="stylesheet">
    <link href="{{URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css')}}" rel="stylesheet" />
    <link href="{{URL::asset('assets/plugins/datatable/css/jquery.dataTables.min.css')}}" rel="stylesheet">
    <link href="{{URL::asset('assets/plugins/datatable/css/responsive.dataTables.min.css')}}" rel="stylesheet">
    <link href="{{URL::asset('assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet">
    <!--Internal   Notify -->
    <link href="{{URL::asset('assets/plugins/notify/css/notifIt.css')}}" rel="stylesheet"/>
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">الفواتير</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ قائمة الفواتير المدفوعه جزئيا </span>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection
@section('content')
    <!-- row -->
    <div class="row">

        {{-- errors --}}
        {{--    $errors دي فانكشن متعرفه جاهزه ف لارفيل   --}}
        @if(count($errors) > 0)
            @foreach($errors->all() as $error)
                <div class="alert alert-danger container m-auto my-3 p-2 text-center" role="alert" style="width: 30%">
                    {{$error}}
                </div>
            @endforeach
        @endif

        {{-- success  --}}
        {{--    @if($message = Session::get('success'))--}}
        {{--        <div class="alert alert-success container m-auto my-3 p-2 text-center" role="alert" style="width: 30%">--}}
        {{--            {{$message}}--}}
        {{--        </div>--}}
        {{--    @endif--}}

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
            <div class="card mg-b-20">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example1" class="table key-buttons text-md-nowrap" data-page-length="50">
                            <thead>
                            <tr>
                                <th class="border-bottom-0">#</th>
                                <th class="border-bottom-0">رقم الفاتورة</th>
                                <th class="border-bottom-0">تاريخ الفاتورة</th>
                                <th class="border-bottom-0">تاريخ الاستحقاق</th>
                                <th class="border-bottom-0">المنتج</th>
                                <th class="border-bottom-0">القسم</th>
                                <th class="border-bottom-0">الخصم</th>
                                <th class="border-bottom-0">نسبة الضريبة</th>
                                <th class="border-bottom-0">قيمة الضريبة</th>
                                <th class="border-bottom-0">الاجمالي</th>
                                <th class="border-bottom-0">الحاله</th>
                                <th class="border-bottom-0">ملاحظات</th>
                                <th class="border-bottom-0">العمليات</th>
                            </tr>
                            </thead>
                            <tbody>
                            @php
                                $i = 1;
                            @endphp

                            @foreach($invoices as $inovice)

                                <tr>
                                    <td>{{$i++}}</td>
                                    <td>{{$inovice->invoice_number}}</td>
                                    <td>{{$inovice->invoice_Date}}</td>
                                    <td>{{$inovice->Due_date}}</td>
                                    <td>{{$inovice->product}}</td>
                                    <td>
                                        <a href="invoicesDetails/{{$inovice->id}}">  {{-- invoicesDetails مسار ال Route --}}
                                            {{$inovice->sction->section_name}}
                                        </a>
                                    </td>
                                    <td>{{$inovice->Discount}}</td>
                                    <td>{{$inovice->Rate_VAT}}</td>
                                    <td>{{$inovice->Value_VAT}}</td>
                                    <td>{{$inovice->Total}}</td>
                                    <td>
                                        @if ($inovice->Value_Status == 1)
                                            <span class="text-success">{{ $inovice->Status }}</span>
                                        @elseif($inovice->Value_Status == 2)
                                            <span class="text-danger">{{ $inovice->Status }}</span>
                                        @else
                                            <span class="text-warning">{{ $inovice->Status }}</span>
                                        @endif
                                    </td>
                                    <td>{{$inovice->note}}</td>
                                    <td>
                                        <div class="dropdown">
                                            <button aria-expanded="false" aria-haspopup="true"
                                                    class="btn ripple btn-primary btn-sm" data-toggle="dropdown"
                                                    type="button">العمليات<i class="fas fa-caret-down ml-1"></i>
                                            </button>
                                            <div class="dropdown-menu tx-13">
                            @can('تعديل الفاتورة')
                                                <a class="dropdown-item"
                                                   href=" {{ url('edit_invoice') }}/{{ $inovice->id }}">تعديل الفاتورة
                                                </a>
                                       @endcan

                            @can('حذف الفاتورة')
                                                <a class="dropdown-item" href="#" data-invoice_id="{{ $inovice->id }}"
                                                   data-toggle="modal" data-target="#delete_invoice"><i
                                                        class="text-danger fas fa-trash-alt"></i>&nbsp;&nbsp;حذف
                                                    الفاتورة</a>
                                       @endcan

                            @can('تغير حالة الدفع')
                                                <a class="dropdown-item"
                                                   href="{{ URL::route('Status_show', [$inovice->id]) }}"><i
                                                        class=" text-success fas
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        fa-money-bill"></i>&nbsp;&nbsp;تغير
                                                    حالة
                                                    الدفع</a>
                                        @endcan

                            @can('ارشفة الفاتورة')
                                                <a class="dropdown-item" href="#" data-invoice_id="{{ $inovice->id }}"
                                                   data-toggle="modal" data-target="#Transfer_invoice"><i
                                                        class="text-warning fas fa-exchange-alt"></i>&nbsp;&nbsp;نقل الي
                                                    الارشيف</a>
                                        @endcan

                             @can('طباعةالفاتورة')
                                                <a class="dropdown-item" href="Print_invoice/{{ $inovice->id }}"><i
                                                        class="text-success fas fa-print"></i>&nbsp;&nbsp;طباعة
                                                    الفاتورة
                                                </a>
                                         @endcan
                                            </div>
                                        </div>
                                    </td>

                                </tr>
                            @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- حذف الفاتورة -->
                <div class="modal fade" id="delete_invoice" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                     aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">حذف الفاتورة</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                <form action="{{ route('invoices.destroy', 'test') }}" method="post">
                                {{ method_field('delete') }}
                                {{ csrf_field() }}   {{-- هو خاص بالتشفير --}}
                            </div>
                            <div class="modal-body">
                                هل انت متاكد من عملية الحذف ؟
                                <input type="hidden" name="invoice_id" id="invoice_id" value="">
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">الغاء</button>
                                <button type="submit" class="btn btn-danger">تاكيد</button>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>


                <!-- ارشيف الفاتورة -->
                <div class="modal fade" id="Transfer_invoice" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                     aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">ارشفة الفاتورة</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                <form action="{{ route('invoices.destroy', 'test') }}" method="post">
                                {{ method_field('delete') }}
                                {{ csrf_field() }}
                            </div>
                            <div class="modal-body">
                                هل انت متاكد من عملية الارشفة ؟
                                <input type="hidden" name="invoice_id" id="invoice_id" value="">
                                <input type="hidden" name="id_page" id="id_page" value="2">

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">الغاء</button>
                                <button type="submit" class="btn btn-success">تاكيد</button>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>



            </div>
        </div>
        <!--/div-->

    </div>
    <!-- row closed -->

@endsection
@section('js')
    <!-- Internal Data tables -->
    <script src="{{URL::asset('assets/plugins/datatable/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/dataTables.dataTables.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/responsive.dataTables.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/jquery.dataTables.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/dataTables.bootstrap4.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/dataTables.buttons.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/buttons.bootstrap4.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/jszip.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/pdfmake.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/vfs_fonts.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/buttons.html5.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/buttons.print.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/buttons.colVis.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/responsive.bootstrap4.min.js')}}"></script>

    <!--Internal  Notify js -->
    <script src="{{URL::asset('assets/plugins/notify/js/notifIt.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/notify/js/notifit-custom.js')}}"></script>
    <!--Internal  Datatable js -->
    <script src="{{URL::asset('assets/js/table-data.js')}}"></script>

    {{--  عشان يباصيلي قيمه ال id بتاع الفاتوره فالموديل دا  --}}
    <script>
        $('#delete_invoice').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var invoice_id = button.data('invoice_id')
            var modal = $(this)
            modal.find('.modal-body #invoice_id').val(invoice_id);
        })
    </script>

    {{--  عشان يباصيلي قيمه ال id بتاع الفاتوره فالموديل دا  --}}
    <script>
        $('#Transfer_invoice').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var invoice_id = button.data('invoice_id')
            var modal = $(this)
            modal.find('.modal-body #invoice_id').val(invoice_id);
        })
    </script>
@endsection
