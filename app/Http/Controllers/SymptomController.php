<?php

namespace App\Http\Controllers;

use App\Symptom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SymptomController extends Controller
{
    public function getSymptoms()
    {
        $list = Symptom::all();
        $status = $list ? '200' : '404';
        $data = compact('list', 'status');

        return response()->json($data);
    }

    public function getSymptom($id)
    {
        $symptom = Symptom::findOrFail($id);
        $list = $symptom;
        $status = $symptom ? '200' : '404';
        $data = compact('list', 'status');

        return response()->json($data);
    }

    public function addSymptom(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
        ], [
            'required' => 'Обязательное поле',
        ]);

        if ($validator->passes()) {
            $symptom = Symptom::create([
                'title' => $request->input('title'),
                'description' => $request->input('description')
            ]);

            $status = '201';
            $list = $symptom->id;
        } else {
            $status = '422';
            $list = $validator->errors();
        }

        $data = compact('list', 'status');

        return response()->json($data);
    }

    public function updateSymptom(Request $request, $id)
    {
        $symptom = Symptom::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'title' => 'required',
        ], [
            'required' => 'Обязательное поле',
        ]);

        if ($validator->passes()) {
            $symptom->update([
                'title' => $request->input('title'),
                'description' => $request->input('description')
            ]);

            $status = '201';
        } else {
            $status = '422';
            $symptom = $validator->errors();
        }
        $data = compact('symptom', 'status');

        return response()->json($data);
    }

    public function deleteSymptom($id)
    {
        $symptom = Symptom::findOrFail($id);
        $symptom->delete($id);
        $status = '204';

        return response()->json($status);
    }
}
