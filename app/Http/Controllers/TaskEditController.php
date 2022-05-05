<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskEditController extends Controller
{
    public function store(Request $request, $id)

    {
        $tasks = Task::all();

        // Validation du formulaire
        $request->validate([
            "task" => 'required|string',
            'list_id' => 'required|integer',
        ]);

        // Création d'une nouvelle tache grace à l'input
        $task = [
            "task" => $request->input("task"),
            "list_id" => $request->input("list_id"),
        ];
        // Envoi de la tache dans la bdd grâce a notre model
        Task::create($task);

        return redirect()
            ->route('lists.show', [$id])
            ->with('messageTache', 'Votre tache a bien été crée'); // affichage d'un message flash sur le front 
    }

    public function detruire($id, $idList, $idTask)
    {
        $task = Task::findOrFail($idTask);
        $task->delete();


        return redirect()
            ->route('lists.show', [$id]);
    }
}
