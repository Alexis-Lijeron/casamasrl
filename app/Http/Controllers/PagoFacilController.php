<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\PagoFacilService;

class PagoFacilController extends Controller
{
    protected $pagoFacilService;

    public function __construct(PagoFacilService $pagoFacilService)
    {
        $this->pagoFacilService = $pagoFacilService;
    }

    public function authenticate()
    {
        $accessToken = $this->pagoFacilService->authenticate();

        if (!$accessToken) {
            return response()->json(['error' => 'No se pudo autenticar con PagoFácil'], 401);
        }

        return response()->json(['access_token' => $accessToken]);
    }
}
