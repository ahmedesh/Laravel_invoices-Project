<?php

namespace App\Http\Controllers;

use App\invoice_attachments;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InvoiceAttachmentsController extends Controller
{

//    public function __construct()
//    {   // عشان احمي ان مش اي حد يقدر يخش علي الا م يسجل الاول
//        $this->middleware('auth');
//    }
    function __construct()
    {   // حمايه الكونترولر بتاعي بالصلاحيات اللي انا مديهالو
        $this->middleware('auth');
        $this->middleware('permission:اضافة مرفق', ['only' => ['create','store']]);
        $this->middleware('permission:حذف المرفق', ['only' => ['destroy']]);
    }

    public function index()
    {

    }

    public function create()
    {

    }


    public function store(Request $request)
    {

        $this->validate($request, [

            'file_name' => 'mimes:pdf,jpeg,png,jpg',

        ], [
            'file_name.mimes' => 'صيغة المرفق يجب ان تكون   pdf, jpeg , png , jpg',
        ]);

        $image = $request->file_name;
        $file_name = $image->getClientOriginalName();  // getClientOriginalName  بيجبلي اسم الصوره بالامتداد بتاعها ويرجعهملي بقا
        // يحفظلي الصوره الاسم بالامتداد فالداتابيز
    //  $file_name = $image->extension() => دي بيجبلي الامتداد بتاع الصوره بقا بس من غير الاسم

        $attachments = invoice_attachments::create([
            'file_name' => $file_name,  // $file_name => هي اسم الصوره بدون امتداد
            'invoice_number' => $request->invoice_number,
            'Created_by' => Auth::user()->name,
            'invoice_id' => $request->invoice_id,
        ]);
        $attachments->save();

        // move pic
        $imageName = $request->file_name->getClientOriginalName();  // يحفظلي الصوره الاسم بالامتداد فالفولدر بتاعي
        $request->file_name->move(public_path('Attachments/'. $request->invoice_number), $imageName);

        return redirect()->back()->with('success', 'تم انشاء المرفق بنجاج');

    }


    public function show(invoice_attachments $invoice_attachments)
    {

    }


    public function edit(invoice_attachments $invoice_attachments)
    {

    }


    public function update(Request $request, invoice_attachments $invoice_attachments)
    {

    }


    public function destroy(invoice_attachments $invoice_attachments)
    {

    }
}
