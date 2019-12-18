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

    public function getReceivingSheetsByPatient($id)
    {
        $list = ReceivingSheet::where('patient_id', $id)->get();
        $status = $list ? '200' : '404';
        $data = compact('list', 'status');

        return response()->json($data);
    }

    public function getReceivingSheet($id)
    {
        $list = ReceivingSheet::with(['symptoms', 'diseases', 'drugs'])->get();
        $status = $list ? '200' : '404';
        $data = compact('list', 'status');

        return response()->json($data);
    }

    public function addReceivingSheet(Request $request, $token)
    {
        $user = User::where('token', $token)->get()->first();

        $validator = Validator::make($request->all(), [
            'patient_id' => 'required',
        ], [
            'required' => 'Обязательное поле',
        ]);

        if (!is_null($user)) {
            if ($validator->passes()) {
                $receivingsheet = ReceivingSheet::create([
                    'doctor_id' => $user->id,
                    'patient_id' => $request->input('patient_id'),
                    'date' => date_format(new DateTime("now", new DateTimeZone('Europe/Ulyanovsk')), 'Y-m-d H:i'),
                    'description' => $request->input('description'),
                ]);


                $symptoms = $request->input('symptoms');
                foreach ($symptoms as $symptom) {
                    \App::call('App\Http\Controllers\SymptomController@addSymptomToReceivingSheet', ['sheet_id' => $receivingsheet->id, 'symptom_id' => $symptom]);
                }
                $drugs = $request->input('drugs');
                foreach ($drugs as $drug) {
                    \App::call('App\Http\Controllers\DrugController@addDrugToReceivingSheet', ['sheet_id' => $receivingsheet->id, 'drug_id' => $drug]);
                }
                $diseases = $request->input('diseases');
                foreach ($diseases as $disease) {
                    \App::call('App\Http\Controllers\DiseaseController@addDiseaseToReceivingSheet', ['sheet_id' => $receivingsheet->id, 'disease_id' => $disease]);
                }

                $status = '201';
            } else {
                $status = '422';
                $receivingsheet = $validator->errors();
            }
        } else {
            $status = '422';
            $receivingsheet = "Doctor not found";
        }
        $data = compact('receivingsheet', 'status');

        return response()->json($data);
    }

    public function updateReceivingSheet(Request $request, $id)
    {
        $receivingsheet = ReceivingSheet::findOrFail($id);

        $receivingsheet->update([
            'doctor_id' => $receivingsheet->doctor_id,
            'patient_id' => $request->input('patient_id') ? $request->input('patient_id') : $receivingsheet->patient_id,
            'date' => $receivingsheet->date,
            'description' => $request->input('description'),
        ]);
        $status = '201';
        $data = compact('receivingsheet', 'status');

        return response()->json($data);
    }

    public function deleteReceivingSheet($id)
    {
        $receivingsheet = ReceivingSheet::findOrFail($id);
        $receivingsheet->delete($id);
        $status = '204';

        return response()->json($status);
    }
}
