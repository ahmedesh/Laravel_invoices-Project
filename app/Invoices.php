<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invoices extends Model
{
//   protected $fillable = [
//             'id',
//            'invoice_number',   // رقم الفاتورة
//            'invoice_Date',    //  تاريخ الفاتورة
//            'Due_date',        //  تاريخ الاستحقاق
//            'product',          //  المنتج
//            'section_id',
//            'Amount_collection',  // مبلغ التحصيل
//            'Amount_Commission',      // مبلغ العمولة
//            'Discount',            //  الخصم
//            'Value_VAT',             // قيمة الضريبة
//            'Rate_VAT',                 // نسبة الضريبة
//            'Total',            // الاجمالي
//            'Status',          // حالة الفاتوره مثلا مدفوعه ولا مش مدفوعه وهكذا
//            'Value_Status',     // مثلا حاله الفاتوره لو مدفوعه ب 1 ولو مش مدفوعه ب 0 مثلا
//            'note',                    // ملاحظات
//            'Payment_Date',           // تاريخ الدفع
//          ];
    protected $guarded = [];   // بدل م اعمل $fillable واقعد ادحل الداتا زي فوق كدا

    use SoftDeletes;
    protected $dates = ['deleted_at'];   // SoftDelete

//    one to many
    public function sction(){
        return $this->belongsTo('App\Section' , 'section_id');
        //  ال Section هو اب لل Invoices
    }
}
