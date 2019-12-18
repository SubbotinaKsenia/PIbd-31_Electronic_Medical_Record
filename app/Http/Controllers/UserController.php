<?php

namespace App\Http\Controllers;

use App\Record;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function getUsers()
    {
        $list = User::all();
        $status = $list ? '200' : '404';
        $data = compact('list', 'status');

        return response()->json($data);
    }

    public function getDoctors()
    {
        $list = User::where('type', 'doctor')->get();
        $status = $list ? '200' : '404';
        $data = compact('list', 'status');

        return response()->json($data);
    }

    public function getPatients()
    {
        $list = User::where('type', 'patient')->get();
        $status = $list ? '200' : '404';
        $data = compact('list', 'status');

        return response()->json($data);
    }

    public function getAdmins()
    {
        $list = User::where('type', 'admin')->get();
        $status = $list ? '200' : '404';
        $data = compact('list', 'status');

        return response()->json($data);
    }

    public function getUser($id)
    {
        $user = User::findOrFail($id);
        $list = $user;
        $status = $user ? '200' : '404';
        $data = compact('list', 'status');

        return response()->json($data);
    }

    public function addDoctor(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'fio' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6'],
        ], [
            'required' => 'Обязательное поле',
            'string' => 'Поле в строковом формате',
            'max:255' => 'Максимальное количество симоволов в поле - 255',
            'email' => 'Поле в формате почты',
            'unique:users' => "Уникальная почта для каждого пользователя",
            'min:6' => 'Минимальное количество символов в поле - 6',
        ]);

        if ($validator->passes()) {
            $user = User::create([
                'fio' => $request->input('fio'),
                'email' => $request->input('email'),
                'password' => Hash::make($request->input('password')),
                'type' => 'doctor',
            ]);

            $status = '201';
            $list = $user;
        } else {
            $status = '422';
            $list = $validator->errors();
        }

        $data = compact('list', 'status');

        return response()->json($data);
    }

    public function addAdmin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'fio' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6'],
        ], [
            'required' => 'Обязательное поле',
            'string' => 'Поле в строковом формате',
            'max:255' => 'Максимальное количество симоволов в поле - 255',
            'email' => 'Поле в формате почты',
            'unique:users' => "Уникальная почта для каждого пользователя",
            'min:6' => 'Минимальное количество символов в поле - 6',
        ]);

        if ($validator->passes()) {
            $user = User::create([
                'fio' => $request->input('fio'),
                'email' => $request->input('email'),
                'password' => Hash::make($request->input('password')),
                'type' => 'admin',
                'token' => uniqid(),
            ]);

            $status = '201';
            $list = [
                'token' => $user->token,
                'fio' => $user->fio,
            ];
        } else {
            $status = '422';
            $list = $validator->errors();
        }

        $data = compact('list', 'status');

        return response()->json($data);
    }

    public function addPatient(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'fio' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6'],
        ], [
            'required' => 'Обязательное поле',
            'string' => 'Поле в строковом формате',
            'max:255' => 'Максимальное количество симоволов в поле - 255',
            'email' => 'Поле в формате почты',
            'unique:users' => "Уникальная почта для каждого пользователя",
            'min:6' => 'Минимальное количество символов в поле - 6',
        ]);

        if ($validator->passes()) {
            $user = User::create([
                'fio' => $request->input('fio'),
                'email' => $request->input('email'),
                'password' => Hash::make($request->input('password')),
                'type' => 'patient',
                'token' => uniqid(),
            ]);

            $status = '201';
            $list = [
                'token' => $user->token,
                'fio' => $user->fio,
            ];
        } else {
            $status = '422';
            $list = $validator->errors();
        }

        $data = compact('list', 'status');

        return response()->json($data);
    }

    public function updateById(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'fio' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
        ], [
            'required' => 'Обязательное поле',
            'string' => 'Поле в строковом формате',
            'max:255' => 'Максимальное количество симоволов в поле - 255',
            'email' => 'Поле в формате почты',
        ]);

        if ($validator->passes()) {
            $user->update([
                'fio' => $request->input('fio'),
                'email' => $request->input('email'),
                'password' => $user->password,
                'type' => $user->type,
                'token' => $user->token,
            ]);
            $status = '201';
        } else {
            $status = '422';
            $user = $validator->errors();
        }
        $data = compact('user', 'status');

        return response()->json($data);
    }

    public function updateByToken(Request $request, $token)
    {
        $user = User::where('token', $token)->get()->first();

        $validator = Validator::make($request->all(), [
            'fio' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['string', 'min:6'],
        ], [
            'required' => 'Обязательное поле',
            'string' => 'Поле в строковом формате',
            'max:255' => 'Максимальное количество симоволов в поле - 255',
            'email' => 'Поле в формате почты',
        ]);

        if (!is_null($user)) {
            if ($validator->passes()) {
                $user->update([
                    'fio' => $request->input('fio'),
                    'email' => $request->input('email'),
                    'password' => $request->input('password') ? Hash::make($request->input('password')) : $user->password,
                    'type' => $user->type,
                    'token' => $user->token,
                ]);
                $status = '201';
            } else {
                $status = '422';
                $user = $validator->errors();
            }
        } else {
            $status = '422';
            $user = "User not found";
        }
        $data = compact('user', 'status');

        return response()->json($data);
    }

    public function deleteUser($id)
    {
        $user = User::findOrFail($id);
        $user->delete($id);

        $records = Record::query()
            ->where('patient_id', null)
            ->get();

        foreach ($records as $record) {
            $record->update([
                'is_reserved' => 0,
            ]);
        }

        $status = '204';
        return response()->json($status);
    }

    public function authorization(Request $request)
    {
        $credentials = $request->only('email', 'password');

        $user = User::query()
            ->where('email', $credentials['email'])
            ->get()->first();

        if (!is_null($user)) {
            if (password_verify($credentials['password'], $user->password)) {
                $user->update([
                    'token' => uniqid(),
                ]);
                return response()->json([
                    'message' => 'Authorised',
                    'token' => $user->token,
                    'fio' => $user->fio,
                    'status' => '200',
                ]);

            } else {
                return response()->json([
                    'message' => 'You cannot sign with those credentials',
                    'status' => '401',
                ]);
            }
        } else {
            return response()->json([
                'message' => 'User not found',
                'status' => '401',
            ]);
        }
    }

    public function logout($token)
    {
        $user = User::where('token', $token)->get()->first();
        if (!is_null($user)) {
            $user->update([
                'token' => null,
            ]);
            return response()->json([
                'message' => 'Logout is complete',
                'status' => '200',
            ]);
        } else {
            return response()->json([
                'message' => 'User not found',
                'status' => '401',
            ]);
        }
    }

    public function getDoctorsFromRecordsByService($service_id)
    {
        $records = Record::where('service_id', $service_id)->get();
        $doctors = array();
        foreach ($records as $record) {
            $doctor = User::findOrFail($record->doctor_id);
            if (!in_array($doctor, $doctors)) {
                array_push($doctors, $doctor);
            }
        }
        $list = $doctors;
        $status = $list ? '200' : '404';
        $data = compact('list', 'status');

        return response()->json($data);
    }

    public function getPatientsFromRecordsByDoctor($token)
    {
        $user = User::where('token', $token)->get()->first();
        $records = Record::where('doctor_id', $user->id)->get();

        $patients = array();
        foreach ($records as $record) {
            $patient = User::findOrFail($record->patient_id);
            if (!in_array($patient, $patients)) {
                array_push($patients, $patient);
            }
        }
        $list = $patients;
        $status = $list ? '200' : '404';
        $data = compact('list', 'status');

        return response()->json($data);
    }
}
