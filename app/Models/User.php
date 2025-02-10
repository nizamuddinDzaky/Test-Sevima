<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'first_name',
        'last_name',
        'name',
        'username'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function getPhotoProfileAttribute()  {
        return MUserConfig::where('user_id', $this->id)
        ->join('m_config', 'm_config.id', '=', 'm_user_config.config_id')
        ->where('m_config.key', 'photo_profile')
        ->whereNull(['m_config.deleted_at', 'm_user_config.deleted_at'])
        ->first()
        ?->value;
    }

    public function getBioAttribute()  {
        return  MUserConfig::where('user_id', $this->id)
        ->join('m_config', 'm_config.id', '=', 'm_user_config.config_id')
        ->where('m_config.key', 'bio')
        ->whereNull(['m_config.deleted_at', 'm_user_config.deleted_at'])
        ->first()
        ?->value;
    }

    public function getEnableCommentAttribute()  {
        return  MUserConfig::where('user_id', $this->id)
        ->join('m_config', 'm_config.id', '=', 'm_user_config.config_id')
        ->where('m_config.key', 'enable_comment')
        ->whereNull(['m_config.deleted_at', 'm_user_config.deleted_at'])
        ->first()
        ?->value;
    }

    public static function validation() {
        return (object) [
            'rules' => [
                'username' => 'required|unique:users,username',
                'email' => 'required|unique:users,email',
                'first_name' => 'required',
                'last_name' => 'required',
                'password' => 'required|confirmed|min:6',
                'password_confirmation' => 'required',
            ],
            'messages' => [
                'username.required' => 'Username Tidak Boleh Kosong',
                'username.unique' => 'Username Telah Terdaftar',
                'email.required' => 'Email Tidak Boleh Kosong',
                'email.unique' => 'Email Telah Terdaftar',
                'first_name.required' => 'First Tidak Boleh Kosong',
                'last_name.required' => 'Last Tidak Boleh Kosong',
                'password.required' => 'Password Tidak Boleh Kosong',
                'password_confirmation.required' => 'Confirm Password Tidak Boleh Kosong'
            ]
        ];
    }
}
