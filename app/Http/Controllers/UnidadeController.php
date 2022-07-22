<?php namespace App\Http\Controllers;
use App\Models\Empreendimentos;
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
            $unidade = Empreendimentos::
                where('empreendimentos.id', $id)
                ->leftJoin('blocos','empreendimentos.id','=','blocos.id_empreendimentos')
                ->leftJoin('unidade','blocos.id','=','unidade.id_bloco')
                ->join('status','unidade.id_status',"=","status.id")
                ->get();

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
            $unidade = new Unidade();

            $this->validate($request, Unidade::$rules);

            $unidade->fill($request->toArray());

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
                $log_reaj->percentual        = (($request->valor / $unidade->valor) * 100) - 100;
                $log_reaj->save();
            }

            $unidade->id_bloco           = $request->id_bloco ?: $unidade->id_bloco;
            $unidade->valor              = $request->valor ?: $unidade->valor;
            $unidade->id_status          = $request->id_status ?: $unidade->id_status;

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
