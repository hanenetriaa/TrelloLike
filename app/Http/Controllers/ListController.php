<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Projet;
use App\Models\Inviation;
use App\Models\ListTrello;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ListController extends Controller
{
    /** 
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $name = User::select('name')
            ->where('id', Auth::User()->id)
            ->get();
        return view('trello.nono', compact('name'));
    }

    /** 
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("lists.index");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        // Validation du formulaire
        $request->validate([
            "category" => 'required|string',
        ]);

        $id = $request->input('idProjets');
        // Création d'une nouvelle liste 
        $list = [
            "category" => $request->input("category"),
            "titre_id" => $id
        ];
        // Envoi de la liste dans la bdd grâce a notre model

        ListTrello::create($list);
        return redirect()
            ->route('lists.show', [$id])
            ->with('message', 'Votre liste a bien été créé'); // affichage d'un message flash sur le front 

    }

    /** 
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $id_user = Auth::User()->id;
        $verif = Projet::select('id')
            ->where('user_id', $id_user)
            ->where('id', $id)
            ->get();

        $verifInvit = Inviation::select('titre_id', 'status')
            ->where('guest_id', $id_user)
            ->where('titre_id', $id)
            ->get();

        $titreProjet = Projet::select('titre')
            ->where('id', $id)
            ->get();



        if ($verif[0]->id ?? null == $id) {
            $lists = ListTrello::select('category', 'id')
                ->where('titre_id', $id)
                ->get();
            return view("trello.index", compact('lists', 'id', 'titreProjet'));
        } else if (($verifInvit[0]->titre_id ?? null == $id) && ($verifInvit[0]->status == "true")) {
            $lists = ListTrello::select('category', 'id')
                ->where('titre_id', $id)
                ->get();
            return view("trello.index", compact('lists', 'id', 'titreProjet'));
        } else {
            $name = User::select('name')
                ->where('id', Auth::User()->id)
                ->get();

            return view('trello.nono', compact('name'));
        }
    }

    /** 
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
    }

    /** 
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $list =  ListTrello::findOrFail($id);
        $list->category = $request->input('category');
        $list->save();

        return redirect()
            ->route('lists.index');
    }

    /** 
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy()
    {
        // Voir le controller ListEditController la function destroy
    }
}
