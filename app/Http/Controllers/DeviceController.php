<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Device;

class DeviceController extends Controller
{
    public function index()
    {
        $devices = Device::all();
        return view('device.index', compact('devices'));
    }

    public function create()
    {
        return view('device.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'serial_number' => 'required',
            'topic' => 'required'
        ]);

        Device::create($request->all());

        return redirect()->route('device.index')
                         ->with('success', 'Data berhasil ditambahkan');
    }

    public function edit($id)
    {
        $device = Device::findOrFail($id);
        return view('device.edit', compact('device'));
    }

    public function update(Request $request, $id)
    {
        $device = Device::findOrFail($id);

        $device->update($request->all());

        return redirect()->route('device.index')
                         ->with('success', 'Data berhasil diupdate');
    }

    public function destroy($id)
    {
        Device::destroy($id);

        return redirect()->route('device.index')
                         ->with('success', 'Data berhasil dihapus');
    }
}