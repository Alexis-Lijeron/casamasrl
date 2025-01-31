<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class PagoFacilService
{
    protected $client;
    protected $baseUrl;

    public function __construct()
    {
        $this->client = new Client();
        $this->baseUrl = "https://serviciostigomoney.pagofacil.com.bo/api/";
    }

    public function authenticate()
    {
        try {
            $response = $this->client->post($this->baseUrl . "servicio/login", [
                'headers' => [
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                ],
                'json' => [
                    'TokenService' => env('PAGOFACIL_TOKEN_SERVICE'),
                    'TokenSecret' => env('PAGOFACIL_TOKEN_SECRET'),
                ],
            ]);

            $data = json_decode($response->getBody()->getContents(), true);

            if (isset($data['values'])) {
                return $data['values']; // Retornamos el AccessToken
            }

            return null;
        } catch (RequestException $e) {
            return ['error' => 'Error en la autenticación', 'message' => $e->getMessage()];
        }
    }
}
