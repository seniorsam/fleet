<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\VehicleExpensesSearcher;
use DB;
use Validator;
use Illuminate\Validation\Rule;

class ExpensesController extends Controller
{
    function main(Request $request){
        
        # validation rules
        $rules=array(   
            'cost_min' => 'int',
            'cost_max' => 'int'
        );
    
        $validator=Validator::make($request->all(),$rules);
        
        if($validator->fails())
        {
            $messages=$validator->messages();
            $errors=$messages->all();
            return response()->json($errors, 500);
        }

        $searcher = new VehicleExpensesSearcher($request->all());
        $query = $searcher->getQuery();
        return DB::select($query);

    }
}
