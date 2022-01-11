<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class invoices_details extends Model
{

//    protected $fillable = [
//        'id_Invoice',
//        'invoice_number',
//        'product',
//        'Section',
//        'Status',
//        'Value_Status',
//        'note',
//        'user',
//        'Payment_Date',
//    ];

    protected $guarded = [];   // بدل م اعمل $fillable واقعد ادحل الداتا زي فوق كدا

    protected $dates = ['deleted_at'];   // SoftDelete

//    one to many
    public function invoices(){
        return $this->belongsTo('App\Invoices' , 'id_Invoice');
        //  ال Section هو اب لل Invoices
    }

    //    one to many
    public function sction(){
        return $this->belongsTo('App\Section' , 'section_id');
        //  ال Section هو اب لل Invoices
    }
}
