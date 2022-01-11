<?php

namespace App\Http\Controllers;

use App\Invoices;
use Illuminate\Http\Request;

class InvoiceAchiveController extends Controller
{

//    public function __construct()
//    {   // عشان احمي ان مش اي حد يقدر يخش علي الا م يسجل الاول
//        $this->middleware('auth');
//    }
    function __construct()
    {   // حمايه الكونترولر بتاعي بالصلاحيات اللي انا مديهالو
        $this->middleware('auth');
        $this->middleware('permission:ارشيف الفواتير', ['only' => ['index']]);
        $this->middleware('permission:حذف الفاتورة', ['only' => ['destroy']]);
    }

    public function index()
    {
        $invoices = invoices::onlyTrashed()->get();
        return view('Invoices.Archive_Invoices',compact('invoices'));
    }

    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        //
    }


    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        //
    }


    public function update(Request $request)
    {
        $id = $request->invoice_id;
        invoices::withTrashed()->where('id', $id)->restore();  // استعاده الفاتوره من الارشيف
        return redirect()->route('invoices.index')->with('success', 'تم استعاده الفاتوره من الارشيف ');
    }


    public function destroy(Request $request)
    {
        $id = $request->invoice_id;
        invoices::withTrashed()->where('id', $id)->forceDelete();  // حذف الفاتورة المؤرشفه نهائيا
        return redirect()->route('Archive.index')->with('success', 'تم حذف الفاتورة المؤرشفه نهائيا ');
    }
}
