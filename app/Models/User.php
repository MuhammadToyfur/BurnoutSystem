<?php
// ========================
// app/Models/User.php
// ========================
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name', 'email', 'nim', 'jurusan', 'angkatan', 'role', 'password',
    ];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function diagnosisSessions()
    {
        return $this->hasMany(DiagnosisSession::class);
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function latestDiagnosis()
    {
        return $this->hasOne(DiagnosisSession::class)->latest();
    }
}
