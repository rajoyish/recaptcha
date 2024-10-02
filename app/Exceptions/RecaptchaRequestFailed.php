<?php

namespace App\Exceptions;

use Exception;

class RecaptchaRequestFailed extends Exception
{
    public function render()
    {
        return redirect()->back()->with('status', 'Something went wrong! Please try again');
    }
}
