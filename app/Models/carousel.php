<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class carousel extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $primaryKey = "carousel_id";

    public function scopePage($query, $page)
    {
        return $query->where("carousel_page", $page);
    }

    public function scopeActive($query)
    {
        return $query->where("estado", 1);
    }


}