<?php

namespace App\Http\Controllers;

use App\Invoices;
use App\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SectionController extends Controller
{
//    public function __construct()
//    {   // عشان احمي ان مش اي حد يقدر يخش علي الا م يسجل الاول
//        $this->middleware('auth');
//    }

    function __construct()
    {   // حمايه الكونترولر بتاعي بالصلاحيات اللي انا مديهالو
        $this->middleware('auth');
        $this->middleware('permission:الاقسام', ['only' => ['index']]);
        $this->middleware('permission:اضافة قسم', ['only' => ['create','store']]);
        $this->middleware('permission:تعديل قسم', ['only' => ['edit','update']]);
        $this->middleware('permission:حذف قسم', ['only' => ['destroy']]);
    }

    public function index()
    {
        $sections = Section::all();

        return view('sections.sections', compact('sections'));
    }


    public function store(Request $request)
    {

        $this->validate($request, [
            'section_name' => ['required', 'string', 'max:255', 'unique:sections'],
//            'description' => 'required'
        ], [
            'section_name.required' => 'يرجي ادخال اسم القسم',
            'section_name.unique' => 'اسم القسم مسجل مسبقا',
//            'description.required' => 'يرجي ادخال البيان',
        ]);

        Section::create([
            'section_name' => $request->section_name,
            'description' => $request->description,
            'Created_by' => Auth::user()->name,
        ]);
        return redirect()->back()->with('success', 'تم انشاء القسم بنجاج');

    }


    public function update(Request $request)
    {
        $id = $request->id;
        $this->validate($request, [

            'section_name' => 'required|max:255|unique:sections,section_name,' . $id, // اسم السكشن اللي ف جدول السكشن بال id دا هو unique
            // .$id عشان مثلا لة هعدل ال description وهسيب ال اسم زي م هو يعدل عاي وميقوليش ان الاسم دا متسجل قبل كدا
//            'description' => 'required',
        ], [

            'section_name.required' => 'يرجي ادخال اسم القسم',
            'section_name.unique' => 'اسم القسم مسجل مسبقا',
//            'description.required' => 'يرجي ادخال البيان',

        ]);

        $sections = Section::find($id);
        $sections->update([
            'section_name' => $request->section_name,
            'description' => $request->description,
        ]);

        return redirect()->back()->with('success', 'تم تعديل القسم بنجاج');

    }


    public function destroy(Request $request)
    {
        $id = $request->id;  // شوفلي ال id اللي جايلك من ال request المخفي دا
        Section::find($id)->delete();   // دورلي علي ال id دا فالجدول بتاعك واحذفه
        return redirect()->back()->with('success', 'تم حذف القسم بنجاج');
    }
}
