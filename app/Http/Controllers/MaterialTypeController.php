<?php

namespace App\Http\Controllers;

use App\Models\MaterialType;
use App\Http\Requests\StoreMaterialTypeRequest;
use App\Http\Requests\UpdateMaterialTypeRequest;

class MaterialTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $materials = MaterialType::all();

        return view('material-types.index', compact('materials'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('material-types.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMaterialTypeRequest $request)
    {
        MaterialType::create($request->validated());

        return redirect()->route('material-types.index')->with('success', 'Material type created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(MaterialType $materialType)
    {
        // Paginate the study materials related to this material type
        $studyMaterials = $materialType->studyMaterials()->get();

        return view('material-types.show', compact('materialType', 'studyMaterials'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MaterialType $materialType)
    {
        return view('material-types.edit', compact('materialType'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMaterialTypeRequest $request, MaterialType $materialType)
    {
        $materialType->update($request->validated());

        return redirect()->route('material-types.index')->with('success', 'Material type updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MaterialType $materialType)
    {
        if ($materialType->studyMaterials()->count() > 0) {
            return back()->withErrors(['name' => 'This material type cannot be deleted because it is associated with study materials.'])->withInput();
        }

        $materialType->delete();

        return redirect()->route('material-types.index')->with('success', 'Material type deleted successfully');
    }
}
