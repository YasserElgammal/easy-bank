<?php

namespace App\Http\Controllers\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\SettingRequest;
use App\Http\Resources\V1\SettingResource;
use App\Interfaces\SettingRepositoryInterface;

class SettingController extends Controller
{
    public function __construct(private SettingRepositoryInterface $settingRepository)
    {
    }

    public function index()
    {
        $settings = $this->settingRepository->index();

        return $this->successReponse(data: SettingResource::collection($settings));
    }

    public function store(SettingRequest $request)
    {
        $this->settingRepository->store($request->validated());

        return $this->successReponse(message: trans('app.record_added'));
    }

    public function show($id)
    {
        $setting = $this->settingRepository->show($id);

        return $this->successReponse(data: SettingResource::make($setting));
    }

    public function update($id, SettingRequest $request)
    {
        $setting = $this->settingRepository->update($id, $request->validated());

        return $this->successReponse(message: trans('app.record_updated'));
    }

    public function destroy($id)
    {
        $this->settingRepository->destroy($id);

        return $this->successReponse(message: trans('app.record_deleted'));
    }
}
