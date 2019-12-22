<?php

namespace App\Http\Controllers;

use App;
use App\ReceivingSheet;
use App\User;
use DateTime;
use DateTimeZone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ReceivingSheetController extends Controller
{
    public function getReceivingSheets()
    {
        $list = ReceivingSheet::all();
        $status = $list ? '200' : '404';
        $data = compact('list', 'status');

        return response()->json($data);
    }

    public function getReceivingSheetsByDoctor($id)
    {
        $list = ReceivingSheet::where('doctor_id', $id)->get();
        $status = $list ? '200' : '404';
        $data = compact('list', 'status');

        return response()->json($data);
    }

    public function getReceivingSheetsByPatient(Request $request)
    {
        $token = $request->header('Authorization');
        $user = User::where('token', $token)->get()->first();
        $list = ReceivingSheet::where('patient_id', $user->id)->get();
        $rs = array();
        foreach ($list as $el) {
            $doc = User::findOrFail($el->doctor_id);
            array_push($rs, [
                'id' => $el->id,
                'doctor_fio' => $doc->fio,
                'date' => $el->date
            ]);
        }

        $status = $rs ? '200' : '404';
        $data = compact('rs', 'status');

        return response()->json($data);
    }

    public function getReceivingSheet($id)
    {
        $list = ReceivingSheet::with(['symptoms', 'diseases', 'drugs'])->find($id);
        $status = $list ? '200' : '404';
        $data = compact('list', 'status');

        return response()->json($data);
    }

    public function addReceivingSheet(Request $request)
    {
        $token = $request->header('Authorization');
        $user = User::where('token', $token)->get()->first();

        $validator = Validator::make($request->all(), [
            'patient_id' => 'required',
        ], [
            'required' => 'Обязательное поле',
        ]);

        if (!is_null($user)) {
            if ($validator->passes()) {
                $receiving_sheet = ReceivingSheet::create([
                    'doctor_id' => $user->id,
                    'patient_id' => $request->input('patient_id'),
                    'date' => date_format(new DateTime("now", new DateTimeZone('Europe/Ulyanovsk')), 'Y-m-d H:i'),
                    'description' => $request->input('description'),
                ]);


                $symptoms = $request->input('symptoms');
                foreach ($symptoms as $symptom) {
                    \App::call('App\Http\Controllers\SymptomController@addSymptomToReceivingSheet', ['sheet_id' => $receiving_sheet->id, 'symptom_id' => $symptom]);
                }
                $drugs = $request->input('drugs');
                foreach ($drugs as $drug) {
                    \App::call('App\Http\Controllers\DrugController@addDrugToReceivingSheet', ['sheet_id' => $receiving_sheet->id, 'drug_id' => $drug]);
                }
                $diseases = $request->input('diseases');
                foreach ($diseases as $disease) {
                    \App::call('App\Http\Controllers\DiseaseController@addDiseaseToReceivingSheet', ['sheet_id' => $receiving_sheet->id, 'disease_id' => $disease]);
                }

                $status = '201';
            } else {
                $status = '422';
                $receiving_sheet = $validator->errors();
            }
        } else {
            $status = '422';
            $receiving_sheet = "Doctor not found";
        }
        $data = compact('receiving_sheet', 'status');

        return response()->json($data);
    }

    public function updateReceivingSheet(Request $request, $id)
    {
        $receiving_sheet = ReceivingSheet::findOrFail($id);

        $receiving_sheet->update([
            'doctor_id' => $receiving_sheet->doctor_id,
            'patient_id' => $request->input('patient_id') ? $request->input('patient_id') : $receiving_sheet->patient_id,
            'date' => $receiving_sheet->date,
            'description' => $request->input('description'),
        ]);
        $status = '201';
        $data = compact('receiving_sheet', 'status');

        return response()->json($data);
    }

    public function deleteReceivingSheet($id)
    {
        $receiving_sheet = ReceivingSheet::findOrFail($id);
        $receiving_sheet->delete($id);
        $status = '204';

        return response()->json($status);
    }
}
