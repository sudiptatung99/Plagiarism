<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'folder_id', 'name', 'type',
    'isDoc','text','is_index', 'is_delete','doc_id','doc_status',
    'report_url','originality','inTextCount','outTextCount','outSentenceCount','inSentenceCount','inDeductDocument','outDeductDocument','doc_text'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function folder()
    {
        return $this->belongsTo(Folder::class, 'folder_id', 'id');
    }
}
