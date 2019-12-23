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

    public function getReceivingSheetsByDoctor(Request $request)
    {
        $token = $request->header('Authorization');
        $user = User::where('token', $token)->get()->first();
        $list = ReceivingSheet::where('doctor_id', $user->id)->get();
        $rs = array();
        foreach ($list as $el) {
            $pat = User::findOrFail($el->patient_id);
            array_push($rs, [
                'id' => $el->id,
                'patient_fio' => $pat->fio,
                'date' => $el->date
            ]);
        }

        $status = $rs ? '200' : '404';
        $data = compact('rs', 'status');

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

    public function getReceivingSheetToPatient($id)
    {
        $list = ReceivingSheet::with(['symptoms', 'diseases', 'drugs'])->find($id);
        $doc = User::findOrFail($list->doctor_id);
        $rs = [
            'id' => $list->id,
            'doctor_fio' => $doc->fio,
            'date' => $list->date,
            'description' => $list->description,
            'drugs' => '',
            'symptoms' => '',
            'diseases' => ''
        ];
        $k = 0;
        foreach ($list->diseases as $disease) {
            if ($k != 0) {
                $rs = [
                    'id' => $rs['id'],
                    'doctor_fio' => $rs['doctor_fio'],
                    'date' => $rs['date'],
                    'description' => $rs['description'],
                    'drugs' => $rs['drugs'],
                    'symptoms' => $rs['symptoms'],
                    'diseases' => $rs['diseases'] . ', ' . $disease->title
                ];
            } else {
                $rs = [
                    'id' => $rs['id'],
                    'doctor_fio' => $rs['doctor_fio'],
                    'date' => $rs['date'],
                    'description' => $rs['description'],
                    'drugs' => $rs['drugs'],
                    'symptoms' => $rs['symptoms'],
                    'diseases' => $disease->title
                ];
            }
            $k++;
        }

        $k = 0;
        foreach ($list->drugs as $drug) {
            if ($k != 0) {
                $rs = [
                    'id' => $rs['id'],
                    'doctor_fio' => $rs['doctor_fio'],
                    'date' => $rs['date'],
                    'description' => $rs['description'],
                    'drugs' => $rs['drugs'] . ', ' . $drug->title,
                    'symptoms' => $rs['symptoms'],
                    'diseases' => $rs['diseases']
                ];
            } else {
                $rs = [
                    'id' => $rs['id'],
                    'doctor_fio' => $rs['doctor_fio'],
                    'date' => $rs['date'],
                    'description' => $rs['description'],
                    'drugs' => $drug->title,
                    'symptoms' => $rs['symptoms'],
                    'diseases' => $rs['diseases']
                ];
            }
            $k++;
        }

        $k = 0;
        foreach ($list->symptoms as $symptom) {
            if ($k != 0) {
                $rs = [
                    'id' => $rs['id'],
                    'doctor_fio' => $rs['doctor_fio'],
                    'date' => $rs['date'],
                    'description' => $rs['description'],
                    'drugs' => $rs['drugs'],
                    'symptoms' => $rs['symptoms'] . ', ' . $symptom->title,
                    'diseases' => $rs['diseases']
                ];
            } else {
                $rs = [
                    'id' => $rs['id'],
                    'doctor_fio' => $rs['doctor_fio'],
                    'date' => $rs['date'],
                    'description' => $rs['description'],
                    'drugs' => $rs['drugs'],
                    'symptoms' => $symptom->title,
                    'diseases' => $rs['diseases']
                ];
            }
            $k++;
        }

        $status = $rs ? '200' : '404';
        $data = compact('rs', 'status');

        return response()->json($data);
    }

    public function getReceivingSheetToDoc($id)
    {
        $list = ReceivingSheet::with(['symptoms', 'diseases', 'drugs'])->find($id);
        $pat = User::findOrFail($list->patient_id);
        $rs = [
            'id' => $list->id,
            'patient_fio' => $pat->fio,
            'date' => $list->date,
            'drugs' => '',
            'symptoms' => '',
            'diseases' => '',
            'description' => $list->description
        ];
        $k = 0;
        foreach ($list->diseases as $disease) {
            if ($k != 0) {
                $rs = [
                    'id' => $rs['id'],
                    'patient_fio' => $rs['patient_fio'],
                    'date' => $rs['date'],
                    'drugs' => $rs['drugs'],
                    'symptoms' => $rs['symptoms'],
                    'diseases' => $rs['diseases'] . ', ' . $disease->title,
                    'description' => $rs['description']
                ];
            } else {
                $rs = [
                    'id' => $rs['id'],
                    'patient_fio' => $rs['patient_fio'],
                    'date' => $rs['date'],
                    'drugs' => $rs['drugs'],
                    'symptoms' => $rs['symptoms'],
                    'diseases' => $disease->title,
                    'description' => $rs['description']
                ];
            }
            $k++;
        }
        $k = 0;
        foreach ($list->drugs as $drug) {
            if ($k != 0) {
                $rs = [
                    'id' => $rs['id'],
                    'patient_fio' => $rs['patient_fio'],
                    'date' => $rs['date'],
                    'drugs' => $rs['drugs'] . ', ' . $drug->title,
                    'symptoms' => $rs['symptoms'],
                    'diseases' => $rs['diseases'],
                    'description' => $rs['description']
                ];
            } else {
                $rs = [
                    'id' => $rs['id'],
                    'patient_fio' => $rs['patient_fio'],
                    'date' => $rs['date'],
                    'drugs' => $drug->title,
                    'symptoms' => $rs['symptoms'],
                    'diseases' => $rs['diseases'],
                    'description' => $rs['description']
                ];
            }
            $k++;
        }
        $k = 0;
        foreach ($list->symptoms as $symptom) {
            if ($k != 0) {
                $rs = [
                    'id' => $rs['id'],
                    'patient_fio' => $rs['patient_fio'],
                    'date' => $rs['date'],
                    'drugs' => $rs['drugs'],
                    'symptoms' => $rs['symptoms'] . ', ' . $symptom->title,
                    'diseases' => $rs['diseases'],
                    'description' => $rs['description']
                ];
            } else {
                $rs = [
                    'id' => $rs['id'],
                    'patient_fio' => $rs['patient_fio'],
                    'date' => $rs['date'],
                    'drugs' => $rs['drugs'],
                    'symptoms' => $symptom->title,
                    'diseases' => $rs['diseases'],
                    'description' => $rs['description']
                ];
            }
            $k++;
        }
        $status = $rs ? '200' : '404';
        $data = compact('rs', 'status');
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
                    'date' => date_format(new DateTime("now", new DateTimeZone('Europe/Ulyanovsk')), 'Y-m-d H:i:s'),
                    'description' => $request->input('description'),
                ]);

                $symptoms = $request->input('symptoms');
                foreach ($symptoms as $symptom) {
                    \App::call('App\Http\Controllers\SymptomController@addSymptomToReceivingSheet', ['sheet_id' => $receiving_sheet->id, 'symptom_id' => $symptom['id']]);
                }
                $drugs = $request->input('drugs');
                foreach ($drugs as $drug) {
                    \App::call('App\Http\Controllers\DrugController@addDrugToReceivingSheet', ['sheet_id' => $receiving_sheet->id, 'drug_id' => $drug['id']]);
                }
                $diseases = $request->input('diseases');
                foreach ($diseases as $disease) {
                    \App::call('App\Http\Controllers\DiseaseController@addDiseaseToReceivingSheet', ['sheet_id' => $receiving_sheet->id, 'disease_id' => $disease['id']]);
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
