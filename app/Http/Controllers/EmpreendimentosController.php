<?php namespace App\Http\Controllers;
use App\Models\Empreendimentos;
use App\Models\Blocos;
use App\Models\Unidade;
use Illuminate\Http\Request;

class EmpreendimentosController extends Controller {
    public function index() {
        try{
            $empreendimentos = Empreendimentos::all();
            return \response($empreendimentos);
        }catch (\Exception $ex){
            return \response()->json($ex);
        }
    }

    public function show($id) {
        try {
            $empreendimentos = Empreendimentos::where('id', $id)->get();
            return \response($empreendimentos);
    }catch (\Exception $ex){
            return \response()->json($ex);
        }
    }

    public function store(Request $request){
        try{
            $erros = array();
            $empreendimento = new Empreendimentos();

            if(!$request->nome || $request->nome == '') array_push($erros,"Nome obrigatório para a criação de um empreendimento.");
            if(!$request->localizacao || $request->localizacao == '') array_push($erros,"Localizacao obrigatório para a criação de um empreendimento.");
            if(!$request->prev_entrega || $request->prev_entrega == '') array_push($erros,"Previsão de entrega obrigatório para a criação de um empreendimento.");

            if(count($erros) > 0) return \response()->json($erros);

            $empreendimento->nome           = $request->nome;
            $empreendimento->localizacao    = $request->localizacao;
            $empreendimento->prev_entrega   = $request->prev_entrega;

            $empreendimento->save();

            return \response($empreendimento);
        }catch (\Exception $ex){
            return  \response()->json($ex);
        }
    }

    public function update(Request $request, $id){
        try{
            $empreendimento =  Empreendimentos::find($id);

            $empreendimento->nome           = !$request->nome ? $empreendimento->nome : $request->nome;
            $empreendimento->localizacao    = !$request->localizacao ? $empreendimento->localizacao : $request->localizacao;
            $empreendimento->prev_entrega   = !$request->prev_entrega ? $empreendimento->prev_entrega : $request->prev_entrega;

            $empreendimento->save();

            return \response($empreendimento);
        }catch (\Exception $ex){
            return  \response()->json($ex);
        }
    }

    public function destroy($id){
        try{
            $empreendimentos = Empreendimentos::find($id);
            $blocos = Blocos::where('id_empreendimentos', $id);
            foreach ($blocos as $bloco){
                Unidade::where('id_bloco', $bloco->id)->delete();
            }
            $blocos->delete();

            $empreendimentos->delete();
            return \response()->json('Empreendimento excluído com sucesso!');

        }catch (\Exception $ex){
            return  \response()->json($ex);
        }
    }
}
