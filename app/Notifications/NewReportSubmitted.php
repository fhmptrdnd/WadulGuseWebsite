<?php

namespace App\Notifications;

use App\Models\Report;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewReportSubmitted extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     *
     * @var \App\Models\Report
     */
    public $report;

    /**
     *
     * @param \App\Models\Report $report
     * @return void
     */
    public function __construct(Report $report)
    {
        $this->report = $report;
    }

    /**
     * Admin akan menerima notifikasi melalui database (notifikasi di aplikasi) dan email.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database', 'mail'];
    }

    /**
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject('Laporan Baru Telah Diterima - #' . $this->report->id)
                    ->greeting('Halo Admin,')
                    ->line('Sebuah laporan baru dengan judul "' . $this->report->title . '" telah diterima dan menunggu tindakan Anda.')
                    ->line('Kategori: ' . $this->report->category)
                    ->action('Lihat Detail Laporan', url('/dashboard'))
                    ->line('Terima kasih atas kerja keras Anda!');
    }

    /**
     * Mendapatkan representasi notifikasi dalam bentuk array database.
     *
     * @param  mixed
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'report_id' => $this->report->id,
            'user_id' => $this->report->user_id,
            'title' => $this->report->title,
            'message' => 'Laporan baru "' . $this->report->title . '" telah dibuat oleh ' . $this->report->user->name . '.',
            'created_at' => now(),
        ];
    }
}
