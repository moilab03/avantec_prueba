<?php

namespace App\Http\Controllers;

use App\Models\Person;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\Validator;

class PeopleController extends Controller
{
    public function get_people(){
        $people = Person::all();
        return DataTables::of($people)
                            ->addIndexColumn()
                            ->addColumn('actions', function($row){
                                return '<div class="btn-group">
                                              <button class="btn btn-sm btn-primary" data-id="'.$row['id'].'" id="updatePersonBtn">Update</button>
                                              <button class="btn btn-sm btn-danger" style="margin-left: 15px" data-id="'.$row['id'].'" id="deletePersonBtn">Delete</button>
                                        </div>';
                            })
                            ->rawColumns(['actions'])
                            ->make(true);
    }  
    
    public function add_person(Request $request){
        $validator = \Validator::make($request->all(),[
            'name'=>'required',
            'last_name'=>'required',
            'dni'=>'required|unique:people|integer',            

        ]);

        if(!$validator->passes()){
             return response()->json(['code'=>0,'error'=>$validator->errors()->toArray()]);
        }else{
            $person = new Person();
            $person->name = $request->name;
            $person->last_name = $request->last_name;
            $person->dni = $request->dni;
            if (isset($request->phone) and $request->phone != null) {
                $person->phone = $request->phone;
            }
            $query = $person->save();

            if(!$query){
                return response()->json(['code'=>0,'msg'=>'Algo no salio bien']);
            }else{
                return response()->json(['code'=>1,'msg'=>'Se registro una nueva persona']);
            }
        }
    }

    public function get_person_detail(Request $request){
        $person_id = $request->person_id;
        $person_details = Person::find($person_id);
        return response()->json(['details'=>$person_details]);
    }

    public function update_person(Request $request){
        $person_id = $request->person_id;

        $validator = \Validator::make($request->all(),[            

            'name'=>'required',
            'last_name'=>'required',
            'dni'=>'required|integer', 
        ]);

        if(!$validator->passes()){
               return response()->json(['code'=>0,'error'=>$validator->errors()->toArray()]);
        }else{
             
            $person = Person::find($person_id);
            $person->name = $request->name;
            $person->last_name = $request->last_name;
            $person->dni = $request->dni;
            if (isset($request->phone) and $request->phone != null) {
                $person->phone = $request->phone;
            }
            $query = $person->save();

            if($query){
                return response()->json(['code'=>1, 'msg'=>'Los datos fueron actualizados']);
            }else{
                return response()->json(['code'=>0, 'msg'=>'Algo no salio bien']);
            }
        }
    }

    public function delete_person(Request $request){
        $person_id = $request->person_id;
        $query = Person::find($person_id)->delete();

        if($query){
            return response()->json(['code'=>1, 'msg'=>'Fue eliminado de la base de datos']);
        }else{
            return response()->json(['code'=>0, 'msg'=>'Algo no salio bien']);
        }
    }
}
