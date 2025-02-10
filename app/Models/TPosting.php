<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TPosting extends Model
{
    use HasFactory, SoftDeletes;

    public $table = "t_posting";

    /**
     * Write code on Method
     *
     * @return response()
     */
    protected $fillable = [
        'user_id',
        'image',
        'caption',
        'description'
    ];

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function like()
    {
        return $this->hasMany(TPostingLike::class, 'posting_id');
    }

    public function comments()
    {
        return $this->hasMany(TPostingComment::class, 'posting_id');
    }

    public static function validation() {
        return (object) [
            'rules' => [
                'image' => 'required|image|mimes:jpeg,jpg,png,gif',
                'caption' => 'required|',
            ],
            'messages' => [
                'image.required' => 'Image Tidak Boleh Kosong',
                'image.mimes' => 'Format Tidak Memenuhi',
                'caption.required' => 'Caption Tidak Boleh Kosong',
            ]
        ];
    }
}
