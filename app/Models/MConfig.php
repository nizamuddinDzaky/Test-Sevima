<?php
  
namespace App\Models;
  
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MConfig extends Model
{
    use HasFactory, SoftDeletes;
  
    public $table = "m_config";
  
    /**
     * Write code on Method
     *
     * @return response()
     */
    protected $fillable = [
        'key',
        'title',
        'type',
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
}