<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class invoice_attachments extends Model
{
    protected $guarded = [];   // بدل م اعمل $fillable واقعد ادحل الداتا زي فوق كدا

    protected $dates = ['deleted_at'];   // SoftDelete
}
