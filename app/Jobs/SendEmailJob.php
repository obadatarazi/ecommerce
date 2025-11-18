<?php

namespace App\Jobs;

use App\Contracts\EmailFactoryInterface;
use App\Mail\EmailSender;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $receivedEmail;
    protected $data;
    protected $factory;

    /**
     * Create a new job instance.
     */
    public function __construct(EmailFactoryInterface $factory, $receivedEmail, $data)
    {
        $this->receivedEmail = $receivedEmail;
        $this->data = $data;
        $this->factory = $factory;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        $emailSender = new EmailSender($this->factory);
        $emailSender->sendEmail($this->receivedEmail, $this->data);
    }
}
