<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    protected $fillable = [
        'section_name',
        'description',
        'Created_by',
    ];

    //    one to many
    public function product(){
        return  $this->hasMany('App\Product');  // $this عائده علي ال Section
    }

    //    one to many
    public function invoices(){
        return  $this->hasMany('App\Invoices');  // $this عائده علي ال Invoices
    }
}
