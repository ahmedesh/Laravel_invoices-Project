@extends('layouts.master')

{{-- title --}}
@section('title')
    <title> نعديل حاله الدفع </title>
@endsection

@section('css')
    <!--- Internal Select2 css-->
    <link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
    <!---Internal Fileupload css-->
    <link href="{{ URL::asset('assets/plugins/fileuploads/css/fileupload.css') }}" rel="stylesheet" type="text/css" />
    <!---Internal Fancy uploader css-->
    <link href="{{ URL::asset('assets/plugins/fancyuploder/fancy_fileupload.css') }}" rel="stylesheet" />
    <!--Internal Sumoselect css-->
    <link rel="stylesheet" href="{{ URL::asset('assets/plugins/sumoselect/sumoselect-rtl.css') }}">
    <!--Internal  TelephoneInput css-->
    <link rel="stylesheet" href="{{ URL::asset('assets/plugins/telephoneinput/telephoneinput-rtl.css') }}">
@endsection

@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">الفواتير</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/
                    نعديل الفاتورة</span>
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
        {{--        @if($message = Session::get('success'))--}}
        {{--            <div class="alert alert-success container m-auto my-3 p-2 text-center" role="alert" style="width: 30%">--}}
        {{--                {{$message}}--}}
        {{--            </div>--}}
        {{--        @endif--}}

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

        <div class="col-lg-12 col-md-12">
            <div class="card">
                <div class="card-header pb-0">
                    <a href="{{route('invoices.index')}}" class="modal-effect btn btn-sm btn-primary" style="color:white"><i
                            class="fas fa-plus"></i> رجوع </a>
                </div>
                <div class="card-body">
                    <form action="{{ route('Status_Update',['id'=>$invoices->id]) }}" method="POST" autocomplete="off">
                        {{--                        action="{{ url('invoices/update') }}"  عملته هنا url عشان هو فال route المفروض بيرجعله id --}}
                        @csrf
                        {{-- 1 --}}

                        <div class="row">
                            <div class="col">
                                <label for="inputName" class="control-label">رقم الفاتورة</label>
                                <input hidden value="{{$invoices->id}}" name="invoice_id">
                                <input type="text" class="form-control" id="inputName" name="invoice_number" style="cursor:no-drop;"
                                       value="{{$invoices->invoice_number}}" title="رقم الفاتورة" readonly>
                            </div>

                            <div class="col">
                                <label>تاريخ الفاتورة</label>
                                <input class="form-control fc-datepicker" name="invoice_Date" placeholder="YYYY-MM-DD" style="cursor:none;"
                                       type="text" value="{{$invoices->invoice_Date}}" title="تاريخ الفاتورة" readonly>
                            </div>

                            <div class="col">
                                <label>تاريخ الاستحقاق</label>
                                <input class="form-control fc-datepicker" name="Due_date" placeholder="YYYY-MM-DD" style="cursor:none;"
                                       type="text" value="{{$invoices->Due_date}}" title="رقم الاستحقاق" readonly>
                            </div>

                        </div>

                        {{-- 2 --}}
                        <div class="row">
                            <div class="col">
                                <label for="inputName" class="control-label">القسم</label>
                                <select name="Section" class="form-control " readonly style="cursor:no-drop;">
                                    <!--placeholder-->
                                    <option value="{{ $invoices->sction->id}}">
                                        {{ $invoices->sction->section_name }}</option>
                                </select>
                            </div>

                            <div class="col">
                                <label for="inputName" class="control-label">المنتج</label>
                                <select id="product" name="product" class="form-control" readonly style="cursor:no-drop;">
                                    <option value="{{ $invoices->product }}" readonly> {{ $invoices->product }}</option>
                                </select>
                            </div>

                            <div class="col">
                                <label for="inputName" class="control-label"> مبلغ التحصيل </label>
                                <input type="text" class="form-control" id="inputName" name="Amount_collection"
                                       value="{{$invoices->Amount_collection}}" readonly style="cursor:no-drop;"
                                       oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">
                            </div>
                        </div>


                        {{-- 3 --}}

                        <div class="row">

                            <div class="col">
                                <label for="inputName" class="control-label"> مبلغ العمولة </label>
                                <input type="text" class="form-control form-control-lg" id="Amount_Commission"
                                       value="{{$invoices->Amount_Commission}}" readonly style="cursor:no-drop;"
                                       name="Amount_Commission" title="يرجي ادخال مبلغ العمولة "
                                       oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                                       >
                            </div>

                            <div class="col">
                                <label for="inputName" class="control-label">الخصم</label>
                                <input type="text" class="form-control form-control-lg" id="Discount" name="Discount"
                                       value="{{$invoices->Discount}}" readonly style="cursor:no-drop;"
                                       title="يرجي ادخال مبلغ الخصم "
                                       oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                                       value=0 >
                            </div>

                            <div class="col">
                                <label for="inputName" class="control-label">نسبة ضريبة القيمة المضافة</label>
                                <select name="Rate_VAT" id="Rate_VAT" class="form-control" onchange="myFunction()"
                                        value="{{$invoices->Rate_VAT}}" readonly style="cursor:no-drop;">
                                    <!--placeholder-->
                                    <option value="{{$invoices->Rate_VAT}}" class="text-danger" >{{$invoices->Rate_VAT}}</option>
                                </select>
                            </div>

                        </div>

                        {{-- 4 --}}

                        <div class="row">
                            <div class="col">
                                <label for="inputName" class="control-label">قيمة ضريبة القيمة المضافة</label>
                                <input type="text" class="form-control" id="Value_VAT" name="Value_VAT"
                                       value="{{$invoices->Value_VAT}}" readonly style="cursor:no-drop;">
                            </div>

                            <div class="col">
                                <label for="inputName" class="control-label">الاجمالي شامل الضريبة</label>
                                <input type="text" class="form-control" id="Total" name="Total"
                                       value="{{$invoices->Total}}" readonly style="cursor:no-drop;">
                            </div>
                        </div>

                        {{-- 5 --}}
                        <div class="row">
                            <div class="col">
                                <label for="exampleTextarea">ملاحظات</label>
                                <textarea class="form-control" id="exampleTextarea" name="note" rows="3" readonly style="cursor:no-drop;"></textarea>
                            </div>
                        </div>
                       <div class="row">
                           <div class="col">
                               <label for="inputName" class="control-label">حاله الدفع</label>
                               <select name="Status" id="Status" class="form-control  nice-select  custom-select"
                                       value="{{$invoices->Status}}" title="يرجي اختيار حاله الفاتورة" required>
                                   <!--placeholder-->
                                   <option value="{{$invoices->Status}}" class="text-danger" hidden>{{$invoices->Status}}</option>
                                   <option value="مدفوعه"> مدفوعه </option>
                                   <option value="مدفوعه جزئيا"> مدفوعه جزئيا </option>
                               </select>
                           </div>
                           <div class="col">
                               <label for="inputName" class="control-label">تاريخ الدفع</label>
                               <input hidden value="{{$invoices->id}}" name="Payment_Date">
                               <input type="date" class="form-control fc-datepicker" id="Payment_Date" name="Payment_Date"
                                      value="{{$invoices->Payment_Date}}"
                                      title="يرجي ادخال ناريخ الفاتورة" required>
                           </div>
                       </div> <br>

                        <div class="d-flex justify-content-center">
                            <button type="submit" class="btn btn-primary"> تحديث حاله الدفع </button>
                        </div>


                    </form>
                </div>
            </div>
        </div>
    </div>

    </div>

    <!-- row closed -->
    </div>
    <!-- Container closed -->
    </div>
    <!-- main-content closed -->
