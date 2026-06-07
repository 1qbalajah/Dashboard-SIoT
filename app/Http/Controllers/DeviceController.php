<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Device;

class DeviceController extends Controller
{
    public function index()
    {
        $devices = Device::latest()
            ->paginate(15);

        return view('device.index', compact('devices'));
    }

    public function create()
    {
        return view('device.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'serial_number' => 'required|string|max:255',
            'topic' => 'required|string|max:255',
        ]);

        Device::create($request->only(['serial_number', 'topic']));

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
        $request->validate([
            'serial_number' => 'required|string|max:255',
            'topic' => 'required|string|max:255',
        ]);

        $device = Device::findOrFail($id);

        $device->update($request->only(['serial_number', 'topic']));

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
