<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
class Blocos extends Model
{
    protected $table = 'blocos';

    protected $fillable = [
        'id',
        'id_empreendimentos',
        'created_at',
        'updated_at',
    ];
    public static $rules = [
        "id_empreendimentos" => "required",
    ];
}
