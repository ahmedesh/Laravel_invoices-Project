@extends('layouts.master')

{{-- title --}}
@section('title')
    <title> تفاصيل الفاتورة </title>
@endsection

@section('css')
    /*<!-- Internal Data table css -->*/
    <link href="{{URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" />
    <link href="{{URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css')}}" rel="stylesheet">
    <link href="{{URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css')}}" rel="stylesheet" />
    <link href="{{URL::asset('assets/plugins/datatable/css/jquery.dataTables.min.css')}}" rel="stylesheet">
    <link href="{{URL::asset('assets/plugins/datatable/css/responsive.dataTables.min.css')}}" rel="stylesheet">
    <link href="{{URL::asset('assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet">

    <!---Internal  Prism css-->
    <link href="{{URL::asset('assets/plugins/prism/prism.css')}}" rel="stylesheet">
    <!---Internal Input tags css-->
    <link href="{{URL::asset('assets/plugins/inputtags/inputtags.css')}}" rel="stylesheet">
    <!--- Custom-scroll -->
    <link href="{{URL::asset('assets/plugins/custom-scroll/jquery.mCustomScrollbar.css')}}" rel="stylesheet">
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">الفواتير</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ قائمة الفواتير</span>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection
@section('content')
<div class=" tab-menu-heading">
    <div class="tabs-menu1">
        <!-- Tabs -->
        <ul class="nav panel-tabs main-nav-line">
            <li><a href="#tab1" class="nav-link active" data-toggle="tab">معلومات الفاتورة</a></li>
            <li><a href="#tab2" class="nav-link" data-toggle="tab">حالات الدفع</a></li>
            <li><a href="#tab3" class="nav-link" data-toggle="tab">المرفقات</a></li>
        </ul>
    </div>
</div>
<div class="panel-body tabs-menu-body main-content-body-right border">
    <div class="tab-content">
        <div class="tab-pane active" id="tab1">

            <!-- row -->
            <div class="row">
                <!--div-->
                <div class="col-xl-12">
                    <div class="card mg-b-20">
                        <div class="card-header pb-0">
                            <a href="{{route('invoices.index')}}" class="modal-effect btn btn-sm btn-primary" style="color:white"><i
                                    class="fas fa-plus"></i> رجوع </a>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="example1" class="table key-buttons text-md-nowrap">
                                    <thead>
                                    <tr>
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
                                    </tr>
                                    </thead>
                                    <tbody>

