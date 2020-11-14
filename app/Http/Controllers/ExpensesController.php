<?php

namespace App\Http\Controllers;

use App\Http\Requests\VehicleExpensesRequest;
use App\Services\VehicleExpensesSearcher;
use DB;

class ExpensesController extends Controller
{
    function main(VehicleExpensesRequest $request){
        $searcher = new VehicleExpensesSearcher($request->all());
        $query = $searcher->getQuery();
        return DB::select($query);
    }
}
