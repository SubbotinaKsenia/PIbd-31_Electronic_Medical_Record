<?php

namespace App\Http\Controllers;

use App\Disease;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class DiseaseController extends Controller
{
    public function getDiseases()
    {
        $list = Disease::all();
        $status = $list ? '200' : '404';
        $data = compact('list', 'status');

        return response()->json($data);
    }

    public function getDisease($id)
    {
        $disease = Disease::findOrFail($id);
        $list = $disease;
        $status = $disease ? '200' : '404';
        $data = compact('list', 'status');

        return response()->json($data);
    }

    public function addDisease(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
        ], [
            'required' => 'Обязательное поле',
        ]);

        if ($validator->passes()) {
            $disease = Disease::create([
                'title' => $request->input('title'),
                'description' => $request->input('description')
            ]);

            $status = '201';
            $list = $disease->id;
        } else {
            $status = '422';
            $list = $validator->errors();
        }

        $data = compact('list', 'status');

        return response()->json($data);
    }

    public function updateDisease(Request $request, $id)
    {
        $disease = Disease::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'title' => 'required',
        ], [
            'required' => 'Обязательное поле',
        ]);

        if ($validator->passes()) {
            $disease->update([
                'title' => $request->input('title'),
                'description' => $request->input('description')
            ]);

            $status = '201';
        } else {
            $status = '422';
            $disease = $validator->errors();
        }
        $data = compact('disease', 'status');

        return response()->json($data);
    }

    public function deleteDisease($id)
    {
        $disease = Disease::findOrFail($id);
        $disease->delete($id);
        $status = '204';

        return response()->json($status);
    }

    public function addDiseaseToReceivingSheet($sheet_id, $disease_id)
    {
        DB::table('disease_receiving_sheet')->insert([
            'receiving_sheet_id' => $sheet_id,
            'disease_id' => $disease_id,
        ]);
        $status = '204';

        return response()->json($status);
    }
}
