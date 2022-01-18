<?php

namespace Inivate\DatatableLaravel\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Inivate\DatatableLaravel\DatatableApi;

class DataTableController extends Controller {
    public function api(Request $request) {
        request()->validate([
            'order' => 'required',
            'start' => 'required',
            'length' => 'required',
            'model' => 'required',
        ]);
        $dataTable = (new DatatableApi($request))->getData();
        return $dataTable;
    }
}