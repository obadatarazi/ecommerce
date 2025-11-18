<?php

namespace App\Factories\Email;

use App\Contracts\EmailFactoryInterface;
use App\Mail\SendAnswerShariaQuestion;

class AnswerShariaQuestionEmailFactory implements EmailFactoryInterface
{

    public function createEmail($data): \Illuminate\Mail\Mailable
    {
        return new SendAnswerShariaQuestion($data);
    }
}
