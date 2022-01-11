<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoicesTable extends Migration
{

    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('invoice_number', 50);   // رقم الفاتورة
            $table->date('invoice_Date')->nullable();     //  تاريخ الفاتورة
            $table->date('Due_date')->nullable();         //  تاريخ الاستحقاق
            $table->string('product', 50);          //  المنتج
//            $table->string('Section', 50);          //  المنتج
            $table->bigInteger( 'section_id' )->unsigned();   //
            $table->foreign('section_id')->references('id')->on('sections')
                ->onDelete('cascade')->onUpdate('cascade');
            $table->decimal('Amount_collection',8,2)->nullable();  // مبلغ التحصيل
            $table->decimal('Amount_Commission',8,2);       // مبلغ العمولة
            $table->decimal('Discount',8,2);            //  الخصم
            $table->decimal('Value_VAT',8,2);             // قيمة الضريبة
            $table->string('Rate_VAT', 999);                 // نسبة الضريبة
            $table->decimal('Total',8,2);              // الاجمالي
            $table->string('Status', 50);          // حالة الفاتوره مثلا مدفوعه ولا مش مدفوعه وهكذا
            $table->integer('Value_Status');     // مثلا حاله الفاتوره لو مدفوعه ب 1 ولو مش مدفوعه ب 0 مثلا
            $table->text('note')->nullable();                    // ملاحظات
            $table->date('Payment_Date')->nullable();           // تاريخ الدفع
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('invoices');
    }
}
