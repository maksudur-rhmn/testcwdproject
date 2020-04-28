<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Faq;
use Carbon\Carbon;

class FaqController extends Controller
    {
      public function __construct()
      {
        $this->middleware('auth');
        $this->middleware('verified');
      }

      function faq_index()
      {
        // $faqs = Faq::orderBy('id', 'desc')->get();
        $faqs = Faq::latest()->paginate(5);
        $trashFaqs = Faq::onlyTrashed()->get();
        return view('faqs.index', compact('faqs','trashFaqs'));
      }

      function faq_insert(Request $request)
      {
        $request->validate([
          'faq_question'     => 'required',
          'faq_answer'     =>  'required',
        ]);

         if(is_numeric($request->faq_question))
         {
           return back()->withErrors('Question cannot contain any numbers');
         }
         else
         {
           Faq::insert([
             'faq_question'  =>$request->faq_question,
             'faq_answer'    =>$request->faq_answer,
             'created_at'    =>Carbon::now()
           ]);
           return back()->withSuccess('Faq Added Successfully');
         }
      }

          function faq_edit($faq_id)
          {
            $faq = Faq::findOrFail($faq_id);
            return view('faqs.edit', compact('faq'));
          }

          function faq_update(Request $request)
          {
            Faq::findOrFail($request->id)->update([
              'faq_question'    =>$request->faq_question,
              'faq_answer'      =>$request->faq_answer
            ]);
            return back()->withSuccess('Faq Edited');
          }

          function faq_trash($faq_id)
          {
            Faq::findOrFail($faq_id)->delete();
             return back()->withSuccess('Faq Deleted Successfully');
          }

          function faq_restore($faq_id)
          {
            Faq::withTrashed()->where('id', $faq_id)->restore();
            return back();
          }

          function faq_delete($faq_id)
          {
            Faq::withTrashed()->where('id', $faq_id)->forceDelete();
            return back();
          }




  // END
}
