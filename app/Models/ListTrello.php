<?php

namespace App\Models;

use App\Models\Projet;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ListTrello extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function trelloTasks(): HasMany
    {
        return $this->hasMany(Task::class, "list_id", "id");
    }

    public function projetList(): HasMany
    {
        return $this->hasMany(Projet::class, "id", "titre_id");
    }
}
