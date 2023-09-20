<?php

use App\Models\Setting;

if(!function_exists('appSettings')){
    function appSettings($key){
        return Setting::where('key', $key)->first()->value;
    }
}
