<?php namespace App\Services;

class VehicleExpensesSearcher {
    
    protected $params;
    protected $query;
    protected $page = 1;
    protected $perPage = 100;
    protected $orderCol = 'cost';
    protected $orderDir = 'asc';
    protected $filters = '';
    protected $insurancePaymentfilters = '';
    protected $servicesfilters = '';

    function __construct($params){
        $this->params = $params;
    }

    protected function setFuelEntriesQuery(){
        $cols = "v.id, v.name vehicleName, v.plate_number plateNumber, 'fuel' type, fe.cost, fe.entry_date created_at";
        $this->query .= "(SELECT $cols FROM vehicles v INNER JOIN fuel_entries fe";
        $this->query .= " ON v.id = fe.vehicle_id ";
        $this->query .= " {$this->filters} {$this->setLimitQuery()})";
    }

    protected function setInsurancePaymentQuery(){
        $cols = "v.id, v.name vehicleName, v.plate_number plateNumber, 'insurance' type, ip.amount cost, ip.contract_date created_at";
        $this->query .= "(SELECT $cols FROM vehicles v INNER JOIN insurance_payments ip";
        $this->query .= " ON v.id = ip.vehicle_id ";
        $this->query .= " {$this->filters} {$this->setLimitQuery()})";
    }

    protected function setServicesQuery(){
        $cols = "v.id, v.name vehicleName, v.plate_number plateNumber, 'service' type, s.total cost, s.created_at";
        $this->query .= "(SELECT $cols FROM vehicles v INNER JOIN services s";
        $this->query .= " ON v.id = s.vehicle_id ";
        $this->query .= " {$this->filters} {$this->setLimitQuery()})";
    }

    protected function setFilters(){
        $filter = new VehicleExpensesFilter($this->params);
        $this->filters = $filter->setFilters();
    }

    protected function setUnionQuery(){
        $this->query .= " UNION ALL ";
    }

    protected function setSortQuery (){

        if(!isset($this->params['sort'])){
            return '';
        }

        $orderWhiteList = ['cost', 'created_at'];
        $orderParts = explode(',', $this->params['sort']);
        
        if(isset($orderParts[0]) && in_array($orderParts[0], $orderWhiteList)){
            $this->orderCol = $orderParts[0];
        }

        if(isset($orderParts[1]) && !empty($orderParts[1])){
            $this->orderDir = $orderParts[1];
        }

        $this->query .= " ORDER BY {$this->orderCol} {$this->orderDir}";
    }

    protected function setLimitQuery(){
        $this->offset = (isset($this->params['page'])) ? (int)$this->params['page']: $this->page;
        $this->offset = ($this->offset - 1) * $this->perPage; // paging
        return " LIMIT {$this->offset},{$this->perPage}";
    }

    function getQuery(){
        $this->setFilters();
        $this->setFuelEntriesQuery();
        $this->setUnionQuery();
        $this->setInsurancePaymentQuery();
        $this->setUnionQuery();
        $this->setServicesQuery();
        $this->setSortQuery();
        return $this->query;
    }

}