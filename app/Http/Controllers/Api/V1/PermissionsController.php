<?php

namespace App\Http\Controllers\Api\V1;

use App\Permission;
use App\Http\Controllers\Controller;
use App\Http\Resources\Permission as PermissionResource;
use App\Http\Requests\Admin\StorePermissionsRequest;
use App\Http\Requests\Admin\UpdatePermissionsRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;



class PermissionsController extends Controller
{
    public function index()
    {
        if (! Gate::allows('permission_access')) {
            return abort(401);
        }

        return new PermissionResource(Permission::with([])->get());
    }

    public function show($id)
    {
        if (! Gate::allows('permission_view')) {
            return abort(401);
        }

        $permission = Permission::with([])->findOrFail($id);

        return new PermissionResource($permission);
    }

    public function store(StorePermissionsRequest $request)
    {
        if (! Gate::allows('permission_create')) {
            return abort(401);
        }

        $permission = Permission::create($request->all());
        
        

        return (new PermissionResource($permission))
            ->response()
            ->setStatusCode(201);
    }

    public function update(UpdatePermissionsRequest $request, $id)
    {
        if (! Gate::allows('permission_edit')) {
            return abort(401);
        }

        $permission = Permission::findOrFail($id);
        $permission->update($request->all());
        
        
        

        return (new PermissionResource($permission))
            ->response()
            ->setStatusCode(202);
    }

    public function destroy($id)
    {
        if (! Gate::allows('permission_delete')) {
            return abort(401);
        }

        $permission = Permission::findOrFail($id);
        $permission->delete();

        return response(null, 204);
    }
}
