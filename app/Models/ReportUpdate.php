<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReportUpdate extends Model
{
    const UPDATED_AT = null;

    protected $fillable = ['user_id', 'status', 'note', 'photo'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
