<?php

namespace App\Models;

use App\Notifications\LeaveRequestNotification;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Leave extends Model
{
    protected $fillable = [
        'employee_id',
        'leave_type',
        'start_date',
        'end_date',
        'reason',
        'status',
    ];

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

    protected static function booted(): void
    {
        static::created(function (Leave $leave) {
            $user = \App\Models\User::find(1);

            if ($user) {
                $user->notify(
                    new LeaveRequestNotification(
                        $leave->load('employee')
                    )
                );
            }
        });
    }
}
