<?php

use Illuminate\Support\Facades\Artisan;

Artisan::command('meultech:ping', function () {
    $this->comment('Meultech console is ready.');
})->purpose('Simple health check command for the Meultech project');
