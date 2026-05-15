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

        $data = $request->validated();
        contact::create($data);

        return back()->with('success','Message envoyé avec succès, nous vous recontacterons bientôt');
    
    
    }
}
