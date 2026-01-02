<?php

namespace App\Http\Controllers;

use App\Models\Sensor;
use Illuminate\Http\Request;

class SensorController extends Controller
{
    public function index()
    {
        $sensors = Sensor::all();
        return view('sensor.index', compact('sensors'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_sensor' => 'required',
            'data' => 'required|numeric'
        ]);

        Sensor::create($request->all());

        return redirect()->back()->with('success', 'Data sensor berhasil ditambahkan');
    }
}
