<?php

namespace App\Http\Controllers\Api\V1;

use App\Company;
use App\Http\Controllers\Controller;
use App\Http\Resources\Company as CompanyResource;
use App\Http\Requests\Admin\StoreCompaniesRequest;
use App\Http\Requests\Admin\UpdateCompaniesRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

use App\Http\Controllers\Traits\FileUploadTrait;


class CompaniesController extends Controller
{
    public function index()
    {
        if (! Gate::allows('company_access')) {
            return abort(401);
        }

        return new CompanyResource(Company::with(['city', 'categories'])->get());
    }

    public function show($id)
    {
        if (! Gate::allows('company_view')) {
            return abort(401);
        }

        $company = Company::with(['city', 'categories'])->findOrFail($id);

        return new CompanyResource($company);
    }

    public function store(StoreCompaniesRequest $request)
    {
        if (! Gate::allows('company_create')) {
            return abort(401);
        }

        $company = Company::create($request->all());
        $company->categories()->sync($request->input('categories', []));
        if ($request->hasFile('logo')) {
            $company->addMedia($request->file('logo'))->toMediaCollection('logo');
        }

        return (new CompanyResource($company))
            ->response()
            ->setStatusCode(201);
    }

    public function update(UpdateCompaniesRequest $request, $id)
    {
        if (! Gate::allows('company_edit')) {
            return abort(401);
        }

        $company = Company::findOrFail($id);
        $company->update($request->all());
        $company->categories()->sync($request->input('categories', []));
        if (! $request->input('uploaded_logo') && $company->getFirstMedia('logo')) {
            $company->getFirstMedia('logo')->delete();
        }
        if ($request->hasFile('logo')) {
            $company->addMedia($request->file('logo'))->toMediaCollection('logo');
        }

        return (new CompanyResource($company))
            ->response()
            ->setStatusCode(202);
    }

    public function destroy($id)
    {
        if (! Gate::allows('company_delete')) {
            return abort(401);
        }

        $company = Company::findOrFail($id);
        $company->delete();

        return response(null, 204);
    }
}
