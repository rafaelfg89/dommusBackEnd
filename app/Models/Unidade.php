<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Unidade extends Model
{
    protected $table = 'unidade';

    protected $fillable = [
        'id',
        'id_bloco',
        'valor',
        'id_status',
        'created_at',
        'updated_at',
    ];
    public static $rules = [
        "id_bloco" => "required",
        "valor" => "required",
        "id_status" => "required",
    ];
}
