<?php

use App\Http\Controllers\Project\ProjectController;
use Illuminate\Support\Facades\Route;

Route::apiResource('projects', ProjectController::class);
