<?php
  
namespace App\Models;
  
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Casts\Attribute;
  
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
  
    /**
     * The attributes that are mass assignable.
     *
     * @var array

     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role'
    ];
  
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array

     */
    protected $hidden = [
        'password',
        'remember_token',
    ];
  
    /**
     * The attributes that should be cast.
     *
     * @var array

     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
 
    /**
     * @param  integer  $value
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function role(): Attribute
    {
        return new Attribute(
            get: fn ($value) => ["user", "guru", "admin"][$value],
        );
    }
    

    public function kelas()
    {
        return $this->belongsToMany(kelas::class, 'users_kelas', 'user_id', 'kelas_id');
    }
    
    public function pelajarans()
    {
        return $this->belongsToMany(Pelajaran::class, 'guru_mengajars', 'user_id', 'pelajaran_id');
    }
    
    public function soals()
    {
        return $this->belongsTo(soal::class, 'soal_id', 'id');
    }
    public function jawabans()
    {
        return $this->belongsTo(jawaban::class, 'jawaban_id', 'id');
    }
    public function usersJawabans()
    {
        return $this->belongsTo(users_jawaban::class, 'user_jawaban_id', 'id');
    }
    public function usersUjians()
    {
        return $this->belongsTo(usersUjian::class, 'user_ujian_id', 'id');
    }
}