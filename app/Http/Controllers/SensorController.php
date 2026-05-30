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

    public function create()
    {
        return view('sensor.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_sensor' => 'required|string',
            'data'        => 'required|integer|min:0',
        ]);

        Sensor::create($request->all());

        return redirect()->route('sensor.index')
                         ->with('success', 'Data sensor berhasil ditambahkan');
    }

    public function edit($id)
    {
        $sensor = Sensor::findOrFail($id);
        return view('sensor.edit', compact('sensor'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_sensor' => 'required|string',
            'data'        => 'required|integer|min:0',
        ]);

        $sensor = Sensor::findOrFail($id);
        $sensor->update($request->all());

        return redirect()->route('sensor.index')
                         ->with('success', 'Data berhasil diupdate');
    }

    public function destroy($id)
    {
        Sensor::destroy($id);

        return redirect()->route('sensor.index')
                         ->with('success', 'Data sensor berhasil dihapus');
    }
}