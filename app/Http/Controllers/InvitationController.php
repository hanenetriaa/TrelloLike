<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Projet;
use App\Models\Inviation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InvitationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $id_user = Auth::User()->id;

        $invit = Inviation::select('admin_id', 'titre_id', 'id')
            ->with('admins') // on recupere la relation (donc tous les administrateurs) 
            ->with('projets') // on recupere la relation (donc tous les projets) 
            ->where('guest_id', $id_user)
            ->where('status', 'pending')
            ->get();
        $accuse = Inviation::select('status', 'guest_id', 'titre_id')
            ->with('userInvit')
            ->with('projets')
            ->where('admin_id', $id_user)
            ->where('status', '!=', 'pending')
            ->get();
        return view('projets.invitation', compact('invit', 'accuse'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $id = $request->id;
        $email = $request->email;

        // $admin_id = Auth::User()->id;
        $admin_id = Projet::findOrFail($id);

        // dd($admin_id);
        $user_id = User::select('id')
            ->where('email', '=', $email)
            ->get();

        Inviation::create([
            "admin_id" => $admin_id->user_id,
            "guest_id" => $user_id[0]->id,
            "titre_id" => $id,
        ]);
        // return response("hello", 205);
        return redirect()
            ->route('projets.index')
            ->with('invit', 'Votre invitation a étais envoyé');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $id = $request->id;
        $post = Inviation::findOrFail($id);

        $post->status = $request->button;

        $post->save();
        return redirect()->route('projets.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
