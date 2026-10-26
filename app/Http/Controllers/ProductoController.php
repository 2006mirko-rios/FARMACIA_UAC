<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductoRequest;
use App\Http\Requests\UpdateProductoRequest;
use App\Http\Resources\ProductoResource;
use App\Models\Producto;
use Illuminate\Http\JsonResponse;

class ProductoController extends Controller
{
    public function index(): JsonResponse
    {
        return ProductoResource::collection(
            Producto::with('categoria')->paginate(10)
        )->response();
    }

    public function store(StoreProductoRequest $request): JsonResponse
    {
        return (new ProductoResource(
            Producto::create($request->validated())->load('categoria')
        ))->response()->setStatusCode(201);
    }

    public function show(Producto $producto): JsonResponse
    {
        return (new ProductoResource($producto->load('categoria')))->response();
    }

    public function update(UpdateProductoRequest $request, Producto $producto): JsonResponse
    {
        $producto->update($request->validated());

        return (new ProductoResource(
            $producto->refresh()->load('categoria')
        ))->response();
    }

    public function destroy(Producto $producto): JsonResponse
    {
        if ($producto->movimientos()->exists() || $producto->almacenes()->exists()) {
            return response()->json([
                'message' => 'No se puede eliminar un producto con movimientos o stock asociado.',
            ], 409);
        }

        $producto->delete();

        return response()->json(null, 204);
    }
}
