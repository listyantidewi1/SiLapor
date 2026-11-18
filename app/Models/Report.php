<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    // Status yang boleh dituju dari setiap status
    const ALUR = [
        'baru' => ['diproses', 'ditolak'],
        'diproses' => ['selesai'],
        'selesai' => [],
        'ditolak' => [],
    ];

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

    public function bolehKe(string $status): bool
    {
        return in_array($status, self::ALUR[$this->status]);
    }
}
