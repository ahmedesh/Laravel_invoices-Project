<?php

namespace App\Http\Controllers;

use App\Exports\InvoicesExport;
use App\invoice_attachments;
use App\Invoices;
use App\invoices_details;
use App\Notifications\Add_Invoice_Notification;
use App\Notifications\AddInvoice;
use App\Section;
use App\User;
use Illuminate\Http\Request;
//use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class InvoicesController extends Controller
{

//    public function __construct()
//    {   // عشان احمي ان مش اي حد يقدر يخش علي الا م يسجل الاول
//        $this->middleware('auth');
//    }
//    public function __construct()
//    {
//        $this->middleware(['role:super-admin','permission:publish articles|edit articles']);
//    }
    function __construct()
    {   // حمايه الكونترولر بتاعي بالصلاحيات اللي انا مديهالو
        $this->middleware('auth');
        $this->middleware('permission:قائمة الفواتير', ['only' => ['index']]);
        $this->middleware('permission:اضافة فاتورة', ['only' => ['create','store']]);
        $this->middleware('permission:تعديل الفاتورة', ['only' => ['edit','update']]);
        $this->middleware('permission:حذف الفاتورة', ['only' => ['destroy']]);
    }

    public function index()
    {
        $inovices = Invoices::all();
     return view('invoices\invoices' , compact('inovices'));
    }


    public function create()
    {
      $sections = Section::all();
      return view('invoices.add_invoice' , compact('sections'));
    }


    public function store(Request $request)
    {
//      Invoices::create($request->all());
        invoices::create([
            'invoice_number' => $request->invoice_number,
            'invoice_Date' => $request->invoice_Date,
            'Due_date' => $request->Due_date,
            'product' => $request->product,
            'section_id' => $request->Section,
            'Amount_collection' => $request->Amount_collection,
            'Amount_Commission' => $request->Amount_Commission,
            'Discount' => $request->Discount,
            'Rate_VAT' => $request->Rate_VAT,
            'Value_VAT' => $request->Value_VAT,
            'Total' => $request->Total,
            'Status' => 'غير مدفوعة',
            'Value_Status' => 2,
            'note' => $request->note,
        ]);
// هاتلي ال id بتاع الفاتوره دي
        $invoice_id = invoices::latest()->first()->id;  // قولتلو رتبهم بال last واول id اتكريت عندك فال  invoices كريتلي ليه هنا
        invoices_details::create([
            'id_Invoice' => $invoice_id,
            'invoice_number' => $request->invoice_number,
            'product' => $request->product,
            'Section' => $request->Section,
            'Status' => 'غير مدفوعة',
            'Value_Status' => 2,
            'note' => $request->note,
            'user' => (Auth::user()->name),  // دي اللي جديده
        ]);

        if ($request->hasFile('pic')) {

            $invoice_id = Invoices::latest()->first()->id;  // هاتلي ال id بتاع الفاتوره اللي فوق دي اللي لسا مكريتها
            $image = $request->pic;
            $file_name = $image->getClientOriginalName(); // getClientOriginalName  بيجبلي اسم الصوره بالامتداد بتاعها ويرجعهملي بقا
        //  $file_name = $image->extension() => دي بيجبلي الامتداد بتاع الصوره بقا بس من غير الاسم
            $invoice_number = $request->invoice_number;

            // الطريقه دي مش بحتاج اعمل لها $fillable بس كدا مش اكتر
//            $attachments = new invoice_attachments();   // الطريقه دي مش بحتاج اعمل لها $fillable بس كدا مش اكتر
//            $attachments->file_name = $file_name;  // $file_name => هي اسم الصوره بدون امتداد
//            $attachments->invoice_number = $invoice_number;
//            $attachments->Created_by = Auth::user()->name;
//            $attachments->invoice_id = $invoice_id;
//            $attachments->save();
            $attachments = invoice_attachments::create([
            'file_name' => $file_name,  // $file_name => هي اسم الصوره بدون امتداد
            'invoice_number' => $invoice_number,
            'Created_by' => Auth::user()->name,
            'invoice_id' => $invoice_id,
            ]);
            $attachments->save();

            // move pic
            $imageName = $request->pic->getClientOriginalName();
            $request->pic->move(public_path('Attachments/' . $invoice_number), $imageName);
            // هتكريتلي فولدر اسمه Attachments وجواه فولدر ب رقم الفانوره وجواه الصوره او الملف بتاعك دا بقا
        }
// to send email
//      $user = User::get();   // كدا هيبعتلي الاشعارات علي كل اليوزر اللي عندي وليس الادمن فقط
//        $user = User::first();     //  هيبعتلي الاشعار علي اول يوزر بس وهو الادمن بس لاجظ لو عندك اكتر من ادمن مش هيبعتلهم هيبعت لاول واحد بس
        $user = User::where('roles_name' , '["Admin"]')->get();   // كدا هيبعتلي للادمن فقط
        Notification::send($user, new AddInvoice($invoice_id));

// to notification to website when create invoices
//      $user = User::get();   // كدا هيبعتلي الاشعارات علي كل اليوزر اللي عندي وليس الادمن فقط
//        $user = User::find(Auth::user()->id);  // هيبعت الاشعار للشخص اللي اضاف الفاتوره فقط سواء هو مين ادمن ولا يوز ولا اسمه اي
//        $user = User::first();   // كدا هيبعتلي الاشعار علي اول يوزر بس وهو الادمن بس لاجظ لو عندك اكتر من ادمن مش هيبعتلهم هيبعت لاول واحد بس
        $user = User::where('roles_name' , '["Admin"]')->get();   // كدا هيبعتلي للادمن فقط
        $invoice_id = invoices::latest()->first()->id;
        Notification::send($user, new Add_Invoice_Notification($invoice_id));

        return redirect()->route('invoices.index')->with('success', 'تم انشاء الفاتورة بنجاج');
    }


    public function show($id)
    {
        $invoices = Invoices::where('id' , $id)->first();
//        $sections  = Section::all();
        return view('invoices.Status_Update', compact( 'invoices'));

    }

    public function edit($id)
    {
     $invoices = Invoices::where('id' , $id)->first();
     if($invoices){
         $sections  = Section::all();
         return view('invoices.edit_invoice', compact('sections', 'invoices'));
     }
     else{
         return redirect()->route('invoices.index');
     }
      }


    public function update(Request $request)
    {

        $invoices = invoices::find($request->invoice_id);    //عشان يحدث البيانات ف جدول ال invoices
            $invoices->invoice_number    = request('invoice_number');
            $invoices->invoice_Date      = request('invoice_Date');
            $invoices->Due_date          = request('Due_date');
            $invoices->product           = request('product');
            $invoices->section_id        = request('Section');
            $invoices->Amount_collection = request('Amount_collection');
            $invoices->Amount_Commission = request('Amount_Commission');
            $invoices->Discount          = request('Discount');
            $invoices->Rate_VAT          = request('Rate_VAT');
            $invoices->Value_VAT         = request('Value_VAT');
            $invoices->Total             = request('Total');
            $invoices->note              = request('note');
            $invoices->save();

        $invoices_details = invoices_details::where('id_Invoice' , $invoices->id)->first(); //عشان يحدث البيانات ف جدول ال invoices_details برضو
            $invoices_details->invoice_number    = request('invoice_number');
            $invoices_details->product           = request('product');
            $invoices_details->Section        = request('Section');
            $invoices_details->note              = request('note');
            $invoices_details->save();
//        ]);

        return redirect()->route('invoices.index')->with('success', 'تم نعديل الفاتورة ');
    }


// تعديل حاله الدفع
    public function Status_Update(Request $request , $id)
    {
        $invoices = invoices::findOrFail($id);
        if ($request->Status === 'مدفوعه') {

            $invoices->update([
                'Value_Status' => 1,
                'Status' => $request->Status,
                'Payment_Date' => $request->Payment_Date,
            ]);
            invoices_Details::create([
                'id_Invoice' => $request->invoice_id,
                'invoice_number' => $request->invoice_number,
                'product' => $request->product,
                'Section' => $request->Section,
                'Status' => 'مدفوعه',
                'Value_Status' => 1,
                'note' => $request->note,
                'Payment_Date' => $request->Payment_Date,
                'user' => (Auth::user()->name),
            ]);
        }
        else{
            $invoices->update([
                'Value_Status' => 3,
                'Status' => $request->Status,
                'Payment_Date' => $request->Payment_Date,
            ]);
            invoices_Details::create([
                'id_Invoice' => $request->invoice_id,
                'invoice_number' => $request->invoice_number,
                'product' => $request->product,
                'Section' => $request->Section,
                'Status' => 'مدفوعه جزئيا',
                'Value_Status' => 3,
                'note' => $request->note,
                'Payment_Date' => $request->Payment_Date,
                'user' => (Auth::user()->name),
            ]);
        }
        return redirect()->route('invoices.index')->with('success', 'تم تحديث حاله الدفع ');
    }

// forceDelete
    public function destroy(Request $request)
    {
        $id = $request->invoice_id;
        $Details = invoice_attachments::where('invoice_id', $id)->first();
        $id_page =$request->id_page;
        if (!$id_page==2) {

            if (!empty($Details->invoice_number)) {   // لو فيها قيمه وموجوده

                Storage::disk('public_uploads')->deleteDirectory($Details->invoice_number);
                // احذف الفولدر كامل بتاع الفاتوره دي باللي فيه مش المفات بس يعني
                // قولتلو احذف المرفقات الاول قبل ال فاتوره نفسها عشان يحذفها من الفولدر عندي
                // اما ل خليتها بعد الفاتوره كدا هتتحذف من الداتابيز بس ومش هتتحذف من الفولدر
            }

            invoices::where('id', $id)->first()->forceDelete();  // امسح الفاتوره بقا نهائيا
        }
        else{
            invoices::where('id', $id)->first()->delete();  // ارشف الفاتوره
            return redirect()->route('invoices.index')->with('success', 'تم ارشفه الفاتورة ');
        }
return redirect()->route('invoices.index')->with('success', 'تم حذف الفاتورة نهائيا ');
}

//Softdeleted
public function softDelete(Request $request){
    $id = $request->invoice_id;
    $Details = invoice_attachments::where('invoice_id', $id)->first();
    invoices::where('id', $id)->first()->delete();  // امسح الفاتوره بقا
    return redirect()->route('invoices.index')->with('success', 'تم ارشفه الفاتورة ');
}

    //    عشان لما اختر قسم معين يختارلي المنتج اللي تابع للقسم دا
    public function getproducts($id){
        $products = DB::table("products")->where("section_id", $id)->pluck("product_name", "id");
        // where("section_id", $id) => يعني لما الid اللي ف جدول ال products = ال id اللي ف جدول الصفحه اللي انت جاي منها دي
        // DB::table("products") => يعني هتروحلي علي جدول ال products
        // pluck()  => يعني هاتلي اللي جواه دا
        return json_encode($products);  // حولي الناتج ال json ورجعهولي
    }

//  الفواتير (المدفوعه والغير مدفوعه والمدفوعه جزئيا)
    public function Invoice_Paid()
    {
        $invoices = Invoices::where('Value_Status',1)->get();
        return view('invoices.invoices_paid',compact('invoices'));
    }

    public function Invoice_UnPaid()   // الفاتوره الفير المدفوعه
    {
        $invoices = Invoices::where('Value_Status',2)->get();
        return view('invoices.invoices_unpaid',compact('invoices'));
    }

    public function Invoice_Partial()   // الفاتوره المدفوعه جرئيا
    {
        $invoices = Invoices::where('Value_Status',3)->get();
        return view('invoices.invoices_Partial',compact('invoices'));
    }

    public  function Print_invoice($id){
       $invoices = Invoices::where('id' , $id)->first();
        return view('invoices.Print_invoice' , compact('invoices'));
    }

    public function export()   // to export data from database to excel file
    {
        return Excel::download(new InvoicesExport, 'invoices.xlsx');  // invoices.xlsx => دا الاسم اللي هيسمي بيه الملف لما ينزله
    }

    public function MarkAsRead_all()
    {
        // هاتلي كل الاشعارات الغير مقروءه
        $userUnreadNotification = auth()->user()->unreadNotifications;   // unreadNotifications => دي فانكشن جاهزه ف لارفيل

        if ($userUnreadNotification) {    // لو في اشعارات غير مقروءه
            $userUnreadNotification->markAsRead();
            return back();
        }
    }
}
