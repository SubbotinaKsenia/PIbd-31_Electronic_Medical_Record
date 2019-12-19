<?php

namespace App\Http\Controllers;

use App\Record;
use App\Service;
use App\User;
use DateTime;
use DateTimeZone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class RecordController extends Controller
{
    public function getRecords()
    {
        $list = Record::all();
        $status = $list ? '200' : '404';
        $data = compact('list', 'status');

        return response()->json($data);
    }

    public function getRecordsByDoctor($id)
    {
        $list = Record::where('doctor_id', $id)->get();
        $status = $list ? '200' : '404';
        $data = compact('list', 'status');

        return response()->json($data);
    }

    public function getRecordsByPatient(Request $request)
    {
        $token = $request->header('Authorization');
        $user = User::where('token', $token)->get()->first();
        $list = Record::where('patient_id', $user->id)->get();
        $status = $list ? '200' : '404';
        $data = compact('list', 'status');

        return response()->json($data);
    }

    public function getRecord($id)
    {
        $record = Record::findOrFail($id);
        $list = $record;
        $status = $record ? '200' : '404';
        $data = compact('list', 'status');

        return response()->json($data);
    }

    public function addRecord(Request $request)
    {
        $records = Record::query()
            ->where('doctor_id', $request->input('doctor_id'))
            ->get();

        $flag = false;
        foreach ($records->all() as $rec) {
            if (date('H:i', strtotime($rec->date)) === date('H:i', strtotime($request->input('date')))
                && date('Y-m-d', strtotime($rec->date)) === date('Y-m-d', strtotime($request->input('date')))) {
                $flag = true;
            }
        }

        $validator = Validator::make($request->all(), [
            'service_id' => 'required',
            'doctor_id' => 'required',
            'date' => 'required',
        ], [
            'required' => 'Обязательное поле',
        ]);

        if (!$flag) {
            if ($validator->passes()) {
                $record = Record::create([
                    'service_id' => $request->input('service_id'),
                    'doctor_id' => $request->input('doctor_id'),
                    'date' => $request->input('date'),
                    'patient_id' => null,
                    'is_reserved' => 0,
                ]);

                $status = '201';
                $list = $record;
            } else {
                $status = '422';
                $list = $validator->errors();
            }
        } else {
            $status = '422';
            $list = "Doctor isn't available. Choose another date.";
        }

        $data = compact('list', 'status');

        return response()->json($data);
    }

    public function updateRecord(Request $request, $id)
    {
        $record = Record::findOrFail($id);

        $records = Record::query()
            ->where('doctor_id', $request->input('doctor_id'))
            ->get();

        $flag = false;
        foreach ($records->all() as $rec) {
            if (date('H:i', strtotime($rec->date)) === date('H:i', strtotime($request->input('date')))
                && date('Y-m-d', strtotime($rec->date)) === date('Y-m-d', strtotime($request->input('date')))) {
                $flag = true;
            }
        }

        $validator = Validator::make($request->all(), [
            'service_id' => 'required',
            'doctor_id' => 'required',
            'date' => 'required',
        ], [
            'required' => 'Обязательное поле',
        ]);

        if (!$flag) {
            if ($validator->passes()) {
                $record->update([
                    'service_id' => $request->input('service_id'),
                    'doctor_id' => $request->input('doctor_id'),
                    'date' => $request->input('date'),
                    'patient_id' => $record->patient_id,
                    'is_reserved' => $record->is_reserved,
                ]);

                $status = '201';
                $list = $record;
            } else {
                $status = '422';
                $list = $validator->errors();
            }
        } else {
            $status = '422';
            $list = "Doctor isn't available. Choose another date.";
        }

        $data = compact('list', 'status');

        return response()->json($data);
    }

    public function deleteRecord($id)
    {
        $record = Record::findOrFail($id);
        $record->delete($id);
        $status = '204';
        return response()->json($status);
    }

    public function addReservation(Request $request, $id)
    {
        $token = $request->header('Authorization');
        $user = User::where('token', $token)->get()->first();
        $record = Record::findOrFail($id);
        $doctor = User::findOrFail($record->doctor_id);
        $service = Service::findOrFail($record->service_id);

        if (!is_null($user)) {
            $record->update([
                'patient_id' => $user->id,
                'is_reserved' => 1,
            ]);
            $status = '201';
            $list = $record;
        } else {
            $status = '422';
            $list = "User not found";
        }

        Mail::send([], [], function ($message) use ($user, $record, $doctor, $service) {
            $message->to($user->email, $user->fio)
                ->subject('Запись на прием')
                ->from(env('MAIL_USERNAME'), 'MedCenter')
                ->setBody("Здравствуйте, " . $user->fio . "!\nВы записаны на прием.\n\nДоктор: " . $doctor->fio . "\nУслуга: " . $service->title . "\nСтоимость: " . $service->price . "\nДата: " . strval(date('Y-m-d', strtotime($record->date))) . "\nВремя: " . strval(date('H:i', strtotime($record->date))) . "\n\nС уважением, Медицинский Центр");
        });

        $data = compact('list', 'status');

        return response()->json($data);
    }

    public function deleteReservation($id)
    {
        $record = Record::findOrFail($id);

        $record->update([
            'patient_id' => null,
            'is_reserved' => 0,
        ]);
        $status = '201';
        $list = $record;

        $data = compact('list', 'status');

        return response()->json($data);
    }

    public function getRecordByServiceAndDoctor($service_id, $doctor_id)
    {
        $records = Record::query()
            ->where('service_id', $service_id)
            ->where('doctor_id', $doctor_id)
            ->where('is_reserved', 0)
            ->get();

        $list = $records;
        $status = $list ? '200' : '404';
        $data = compact('list', 'status');

        return response()->json($data);
    }
}
