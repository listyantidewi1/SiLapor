<?php

namespace App\Policies;

use App\Models\Report;
use App\Models\User;

class ReportPolicy
{
    // Laporan hanya boleh dibuka pemiliknya atau admin
    public function view(User $user, Report $report): bool
    {
        return $user->id === $report->user_id || $user->isAdmin();
    }
}
