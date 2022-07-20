<?php namespace App\Http\Controllers;
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

            $unidade->id_bloco           = !$request->id_bloco ? $unidade->nome : $request->id_bloco;
            $unidade->valor              = !$request->valor ? $unidade->localizacao : $request->valor;
            $unidade->id_status          = !$request->id_status ? $unidade->prev_entrega : $request->id_status;

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