@endsection
@section('js')
    <!-- Internal Select2 js-->
    <script src="{{ URL::asset('assets/plugins/select2/js/select2.min.js') }}"></script>
    <!--Internal Fileuploads js-->
    <script src="{{ URL::asset('assets/plugins/fileuploads/js/fileupload.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/fileuploads/js/file-upload.js') }}"></script>
    <!--Internal Fancy uploader js-->
    <script src="{{ URL::asset('assets/plugins/fancyuploder/jquery.ui.widget.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/fancyuploder/jquery.fileupload.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/fancyuploder/jquery.iframe-transport.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/fancyuploder/jquery.fancy-fileupload.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/fancyuploder/fancy-uploader.js') }}"></script>
    <!--Internal  Form-elements js-->
    <script src="{{ URL::asset('assets/js/advanced-form-elements.js') }}"></script>
    <script src="{{ URL::asset('assets/js/select2.js') }}"></script>
    <!--Internal Sumoselect js-->
    <script src="{{ URL::asset('assets/plugins/sumoselect/jquery.sumoselect.js') }}"></script>
    <!--Internal  Datepicker js -->
    <script src="{{ URL::asset('assets/plugins/jquery-ui/ui/widgets/datepicker.js') }}"></script>
    <!--Internal  jquery.maskedinput js -->
    <script src="{{ URL::asset('assets/plugins/jquery.maskedinput/jquery.maskedinput.js') }}"></script>
    <!--Internal  spectrum-colorpicker js -->
    <script src="{{ URL::asset('assets/plugins/spectrum-colorpicker/spectrum.js') }}"></script>
    <!-- Internal form-elements js -->
    <script src="{{ URL::asset('assets/js/form-elements.js') }}"></script>

    <script>
        var date = $('.fc-datepicker').datepicker({
            dateFormat: 'yy-mm-dd'
        }).val();

    </script>

    {{--    عشان لما اختار قسم معين يختارلي المنتجات الخاصه بيه فقط  --}}
    <script>
        $(document).ready(function() {
            $('select[name="Section"]').on('change', function() {  // Section => دا اسم ال select اللي ف حفل القسم  name="Section"
                var SectionId = $(this).val();  // this => عائده علي الحقل دا هاتلي القيمه اللي فيه وكدا كدا انا قايله فوق انه بياحد قيمه بال id
                if (SectionId) {
                    $.ajax({
                        url: "{{ URL::to('section') }}/" + SectionId,  // URL::to('section') /" + SectionId == section/{id}
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            $('select[name="product"]').empty(); // روح عليه فضيه خالص لو لقيت فيه حاجه
                            $.each(data, function(key, value) {
                                $('select[name="product"]').append('<option value="' + // كريتلي option حوا ال select وحطلي فيه الاسم اللي رجعلي
                                    value + '">' + value + '</option>');
                            });
                        },
                    });

                } else {
                    console.log('AJAX load did not work');
                }
            });

        });
    </script>

    {{-- حسبه قيمة ضريبة القيمة المضافة والاجمالي الكلي --}}

    {{-- لاحظ قيمه ضريبه القيمه المضافه بتتحسب بعد الخصم مش قبل --}}
    <script>
        function myFunction() {

            var Amount_Commission = parseFloat(document.getElementById("Amount_Commission").value);
            var Discount = parseFloat(document.getElementById("Discount").value); // parseFloat => عشان يعرضلي الارقام العشريه(الكسور)
            var Rate_VAT = parseFloat(document.getElementById("Rate_VAT").value); // parseFloat => عشان يعرضلي الارقام العشريه(الكسور)
            var Value_VAT = parseFloat(document.getElementById("Value_VAT").value); // parseFloat => عشان يعرضلي الارقام العشريه(الكسور)

            var Amount_Commission2 = Amount_Commission - Discount;   // المبلغ الحقيقي = (العموله - الخصم)


            if (typeof Amount_Commission === 'undefined' || !Amount_Commission) {  //  لو مبلغ العمولة فاضي طلعله تحذير

                alert('يرجي ادخال مبلغ العمولة ');

            } else {
                var intResults = Amount_Commission2 * Rate_VAT / 100;  // قيمه الضريبه المضافه = (العموله - الخصم) * نسبه الضريبه المضافه

                var intResults2 = parseFloat(intResults + Amount_Commission2); // الاجمالي =  قيمه الضريبه المضافه + المبلغ الحقيقي

                sumq = parseFloat(intResults).toFixed(2);  // parseFloat => عشان يعرضلي الارقام العشريه(الكسور)

                sumt = parseFloat(intResults2).toFixed(2);  // parseFloat => عشان يعرضلي الارقام العشريه(الكسور)

                document.getElementById("Value_VAT").value = sumq;  // حطلي الناتج قيمه ضريبه القيمه المضافه

                document.getElementById("Total").value = sumt;  // حطلي الناتج فالاجمالي

            }

        }

    </script>


@endsection
