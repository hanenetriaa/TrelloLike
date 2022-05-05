<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inviation extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    // on recupere tous les administrateurs 
    public function admins()
    {
        return $this->hasMany(User::class, 'id', 'admin_id');
    }

    // on recupere tous les projets
    public function projets()
    {
        return $this->hasMany(Projet::class, 'id', 'titre_id');
    }

    public function userInvit()
    {
        return $this->hasmany(User::class, 'id', 'guest_id');
    }
}
