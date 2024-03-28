<?php

namespace App\Http\Controllers;

use App\Models\guruMengajar;
use App\Models\User;
use App\Models\pelajaran;
use Illuminate\Http\Request;

class PelajaranController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $role = 1;

        $users = User::where('role', $role)->get();
        
        $pelajarans = Pelajaran::with('guruMengajars')->whereHas('guruMengajars', function ($query) use ($users) {
            $query->whereIn('user_id', $users->pluck('id'));
        })->paginate(10);

        
        return view('admin.crud_guru.index', compact('pelajarans'));
    }
    
    
    

    /**
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = User::where('role', 1)->pluck('name', 'id');
        return view('admin.crud_guru.create', compact('users'));
    }
    

    public function store(Request $request)
    {
        $data = $request->validate([
            'pelajaran' => 'required',
            'kode_akses' => 'nullable',
        ]);
        
    
        $pelajaran = Pelajaran::create($data);

        $pelajaranId = $pelajaran->id;

        $guru = new guruMengajar();
        $guru->user_id = $request->user_id;
        $guru->pelajaran_id = $pelajaranId; // Use the id obtai
        $guru->save();       
        return redirect()->route('pelajaran.index')->with('success', 'Account berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\pelajaran  $pelajaran
     * @return \Illuminate\Http\Response
     */
    public function show(pelajaran $pelajaran)
    {
        //
    }

    public function edit($id)
    {
        $pelajaran = Pelajaran::find($id);
    
        if (!$pelajaran) {
            return redirect()->back()->with('error', 'Pelajaran tidak ditemukan.');
        }
        return view('admin.crud_guru.edit', compact('pelajaran'));
    }
    
    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'pelajaran' => 'required',
            'kode_akses' => 'nullable',
        ]);
    
        $pelajaran = Pelajaran::find($id);
    
        if (!$pelajaran) {
            return redirect()->back()->with('error', 'Pelajaran tidak ditemukan.');
        }
    
        $pelajaran->update($data);
    
        return redirect()->route('pelajaran.index')->with('success', 'Pelajaran berhasil diperbarui.');
    }
    
    public function destroy($id)
    {
        $pelajaran = Pelajaran::find($id);
    
        if (!$pelajaran) {
            return redirect()->back()->with('error', 'Pelajaran tidak ditemukan.');
        }
    
        $pelajaran->delete();
    
        return redirect()->route('pelajaran.index')->with('success', 'Pelajaran berhasil dihapus.');
    }
}    
