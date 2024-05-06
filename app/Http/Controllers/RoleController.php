<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;
use Illuminate\Support\Facades\Validator;

class RoleController extends Controller
{
    public function getAllRoles()
    {
        $roles = Role::all();
        return response()->json([
            'status' => 'ok',
            'data' => ['roles' => $roles]
        ], 200);
    }

    public function addRole(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_role' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors(),
                'data' => null
            ], 400);
        }
        try {
            $role = Role::create($request->all());
            return response()->json([
                'success' => true,
                'message' => 'Role Successfully Added',
                'data' => ['role' => $role]
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to add role',
                'error' => $e->getMessage(),
                'data' => null
            ], 500);
        }
    }
    public function editRole(Request $request, $idRole)
    {
        $validator = Validator::make($request->all(), [
            'nama_role' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors(),
                'data' => null
            ], 400);
        }
        try {
            $role = Role::find($idRole);
            if ($role == null) {
                return response()->json([
                    'success' => false,
                    'message' => 'Role Not Found',
                    'data' => null
                ], 404);
            }
            $role->update($request->all());
            return response()->json([
                'success' => true,
                'message' => 'Role Successfully Added',
                'data' => ['role' => $role]
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to add role',
                'error' => $e->getMessage(),
                'data' => null
            ], 500);
        }
    }

    public function deleteRole($idRole)
    {
        try {
            $role = Role::find($idRole);
            if ($role == null) {
                return response()->json([
                    'success' => false,
                    'message' => 'Role Not Found',
                    'data' => null
                ], 404);
            }
            $role->delete();
            return response()->json([
                'success' => true,
                'message' => 'Role Successfully Deleted',
                'data' => ['recipe' => $role]
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete role',
                'error' => $e->getMessage(),
                'data' => null
            ], 500);
        }
    }
}
