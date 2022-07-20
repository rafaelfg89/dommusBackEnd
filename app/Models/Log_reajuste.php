<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Log_reajuste extends Model
{
    protected $table = 'log_reajuste';

    protected $fillable = [
        'id',
        'id_unidade',
        'valor_reajuste',
        'valor_antigo',
        'percentual',
        'created_at',
        'updated_at',
    ];
    public static $rules = [
        "id_unidade" => "required",
        "valor_reajuste" => "required",
        "valor_antigo" => "required",
        "percentual" => "required",
    ];
}
