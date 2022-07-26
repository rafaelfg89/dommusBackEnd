<?php namespace App\Http\Controllers;
use App\Models\Empreendimentos;
use App\Models\Blocos;
use App\Models\Unidade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
            $empreendimentos = Empreendimentos::
                where('empreendimentos.id',$id)
                ->leftJoin('blocos','blocos.id_empreendimentos','=','empreendimentos.id')
                ->leftJoin('unidade','unidade.id_bloco','=','blocos.id')
                ->join('status','status.id','=','unidade.id_status')
                ->groupBy('empreendimentos.id','empreendimentos.localizacao','empreendimentos.prev_entrega','empreendimentos.nome','status.descrição')
                ->select('empreendimentos.id','empreendimentos.localizacao','empreendimentos.prev_entrega','empreendimentos.nome','status.descrição',
                    DB::raw('COUNT(unidade.valor) as quantidade_unidade'),
                    DB::raw('SUM(unidade.valor) as valor_unidade_total'))
                ->get();

            return \response($empreendimentos);
        }catch (\Exception $ex){
            return \response()->json($ex);
        }
    }

    public function store(Request $request){
        try{
            $empreendimento = new Empreendimentos();

            $this->validate($request,[
                'nome'          => 'required',
                'localizacao'   => 'required',
                'prev_entrega'  => 'required'
            ]);

            $empreendimento->fill($request->toArray());

            $empreendimento->save();
            return \response($empreendimento);
        }catch (\Exception $ex){
            return  \response()->json($ex);
        }
    }

    public function update(Request $request, $id){
        try{
            $empreendimento =  Empreendimentos::find($id);

            $this->validate($request,[
                'nome'          => 'required',
                'localizacao'   => 'required',
                'prev_entrega'  => 'required'
            ]);

            $empreendimento->fill($request->toArray());

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
