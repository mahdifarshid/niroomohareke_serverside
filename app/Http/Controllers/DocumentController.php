<?php

namespace App\Http\Controllers;

use App\Document;
use App\Documentcat;
use Illuminate\Http\Request;

class DocumentController extends Controller
{
    public function document_index(Request $request)
    {
        if (isset($request->cat_id)) {
            $id = $request->cat_id;
            if ($request->cat_id == 'all') {
                $documents = Document::from('documents')
                    ->paginate(10);
            } else {
                $documents = Document::from('documents')
                    ->where('cat_id', '=', $id)
                    ->paginate(10);
            }
        } else {
            $documents = Document::from('documents')
                ->paginate(10);
        }

        $cats = Documentcat::all();

        return view('document.document',
            [
                'categories' => $cats,
                'documents' => $documents
            ]
        );
    }

    private function doc_validate($request)
    {
        $customMessages = [
            'mimes' => 'تنها فرمت های doc docx  pdf پشتیبانی میشود'
        ];

        $this->validate($request, [
            'title' => 'required|min:2',
            'cat_id' => 'required',
            "pdf" => 'mimes:pdf,docx,doc,odt'
        ], $customMessages);
    }

    public function add_doc(Request $request)
    {
        $this->doc_validate($request);

        if ($request->pdf != null) {
            $fullName = $request->pdf->getClientOriginalName();
            $fullName = explode('.', $fullName)[0];
            $docname = $fullName . '__' . date('YmdHis') . '.' . $request->pdf->getClientOriginalExtension();

            $file = $request->file('pdf');
            if (!file_exists('docs')) {
                mkdir('docs');
            }
            $file->move('docs', $docname);
        }

        if (isset($request)) {
            $cat = new Document();
            $cat->title = $request->title;
            if (isset($docname)) {
                $cat->doc = $docname;
            }
            $cat->description = $request->description;
            $cat->cat_id = $request->cat_id;
            $cat->save();
        }
        return redirect()->back();
    }

    public function del_doc($id)
    {
        $doc = Document::findOrfail($id);
        if ($doc->doc != "") {
            if (file_exists('docs/' . $doc->doc)) {
                if(is_file('docs/' . $doc->doc)){
                    unlink('docs/' . $doc->doc);
                }
            }
        }
        $doc->delete();
        return redirect()->back();
    }

    public function del_docfile($id)
    {
        $doc = Document::findOrfail($id);
        if ($doc->doc != "") {
            if (file_exists('docs/' . $doc->doc)) {
                unlink('docs/' . $doc->doc);
            }
        }
        $doc->doc="";
        $doc->save();
        return redirect()->back();
    }

    public function edit_documet($id)
    {

        $document = Document::find($id);
        $cats = Documentcat::all();

        return view('document.editdocument',
            [
                'categories' => $cats,
                'document' => $document
            ]
        );
    }

    public function edit_doc(Request $request)
    {
        $this->doc_validate($request);

        if ($request->pdf != null) {
            $fullName = $request->pdf->getClientOriginalName();
            $fullName = explode('.', $fullName)[0];
            $docname = $fullName . '__' . date('YmdHis') . '.' . $request->pdf->getClientOriginalExtension();

            $file = $request->file('pdf');
            if (!file_exists('docs')) {
                mkdir('docs');
            }
            $file->move('docs', $docname);

            $doc = Document::find($request->id);
            if($doc->doc!=null){
                if(file_exists('docs/'.$doc->doc)){
                    unlink('docs/'.$doc->doc);
                }
            }
        }

        $doc = Document::find($request->id);
        $doc->title = $request->title;
        $doc->description = $request->description;
        if (isset($docname)) {
            $doc->doc = $docname;
        }
        $doc->cat_id = $request->cat_id;
        $doc->save();
        return redirect()->back();
    }

    ///////////////////////////

    public function cat_index()
    {
        $documents = Documentcat::from('documentcats')->withCount('documents')->paginate(10);
        return view('document.category',
            [
                'category' => $documents,
            ]
        );
    }

    public function add_cat(Request $request)
    {
        $this->validate($request, [
            'cat_name' => 'required|min:2'
        ]);
        if (isset($request)) {
            $cat = new Documentcat();
            $cat->title = $request->cat_name;
            $cat->save();
        }
        return redirect()->back();
    }

    public function del_cat($id)
    {
        $cat = Documentcat::findOrfail($id);
        $docs=Document::where('cat_id','=',$cat->id)->get();
        foreach ($docs as $doc){
            if(file_exists('docs/'.$doc->doc)){
                if(is_file('docs/'.$doc->doc)){
                    unlink('docs/'.$doc->doc);
                }
            }
        }
        $docs=Document::where('cat_id','=',$cat->id);
        $docs->delete();
        $cat->delete();
        return redirect()->back();
    }

    ///////////////////
    ///
    public function edit_category($cat_id)
    {
        $category = Documentcat::find($cat_id);
        return view('document.editcategory', compact('category'));
    }

    public function edit_cat(Request $request)
    {
        $category = Documentcat::find($request->id);
        $category->title = $request->cat_name;
        $category->save();
        return redirect()->to('/document/category');
    }


    //////////////////////////////////
    /// api
    /// //////////////////

    public function getdoc_cats()
    {
        return Documentcat::from('documentcats')->withCount('documents')->get();
    }

    public function get_docs(Request $request)
    {
        $documets= Document::where('cat_id','=',$request->cat_id)->get();

        foreach ($documets as $index=>$value){
            if(!empty($value->doc)){
                $documets[$index]['doc']=url('docs/'.$value->doc);
                $path_info = pathinfo($value->doc);
                $documets[$index]['extention']=   $path_info['extension'];
            }
            else{
                $documets[$index]['extention']=   "";
            }
        }
        return $documets;
    }

}
