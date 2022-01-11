<?php

namespace App\Http\Controllers;

use App\Invoices;
use App\Notifications\Add_Invoice_Notification;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notification;


class HomeController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index()
    {

       //  Bar Chart:

        //=================احصائية نسبة تنفيذ الحالات======================

        $count_all = Invoices::count();
        $count_invoices_paid    = Invoices::where('Value_Status', 1)->count();
        $count_invoices_unpaid  = Invoices::where('Value_Status', 2)->count();
        $count_invoices_partial = Invoices::where('Value_Status', 3)->count();
//        $count_all =Invoices::sum('Total');
//        $count_invoices_paid = Invoices::where('Value_Status', 1)->sum('Total');
//        $count_invoices_unpaid = Invoices::where('Value_Status', 2)->sum('Total');
//        $count_invoices_partial = Invoices::where('Value_Status', 3)->sum('Total');
        if($count_invoices_unpaid == 0){
            $Unpaid_invoices=0;
        }
        else{
            $Unpaid_invoices = number_format($count_invoices_unpaid/ $count_all*100 , 1);
        }

        if($count_invoices_paid == 0){
            $Paid_invoices=0;
        }
        else{
            $Paid_invoices = number_format($count_invoices_paid/ $count_all*100 , 1);
        }

        if($count_invoices_partial == 0){
            $Partial_invoices=0;
        }
        else{
            $Partial_invoices = number_format($count_invoices_partial/ $count_all*100 , 1);
        }


        $chartjs = app()->chartjs
            ->name('barChartTest')
            ->type('bar')
            ->size(['width'=>350 , 'height'=>170])
            ->labels(['الفواتير الغير المدفوعة', 'الفواتير المدفوعة','الفواتير المدفوعة جزئيا'])
            ->datasets([
                [
                    "label" => "الفواتير المدفوعة جزئيا",
                    'backgroundColor' => ['#ff9642'],
                    'data' => [$Partial_invoices],
                ],
                [
                    "label" => "الفواتير المدفوعة",
                    'backgroundColor' => ['#81b214'],
                    'data' => [$Paid_invoices],
                ],
                [
                    "label" => "الفواتير الغير المدفوعة",
                    'backgroundColor' => ['#ec5858'],
                    'data' => [$Unpaid_invoices],
                ],

            ])
            ->options([]);




//=================احصائية نسبة تنفيذ الحالات======================
// Pie Chart / Doughnut Chart

        $Total =Invoices::sum('Total');
        $Totalinvoices_paid = Invoices::where('Value_Status', 1)->sum('Total');
        $Totalinvoices_unpaid = Invoices::where('Value_Status', 2)->sum('Total');
        $Totalinvoices_partial = Invoices::where('Value_Status', 3)->sum('Total');

        if($Totalinvoices_unpaid == 0){
            $Unpaid_invoices=0;
        }
        else{
            $Unpaid_invoices = number_format($Totalinvoices_unpaid/ $Total*100 , 1);
        }

        if($Totalinvoices_paid == 0){
            $Paidinvoices=0;
        }
        else{
            $Paidinvoices = number_format($Totalinvoices_paid/ $Total*100 , 1);
        }

        if($Totalinvoices_partial == 0){
            $Partialinvoices=0;
        }
        else{
            $Partialinvoices = number_format($Totalinvoices_partial/ $Total*100 , 1);
        }

        $chartjs_2 = app()->chartjs
            ->name('pieChartTest')
//            ->type('pie')
            -> type ('doughnut')
            ->size(['width'=>400 , 'height'=>200])
            ->labels(['الفواتير الغير المدفوعة', 'الفواتير المدفوعة','الفواتير المدفوعة جزئيا'])
            ->datasets([
                [
//                    'hoverBackgroundColor' => ['#ec5858', '#81b214','#ff9642'],
                    'backgroundColor' => ['#ec5858', '#81b214','#ff9642'],
                    'data' => [$Unpaid_invoices , $Paidinvoices , $Partialinvoices]
                ]
            ])
            ->options([]);

        return view('home' , compact('chartjs' , 'chartjs_2'));
    }

}
