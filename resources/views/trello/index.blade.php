@extends('layouts.app')

@section('content')
   
    <!--Section: Contact v.2-->
    <section class="mb-4">
    <!--Section heading-->
    <h2 class="h1-responsive font-weight-bold text-center my-4">LISTS</h2>
    <h2 class="h1-responsive font-weight-bold text-center my-4">{{$titreProjet[0]->titre??null}}</h2>
    <!--Section description-->
    <p class="text-center w-responsive mx-auto mb-5">Add title list</p>

<div class="row">
        <!--Grid column-->
        <div class="text-center w-responsive mx-auto mb-5">

            <form  action="{{route('lists.store')}}" method="POST">
                @csrf
            <!--Grid row-->
            <div class="row">
            <div class="col-md-12">
                <input type="hidden" name="idProjets" value="{{$id}}"/>
                <input type="text" id="category" name="category" class="form-control">
                <br>
            </div>
            </div>
            <!--Grid row-->
            <div class="text-center w-responsive mx-auto mb-5">
                <button type="submit" class="btn btn-warning" >create a list</button>
            </div>      
            </form>  
        </div>
        @if(session()->has('message'))
        
        <div class="alert alert-success">
            {{ session()->get('message') }}
        </div>


    @endif
    @if(session()->has('messageDestroy'))
        
    <div class="alert alert-success">
        {{ session()->get('messageDestroy') }}
    </div>


@endif
        <div class="container-list"> 

            @foreach($lists as $list)
    
           
           
                <div class="card" style="width: 18rem;">
                    <img src="/images/img-list-task.png" class="card-img-top" alt="...">
                   
                    <div class="card-body mr-2">
                        <p class="card-text">LIST STATUT : {{$list->category}}</p>
                       
                        <form action="{{ route('taskes.store', $id) }}" method="POST">
                            @csrf
                        
                            <div class="task">
                                <input name="task" type="text" class="form-control" placeholder="add task" >
                                <input type="hidden" name="list_id" value="{{$list->id}}">
                                    <button type="submit" class="btn btn-outline-success">add</button>
                            </div> 

                        </form>
                        
                   
                          
            
                            @foreach ($list->trelloTasks()->get() as $task) 
                                <div class="item" draggable="true" data-id="{{$task->id}}">
                                    <div class="liste_tasks"> 
                                            <!-- Apparition de nos taches en fonction de leur liste -->
                                            <hr> 
                                
                                            {{$task->task }} 
                                        
                                    
                                            <form  action="{{ route('taskes.detruire',["id" =>$id , "idList"=>$list->id, "idTask"=>$task->id])}}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button class="div-btn-delet" > X </button> 
                                            </form> 
                                    
                                    </div>     
                                </div>   
                            @endforeach
                            <div class="column" data-list-id="{{$list->id}}"></div>
                          
                        <div class="div-btn-list">
                            <a href="{{ route('listes.edit',['id'=>$id ,'idList'=>$list->id]) }}" class="btn btn-success">Edit list </a>
                          
                            <form action="{{ route('listes.destroy',['id'=>$id,'idList'=>$list->id]) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger text-center ">delete</button>
                            </form>
                       
                        </div>

                    </div>
                
                </div>
                
         
            @endforeach
        </div>

        
     
</div>



    
@endsection