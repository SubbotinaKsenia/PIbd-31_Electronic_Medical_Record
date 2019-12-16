<?php

namespace App\Http\Controllers;

use App\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ServiceController extends Controller
{
    public function getServices()
    {
        $list = Service::all();
        $status = $list ? '200' : '404';
        $data = compact('list', 'status');

        return response()->json($data);
    }

    public function getService($id)
    {
        $service = Service::findOrFail($id);
        $list = $service;
        $status = $service ? '200' : '404';
        $data = compact('list', 'status');

        return response()->json($data);
    }

    public function addService(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'price' => 'required',
        ], [
            'required' => 'Обязательное поле',
        ]);

        if ($validator->passes()) {
            $service = Service::create([
                'title' => $request->input('title'),
                'price' => $request->input('price'),
                'description' => $request->input('description')
            ]);

            $status = '201';
            $list = $service->id;
        } else {
            $status = '422';
            $list = $validator->errors();
        }

        $data = compact('list', 'status');

        return response()->json($data);
    }

    public function updateService(Request $request, $id)
    {
        $service = Service::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'price' => 'required',
        ], [
            'required' => 'Обязательное поле',
        ]);

        if ($validator->passes()) {
            $service->update([
                'title' => $request->input('title'),
                'price' => $request->input('price'),
                'description' => $request->input('description')
            ]);

            $status = '201';
        } else {
            $status = '422';
            $service = $validator->errors();
        }
        $data = compact('service', 'status');

        return response()->json($data);
    }

    public function deleteService($id)
    {
        $service = Service::findOrFail($id);
        $service->delete($id);
        $status = '204';

        return response()->json($status);
    }
}
