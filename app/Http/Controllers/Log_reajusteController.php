<?php namespace App\Http\Controllers;
use App\Models\Empreendimentos;
use App\Models\Log_reajuste;
use Illuminate\Http\Request;

class Log_reajusteController extends Controller {

    public function index() {
        try{
            $log_reaj = Log_reajuste::all();
            return \response($log_reaj);
        }catch (\Exception $ex){
            return \response($ex);
        }
    }

    public function show($id) {
        try{
            $log_reaj = Log_reajuste::find($id);
            return \response($log_reaj);
        }catch (\Exception $ex){
            return \response($ex);
        }
    }
}
