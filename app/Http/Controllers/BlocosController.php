<?php namespace App\Http\Controllers;
use App\Models\Empreendimentos;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Blocos;
use App\Models\Unidade;

class BlocosController extends Controller {

    public function index() {
        $blocos = Blocos::all();
        return \response($blocos);
    }

    public function show($id) {

        $blocos = Blocos::where('id', $id)->get();
        if(is_null($blocos)){
            return \response(Response::HTTP_NOT_FOUND);
        }
        return \response($blocos);
    }

    public function store(Request $request){
        try{

            $blocos = new Blocos();

            $this->validate($request,[
                'id_empreendimentos' => 'required'
            ]);

            $blocos->fill($request->toArray());

            $blocos->save();

            return \response($blocos);
        }catch (\Exception $ex){
            return  \response()->json($ex);
        }
    }

    public function update(Request $request, $id){
        try{
            $blocos =  Blocos::find($id);

            $this->validate($request,[
                "id_empreendimentos" => "required"
            ]);

            $blocos->fill($request->toArray());

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
