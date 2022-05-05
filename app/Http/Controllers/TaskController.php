<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;


class TaskController extends Controller
{
    /** 
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    }

    /** 
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /** 
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
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
            ->route("lists.index")
            ->with('message', 'Votre tache a bien été crée'); // affichage d'un message flash sur le front 
    }

    /** 
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    { {
        }
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
    public function update(Request $request, $id)
    {
        //
    }

    /** 
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $task = Task::findOrFail($id);
        $task->delete();


        return redirect()
            ->route('lists.index');
    }

    /** 
     * Move task from current list to another list.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function move(Request $request)
    {
        $request->validate([
            "id" => ["required", "integer"],
            "list_id" => ["required", "integer"]
        ]);

        $id = $request->input("id");
        $list_id = $request->input("list_id");

        $task = Task::findOrFail($id);
        $task->list_id = $list_id;
        $task->save();

        return response('', 200);
    }
}
