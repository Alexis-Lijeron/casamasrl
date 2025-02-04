<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\PagoFacilService;
use App\Models\Pago;

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

    public function generateQR(Request $request)
    {
        try {
            // Intentamos validar la solicitud
            $validatedData = $request->validate([
                'tcCommerceID' => 'required|string',
                'tcNroPago' => 'required|string',
                'tcNombreUsuario' => 'required|string',
                'tnCiNit' => 'required|integer',
                'tnTelefono' => 'required|integer',
                'tcCorreo' => 'required|email',
                'tcCodigoClienteEmpresa' => 'required|string',
                'tnMontoClienteEmpresa' => 'required|numeric',
                'tnMoneda' => 'required|integer',
                'tcUrlCallBack' => 'required|url',
                'tcUrlReturn' => 'required|url',
                'taPedidoDetalle' => 'required|array',
            ]);

            $response = $this->pagoFacilService->generateQR($validatedData);

            return response()->json($response);
        } catch (\Illuminate\Validation\ValidationException $e) {
            // 🔹 Retornamos los errores específicos de validación
            return response()->json([
                'error' => 1,
                'message' => 'Error en la validación de datos',
                'details' => $e->errors()  // Muestra los errores exactos
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 1,
                'message' => 'Error interno en el servidor',
                'details' => $e->getMessage()
            ], 500);
        }
    }
    // 🔹 Método para consultar el estado de una transacción
    public function consultarTransaccion(Request $request)
    {
        $validatedData = $request->validate([
            'transaccionDePago' => 'required|string',
        ]);

        try {
            $result = app('App\Services\PagoFacilService')->consultarTransaccion($validatedData['transaccionDePago']);

            if (!isset($result['values'])) {
                return response()->json([
                    'error' => 1,
                    'message' => 'No se encontraron datos de la transacción.',
                    'messageSistema' => $result['message'] ?? 'Respuesta inválida del servidor de PagoFácil',
                ], 500);
            }

            return response()->json($result);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 1,
                'message' => 'Error al verificar la transacción.',
                'details' => $e->getMessage(),
            ], 500);
        }
    }

    public function actualizarEstadoPago(Request $request)
    {
        $validatedData = $request->validate([
            'idPago' => 'required|integer',
            'estadoTransaccion' => 'required|string',
        ]);

        try {
            // Validar que el estado de la transacción contenga "COMPLETADO - PROCESADO"
            if (!str_contains($validatedData['estadoTransaccion'], 'COMPLETADO - PROCESADO')) {
                return response()->json([
                    'error' => 1,
                    'message' => 'El estado de la transacción no es válido para actualizar el pago.',
                ], 400);
            }

            $pago = Pago::findOrFail($validatedData['idPago']);
            $pago->estado = 1; // Pagado
            $pago->metodo_pago_id = 2; // QR
            $pago->save();

            return response()->json([
                'error' => 0,
                'message' => 'El estado del pago y el método de pago se han actualizado correctamente.',
            ]);
        } catch (\Exception $e) {
            \Log::error('Error al actualizar el estado del pago: ' . $e->getMessage());

            return response()->json([
                'error' => 1,
                'message' => 'Error al actualizar el estado del pago.',
                'details' => $e->getMessage(),
            ], 500);
        }
    }
}
