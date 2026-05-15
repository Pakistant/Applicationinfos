<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorecontactRequest;
use App\Models\contact;
use Illuminate\Http\Request;

class FrontcontactController extends Controller
{
    public function index(){
        return view('Front.contact');
    
    }

    public function contact(StorecontactRequest $request){

        $request->validated($request->all());

        contact::create($request->all());


        return back()->with('success','Message envoyer avec success nous vous recontacterons bientot');
    
    
    }
}
