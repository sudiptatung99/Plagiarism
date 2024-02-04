<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Folder extends Model
{
    use HasFactory;

    // protected $fillable = ['id','user_id', 'parent_id', 'name', 'step'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id' );
    }

    public function folder()
    {
        return $this->hasMany(Folder::class, 'parent_id');
    }
    public function document()
    {
        return $this->hasMany(Document::class)->where('is_delete','0');
    }
}
