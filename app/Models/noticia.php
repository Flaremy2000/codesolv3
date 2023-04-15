<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class noticia extends Model
{
    use HasFactory;
    protected $primaryKey = 'id_noticia';
    public $timestamps = false;
    public function scopeCategoria($query, $categoria)
    {
        if ($categoria) {
            return $query->where('categoria_id', $categoria);
        }
    }

    public function scopeEstado($query, $estado)
    {
        if ($estado) {
            return $query->where('estado', $estado);
        }
    }

}
