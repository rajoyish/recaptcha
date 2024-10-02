<?php

namespace App\Exceptions;

use Exception;

class RecaptchaVerificationFailed extends Exception
{
    public function render()
    {
        return redirect()->back()->with('status', 'reCaptcha Failed! Please try again');
    }
}
