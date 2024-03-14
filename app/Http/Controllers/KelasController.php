<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\kelas;
use App\Models\usersKelas;
use Illuminate\Http\Request;

class KelasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $role = 0;
        $users = User::where('role', $role)->get();
        $kelas = kelas::with('userKelas', 'User')->whereHas('userKelas', function ($query) use ($users) {
            $query->whereIn('user_id', $users->pluck('id'));
        })->get();

        $kelaz = kelas::all();
        return view('admin.crud_kelas.index', compact('kelas', 'kelaz'));
    }
    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return view('admin.crud_kelas.create');
    }

    public function store(Request $request)
    {
        $data = new kelas;
        $data->nama_kelas = $request->input('nama_kelas');
        $data->save();
        return redirect()->route('kelas.index')->with('success', 'Kelas berhasil ditambahkan.');
    }
    

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\kelas  $kelas
     * @return \Illuminate\Http\Response
     */
    public function show(kelas $kelas)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\kelas  $kelas
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $kelas = Kelas::findOrFail($id);
        return view('admin.crud_kelas.edit', compact('kelas'));
    }
    
    public function update(Request $request, $id)
    {
        $kelas = Kelas::findOrFail($id);
        $kelas->nama_kelas = $request->input('nama_kelas');
        $kelas->save();
        return redirect()->route('kelas.index')->with('success', 'Kelas berhasil diperbarui.');
    }
    

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\kelas  $kelas
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $kelas = Kelas::findOrFail($id);
        $kelas->delete();
        return redirect()->route('kelas.index')->with('success', 'Kelas berhasil dihapus.');
    }
    
}