{{--                                    @foreach($inovices as $inovice)--}}
{{--لاحظ معملتش loop هنا عشان انا اصلا قايله يرجعلي row واحد بس مش اكتر ف مش محاج اني الوب بقا هنا--}}
                                        <tr>
                                            <td>{{$inovices->invoice_number}}</td>
                                            <td>{{$inovices->invoice_Date}}</td>
                                            <td>{{$inovices->Due_date}}</td>
                                            <td>{{$inovices->product}}</td>
                                            <td>{{$inovices->sction->section_name}} </td>
                                            <td>{{$inovices->Discount}}</td>
                                            <td>{{$inovices->Rate_VAT}}</td>
                                            <td>{{$inovices->Value_VAT}}</td>
                                            <td>{{$inovices->Total}}</td>
                                            <td>
                                                @if ($inovices->Value_Status == 1)
                                                    <span class="badge badge-pill badge-success">{{ $inovices->Status }}</span>
                                                @elseif($inovices->Value_Status == 2)
                                                    <span class="badge badge-pill badge-danger">{{ $inovices->Status }}</span>
                                                @else
                                                    <span class="badge badge-pill badge-warning">{{ $inovices->Status }}</span>
                                                @endif
                                            </td>
                                            <td>{{$inovices->note}}</td>
                                        </tr>
{{--                                    @endforeach--}}

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
        <div class="tab-pane" id="tab2">

            <!-- row -->
            <div class="row">
                <!--div-->
                <div class="col-xl-12">
                    <div class="card mg-b-20">
                        <div class="card-header pb-0">
                            <a href="{{route('invoices.index')}}" class="modal-effect btn btn-sm btn-primary" style="color:white"><i
                                    class="fas fa-plus"></i> رجوع </a>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="example3" class="table key-buttons text-md-nowrap">
                                    <thead>
                                    <tr>
                                        <th class="border-bottom-0">#</th>
                                        <th class="border-bottom-0">رقم الفاتورة</th>
                                        <th class="border-bottom-0">المنتج</th>
                                        <th class="border-bottom-0">القسم</th>
                                        <th class="border-bottom-0">الحاله</th>
                                        <th class="border-bottom-0">تاريخ الاضافه</th>
                                        <th class="border-bottom-0">تاريخ الدفع</th>
                                        <th class="border-bottom-0">المستخدم</th>
                                        <th class="border-bottom-0">ملاحظات</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @php
                                        $i = 1;
                                    @endphp

                                    @foreach($invoices_details as $item)

                                        <tr>
                                            <td>{{$i++}}</td>
                                            <td>{{$item->invoice_number}}</td>
                                            <td>{{$item->product}}</td>
                                            <td>{{$inovices->sction->section_name}} </td>
                                            <td>
                                                @if ($item->Value_Status == 1)
                                                    <span class="badge badge-pill badge-success">{{ $item->Status }}</span>
                                                @elseif($item->Value_Status == 2)
                                                    <span class="badge badge-pill badge-danger">{{ $item->Status }}</span>
                                                @else
                                                    <span class="badge badge-pill badge-warning">{{ $item->Status }}</span>
                                                @endif
                                            </td>
                                            <td>{{$item->created_at}}</td>
                                            <td>{{$item->Payment_Date}}</td>
                                            <td>{{$item->user}}</td>
                                            <td>{{$item->note}}</td>
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
        <div class="tab-pane" id="tab3">
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
{{--                @if($message = Session::get('success'))--}}
{{--                    <div class="alert alert-success container m-auto my-3 p-2 text-center" role="alert" style="width: 30%">--}}
{{--                        {{$message}}--}}
{{--                    </div>--}}
{{--            @endif--}}

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

                <!--div-->
                <div class="col-xl-12">
                    <div class="card mg-b-20">
                        <div class="card-header pb-0">
                            <a href="{{route('invoices.index')}}" class="modal-effect btn btn-sm btn-primary" style="color:white"><i
                                    class="fas fa-plus"></i> رجوع </a>
                        </div>
                        <br>
                        <!--المرفقات-->
                        <div class="card card-statistics">
                            @can('اضافة مرفق')
                                <div class="card-body">
                                    <p class="text-danger">* صيغة المرفق pdf, jpeg ,.jpg , png </p>
                                    <h5 class="card-title">اضافة مرفقات</h5>
                                    <form method="post" action="{{ url('/InvoiceAttachments') }}"
                                          enctype="multipart/form-data">
                                        {{ csrf_field() }}
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="customFile"
                                                   name="file_name" required>
                                            <input type="hidden" id="customFile" name="invoice_number"
                                                   value="{{ $inovices->invoice_number }}">
                                            <input type="hidden" id="invoice_id" name="invoice_id"
                                                   value="{{ $inovices->id }}">
                                            <label class="custom-file-label" for="customFile">حدد
                                                المرفق</label>
                                        </div><br><br>
                                        <button type="submit" class="btn btn-primary btn-sm "
                                                name="uploadedFile">تاكيد</button>
                                    </form>
                                </div>
                            @endcan
                            <br>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="example1" class="table key-buttons text-md-nowrap">
                                    <thead>
                                    <tr>
                                        <th class="border-bottom-0">#</th>
                                        <th class="border-bottom-0">رقم الفاتورة</th>
                                        <th class="border-bottom-0">اسم الملف </th>
                                        <th class="border-bottom-0">قام بالاضافه</th>
                                        <th class="border-bottom-0">تاريخ الاضافه</th>
                                        <th class="border-bottom-0"> العمليات </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @php
                                        $i = 1;
                                    @endphp

                                    @foreach($invoice_attachments as $attachment)

                                        <tr>
                                            <td>{{$i++}}</td>
                                            <td>{{$attachment->invoice_number}}</td>
                                            <td>{{$attachment->file_name}}</td>
                                            <td>{{$attachment->Created_by}} </td>
                                            <td>{{$attachment->created_at}} </td>
                                            <td colspan="2">

                                                <a class="btn btn-outline-success btn-sm"
                                                   href="{{ url('View_file') }}/{{ $inovices->invoice_number }}/{{ $attachment->file_name }}"
                                                   role="button"><i class="fas fa-eye"></i>&nbsp;
                                                    عرض</a>

                                                <a class="btn btn-outline-info btn-sm"
                                                   href="{{ url('download') }}/{{ $inovices->invoice_number }}/{{ $attachment->file_name }}"
                                                   role="button"><i
                                                        class="fas fa-download"></i>&nbsp;
                                                    تحميل</a>

                                                @can('حذف المرفق')
                                                    <button class="btn btn-outline-danger btn-sm"
                                                            data-toggle="modal"
                                                            data-file_name="{{ $attachment->file_name }}"
                                                            data-invoice_number="{{ $attachment->invoice_number }}"
                                                            data-id_file="{{ $attachment->id }}"
                                                            data-target="#delete_file">حذف</button>
                                                @endcan

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
    </div>
