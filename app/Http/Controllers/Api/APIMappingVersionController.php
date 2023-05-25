<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\MappingVersion\APIMappingVersionFormRequest;
use App\Models\Mapping\MappingVersion;

class APIMappingVersionController extends Controller
{
    /**
     * @param APIMappingVersionFormRequest $request
     * @param MappingVersion $mappingVersion
     * @return MappingVersion
     */
    public function store(APIMappingVersionFormRequest $request, MappingVersion $mappingVersion): MappingVersion
    {
        $updateResult = $mappingVersion->update($request->validated());

        if (!$updateResult) {
            abort(500);
        }

        return $mappingVersion;
    }
}
