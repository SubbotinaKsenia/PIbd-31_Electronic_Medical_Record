<?php

namespace App\Http\Controllers;

use App\Drug;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class DrugController extends Controller
{
    public function getDrugs()
    {
        $list = Drug::all();
        $status = $list ? '200' : '404';
        $data = compact('list', 'status');

        return response()->json($data);
    }

    public function getDrug($id)
    {
        $drug = Drug::findOrFail($id);
        $list = $drug;
        $status = $drug ? '200' : '404';
        $data = compact('list', 'status');

        return response()->json($data);
    }

    public function addDrug(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'fio' => 'required',
            'email' => 'required',

        ], [
            'required' => 'Обязательное поле',
        ]);

        if ($validator->passes()) {
            $drug = Drug::create([
                'title' => $request->input('title'),
                'description' => $request->input('description')
            ]);

            $status = '201';
            $list = $drug->id;
        } else {
            $status = '422';
            $list = $validator->errors();
        }

        $data = compact('list', 'status');

        return response()->json($data);
    }

    public function updateDrug(Request $request, $id)
    {
        $drug = Drug::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'title' => 'required',
        ], [
            'required' => 'Обязательное поле',
        ]);

        if ($validator->passes()) {
            $drug->update([
                'title' => $request->input('title'),
                'description' => $request->input('description')
            ]);

            $status = '201';
        } else {
            $status = '422';
            $drug = $validator->errors();
        }
        $data = compact('drug', 'status');

        return response()->json($data);
    }

    public function deleteDrug($id)
    {
        $drug = Drug::findOrFail($id);
        $drug->delete($id);
        $status = '204';

        return response()->json($status);
    }

    public function addDrugToReceivingSheet($sheet_id, $drug_id)
    {
        DB::table('drug_receiving_sheet')->insert([
            'receiving_sheet_id' => $sheet_id,
            'drug_id' => $drug_id,
        ]);
        $status = '204';

        return response()->json($status);
    }
}
