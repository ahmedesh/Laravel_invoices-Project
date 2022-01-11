<?php

namespace App\Exports;

use App\Invoices;
use Maatwebsite\Excel\Concerns\FromCollection;

class InvoicesExport implements FromCollection
{

    public function collection()
    {
//        return Invoices::all();  // لكس اجيب كل اللي فالداتابيز للملف عندي

        // عشان اجيب اللي انا عاوزه فقط مش كله
 return invoices::select('invoice_number', 'invoice_Date', 'Due_date','Section', 'product', 'Amount_collection',
                        'Amount_Commission', 'Rate_VAT', 'Value_VAT','Total', 'Status', 'Payment_Date','note')->get();

    }
}
