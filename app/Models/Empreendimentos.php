<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Empreendimentos extends Model
{
    protected $fillable = [
        'nome',
        'localizacao',
        'prev_entrega',
        'created_at',
        'updated_at',
    ];
    public static $rules = [
        "nome" => "required",
        "localizacao" => "required",
        "prev_entrega" => "required",
    ];
}
