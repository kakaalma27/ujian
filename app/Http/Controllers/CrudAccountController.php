<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\kelas;
use App\Models\pelajaran;
use App\Models\users_kelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CrudAccountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $selectedRole = $request->input('listRole');
    
        $query = User::query();
    
        if ($selectedRole !== null) {
            $query->where('role', $selectedRole);
    
            if ($selectedRole == 0) {

            } elseif ($selectedRole == 1) {

            }
        }
    
        $accounts = $query->get();

        return view('admin.crud_admin.index', [
            'accounts' => $accounts,
            'selectedRole' => $selectedRole,
        ]);
    }
    
    
    
    
    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       
        return view('admin.crud_admin.create');
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
    
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'role' => array_search($request->role, ['user', 'editor', 'admin']),
            ]);
    
            DB::commit();
    
            return redirect()->route('account.index')->with('success', 'Account berhasil ditambahkan.');
        } catch (\Exception $e) {
            DB::rollback();
    
            return redirect()->route('account.index')->with('error', 'Gagal menambahkan akun.');
        }
    }
    
    

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CrudAccount  $crudAccount
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CrudAccount  $crudAccount
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
{
    $user = User::find($id);

    if (!$user) {
        return redirect()->back()->with('error', 'User tidak ditemukan.');
    }

    return view('admin.crud_admin.edit', compact('user'));
}

public function update(Request $request, $id)
{
    $data = $request->validate([
        'name' => 'required',
        'email' => 'required|email',
        'password' => 'nullable|min:8',
        'role' => 'required|in:user,editor,admin',
    ]);

    $user = User::find($id);

    if (!$user) {
        return redirect()->back()->with('error', 'User tidak ditemukan.');
    }

    if ($request->filled('password')) {
        $data['password'] = bcrypt($request->password);
    } else {
        unset($data['password']);
    }

    $data['role'] = array_search($request->role, ['user', 'editor', 'admin']);

    $user->update($data);

    return redirect()->route('account.index')->with('success', 'Akun berhasil diperbarui.');
}

public function destroy($id)
{
    $user = User::find($id);

    if (!$user) {
        return redirect()->back()->with('error', 'User tidak ditemukan.');
    }

    $user->delete();

    return redirect()->route('account.index')->with('success', 'Akun berhasil dihapus.');
}

}
