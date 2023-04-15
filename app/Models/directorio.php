<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class directorio extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $primaryKey = "id_directorio";

    public function comision()
    {
        return $this->belongsTo(comision::class, "comision_directorio");
    }

    public function cargo()
    {
        return $this->belongsTo(cargo::class, "cargo_directorio");
    }

    public function periodo()
    {
        return $this->belongsTo(periodo::class, "periodo_directorio");
    }

    public function cargos()
    {
        return $this->belongsTo(cargo::class, "cargo_directorio");
    }

    public function Comisions()
    {
        return $this->belongsTo(comision::class, "comision_directorio");
    }

    public function scopePeriodo($query, $periodo)
    {
        if ($periodo) {
            return $query->where("periodo_directorio", "=", $periodo);
        }
    }

    public function scopeEstado($query)
    {
        return $query->where("estado_directorio", 1);
    }

}