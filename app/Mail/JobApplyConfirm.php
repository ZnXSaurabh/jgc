<?php
namespace App\Mail;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class JobApplyConfirm extends Mailable
{
    use Queueable, SerializesModels;
    public $user, $job_id;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, $job_id)
    {
        $this->user = $user;
        $this->job_id = $job_id;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.job-apply')->from('no-reply@jgc.com.sa')->subject('Job Apply Confirmation from JGC Career Portal');
    }
}
