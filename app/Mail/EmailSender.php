<?php

namespace App\Mail;

use App\Contracts\EmailFactoryInterface;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Mail;

class EmailSender extends Mailable
{
    protected $factory;

    public function __construct(EmailFactoryInterface $factory)
    {
        $this->factory = $factory;
    }

    public function sendEmail($email, $data)
    {
        $mailable = $this->factory->createEmail($data);
        Mail::to($email)->send($mailable);
    }
}