</div>


<!-- delete -->
<div class="modal fade" id="delete_file" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">حذف المرفق</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('delete_file') }}" method="post">

                {{ csrf_field() }}
                <div class="modal-body">
                    <div class="text-center">
                    <h6 style="color:red"> هل انت متاكد من عملية حذف المرفق ؟</h6>
                </div>

                    <input type="hidden" name="id_file" id="id_file" value="">
                    <input type="hidden" name="file_name" id="file_name" value="">
                    <input type="hidden" name="invoice_number" id="invoice_number" value="">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">الغاء</button>
                    <button type="submit" class="btn btn-danger">تاكيد</button>
                </div>
            </form>
        </div>
    </div>


<!-- main-content closed -->
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
    <!--Internal  Datatable js -->
    <script src="{{URL::asset('assets/js/table-data.js')}}"></script>

    <!--Internal  Datepicker js -->
    <script src="{{URL::asset('assets/plugins/jquery-ui/ui/widgets/datepicker.js')}}"></script>
    <!-- Internal Select2 js-->
    <script src="{{URL::asset('assets/plugins/select2/js/select2.min.js')}}"></script>
    <!-- Internal Jquery.mCustomScrollbar js-->
    <script src="{{URL::asset('assets/plugins/custom-scroll/jquery.mCustomScrollbar.concat.min.js')}}"></script>
    <!-- Internal Input tags js-->
    <script src="{{URL::asset('assets/plugins/inputtags/inputtags.js')}}"></script>
    <!--- Tabs JS-->
    <script src="{{URL::asset('assets/plugins/tabs/jquery.multipurpose_tabcontent.js')}}"></script>
    <script src="{{URL::asset('assets/js/tabs.js')}}"></script>
    <!--Internal  Clipboard js-->
    <script src="{{URL::asset('assets/plugins/clipboard/clipboard.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/clipboard/clipboard.js')}}"></script>
    <!-- Internal Prism js-->
    <script src="{{URL::asset('assets/plugins/prism/prism.js')}}"></script>

{{--   حذف المرفق  --}}
    <script>
        $('#delete_file').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var id_file = button.data('id_file')
            var file_name = button.data('file_name')
            var invoice_number = button.data('invoice_number')
            var modal = $(this)
            modal.find('.modal-body #id_file').val(id_file);
            modal.find('.modal-body #file_name').val(file_name);
            modal.find('.modal-body #invoice_number').val(invoice_number);
        })
    </script>
@endsection
