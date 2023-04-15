<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class categoria extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_categoria';

    protected $fillable = [
        'nombre_categoria',
        'privacidad_categoria',
        'pagina_categoria',
        'estado_categoria',
    ];

    public $timestamps = false;

    public function scopePrivacidad($query, $privacidad)
    {
        if ($privacidad) {
            return $query->where('privacidad_categoria', '=', $privacidad);
        }
    }

    public function scopeEstado($query, $estado)
    {
        if ($estado) {
            return $query->where('estado_categoria', $estado);
        }
    }

    public function scopePagina($query, $pagina)
    {
        if ($pagina) {
            return $query->where('pagina_categoria', $pagina);
        }
    }


    public function scopeAll($query)
    {
        return $query->get();
    }

    public function scopeFirst($query)
    {
        return $query->first();
    }

    // Order by name ASC by default (if no order is specified) and return the first result (if any) as a JSON object to the client side application (Vue.js)
    public function scopeFirstByName($query, $order = 'ASC')
    {
        return $query->orderBy('nombre_categoria', $order)->first();
    }

    // Order by name ASC by default (if no order is specified) and return all results as a JSON object to the client side application (Vue.js)
    public function scopeAllByName($query, $order = 'ASC')
    {
        return $query->orderBy('nombre_categoria', $order)->get();
    }

}
