<?php

namespace App\Repositories\V1\Admin;

use App\Interfaces\SettingRepositoryInterface;
use App\Models\Setting;

class SettingRepository implements SettingRepositoryInterface
{
    public function index()
    {
        $settings = Setting::paginate(15);

        return $settings;
    }

    public function show($id)
    {
        $setting = Setting::findOrFail($id);

        return $setting;
    }

    public function store($request)
    {
        $setting = Setting::create($request);

        return $setting;
    }

    public function update($id, $request)
    {
        $setting = Setting::findOrFail($id);
        $setting->update($request);

        return $setting;
    }

    public function destroy($id)
    {
        $setting = Setting::findOrFail($id);

        return $setting->delete();
    }

}
