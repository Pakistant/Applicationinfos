<?php

namespace App\Http\Controllers;
use App\Models\Settings;
use App\Http\Requests\SettingsRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function index()
    {
        return view('Admin.settings.index',

        ['settings'=>Settings::where('id',1)->first()]);
    }

    public function update(SettingsRequest $request){


        $request->validated($request->all());

        

    $logo=$request->logo;

    $settings=Settings::where('id',1)->first();
    
    if($logo!=null && !$logo->getError()){

        if($settings->logo){
         Storage::disk('public')->delete($settings->image);
        }
        $logo=$request->image->store('asset','public');
    }

    if(!$settings){
    
    
      $settings=settings::create([

        'web_site_name' => $request->web_site_name,
        'logo' => $logo,
        'address' => $request->address,
        'phone' => $request->phone,
        'email' => $request->email,
        'about' => $request->about,
    
    ]);
    }
    
   
     
     return back()->with('success', 'Parametre modifier avec sur success  ');
      
    
    }
}
