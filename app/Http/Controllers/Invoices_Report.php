<?php

namespace App\Http\Controllers;

use App\Invoices;
use Illuminate\Http\Request;

class Invoices_Report extends Controller
{

    function __construct()
    {   // حمايه الكونترولر بتاعي بالصلاحيات اللي انا مديهالو
        $this->middleware('auth');
        $this->middleware('permission:تقرير الفواتير', ['only' => ['index']]);
    }

    public function index(){
        return view('reports.invoices_report');
    }

    public function Search_invoices(Request $request){

        $rdio = $request->rdio;

        // ف حاله البحث بنوع الفاتوره
        if($rdio == 1) {
            //  لو دخلي نوع الفاتوره ومدخلش تاريخ البدايه او مدخلش تاريخ النهايه او مدخلش الاتنين
            if ($request->type && $request->start_at == '' && $request->end_at == '') {

                $invoices = invoices::select('*')->where('Status', $request->type)->get();
                $type = $request->type;
                return view('reports.invoices_report', compact('type'))->withDetails($invoices);
            } else {
                $start_at = date($request->start_at);  // لازم اعمل داله date عشان يفهم ان دا تاريخ ويظبطها فالداتابيز
                $end_at = date($request->end_at);      // لازم اعمل داله date عشان يفهم ان دا تاريخ ويظبطها فالداتابيز
                $type = $request->type;
                //  هاتلي الفواتير اللي من تاريخ كذا ل تاريخ كذا وشرط تكون بحاله الفاتوره اللي دخلتها انا
                $invoices = invoices::whereBetween('invoice_Date', [$start_at, $end_at])->where('Status', $request->type)->get();
                return view('reports.invoices_report', compact('type', 'start_at', 'end_at'))->withDetails($invoices);
            }

        }
            // ف حاله البحث برقم الفاتوره
        else{
            $invoices = invoices::all()->where('invoice_number', $request->invoice_number);
            return view('reports.invoices_report')->withDetails($invoices);
        }
    }
}
