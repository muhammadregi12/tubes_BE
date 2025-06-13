<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\arisan_group;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ArisanGroupController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 10);
        $search = $request->input('search');

        $query = arisan_group::query();

        if ($search) {
            $query->where('name', 'like', "%{$search}%");
        }

        $arisanGroups = $query->paginate($perPage);

        return response()->json([
            'status' => 'success',
            'data' => $arisanGroups->items(),
            'meta' => [
                'current_page' => $arisanGroups->currentPage(),
                'last_page' => $arisanGroups->lastPage(),
                'per_page' => $arisanGroups->perPage(),
                'total' => $arisanGroups->total()
            ]
        ]);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'amount' => 'required|integer',
            'duration' => 'required|string',
            'start_date' => 'required|date',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()
            ], 422);
        }

        $arisanGroups = new arisan_group();
        $arisanGroups->name = $request->name;
        $arisanGroups->code = hexdec(uniqid());
        $arisanGroups->amount = $request->amount;
        $arisanGroups->duration = $request->duration;
        $arisanGroups->start_date = $request->start_date;
        $arisanGroups->end_date = $request->end_date;
        $arisanGroups->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Arisan Group created successfully',
            'data' => $arisanGroups
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return response()->json([
            'status' => 'success',
            'data' => $id
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, arisan_group $arisanGroup)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'amount' => 'required|integer',
            'duration' => 'required|string',
            'start_date' => 'required|date',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()
            ], 422);
        }

        if ($request->has('name')) {
            $arisanGroup->name = $request->name;
        }

        if ($request->has('amount')) {
            $arisanGroup->amount = $request->amount;
        }

        if ($request->has('duration')) {
            $arisanGroup->duration = $request->duration;
        }

        if ($request->has('start_date')) {
            $arisanGroup->start_date = $request->start_date;
        }

        $arisanGroup->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Category updated successfully',
            'data' => $arisanGroup
        ], 200);


    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(arisan_group $arisanGroup)
    {
        $arisanGroup->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Category deleted successfully'
        ], 200);
    }
}
