<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Usuario extends Authenticatable
{
    use Notifiable;

    protected $table = 'usuarios';
    protected $primaryKey = 'id_usuario';
    protected $fillable = ['name', 'email', 'password', 'id_rol'];
    protected $hidden = ['password', 'remember_token'];

    public function rol() {
        return $this->belongsTo(Rol::class, 'id_rol');
    }

    public function getAuthPassword() {
        return $this->password;
    }
}
