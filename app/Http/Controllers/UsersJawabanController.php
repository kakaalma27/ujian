<?php

namespace App\Http\Controllers;

use App\Models\guruMengajar;
use App\Models\Soal;
use App\Models\User;
use App\Models\kelas;
use App\Models\jawaban;

use App\Models\Pelajaran;

use Illuminate\Http\Request;
use App\Models\users_jawaban;
use App\Models\usersKelas;
use App\Models\usersUjian;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class UsersJawabanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    }


    public function ujian(Request $request)
    {
        $data = new users_jawaban();
        $data->kode_akses = $request->input('kode_akses');
        $cek = Pelajaran::where('kode_akses', $data->kode_akses)->first();

        if ($cek) {
            $userId = auth()->id();
            $userUjianCount = DB::table('users_ujians')
            ->where('user_id', $userId)
            ->where('pelajaran_id', $cek['id'])
            ->count();
            if ($userUjianCount > 0) {
                session()->flash('status', "Anda telah melakukan ujian {$cek['pelajaran']}");
                return view('siswa.index');        
        } else {
            $infoSoal = Soal::with('user')->count();
            $soal = Soal::with('jawabans')->paginate(1);
            $userId = auth()->id();
            $infoUjian = usersKelas::with(['user', 'kelas'])
            ->where('user_id', $userId)
            ->get();
            $pelajaran = guruMengajar::with('User', 'Pelajarans')
            ->where('user_id', $userId)
            ->get();
            $getSoals = DB::select(DB::raw('select * from soals WHERE pelajaran_id = ? ORDER BY RAND(RAND()) LIMIT 50'), [$cek->id]);
            $insertUjianUserId = DB::table('users_ujians')->insertGetId([
                'user_id' => Auth::id(),
                'pelajaran_id' => $cek->id,
                'kelas_id' => $infoUjian[0]->kelas_id,
                'start_timestamp' => time(),
                'end_timestamp' => time() + ($cek->durasi * 60),
                'is_done' => 0,
            ]);
            foreach($getSoals as $soal){
                DB::insert(DB::raw("INSERT INTO users_jawabans(user_id, soal_id, user_ujian_id) VALUES(?,?,?)"), [
                    Auth::id(), $soal->id, $insertUjianUserId
                ]);
            }
            session()->flash('status', 'Kode Akses Berhasil, Ujian akan dimulai dalam waktu ');

            $seconds = 5;
            
            while ($seconds > 0) {
                session()->flash('countdown', $seconds);
                sleep(1); 
                $seconds--;
            }            
            return view('siswa.ujian.index', compact('infoUjian', 'cek', 'infoSoal', 'soal', 'pelajaran'));
        }
        } else {
            session()->flash('status', 'Kode Akses Tidak Ditemukan!');
            return view('siswa.index');
        }
    }

    function getUjianDetails(Request $request){
        $ujianId = DB::select(DB::raw("SELECT users_ujians.id, users_ujians.start_timestamp, users_ujians.end_timestamp, pelajarans.pelajaran, kelas.nama_kelas
        FROM users_ujians
        INNER JOIN pelajarans ON users_ujians.pelajaran_id = pelajarans.id
        INNER JOIN kelas ON users_ujians.kelas_id = kelas.id
        WHERE users_ujians.user_id = ? AND users_ujians.is_done = ?
        ORDER BY users_ujians.id DESC"), [Auth::id(), 0]);
        $userSoal = DB::select(DB::raw("SELECT id, user_id, soal_id, jawaban_id, user_ujian_id FROM users_jawabans WHERE user_ujian_id = ? ORDER BY id ASC"), [$ujianId[0]->id]);
        $data = array_fill(0, count($userSoal), 0);
        $information = [];
        $information['start_timestamp'] = (int) $ujianId[0]->start_timestamp;
        $information['end_timestamp'] = (int) $ujianId[0]->end_timestamp;
        $information['jumlah_soal'] = sizeof($userSoal);
        $information['mapel'] = $ujianId[0]->pelajaran;
        $information['kelas'] = $ujianId[0]->nama_kelas;
        foreach($userSoal as $key => $soal){
            $isiSoal = DB::select(DB::raw("SELECT id, isi_soal FROM soals WHERE id = ?"), [$soal->soal_id]);
            $data[$key] = [];
            $data[$key]['ujian_id'] = $ujianId[0]->id;
            $data[$key]['user_jawaban_id'] = $soal->id;
            $data[$key]['soal_id'] = $isiSoal[0]->id;
            $data[$key]['jawaban_id'] = $soal->jawaban_id;
            $data[$key]['isi_soal'] = $isiSoal[0]->isi_soal;

            $jawabanContainer = [];
            $jawabanSoal = DB::select(DB::raw("SELECT id, isi_jawaban, is_correct FROM jawabans WHERE soal_id = ? ORDER BY id ASC"), [$soal->soal_id]);
            foreach($jawabanSoal as $jawaban){
                $jawabanContainer[] = ['jawaban_id' => $jawaban->id, 'isi_jawaban' => $jawaban->isi_jawaban];
            }
            $data[$key]['jawaban'] = $jawabanContainer;
        }

        return response()->json([
            "ok" => true,
            "data" => [
                "information" => $information,
                "form" => $data
            ]
        ]);
    }

    function selesaiUjian(Request $request){
        $ujian = DB::update(DB::raw('UPDATE users_ujians SET is_done = ? WHERE user_id = ? ORDER BY id DESC'), [1, Auth::id()]);
        return response()->json([
            'ok' => true,
            'message' => 'Ujian selesai'
        ]);
    }

    function updateJawabanUser(Request $request){
        $ujianId = DB::select(DB::raw("SELECT `id`, start_timestamp, end_timestamp FROM users_ujians WHERE user_id = ? AND is_done = ? ORDER BY id DESC"), [Auth::id(), 0]);
        if(time() > $ujianId[0]->end_timestamp){
            return response()->json([
                'ok' => false,
                'data' => null,
                'message' => 'waktu ujian berakhir'
            ]);
        }
        $soalUjianUser = DB::update(DB::raw("UPDATE users_jawabans SET jawaban_id = ? WHERE id = ?"), [$request->input("jawaban_id"), $request->input("user_jawaban_id")]);
        return response()->json([
            "ok" => true,
            "data" => null
        ]);
    }

    public function getAllNilaiUjian(Request $request){
        $users = DB::select(DB::raw("SELECT id FROM users WHERE `name` LIKE ?"), ["%".$request->get("name")."%"]);
        $usersId = [];
        for($i = 0; $i < sizeof($users); $i++){
            $usersId[] = $users[$i]->id;
        }
        if(sizeof($usersId) > 0){
            $ujians = DB::select(DB::raw("SELECT users_ujians.`id`, users.name, users_ujians.start_timestamp, users_ujians.end_timestamp, pelajarans.pelajaran FROM users_ujians INNER JOIN users ON users.id = users_ujians.user_id INNER JOIN pelajarans ON users_ujians.pelajaran_id = pelajarans.id WHERE users_ujians.user_id IN (" . implode(",", $usersId) . ") AND users_ujians.is_done = ? ORDER BY users_ujians.id DESC"), [1]);
        }else{
            $ujians = DB::select(DB::raw("SELECT users_ujians.`id`, users.name, users_ujians.start_timestamp, users_ujians.end_timestamp, pelajarans.pelajaran FROM users_ujians INNER JOIN users ON users.id = users_ujians.user_id INNER JOIN pelajarans ON users_ujians.pelajaran_id = pelajarans.id WHERE users_ujians.is_done = ? ORDER BY users_ujians.id DESC"), [1]);
        }
        $wrapper = [];
        foreach($ujians as $ujianKey => $ujian){
            $userSoal = DB::select(DB::raw("SELECT id, user_id, soal_id, jawaban_id, user_ujian_id FROM users_jawabans WHERE user_ujian_id = ? ORDER BY id ASC"), [$ujian->id]);
            $information= [];
            $information['user_name'] = $ujian->name;
            $information['start_timestamp'] = (int) $ujian->start_timestamp;
            $information['end_timestamp'] = (int) $ujian->end_timestamp;
            $information['jumlah_soal'] = sizeof($userSoal);
            $information['mapel'] = $ujian->pelajaran;
            $totalBenar = 0;
            $totalSalah = 0;
            $data = [];
            foreach($userSoal as $key => $soal){
                $isiSoal = DB::select(DB::raw("SELECT id, isi_soal FROM soals WHERE id = ?"), [$soal->soal_id]);
                $data[$key] = [];
                $data[$key]['ujian_id'] = $ujian->id;
                $data[$key]['user_jawaban_id'] = $soal->id;
                $data[$key]['soal_id'] = $isiSoal[0]->id;
                $data[$key]['jawaban_id'] = $soal->jawaban_id;
                $data[$key]['isi_soal'] = $isiSoal[0]->isi_soal;
                $jawabanContainer = [];
                $jawabanSoal = DB::select(DB::raw("SELECT id, isi_jawaban, is_correct FROM jawabans WHERE soal_id = ? ORDER BY id ASC"), [$soal->soal_id]);
                $checkIsCorrect = false;
                foreach($jawabanSoal as $jawaban){
                    $jawabanContainer[] = ['jawaban_id' => $jawaban->id, 'isi_jawaban' => $jawaban->isi_jawaban, 'is_correct' => $jawaban->is_correct];
                    if($jawaban->id == $soal->jawaban_id && $jawaban->is_correct){
                        $checkIsCorrect = true;
                    }
                }
                if($checkIsCorrect){
                    $totalBenar++;
                }else{
                    $totalSalah++;
                }
                $data[$key]['jawaban'] = $jawabanContainer;
            }
            $information['total_benar'] = $totalBenar;
            $information['total_salah'] = $totalSalah;
            if (sizeof($userSoal) > 0) {
                $information['total_presentase'] = ($totalBenar / sizeof($userSoal)) * 100;
            } else {
                $information['total_presentase'] = 0;
            }
            $wrapper[$ujianKey] = [];
            $wrapper[$ujianKey] = ['information' => $information, 'data' => $data];
        }

        return response()->json([
            "ok" => true,
            "data" => $wrapper
        ]);
    }


    public function Hasil()
    {
        return view('siswa.ujian.resultUjian');
    }
}
