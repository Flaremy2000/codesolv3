<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class cargo extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $table = "cargos";

    protected $primaryKey = "id_cargo";
    
}
