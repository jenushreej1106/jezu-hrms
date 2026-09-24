<?php

namespace App\Notifications;

use App\Models\Leave;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\DatabaseMessage;
use Illuminate\Notifications\Notification;

class LeaveRequestNotification extends Notification
{
    use Queueable;

    public function __construct(
        public Leave $leave
    ) {
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'title' => 'New Leave Request',
            'message' => ($this->leave->employee?->name ?? 'Employee')
                . ' submitted a '
                . ($this->leave->leave_type ?? 'leave')
                . ' request.',
            'leave_id' => $this->leave->id,
            'employee_id' => $this->leave->employee_id,
            'status' => $this->leave->status,
        ];
    }
}
