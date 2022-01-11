<?php

namespace App\Http\Controllers;

use App\Product;
use App\Section;
use Illuminate\Http\Request;

class ProductController extends Controller
{

//    public function __construct()
//    {   // عشان احمي ان مش اي حد يقدر يخش علي الا م يسجل الاول
//        $this->middleware('auth');
//    }

    function __construct()
    {   // حمايه الكونترولر بتاعي بالصلاحيات اللي انا مديهالو
        $this->middleware('auth');
        $this->middleware('permission:المنتجات', ['only' => ['index']]);
        $this->middleware('permission:اضافة منتج', ['only' => ['create','store']]);
        $this->middleware('permission:تعديل منتج', ['only' => ['edit','update']]);
        $this->middleware('permission:حذف منتج', ['only' => ['destroy']]);
    }

    public function index()
    {
        $products = Product::all();
        $sections = Section::all();

        return view('products.products', compact('products' , 'sections'));
//        return view('products.products', ['products' => $products , 'sections'=>$sections]);
    }


    public function store(Request $request)
    {

        $this->validate($request, [
            'product_name' => ['required', 'string', 'max:255', 'unique:products'],
            'section_id' => 'required'
        ], [
            'product_name.required' => 'يرجي ادخال اسم المنتج',
            'product_name.unique' => 'اسم القسم مسجل مسبقا',
            'section_id.required' => 'يرجي ادخال البيان',
        ]);

        $product = Product::create([
            'product_name'=> $request->product_name,
            'section_id'  => $request->section_id,
            'notes'       => $request->notes,
        ]);

        return redirect()->back()->with('success', 'تم انشاء المنتج بنجاج');
    }


    public function update(Request $request)
    {
        $id = $request->id;
        $this->validate($request, [

            'product_name' => 'required|max:255|unique:products,product_name,' . $id, // اسم السكشن اللي ف جدول السكشن بال id دا هو unique
            // .$id عشان مثلا لة هعدل ال description وهسيب ال اسم زي م هو يعدل عاي وميقوليش ان الاسم دا متسجل قبل كدا
            'section_id' => 'required',
        ], [

            'product_name.required' => 'يرجي ادخال اسم المنتج',
            'section_name.unique' => 'اسم القسم مسجل مسبقا',
            'section_id.required' => 'يرجي ادخال البيان',

        ]);

        $products = Product::find($id);
        $products->update([
            'product_name' => $request->product_name,
            'section_id'   => $request->section_id,
            'notes'        => $request->notes,
        ]);

        return redirect()->back()->with('success', 'تم تعديل المنتج بنجاج');

    }


    public function destroy(Request $request)
    {
        $id = $request->id;  // شوفلي ال id اللي جايلك من ال request المخفي دا
        Product::find($id)->delete();   // دورلي علي ال id دا فالجدول بتاعك واحذفه
        return redirect()->back()->with('success', 'تم حذف المنتج بنجاج');
    }
}
