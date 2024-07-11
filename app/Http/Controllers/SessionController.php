<?php

namespace App\Http\Controllers;

use App\Http\Requests\SetAccountIdRequest;
use App\Services\SessionService;

class SessionController extends Controller
{
    private $sessionService;

    public function __construct(SessionService $sessionService)
    {
        $this->sessionService = $sessionService;
    }

    public function setSelectedAccount(SetAccountIdRequest $request)
    {
        return $this->sessionService->setSelectedAccount($request);
    }
}
