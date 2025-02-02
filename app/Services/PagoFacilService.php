<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class PagoFacilService
{
    protected $client;
    protected $baseUrl;

    protected $accessToken;
    public function __construct()
    {
        $this->client = new Client();
        $this->baseUrl = "https://serviciostigomoney.pagofacil.com.bo/api/";
        $this->accessToken = $this->authenticate();
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
    public function generateQR($data)
    {
        if (!$this->accessToken) {
            return ['error' => 'No se pudo autenticar con PagoFácil'];
        }

        try {
            $response = $this->client->post($this->baseUrl . "servicio/pagoqr", [
                'headers' => [
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Bearer ' . $this->accessToken,
                ],
                'json' => $data,
            ]);

            $responseData = json_decode($response->getBody()->getContents(), true);

            return $responseData;
        } catch (RequestException $e) {
            return ['error' => 'Error al generar el QR', 'message' => $e->getMessage()];
        }
    }
    // 🔹 Método para consultar el estado de la transacción
    public function consultarTransaccion($transaccionDePago)
    {
        try {
            $response = $this->client->post($this->baseUrl . 'servicio/consultartransaccion', [
                'headers' => [
                    'Authorization' => 'Bearer ' . $this->accessToken,
                    'Content-Type' => 'application/json',
                ],
                'json' => [
                    'TransaccionDePago' => $transaccionDePago,
                ],
            ]);

            return json_decode($response->getBody()->getContents(), true);
        } catch (\Exception $e) {
            \Log::error('Error en consultarTransaccion: ' . $e->getMessage());

            return [
                'error' => 1,
                'message' => 'Error al consultar la transacción.',
                'messageSistema' => $e->getMessage(),
            ];
        }
    }
}
