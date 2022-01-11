<?php

namespace App\Http\Controllers;

use App\invoice_attachments;
use App\Invoices;
use App\invoices_details;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class InvoicesDetailsController extends Controller
{

//    public function __construct()
//    {   // عشان احمي ان مش اي حد يقدر يخش علي الا م يسجل الاول
//        $this->middleware('auth');
//    }
    function __construct()
    {   // حمايه الكونترولر بتاعي بالصلاحيات اللي انا مديهالو
        $this->middleware('auth');
        $this->middleware('permission:قائمة الفواتير', ['only' => ['index']]);
    }

    // لعرض الفواتير
    public function index($id)
    {
        $inovices = Invoices::where('id' , $id)->first();  // ال id اللي جوا الجدول = ال id اللي جايلي فالصفحه
        $invoices_details = invoices_details::where('id_Invoice' , $id)->get();
        $invoice_attachments = invoice_attachments::where('invoice_id' , $id)->get();

        // هاتلي كل الاشعارات الغير مقروءه
//        $userUnreadNotification = auth()->user()->unreadNotifications;   // unreadNotifications => دي فانكشن جاهزه ف لارفيل
//        if ($userUnreadNotification) {    // لو في اشعارات غير مقروءه
//            $userUnreadNotification->markAsRead();
//        }
        return view('invoices/invoicesDetails' , compact('inovices' , 'invoices_details' , 'invoice_attachments'));// invoices/invoicesDetails => دا هو فولدر ال invoices اللي فال view

    }



// Open file
    public function open_file($invoice_number,$file_name)

    {
        $files = Storage::disk('public_uploads')->getDriver()->getAdapter()->applyPathPrefix($invoice_number.'/'.$file_name);
//        Storage::disk('public_uploads')  => Attachments لاني مديله المسار دا فال filessystems كدا هيخش علطول علي فولدر ال
        return response()->file($files);
    }

// Download file
    public function get_file($invoice_number,$file_name)

    {
        $contents= Storage::disk('public_uploads')->getDriver()->getAdapter()->applyPathPrefix($invoice_number.'/'.$file_name);
        return response()->download( $contents);
    }

// Destroy file
    public function destroy(Request $request)
    {
       invoice_attachments::findOrFail($request->id_file)->delete();  // يحذفلي المرفق من الداتابيز
        Storage::disk('public_uploads')->delete($request->invoice_number.'/'.$request->file_name); // يحذفلي المرفق من الفولدر عندي فالمشروع

        return redirect()->back()->with('success', 'تم حذف المرفق بنجاج');
    }
}
