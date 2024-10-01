<?php

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;
use Illuminate\Support\Facades\Log;
use App\Models\Bloodreq;

    // Schedule::call(function () {
    //     Bloodreq::where('created_at', '<', now()->subMinute())->delete();
    //     Log::info('Deleted all bloodreqs!');
    // })->weekly();
