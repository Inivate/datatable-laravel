<?php

namespace Inivate\DatatableLaravel;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Schema;

class DataTable {

    private $id;
    private $model;
    private $resource;
    private $displayLength = 25;
    private $columns = [];
    private $columnOrder = 1;
    private $sortBy = 'asc';
    private $modelWhere = '';

    public function __construct($model, $resource = null) {
        $this->id = Str::lower(Str::replace('\\', '_', $model) . '_' . Str::random(5));
        $this->model = Str::replace('\\', '-', $model);
        $this->resource = Str::replace('\\', '-', $resource);
    }

    public function setDisplayLength($displayLength) {
        $this->displayLength = $displayLength;
        return $this;
    }

    public function setColumnOrder($column) {
        $this->columnOrder = $column;
        return $this;
    }

    public function addModelWhere($where, $operator, $value) {
        if ($this->modelWhere == '') {
            $this->modelWhere = $where . ',' . $operator . ',' . $value;
        } else {
            $this->modelWhere = $this->modelWhere . '|'. $where . ',' . $operator . ',' . $value;
        }
        return $this;
    }

    public function setColumnDirection($columnDirection) {
        $this->sortBy = $columnDirection;
        return $this;
    }

    public function addColumn($label, $data, $orderable = false, $searchable = false) {
        $this->columns[] = [
            'label' => $label, 
            'name' => Str::lower($data), 
            'data' => Str::lower($data), 
            'orderable' => $orderable ? 'true' : 'false', 
            'searchable' => $searchable ? 'true' : 'false',
        ];
        return $this;
    }

    public function build() {
        return [
                'id' => $this->id,
                'model' => $this->model,
                'model_where' => $this->modelWhere,
                'resource' => $this->resource,
                'table' => [
                    'displayLength' => $this->displayLength,
                    'columns' => $this->columns,
                    'defaultOrder' => [
                        'column' => $this->columnOrder, 
                        'sortBy' => $this->sortBy,
                    ]
                ]
            ];
    }
}