<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class BloodRequestStatusNotification extends Notification
{
    use Queueable;

    public $status;
    public $hospitalName;

    public function __construct($status, $hospitalName)
    {
        $this->status = $status;
        $this->hospitalName = $hospitalName;
    }

    public function via($notifiable)
    {
        return ['database']; // আমরা ডাটাবেসে নোটিফিকেশন সেভ করব
    }

    public function toArray($notifiable)
    {
        return [
            'message' => "Your blood request has been {$this->status} by {$this->hospitalName}.",
            'status' => $this->status,
        ];
    }
}