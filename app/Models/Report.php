<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $fillable = ['category_id', 'title', 'description', 'location'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function updates()
    {
        return $this->hasMany(ReportUpdate::class)->oldest('id');
    }
}
