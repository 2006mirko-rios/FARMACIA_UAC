<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\JsonResponse;

class CategoriaController extends Controller
{
    public function destroy(Categoria $categoria): JsonResponse
    {
        if ($categoria->productos()->exists() || $categoria->productos()->whereHas('movimientos')->exists()) {
            return response()->json([
                'message' => 'No se puede eliminar una categoría con productos o movimientos vinculados.',
            ], 409);
        }

        $categoria->delete();

        return response()->json(null, 204);
    }
}
