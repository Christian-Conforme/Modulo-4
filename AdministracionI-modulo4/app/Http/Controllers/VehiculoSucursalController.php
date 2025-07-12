<?php

namespace App\Http\Controllers;

use App\Models\VehiculoSucursal;
use App\Http\Requests\StoreVehiculoSucursalRequest;
use App\Http\Requests\UpdateVehiculoSucursalRequest;

class VehiculoSucursalController extends Controller
{
    /**
     * Listar todas las relaciones vehículo-sucursal.
     *
     * @group VehiculoSucursal
     * @authenticated
     * @response 200 scenario="Listado de relaciones" [
     *   {
     *     "id": 1,
     *     "vehiculo_id": 1,
     *     "sucursal_id": 2,
     *     "fecha_ingreso": "2024-07-01"
     *   }
     * ]
     */
    public function index()
    {
        return response()->json(VehiculoSucursal::all());
    }

    /**
     * Crear una nueva relación vehículo-sucursal.
     *
     * @group VehiculoSucursal
     * @authenticated
     * @bodyParam vehiculo_id int required ID del vehículo. Example: 1
     * @bodyParam sucursal_id int required ID de la sucursal. Example: 2
     * @bodyParam fecha_ingreso date required Fecha de ingreso. Example: 2024-07-01
     * @response 201 scenario="Relación creada" {
     *   "id": 2,
     *   "vehiculo_id": 1,
     *   "sucursal_id": 2,
     *   "fecha_ingreso": "2024-07-01"
     * }
     * @response 422 scenario="Campos inválidos o faltantes" {
     *   "message": "Campos inválidos o faltantes",
     *   "errors": {
     *     "vehiculo_id": {"El campo vehiculo_id es obligatorio."}
     *   }
     * }
     */
    public function store(StoreVehiculoSucursalRequest $request)
    {
        $relacion = VehiculoSucursal::create($request->validated());
        return response()->json($relacion, 201);
    }

    /**
     * Mostrar una relación vehículo-sucursal específica.
     *
     * @group VehiculoSucursal
     * @authenticated
     * @urlParam id int required El ID de la relación.
     * @response 200 scenario="Relación encontrada" {
     *   "id": 1,
     *   "vehiculo_id": 1,
     *   "sucursal_id": 2,
     *   "fecha_ingreso": "2024-07-01"
     * }
     * @response 404 scenario="Relación no encontrada" {
     *   "message": "Relación no encontrada"
     * }
     */

    public function show($id)
    {
        try {
            $vehiculoSucursal = VehiculoSucursal::findOrFail($id);
            return response()->json($vehiculoSucursal);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Vehiculo con Sucursal no encontrado'
            ], 404);
        }
    }

    /**
     * Actualizar una relación vehículo-sucursal.
     *
     * @group VehiculoSucursal
     * @authenticated
     * @urlParam id int required El ID de la relación.
     * @bodyParam vehiculo_id int ID del vehículo. Example: 1
     * @bodyParam sucursal_id int ID de la sucursal. Example: 2
     * @bodyParam fecha_ingreso date Fecha de ingreso. Example: 2024-07-01
     * @response 200 scenario="Relación actualizada" {
     *   "id": 1,
     *   "vehiculo_id": 1,
     *   "sucursal_id": 2,
     *   "fecha_ingreso": "2024-07-01"
     * }
     * @response 422 scenario="Campos inválidos o faltantes" {
     *   "message": "Campos inválidos o faltantes",
     *   "errors": {
     *     "vehiculo_id": {"El campo vehiculo_id es obligatorio."}
     *   }
     * }
     */
    public function update(UpdateVehiculoSucursalRequest $request, VehiculoSucursal $vehiculoSucursal)
    {
        $vehiculoSucursal->update($request->validated());
        return response()->json([
            'message' => 'Vehiculo con Sucursal actualizado',
            'vehiculo_sucursal' => $vehiculoSucursal
        ], 200);
    }

    /**
     * Eliminar una relación vehículo-sucursal.
     *
     * @group VehiculoSucursal
     * @authenticated
     * @urlParam id int required El ID de la relación.
     * @response 204 scenario="Relación eliminada" {}
     * @response 404 scenario="Relación no encontrada" {
     *   "message": "Relación no encontrada"
     * }
     */
    public function destroy(VehiculoSucursal $vehiculoSucursal)
    {
        $vehiculoSucursal->delete();
        return response()->json([
            'message' => 'Vehiculo con Sucursal eliminado'
        ], 200);
    }
}