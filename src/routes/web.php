<?php

use Illuminate\Support\Facades\Route;
use Inivate\DatatableLaravel\Http\Controllers\DataTableController;

Route::get('datatable/api', [DataTableController::class, 'api'])->name('datatable.api');