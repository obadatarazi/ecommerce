<?php

namespace App\Contracts;

interface EmailFactoryInterface
{
    public function createEmail($data): \Illuminate\Mail\Mailable;
}
