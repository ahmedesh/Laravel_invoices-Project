<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;



Route::get('/', function () {
    return view('auth.login');
})->middleware('auth');

//Auth::routes(['register'=>false]);          =>    لو عاوز الغي ان حد يعمل register وانا اللي هسجله عالسيستم انا بنفسي وخلاص
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::resource('invoices' , 'InvoicesController');

Route::resource('sections' , 'SectionController');
Route::resource('products' , 'ProductController');

Route::get('section/{id}' , 'InvoicesController@getproducts');

Route::get('invoicesDetails/{id}' , 'InvoicesDetailsController@index');
 // Start (عرض - تحميل - حذف)
Route::get('download/{invoice_number}/{file_name}', 'InvoicesDetailsController@get_file');

Route::get('View_file/{invoice_number}/{file_name}', 'InvoicesDetailsController@open_file');

Route::post('delete_file', 'InvoicesDetailsController@destroy')->name('delete_file');
// End (عرض - تحميل - حذف)

Route::resource('InvoiceAttachments' , 'InvoiceAttachmentsController');

Route::get('/edit_invoice/{id}', 'InvoicesController@edit');
Route::get('/Status_show/{id}', 'InvoicesController@show')->name('Status_show'); // عاوز اعرض خاله الفاتوره عشان احدث حاله الدفع
Route::post('/Status_Update/{id}', 'InvoicesController@Status_Update')->name('Status_Update'); // تحديث حاله الدفع

Route::get('Invoice_Paid','InvoicesController@Invoice_Paid');

Route::get('Invoice_UnPaid','InvoicesController@Invoice_UnPaid');

Route::get('Invoice_Partial','InvoicesController@Invoice_Partial');

Route::resource('Archive', 'InvoiceAchiveController');  // الفواتير المؤرشفه
Route::get('Print_invoice/{id}' , 'InvoicesController@Print_invoice'); // print

Route::get('export_invoices', 'InvoicesController@export'); // to export excel


// for permission
Route::group(['middleware' => ['auth']], function() {

    Route::resource('roles','RoleController');

    Route::resource('users','UserController');

});

// Reports for invoices
Route::get('invoices_report' , 'Invoices_Report@index');
Route::post('Search_invoices', 'Invoices_Report@Search_invoices');
// Reports for customers
Route::get('customers_report', 'Customers_Report@index')->name("customers_report");
Route::post('Search_customers', 'Customers_Report@Search_customers');


Route::get('MarkAsRead_all' , 'InvoicesController@MarkAsRead_all');


Route::get('/{page}', 'AdminController@index');


