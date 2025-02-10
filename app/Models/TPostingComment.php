<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TPostingComment extends Model
{
    use HasFactory, SoftDeletes;

    public $table = "t_posting_comment";

    /**
     * Write code on Method
     *
     * @return response()
     */
    protected $fillable = [
        'user_id',
        'posting_id',
        'comment'
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
    public static function validation() {
        return (object) [
            'rules' => [
                'comment' => 'required|',
            ],
            'messages' => [
                'comment.required' => 'Comment Tidak Boleh Kosong',
            ]
        ];
    }
}
