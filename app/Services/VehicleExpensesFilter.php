<?php namespace App\Services;
class VehicleExpensesFilter {
    
    protected $params;
    protected $prefix = '';

    function __construct($params){
        $this->params = $params;
    }

    protected function filtersConfiguration(){
        return [
            'vehicle_name'=> [
                'condition' => '==',
                'key' => 'name'
            ],
            'cost_min' => [
                'condition' => '>=',
                'key' => 'cost'
            ],
            'cost_max' => [
                'condition' => '<=',
                'key' => 'cost'
            ],
            'date_min' => [
                'condition' => '>=',
                'key' => 'created_at',
                'inputSetter' => 'setDateInput'
            ],
            'date_max' => [
                'condition' => '<=',
                'key' => 'created_at',
                'inputSetter' => 'setDateInput'
            ],
            'vehicle_name' => [
                'condition' => 'LIKE',
                'key' => 'vehicleName',
                'inputSetter' => 'setVehicleNameInput'
            ],
            'type' => [
                'condition' => 'in',
                'key' => 'type',
                'inputSetter' => 'setExpenseTypeInput'
            ]
        ];

    }

    protected function getUserRequiredFilters($params){
        $op = [];
        $availableFilters = $this->filtersConfiguration();
        foreach($params as $key => $value){
            if(isset($availableFilters[$key])){
                $op[$key] = $availableFilters[$key];
                if(isset($availableFilters[$key]['inputSetter'])){
                    $op[$key]['userInput'] = $this->{$availableFilters[$key]['inputSetter']}($value);
                } else {
                    $op[$key]['userInput'] = $value;
                }
            }
        }

        return $op;
    }

    protected function buildFiltersLine($userFilters){
        $filtersLine = '';
        foreach($userFilters as $filterKey => $filterValue){
            if(!empty($filterValue['userInput'])){
                $filtersLine .= $filterValue['key'] . ' ';
                $filtersLine .= $filterValue['condition'] . ' ';
                $filtersLine .= '(' . $filterValue['userInput'] . ') AND ';
            }
        }
        return rtrim($filtersLine, ' AND ');
    }

    public function setFilters (){
        $userRequiredfilters = $this->getUserRequiredFilters($this->params);
        $filtersLine = $this->buildFiltersLine($userRequiredfilters);
        return $filtersLine = (empty($filtersLine)) ? '' : 'HAVING ' . $filtersLine;
    }

    protected function setExpenseTypeInput($input){

        return "'" . implode( "','", explode(',', $input) ) . "'";

    }

    protected function setVehicleNameInput($input){
        return (!empty($input)) ? "'%" . $input . "%'" : '';

    }

    protected function setDateInput($input){
        return "STR_TO_DATE('$input 00:00:00', '%Y-%m-%d %H:%i:%s')";
    }

}