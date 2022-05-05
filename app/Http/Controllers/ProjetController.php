<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Projet;
use App\Models\Inviation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $my_id;
    public function  __construct()
    {
        // $this->middleware('auth');
    }
    public function index()
    {
        $this->my_id = Auth::User()->id;
        $notification = Inviation::select('status')
            ->where('guest_id', $this->my_id)
            ->where('status', 'pending')
            ->get();

        $titres = Projet::select('titre', 'id')
            ->where('user_id', '=', $this->my_id)
            ->get();

        $titreId = Inviation::select('titre_id')
            ->where('guest_id', '=', $this->my_id)
            ->where('status', '=', 'true')
            ->get();

        $projetId =
            Projet::select('titre', 'id')

            // ->where('id', '=', 'post_id')
            ->get();

        return view('projets.index', compact('notification', 'titres', 'titreId', 'projetId'));
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
        $request->validate([
            "titre" => 'required|string|max:60'
        ]);
        $this->my_id = Auth::User()->id;
        $titre = $request->titre;


        Projet::create([
            "titre" => $titre,
            "user_id" => $this->my_id
        ]);

        return redirect()
            ->route('projets.index')
            ->with('message', 'Votre projet a bien été crée');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // fonction qui permet d'inviter
    public function invit(Request $request)
    {
        $request->validate([
            "email" => 'required|email|max:60'
        ]);

        $id = $request->id;
        $email = $request->email;

        $user_id = User::select('id')
            ->where('email', '=', $email)
            ->get();

        Inviation::create([
            "admin_id" => $this->my_id,
            "guest_id" => $user_id[0]->id,
            "titre_id" => $id,
        ]);

        return redirect()
            ->route('projets.index')
            ->with('invit', 'Votre invitation a été envoyée');
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

        $request->validate([
            "titre" => 'required|string'
        ]);

        $id = $request->input('id');
        $titre = Projet::findOrFail($id);
        $titre->titre = $request->input('titre');
        $titre->save();

        return redirect()->route('projets.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $id = $request->input('id');
        $post = Projet::findOrFail($id);
        $post->delete();
        return redirect()->route('projets.index');
    }
}
