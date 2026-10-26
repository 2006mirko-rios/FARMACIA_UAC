<?php

namespace App\Http\Controllers;

use App\Models\Almacen;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AlmacenController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(Almacen::paginate(10));
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'nombre' => ['required', 'string', 'max:100'],
            'ubicacion' => ['required', 'string', 'max:150'],
        ]);

        return response()->json(Almacen::create($data), 201);
    }

    public function show(Almacen $almacen): JsonResponse
    {
        return response()->json($almacen);
    }

    public function update(Request $request, Almacen $almacen): JsonResponse
    {
        $data = $request->validate([
            'nombre' => ['sometimes', 'required', 'string', 'max:100'],
            'ubicacion' => ['sometimes', 'required', 'string', 'max:150'],
        ]);

        $almacen->update($data);

        return response()->json($almacen->refresh());
    }

    public function destroy(Almacen $almacen): JsonResponse
    {
        if ($almacen->movimientos()->exists() || $almacen->productos()->exists()) {
            return response()->json([
                'message' => 'No se puede eliminar un almacén con movimientos o stock asociado.',
            ], 409);
        }

        $almacen->delete();

        return response()->json(null, 204);
    }
}
