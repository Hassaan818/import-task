<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Import extends Model
{
    protected $fillable = [
        'user_id',
        'source',
        'sheet_id',
        'file_id',
        'status',
        'total_rows',
        'processed_rows',
        'error_message',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
