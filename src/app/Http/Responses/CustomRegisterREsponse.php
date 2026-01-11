<?php

namespace App\Http\Responses;

use Laravel\Fortify\Http\Responses\RegisterResponse;

class CustomRegisterREsponse extends RegisterResponse
{
    public function toResponse($request)
    {
        return redirect()->route('verification.notice');
    }
}
