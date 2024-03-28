<?php

namespace App\Http\Controllers;

use App\Models\format_ujian;
use Carbon\Carbon;
use App\Models\Soal;
use App\Models\User;
use App\Models\kelas;
use App\Models\jawaban;
use App\Models\pelajaran;
use App\Models\usersKelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Auth;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class UjianController extends Controller
{
    public function index()
    {
        $users = auth()->id();
        $pelajarans = Pelajaran::with('guruMengajars')->whereHas('guruMengajars', function ($query) use ($users) {
            $query->whereIn('user_id', [$users]);
        })->get();
    
        $soalAda = [];
        foreach ($pelajarans as $pelajaran) {
            $soalAda[$pelajaran->id] = Soal::where('pelajaran_id', $pelajaran->id)->exists();
        }
        $kelas = Kelas::all();
        $data = format_ujian::all();
        return view('guru.crud_soal.index', compact('pelajarans', 'kelas', 'data', 'soalAda'));
    }
    

    public function create()
    {
        $users = auth()->id();

        $pelajarans = Pelajaran::with('guruMengajars')->whereHas('guruMengajars', function ($query) use ($users) {
            $query->whereIn('user_id', [$users]);
        })->get();

        $kelas = Kelas::all();
        return view('guru.crud_soal.create', compact('pelajarans', 'kelas'));
    }

    public function upload(Request $request)
    {
        DB::beginTransaction();
        try {
            $soalArray = $request->input('data.soal');
            foreach ($soalArray as $soalData) {
                $isiSoalArray = $soalData['isi_soal'];
                foreach ($isiSoalArray as $isiSoal) {
                    $question = Soal::create([
                        'user_id' => auth()->id(),
                        'kelas_id' => $request->input('kelas_id'),
                        'pelajaran_id' => $request->input('pelajaran_id'),
                        'isi_soal' => $isiSoal
                    ]);

                    $jam = intval(request('durasi')); 
                    $menit = intval(request('durasi_menit'));
                    
                    $total_menit = ($jam * 60) + $menit; 
                    
                    
                    $pelajaran_id = $question->pelajaran_id;
                    
                    pelajaran::where('id', $pelajaran_id)->update([
                        'durasi' => $total_menit
                    ]);
                    

                    $jawabanArray = $soalData['isi_jawaban'];
                    $totalJawaban = count($jawabanArray);
    
                    $is_correct_option = $soalData['isi_jawaban_correct'];
    
                    for ($j = 0; $j < $totalJawaban; $j++) {
                        $jawabanData = $jawabanArray[$j];
                        $is_correct = ($is_correct_option == $j) ? 1 : 0;
    
                        Jawaban::create([
                            'soal_id' => $question->id,
                            'isi_jawaban' => $jawabanData,
                            'is_correct' => $is_correct,
                        ]);
                    }
                }
            }
    
            DB::commit();
    
            return response()->json(['message' => 'Data imported successfully'], 200);
        } catch (\Exception $e) {
            DB::rollBack();
    
            return response('Error: ' . $e->getMessage(), 500);
        }
    }
    
    public function uploadExcal(Request $request)
    {
        DB::beginTransaction();

        try {
            $uploadedFile = $request->file('xlsx_file');
    
            $reader = new Xlsx();
            $spreadsheet = $reader->load($uploadedFile);
            $sheets = $spreadsheet->getActiveSheet()->toArray(null, true, true, false);
            array_shift($sheets);
            $idxJawaban = ['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4, 'e' => 5, 'f' => 6, 'g' => 7, 'h' => 8, 'i' => 9, 'j' => 10]; // tambahkan jika pilihan ganda diatas i dengan rumus prefix => i
            foreach($sheets as $sheet){
                $isCorrect = $idxJawaban[trim(strtolower($sheet[count($sheet) - 1]))];
                $question = Soal::create([
                    'user_id' => auth()->id(),
                    'kelas_id' => $request->input('kelas_id'),
                    'pelajaran_id' => $request->input('pelajaran_id'),
                    'isi_soal' => trim($sheet[0]),
                ]);

                $jam = intval(request('durasi')); 
                $menit = intval(request('durasi_menit'));
                $total_menit = ($jam * 60) + $menit; 
                $pelajaran_id = $question->pelajaran_id;
                pelajaran::where('id', $pelajaran_id)->update([
                    'durasi' => $total_menit
                ]);
                foreach($sheet as $key => $jawaban){
                    if($key === 0 || $key === (count($sheet) - 1)){
                        continue;
                    }
                    if($isCorrect === $key){
                        Jawaban::create([
                            'soal_id' => $question->id,
                            'isi_jawaban' => $jawaban, 
                            'is_correct' => 1,
                        ]);
                    }else{
                        Jawaban::create([
                            'soal_id' => $question->id,
                            'isi_jawaban' => $jawaban, 
                            'is_correct' => 0,
                        ]);
                    }
                }
            }
    
            DB::commit();
    
            return response()->json(200);
        } catch (\Exception $e) {
            DB::rollBack();
    
            return response('Error: ' . $e->getMessage(), 500);
        }
    }
    
    public function edit($id)
    {
        try {
            $data = Soal::with('jawabans', 'pelajarans', 'kelas')
                ->where('pelajaran_id', $id)
                ->get();

            return view('guru.crud_soal.edit', compact('data'));
        } catch (\Throwable $e) {
            return response()->json(['success' => false, 'message' => 'Error: ' . $e->getMessage()], 500);
        }
    }
    
    
    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            // Hapus soal dan jawaban yang terkait dengan pelajaran ini
            $deletedSoalIds = Soal::where('pelajaran_id', $id)->pluck('id');
            foreach ($deletedSoalIds as $soalId) {
                DB::table('users_jawabans')->whereIn('jawaban_id', function ($query) use ($soalId) {
                    $query->select('id')->from('jawabans')->where('soal_id', $soalId);
                })->delete();
            }
    
            Jawaban::whereIn('soal_id', $deletedSoalIds)->delete();
            Soal::where('pelajaran_id', $id)->delete();
    
            // Update durasi pelajaran
            $jam = intval($request->input('durasi'));
            $menit = intval($request->input('durasi_menit'));
            $total_menit = ($jam * 60) + $menit;
            $durasi = ($total_menit == 0) ? null : $total_menit;
            Pelajaran::where('id', $id)->update(['durasi' => $durasi]);
    
            // Buat soal dan jawaban baru jika ada data soal yang dikirimkan melalui form
            if ($request->has('soal')) {
                $soalArray = $request->input('soal');
                foreach ($soalArray as $soalData) {
                    $question = Soal::create([
                        'user_id' => auth()->id(),
                        'kelas_id' => $request->input('kelas_id'),
                        'pelajaran_id' => $id,
                        'isi_soal' => $soalData['isi_soal']
                    ]);
    
                    $jawabanArray = $soalData['isi_jawaban'];
                    $totalJawaban = count($jawabanArray);
                    $is_correct_option = $soalData['isi_jawaban_correct'];
    
                    for ($j = 0; $j < $totalJawaban; $j++) {
                        $jawabanData = $jawabanArray[$j];
                        $is_correct = ($is_correct_option == $j) ? 1 : 0;
    
                        Jawaban::create([
                            'soal_id' => $question->id,
                            'isi_jawaban' => $jawabanData,
                            'is_correct' => $is_correct,
                        ]);
                    }
                }
            }
    
            DB::commit();
    
            return response()->json(['message' => 'Data updated successfully'], 200);
        } catch (\Exception $e) {
            DB::rollBack();
    
            return response('Error: ' . $e->getMessage(), 500);
        }
    }
    
    
    public function download($filename)
    {
        $path = public_path('storage/' . $filename);

        return response()->download($path);
    }

    public function template()
    {
        return view('guru.template');
    }
}
