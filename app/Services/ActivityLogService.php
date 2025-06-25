<?php

namespace App\Services;

use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;

class ActivityLogService
{
    /**
     * Mencatat aktivitas pengguna.
     *
     * @param  string  $action  Tindakan yang dilakukan (misalnya 'Create', 'Update', 'Delete')
     * @param  string  $model  Nama model yang terpengaruh
     * @param  mixed  $data  Data yang terkait dengan tindakan (opsional)
     * @return void
     */
    public function logActivity($action, $model, $data = null)
    {
        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => $action,
            'model' => $model,
            'data' => $data ? json_encode($data) : null,
        ]);
    }
}
