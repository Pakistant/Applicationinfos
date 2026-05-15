<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\Models\User;
Use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('Admin.Author.index', [ 'authors'=>User::where('role','author')->get()]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('Admin.Author.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $request)
    {
         
        $request->validated($request->all());
        User::create([
             'name'=>$request->name,
            'email'=>$request->email,
            'password'=>Hash::make('1234567890'),


        ]);
        return to_route('author.index')->with('success','Auteur ajouter avec succes');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
   // public function edit(User $user)
    //{
      //  return view('Admin.author.create',compact('user'));
   // }
     public function edit(User $author)
{
    return view('Admin.Author.create', ['user' => $author]);
}

    /**
     * Update the specified resource in storage.
     */
    public function update(UserRequest $request, User $author)
    {
        $request->validated($request->all());
        $author->update($request->All());

        
        return to_route('author.index')->with('success','Auteur modifier avec succes');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $author)
    {
        $author->delete();
        return back()->with('success', 'Auteur supprimer avec succes ');
    }
}
