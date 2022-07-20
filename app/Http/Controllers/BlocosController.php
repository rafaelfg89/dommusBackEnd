<?php namespace App\Http\Controllers;
use App\Models\Empreendimentos;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Blocos;
use App\Models\Unidade;

class BlocosController extends Controller {


    public function index() {
        $blocos = Blocos::all();
       //$blocos = app('db')->select("select * from blocos") ;
        return \response($blocos);
    }

    public function show($id) {

        $blocos = Blocos::where('id', $id)->get();
        if(is_null($blocos)){
            return $this->respond(Response::HTTP_NOT_FOUND);
        }
        return \response($blocos);
    }

    public function store(Request $request){
        try{
            $erros = array();
            $blocos = new Blocos();

            if(!$request->id_empreendimentos || $request->id_empreendimentos == '') array_push($erros,"Empreendimento obrigatório para a criação de um bloco.");

            if(count($erros) > 0) return \response()->json($erros);

            $blocos->id_empreendimentos   = $request->id_empreendimentos;

            $blocos->save();

            return \response($blocos);
        }catch (\Exception $ex){
            return  \response()->json($ex);
        }
    }

    public function update(Request $request, $id){
        try{
            $blocos =  Blocos::find($id);

            $blocos->id_empreendimentos  = !$request->id_empreendimentos ? $blocos->nome : $request->id_empreendimentos;

            $blocos->save();

            return \response($blocos);
        }catch (\Exception $ex){
            return  \response()->json($ex);
        }
    }

    public function destroy($id){
        try{
            $blocos = Blocos::find($id);
            $unidades = Unidade::where('id_bloco', $id)->delete();

            $blocos->delete();
            return \response()->json('Bloco excluído com sucesso! '.$unidades.' Unidades exluídas');
        }catch (\Exception $ex){
            return  \response()->json($ex);
        }
    }
}
