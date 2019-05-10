<?php

namespace App\Http\Controllers;

use App\Services\Classifier;
use Illuminate\Http\Request;

class MachineLearningController extends Controller
{
    public function getIndex()
    {
        return view("index");
    }

    public function postTrain(Request $request, Classifier $classifier)
    {
        $classifier->train($request->get("data"), $request->get("category"));
        return response('', 200);
    }

    public function getClassify(Request $request, Classifier $classifier)
    {
        return response()->json($classifier->classify($request->get("data")));
    }
}
