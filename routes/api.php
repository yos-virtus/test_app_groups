<?php

use Illuminate\Http\Request;

Route::apiResource('groups', 'API\GroupController');
Route::apiResource('users', 'API\UserController');
