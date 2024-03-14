<?php

namespace App\Http\Controllers;

use App\Models\format_ujian;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use Illuminate\Support\Facades\Storage;

class FormatUjianController extends Controller
{
    public function index()
    {
        $data = format_ujian::all();

        return view('admin.crud_format.index', compact('data'));
    }

    public function create()
    {
        return view('admin.crud_format.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'path' => 'required|mimes:xlsx',
        ]);

        $file = $request->file('path');
        $path = $file->storeAs('excel', $file->getClientOriginalName(), 'public');

        format_ujian::create([
            'name' => $request->name,
            'path' => $path,
        ]);

        return redirect()->route('admin.excel.index')->with('success', 'File berhasil diupload.');
    }

    public function download($id)
    {
        $file = format_ujian::findOrFail($id);
        return response()->download(storage_path('app/public/' . $file->path));
    }

    public function destroy($id)
    {
        $file = format_ujian::findOrFail($id);
        unlink(storage_path('app/public/' . $file->path));
        $file->delete();

        return redirect()->route('excel.index')->with('success', 'File berhasil dihapus.');
    }
}
