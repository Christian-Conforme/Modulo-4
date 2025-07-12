<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

/**
 * Modelo User
 *
 * @property int $id_usuario
 * @property int $empleado_id
 * @property string $username
 * @property string $password
 * @property int $rol_id
 *
 * @example {
 *   "id_usuario": 1,
 *   "empleado_id": 1,
 *   "username": "usuario123",
 *   "password": "********",
 *   "rol_id": 2
 * }
 */
class User extends Authenticatable
{
    use HasApiTokens, Notifiable, HasFactory;

    protected $table = 'users';
    protected $primaryKey = 'id_usuario';

    protected $fillable = [
        'empleado_id',
        'username',
        'password',
        'rol_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'password' => 'hashed',
    ];
}