<?php

namespace App\Http\Controllers;

use App\Models\Movimiento;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Throwable;

class MovimientoController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(
            Movimiento::with(['producto', 'almacen', 'proveedor', 'user'])->paginate(10)
        );
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'producto_id' => ['required', 'integer', 'exists:productos,id'],
            'almacen_id' => ['required', 'integer', 'exists:almacenes,id'],
            'proveedor_id' => ['nullable', 'integer', 'exists:proveedores,id'],
            'user_id' => ['required', 'integer', 'exists:users,id'],
            'tipo' => ['required', 'in:entrada,salida'],
            'cantidad' => ['required', 'integer', 'min:1'],
            'motivo' => ['required', 'string', 'max:255'],
        ]);

        $data['proveedor_id'] ??= null;

        $cacheKey = 'movimientos:store:'.hash('sha256', json_encode($data));

        if (! Cache::add($cacheKey, true, now()->addSeconds(10))) {
            return response()->json([
                'message' => 'Movimiento duplicado detectado.',
            ], 409);
        }

        try {
            $movimiento = Movimiento::create($data);
        } catch (Throwable $exception) {
            Cache::forget($cacheKey);

            throw $exception;
        }

        return response()->json(
            $movimiento->load(['producto', 'almacen', 'proveedor', 'user']),
            201
        );
    }

    public function show(Movimiento $movimiento): JsonResponse
    {
        return response()->json(
            $movimiento->load(['producto', 'almacen', 'proveedor', 'user'])
        );
    }

    public function update(Request $request, Movimiento $movimiento): JsonResponse
    {
        $data = $request->validate([
            'producto_id' => ['sometimes', 'required', 'integer', 'exists:productos,id'],
            'almacen_id' => ['sometimes', 'required', 'integer', 'exists:almacenes,id'],
            'proveedor_id' => ['sometimes', 'nullable', 'integer', 'exists:proveedores,id'],
            'user_id' => ['sometimes', 'required', 'integer', 'exists:users,id'],
            'tipo' => ['sometimes', 'required', 'in:entrada,salida'],
            'cantidad' => ['sometimes', 'required', 'integer', 'min:1'],
            'motivo' => ['sometimes', 'required', 'string', 'max:255'],
        ]);

        $movimiento->update($data);

        return response()->json(
            $movimiento->refresh()->load(['producto', 'almacen', 'proveedor', 'user'])
        );
    }

    public function destroy(Movimiento $movimiento): JsonResponse
    {
        $movimiento->delete();

        return response()->json(null, 204);
    }
}
