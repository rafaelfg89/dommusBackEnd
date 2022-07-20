<?php namespace App\Http\Controllers;
use App\Models\Status;

class StatusController extends Controller {

    public function index() {
        try{
            $status = Status::all();
            return \response($status);
        }catch (\Exception $ex){
            return \response($ex);
        }
    }

    public function show($id) {
        try{
            $status = app('db')->select("select * from status where id =".$id);
            return \response($status);
        }catch (\Exception $ex){
            return \response($ex);
        }
    }
}
