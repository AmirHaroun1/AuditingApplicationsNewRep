<?php

namespace App\Http\Controllers;

use App\document;
use Illuminate\Http\Request;

class AdminDocumentsController extends Controller
{
    //
    public function index(){
        $documents = document::all();

        return response()->json(['documents'=> $documents],200);
    }
    public function update(Request $request,document $document){
        $document->update($request->all());

        return response()->json(['document'=> $document],200);
    }
    public function store(Request $request){
        $document = document::create($request->all());

        return response()->json(['document'=> $document],200);
    }
    public function destroy(document $document){
        $document->delete();
        return response()->json(['document'=>$document],200);
    }

}
