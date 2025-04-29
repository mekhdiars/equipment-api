<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Equipment\IndexRequest;
use App\Http\Requests\Equipment\StoreRequest;
use App\Http\Requests\Equipment\UpdateRequest;
use App\Http\Resources\EquipmentCollection;
use App\Http\Resources\EquipmentResource;
use App\Models\Equipment;
use Illuminate\Http\Response;

class EquipmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(IndexRequest $request): EquipmentCollection
    {
        $validated = $request->validated();

        $equipments = Equipment::with('type')
            ->serialNumber($validated['serial_number'])
            ->note($validated['note'])
            ->typeName($validated['type_name'])
            ->paginate($validated['per_page']);

        return new EquipmentCollection($equipments);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request): EquipmentResource
    {
        $equipment = Equipment::create($request->validated());
        return new EquipmentResource($equipment->load('equipmentType'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Equipment $equipment): EquipmentResource
    {
        return new EquipmentResource($equipment->load('type'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, Equipment $equipment): EquipmentResource
    {
        $equipment->update($request->validated());
        return new EquipmentResource($equipment->load('type'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Equipment $equipment): Response
    {
        $equipment->delete();
        return response()->noContent();
    }
}
