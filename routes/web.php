<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\UjianController;
use App\Http\Controllers\PelajaranController;
use App\Http\Controllers\UsersKelasController;
use App\Http\Controllers\CrudAccountController;
use App\Http\Controllers\FormatUjianController;
use App\Http\Controllers\ResultUjianController;
use App\Http\Controllers\UsersJawabanController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

Route::middleware(['auth'])->group(function()
{
    Route::get("/get-nilai-ujian", [UsersJawabanController::class, 'getAllNilaiUjian']);
});

Route::middleware(['auth','user-role:user'])->group(function()
{
    Route::get("/home",[HomeController::class, 'userHome'])->name("home");
    Route::post("/siswa/kode-akses", [UsersJawabanController::class, 'kodeAkses'])->name("siswa.akses");
    Route::post("/siswa/ujian", [UsersJawabanController::class, 'ujian'])->name("siswa.ujian");
    Route::get("/get-ujian-details",[UsersJawabanController::class, 'getUjianDetails']);
    Route::post("/update-ujian-details",[UsersJawabanController::class, 'updateJawabanUser']);
    Route::get("/selesai-ujian", [UsersJawabanController::class, 'selesaiUjian']);
});
// Route Editor
Route::middleware(['auth','user-role:guru'])->group(function()
{
    Route::get("/guru/home",[HomeController::class, 'guruHome'])->name("guru.home");
    Route::get("/guru/ujian", [UjianController::class, 'index'])->name("guru.ujian");
    Route::post("/guru/upload", [UjianController::class, 'upload'])->name("guru.upload");
    Route::get("/guru/create", [UjianController::class, 'create'])->name("guru.create");
    Route::get('/guru/excel/download/{id}', [FormatUjianController::class, 'download'])->name('guru.excel.download');
    Route::post("/guru/uploadExcal", [UjianController::class, 'uploadExcal'])->name("guru.uploadExcal");
    Route::get("/guru/template", [UjianController::class, 'template'])->name("guru.template");
    // Route::get("/guru/editSoal", [UjianController::class, 'editSoal'])->name("guru.editSoal");

    Route::get("/guru/HasilUjian/{id}", [ResultUjianController::class, 'index'])->name("guru.hasilUjian");

    Route::get('/guru/ujian/edit/{id}', [UjianController::class, 'edit'])->name('guru.ujian.edit');
    Route::put('/guru/ujian/update/{id}', [UjianController::class, 'update'])->name('guru.ujian.update');
    Route::delete('/guru/ujian/delete/{id}', [UjianController::class, 'destroy'])->name('guru.ujian.destroy');
});
// Route Admin
Route::middleware(['auth','user-role:admin'])->group(function()
{
    Route::get("/admin/home",[HomeController::class, 'adminHome'])->name("admin.home");
    Route::resource('/admin/account', CrudAccountController::class);
    Route::resource('/admin/pelajaran', PelajaranController::class);
    Route::resource('/admin/kelas', KelasController::class);
    Route::get("/admin/anggota",[UsersKelasController::class, 'create'])->name("admin.anggota");
    Route::post("/admin/upload",[UsersKelasController::class, 'upload'])->name("admin.upload");
    Route::get("/admin/anggota/{id}/edit", [UsersKelasController::class, 'edit'])->name("admin.anggota.edit");
    Route::put("/admin/anggota/{id}", [UsersKelasController::class, 'update'])->name("admin.anggota.update");
    Route::delete("/admin/anggota/{id}", [UsersKelasController::class, 'destroy'])->name("admin.anggota.destroy");
    Route::get('/admin/excel', [FormatUjianController::class, 'index'])->name('admin.excel.index');
    Route::get('/admin/excel/create', [FormatUjianController::class, 'create'])->name('admin.excel.create');
    Route::post('/admin/excel/store', [FormatUjianController::class, 'store'])->name('admin.excel.store');
    Route::get('/admin/excel/download/{id}', [FormatUjianController::class, 'download'])->name('admin.excel.download');
    Route::delete('/admin/excel/destroy/{id}', [FormatUjianController::class, 'destroy'])->name('admin.excel.destroy');

});
