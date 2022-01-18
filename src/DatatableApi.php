<?php

namespace Inivate\DatatableLaravel;

use Illuminate\Support\Facades\Schema;

class DatatableApi {

    private $request;
    private $start;
    private $length;
    private $model;
    private $sort;
    private $search;
    private $sortDirection;
    private $sortBy;
    private $totalCount;
    private $sortColumns = [];
    private $searchColumns = [];
    private $withModel;
    private $modelName;

    function __construct($request) {
        $this->request = $request;
        $this->getColumns();
        $this->getModel();
        $this->sort = $this->request['order'][0]['column'];
        $this->search = $this->request['search']['value'];
        $this->sortDirection = $this->request['order'][0]['dir'];
        $this->start = $this->request['start'];
        $this->length = $this->request['length'];
        $this->sortBy = $this->sortColumns[$this->sort];
        $this->totalCount = $this->model->count();
        // dd($this->sortBy);
    }
    public function getData() {
        $page = $this->getPage();
        $modelData = $this->getModelData();

        $filtered = $this->totalCount;
        if ($this->search) {
            $filtered = $modelData->count();
        }

        $modelData = $modelData->paginate($this->length, ['*'], 'page', $page);
        if ($this->request['resource']) {
            $resourceName = str_replace('-', '\\', $this->request['resource']);
            $resource = new $resourceName($this->model);
            $resourceData = $resource::collection($modelData);
        } else {
            $resourceData = $modelData->items();
        }
        $data = array(
            'data' => $resourceData,
            "draw" => $this->request['draw'],
            "recordsTotal" => $this->totalCount,
            "recordsFiltered" => $filtered,
        );
        return $data;
    }
    private function getPage() {
        if ($this->start == 0) {
            $page = 1;
        } else {
            $page = ($this->start / $this->length) + 1;
        }
        return $page;
    }
    private function getModelData() {
        $modelData = $this->model->where(function ($query) {
            if ($this->search) {
                foreach ($this->searchColumns as $searchColumn) {
                    // if ($modelEavs && array_key_exists($searchColumn, $modelEavs)) {
                    //     $query->orWhereHas($searchColumn, function (Builder $builder) use ($this->search) {
                    //         $builder->where('content', 'like', '%' . $this->search . '%');
                    //     });
                    // } else {
                        $tableName = (new $this->modelName)->getTable();
                        if (Schema::hasColumn($tableName, $searchColumn)){
                            $query->orWhere($searchColumn, 'like', '%' . $this->search . '%');
                        }
                        
                    // }
                }
            }
            if ($this->withModel) {
                $query->with($this->withModel);
            }
        });
        $tableName = (new $this->modelName)->getTable();
        if (Schema::hasColumn($tableName, $this->sortBy)){
            $modelData->orderBy($this->sortBy, $this->sortDirection);
        }
        
        return $modelData;
    }
    private function getColumns() {
        foreach ($this->request['columns'] as $index => $column){
            // if ($index != 0 ) {
                if ($column['searchable'] == 'true') {
                    $this->searchColumns[] = $column['name'];
                }
                if ($column['orderable'] == 'true') {
                    $this->sortColumns[] = $column['name'];
                } else {
                    $this->sortColumns[] = '';
                }
            // }
        }
    }
    private function getModel() {
        $this->modelName = str_replace('-', '\\', $this->request['model']);
        if ($this->request['model_where']) {
            $whereFields = explode("|", $this->request['model_where']);
            $this->model = new $this->modelName;
            foreach ($whereFields as $whereField) {
                $where = explode(",", str_replace('-', '\\', $whereField));
                $this->model = $this->model->where($where[0], $where[1], $where[2]);
            }
        } else {
            $this->model = new $this->modelName;
        }
    }
}