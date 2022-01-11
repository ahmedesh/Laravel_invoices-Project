@extends('layouts.master')

{{-- title --}}
@section('title')
    <title> اضافة الفواتير </title>
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
                    اضافة فاتورة</span>
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
                    <form action="{{ route('invoices.store') }}" method="post" enctype="multipart/form-data"
                          autocomplete="off">
{{--                        {{ csrf_field() }}--}}
                        @csrf
                        {{-- 1 --}}

                        <div class="row">
                            <div class="col">
                                <label for="inputName" class="control-label">رقم الفاتورة</label>
                                <input type="text" class="form-control" id="inputName" name="invoice_number"
                                       title="يرجي ادخال رقم الفاتورة" required>
                            </div>

                            <div class="col">
                                <label>تاريخ الفاتورة</label>
                                <input class="form-control fc-datepicker" name="invoice_Date" placeholder="YYYY-MM-DD"
                                       type="date" value="{{ date('Y-m-d') }}" required>
                            </div>

                            <div class="col">
                                <label>تاريخ الاستحقاق</label>
                                <input class="form-control fc-datepicker" name="Due_date" placeholder="YYYY-MM-DD"
                                       type="date" required>
                            </div>

                        </div>

                        {{-- 2 --}}
                        <div class="row">
                            <div class="col">
                                <label for="inputName" class="control-label">القسم</label>
                                <select name="Section" class="form-control SlectBox" required>
                                    <!--placeholder-->
                                    <option value="" selected disabled>حدد القسم</option>
                                    @foreach ($sections as $section)
                                        <option value="{{ $section->id }}"> {{ $section->section_name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col">
                                <label for="inputName" class="control-label">المنتج</label>
                                <select id="product" name="product" class="form-control">
                                    {{--    محطتش option هتا عشان يتحطلي تلقائي بال ajax    --}}
                                </select>
                            </div>

                            <div class="col">
                                <label for="inputName" class="control-label"> مبلغ التحصيل </label>
                                <input type="text" class="form-control" id="inputName" name="Amount_collection" required
                                       oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">
                            </div>
                        </div>


                        {{-- 3 --}}

                        <div class="row">

                            <div class="col">
                                <label for="inputName" class="control-label"> مبلغ العمولة </label>
                                <input type="text" class="form-control form-control-lg" id="Amount_Commission" required
                                       name="Amount_Commission" title="يرجي ادخال مبلغ العمولة "
                                       oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                                       required>
                            </div>

                            <div class="col">
                                <label for="inputName" class="control-label">الخصم</label>
                                <input type="text" class="form-control form-control-lg" id="Discount" name="Discount" required
                                       title="يرجي ادخال مبلغ الخصم "
                                       oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                                       value=0 required>
                            </div>

                            <div class="col">
                                <label for="inputName" class="control-label">نسبة ضريبة القيمة المضافة</label>
                                <select name="Rate_VAT" id="Rate_VAT" class="form-control" onchange="myFunction()" required>
                                    <!--placeholder-->
                                    <option value="" selected disabled>حدد نسبة الضريبة</option>
                                    <option value="5%">5%</option>
                                    <option value="10%">10%</option>
                                    <option value="15%">15%</option>
                                </select>
                            </div>

                        </div>

                        {{-- 4 --}}

                        <div class="row">
                            <div class="col">
                                <label for="inputName" class="control-label">قيمة ضريبة القيمة المضافة</label>
                                <input type="text" class="form-control" id="Value_VAT" name="Value_VAT" readonly>
                            </div>

                            <div class="col">
                                <label for="inputName" class="control-label">الاجمالي شامل الضريبة</label>
                                <input type="text" class="form-control" id="Total" name="Total" readonly>
                            </div>
                        </div>

                        {{-- 5 --}}
                        <div class="row">
                            <div class="col">
                                <label for="exampleTextarea">ملاحظات</label>
                                <textarea class="form-control" id="exampleTextarea" name="note" rows="3"></textarea>
                            </div>
                        </div><br>

                        <p class="text-danger">* صيغة المرفق pdf, jpeg ,.jpg , png </p>
                        <h5 class="card-title">المرفقات</h5>

                        <div class="col-sm-12 col-md-12">
                            <input type="file" name="pic" class="dropify" accept=".pdf,.jpg, .png, image/jpeg, image/png"
                                   data-height="70" />
                        </div><br>

                        <div class="d-flex justify-content-center">
                            <button type="submit" class="btn btn-primary">حفظ البيانات</button>
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
                        url: "{{ URL::to('section') }}/" + SectionId,  // URL::to('section') /" + SectionId == section/{id} =>route
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            $('select[name="product"]').empty(); // روح عليه فضيه خالص لو لقيت فيه حاجه
                            $.each(data, function(key, value) {
                                $('select[name="product"]').append('<option value="' + // كريتلي option حوا ال select وحطلي فيه الاسماء اللي رجعتلي
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

                sumq = parseFloat(intResults).toFixed();  // parseFloat => عشان يعرضلي الارقام العشريه(الكسور)

                sumt = parseFloat(intResults2).toFixed();  // parseFloat => عشان يعرضلي الارقام العشريه(الكسور)

                document.getElementById("Value_VAT").value = sumq;  // حطلي الناتج قيمه ضريبه القيمه المضافه

                document.getElementById("Total").value = sumt;  // حطلي الناتج فالاجمالي

            }

        }

    </script>


@endsection
