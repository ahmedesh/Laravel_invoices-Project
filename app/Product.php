<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
//    protected $fillable = [
//        'product_name',
//        'section_id',
//        'notes',
//    ];

    protected $guarded = [];   // بدل م اعمل $fillable واقعد ادحل الداتا زي فوق كدا

//    one to many
    public function section(){
        return $this->belongsTo('App\Section' , 'section_id');  // $this عائده علي ال Product
//  ال Section هو اب للProduct   Section=>Product
    }
}
