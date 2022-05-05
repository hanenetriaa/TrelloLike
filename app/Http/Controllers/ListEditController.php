<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Projet;
use App\Models\Inviation;
use App\Models\ListTrello;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ListEditController extends Controller
{
    public function edit($id, $idList)
    {
        $accord = $this->securite($id, $idList);
        if ($accord == true) {
            $list =  ListTrello::findOrFail($idList);
            return view("trello.edit", compact("list", "id"));
        } else {
            $name = User::select('name')
                ->where('id', Auth::User()->id)
                ->get();

            return view('trello.nono', compact('name'));
        }
    }

    public function update(Request $request, $id, $idList)
    {
        $accord = $this->securite($id, $idList);
        if ($accord == true) {
            $list =  ListTrello::findOrFail($idList);
            $list->category = $request->input('category');
            $list->save();

            return redirect()
                ->route('lists.show', [$id]);
        } else {
            $name = User::select('name')
                ->where('id', Auth::User()->id)
                ->get();

            return view('trello.nono', compact('name'));
        }
    }

    public function destroy($id, $idList)
    {
        $accord = $this->securite($id, $idList);
        if ($accord == true) {
            $list = ListTrello::findOrFail($idList);
            $list->delete();

            return redirect()
                ->route('lists.show', [$id])
                ->with('messageDestroy', 'Votre liste a bien été détruite'); // affichage d'un message flash sur le front 
        } else {
            $name = User::select('name')
                ->where('id', Auth::User()->id)
                ->get();
            return view('trello.nono', compact('name'));
        }
    }

    function securite($id, $idList)
    {
        $accord = 0;
        $idUser = Auth::User()->id;
        $verif = ListTrello::select('titre_id', 'id', 'category')
            ->where('titre_id', $id)
            ->where('id', $idList)
            ->get();


        $invitVerif = Inviation::select('titre_id', 'guest_id', 'status')
            ->where('titre_id', $id)
            ->where('guest_id', $idUser)
            ->where('status', 'true')
            ->get();

        $adminVerif = Projet::select('id', 'user_id')
            ->where('id', $id)
            ->where('user_id', $idUser)
            ->get();
        if (($adminVerif[0]->id ?? null == $id) || ($invitVerif[0]->titre_id ?? null == $id)) {

            if ($verif[0]->id ?? null == $idList) {
                return $accord = true;
            } else {

                return $accord = false;
            }
        } else {
            return $accord = false;
        }
    }
}
