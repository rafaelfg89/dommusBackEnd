<?php namespace App\Http\Controllers;
use App\Models\Log_reajuste;
use Illuminate\Http\Request;
use App\Models\Unidade;

class UnidadeController extends Controller {
    public function index() {
        try{
            $unidade = Unidade::all();
            return \response($unidade);
        }catch (\Exception $ex){
            return \response($ex);
        }
    }

    public function getUnidadeByEmpreendimento($id) {
        try{
            $unidade = app('db')->select('	SELECT
	uni.id, uni.id_bloco, uni.valor, stat.`descrição`
	 FROM empreendimentos emp
	 left JOIN blocos bloc ON emp.id = bloc.id_empreendimentos
	 left JOIN unidade uni ON bloc.id = uni.id_bloco
	 INNER JOIN status stat ON uni.id_status = stat.id
	 WHERE emp.id = '.$id
	 );
            return \response($unidade);
        }catch (\Exception $ex){
            return \response($ex);
        }
    }

    public function show($id) {
        try {
            $unidade = Unidade::where('id', $id)->get();
            return \response($unidade);
    }catch (\Exception $ex){
            return \response($ex);
        }
    }

    public function store(Request $request){
        try{
            $erros = array();
            $unidade = new Unidade();

            if(!$request->id_bloco || $request->id_bloco == '') array_push($erros,"Bloco obrigatório para a criação de um unidade.");
            if(!$request->valor || $request->valor == '') array_push($erros,"Valor obrigatório para a criação de uma unidade.");
            if(!$request->id_status || $request->id_status == '') array_push($erros,"Status é obrigatório para a criação de uma unidade.");

            if(count($erros) > 0) return \response()->json($erros);

            $unidade->id_bloco       = $request->id_bloco;
            $unidade->valor          = $request->valor;
            $unidade->id_status      = $request->id_status;

            $unidade->save();

            return \response($unidade);
        }catch (\Exception $ex){
            return  \response()->json($ex);
        }
    }

    public function update(Request $request, $id){
        try{
            $unidade =  Unidade::find($id);

            if($request->valor){
                $log_reaj = new Log_reajuste();

                $log_reaj->id_unidade        = $id;
                $log_reaj->valor_reajuste    = $request->valor;
                $log_reaj->valor_antigo      = $unidade->valor;

                $log_reaj->percentual   = (($request->valor / $unidade->valor) * 100) - 100;
                $log_reaj->save();
            };

            $unidade->id_bloco           = !$request->id_bloco ? $unidade->id_bloco : $request->id_bloco;
            $unidade->valor              = !$request->valor ? $unidade->valor : $request->valor;
            $unidade->id_status          = !$request->id_status ? $unidade->id_status : $request->id_status;

            $unidade->save();
            return \response($unidade);

        }catch (\Exception $ex){

            return  \response()->json($ex);
        }
    }

    public function destroy($id){
        try{
            $unidade = Unidade::find($id);
            $unidade->delete();

            return \response()->json('Unidade excluída com sucesso!');
        }catch (\Exception $ex){
            return  \response()->json($ex);
        }
    }
}
