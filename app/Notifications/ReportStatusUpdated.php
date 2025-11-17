<?php

namespace App\Notifications;

use App\Models\Report;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ReportStatusUpdated extends Notification
{
    use Queueable;
    public $report;

    public function __construct(Report $report)
    {
        $this->report = $report;
    }

    public function via(object $notifiable): array
    {
        // Notifikasi akan disimpan di database (dapat dibaca user/admin)
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'report_id' => $this->report->id,
            'title' => $this->report->title,
            'status' => $this->report->status,
            'feedback' => $this->report->feedback,
            'message' => "Status laporan Anda ({$this->report->title}) telah diperbarui menjadi '{$this->report->status}'."
        ];
    }
}
