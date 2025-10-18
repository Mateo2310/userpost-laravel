<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    /**
     * Los atributos que se pueden asignar masivamente.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'description',
        'imageUrl',
        'user_id',
    ];

    /**
     * Relación: Un post pertenece a un usuario
     * (muchos posts pueden pertenecer a un usuario)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}