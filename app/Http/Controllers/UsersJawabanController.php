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
        $cek = Pelajaran::where('kode_akses', $data->kode_akses)->get();
        if ($cek->isNotEmpty()) {
            $infoSoal = Soal::with('user')->count();
            $soal = Soal::with('jawabans')->paginate(1);
            $userId = auth()->id();
            $infoUjian = usersKelas::with(['user', 'kelas'])
            ->where('user_id', $userId)
            ->get();
            $pelajaran = guruMengajar::with('User', 'Pelajarans')
            ->where('user_id', $userId)
            ->get();
            $getSoals = DB::select(DB::raw('select * from soals WHERE pelajaran_id = ? ORDER BY RAND(RAND()) LIMIT 50'), [$cek[0]->id]);
            $insertUjianUserId = DB::table('users_ujians')->insertGetId([
                'user_id' => Auth::id(),
                'pelajaran_id' => $cek[0]->id,
                'kelas_id' => $infoUjian[0]->kelas_id,
                'start_timestamp' => time(),
                'end_timestamp' => time() + ($cek[0]->durasi * 60),
                'is_done' => 0,
            ]);
            foreach($getSoals as $soal){
                DB::insert(DB::raw("INSERT INTO users_jawabans(user_id, soal_id, user_ujian_id) VALUES(?,?,?)"), [
                    Auth::id(), $soal->id, $insertUjianUserId
                ]);
            }

            return view('siswa.ujian.index', compact('infoUjian', 'cek', 'infoSoal', 'soal', 'pelajaran'));
        } else {
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
            $ujians = DB::select(DB::raw("SELECT users_ujians.`id`, users.name, users_ujians.start_timestamp, users_ujians.end_timestamp, pelajarans.pelajaran FROM users_ujians INNER JOIN users ON users.id = users_ujians.user_id INNER JOIN pelajarans ON users_ujians.pelajaran_id = pelajarans.id WHERE users_ujians.user_id IN (?) AND users_ujians.is_done = ? ORDER BY users_ujians.id DESC"), [implode(",", $usersId), 1]);
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
            $information['total_presentase'] = ($totalBenar / sizeof($userSoal)) * 100;
            $wrapper[$ujianKey] = [];
            $wrapper[$ujianKey] = ['information' => $information, 'data' => $data];
        }

        return response()->json([
            "ok" => true,
            "data" => $wrapper
        ]);
    }



    // public function store(Request $request)
    // {
    //     DB::beginTransaction();
    //     try {
    //         $hasil = $request->input('detail_soal');
    //         $soal_ids = Soal::pluck('id')->toArray();
    //         $user = auth()->id();

    //         foreach ($soal_ids as $soal_id) {
    //             $jawaban = jawaban::where('isi_jawaban', $hasil)
    //                 ->where('soal_id', $soal_id)
    //                 ->first();

    //             $user_jawaban = new users_jawaban;
    //             $user_jawaban->user_id = $user;
    //             $user_jawaban->soal_id = $soal_id;

    //             if ($jawaban->is_correct == 1) {
    //                 $user_jawaban->jawaban_id = $jawaban->id;
    //                 $user_jawaban->detail_soal = $hasil;
    //                 $user_jawaban->detail_jawaban = 1;
    //             } else {
    //                 $user_jawaban->jawaban_id = $jawaban->id;
    //                 $user_jawaban->detail_soal = $hasil;
    //                 $user_jawaban->detail_jawaban = 0;
    //             }

    //             $user_jawaban->save();
    //         }

    //         DB::commit(); // Commit the transaction after the loop

    //         return response()->json(true);
    //     } catch (\Throwable $e) {
    //         DB::rollBack();
    //         return response('Error: ' . $e->getMessage(), 500);
    //     }
    // }

}
