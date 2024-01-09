<?php

namespace App\Http\Controllers;

use App\Models\kelas;
use App\Models\User;

use App\Models\usersKelas;
use Illuminate\Http\Request;

class UsersKelasController extends Controller
{
    public function create()
    {
        $kelas = Kelas::all();
        $value = 0;
        $users = User::where('role', $value)->get();
    
        $selectedUserIds = session('selectedUserIds', []);
        return view('admin.crud_kelas.crud_anggota.create', compact('kelas', 'users', 'selectedUserIds'));
    }

    
    public function upload(Request $request)
    {
        $kelas_id = $request->kelas_id;
        $user_ids = $request->user_ids;
    
        if (is_array($user_ids)) {
            foreach ($user_ids as $user_id) {
                $existingKelas = usersKelas::where('user_id', $user_id)->first();
    
                if (!$existingKelas) {
                    $userKelas = new usersKelas();
                    $userKelas->kelas_id = $kelas_id;
                    $userKelas->user_id = $user_id;
                    $userKelas->save();
                } else {
                    return redirect()->back()->withErrors(['error' => 'User with ID ' . $user_id . ' already has a class.']);
                }
            }
    
            return redirect()->route('kelas.index')->with('success', 'Data uploaded successfully');
        } else {
            return redirect()->back()->withErrors(['error' => 'Invalid data provided']);
        }
    }

    public function edit($id)
    {
        $kelas = Kelas::find($id);
        if (!$kelas) {
            return redirect()->back()->withErrors(['error' => 'Kelas not found']);
        }
    
        $users = User::where('role', 0)->get();
        $selectedUserIds = usersKelas::where('kelas_id', $id)->pluck('user_id')->toArray();
        return view('admin.crud_kelas.crud_anggota.edit', compact('kelas', 'users', 'selectedUserIds'));
    }
    
    
    public function update(Request $request, $id)
    {
        $kelas = Kelas::findOrFail($id);
        $kelas->id = $request->kelas_id;
        $kelas->save();
    
        // Delete existing userKelas records for the given kelas
       usersKelas::where('kelas_id', $id)->delete();
        // Create new userKelas records based on the selected user_ids
        foreach ($request->user_ids as $user_id) {
            $userKelas = new usersKelas();
            $userKelas->kelas_id = $kelas->id;
            $userKelas->user_id = $user_id;
            $userKelas->save();
        }
    
        return redirect()->route('kelas.index')->with('success', 'Data updated successfully');
    }
    

        public function destroy($id)
    {
        $kelas = Kelas::findOrFail($id);
        $kelas->delete();

        return redirect()->route('kelas.index')->with('success', 'Data deleted successfully');
    }

}    
