<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class VehicleExpensesSearcherTest extends TestCase
{
    
    public function testGetAllDataWithOutFilteration()
    {
        $response = $this->get('/api/v1/cars/expenses');
        $response->assertStatus(200);
    }

    public function testGetFilteredDataByName()
    {
        $response = $this->get('/api/v1/cars/expenses?name=don');
        $response->assertStatus(200);
    }

    public function testGetFilteredDataByType()
    {
        $response = $this->get('/api/v1/cars/expenses?type=fuel,service');
        $response->assertStatus(200);
    }

    public function testGetFilteredDataByCostRange()
    {
        $response = $this->get('/api/v1/cars/expenses?cost_min=1&cost_max=5');
        $response->assertStatus(200);
    }

    public function testGetFilteredDataByDateRange()
    {
        $response = $this->get('/api/v1/cars/expenses?date_min=2019-1-1&date_max=2020-1-1');
        $response->assertStatus(200);
    }

    public function testGetOrderedData()
    {
        $response = $this->get('/api/v1/cars/expenses?sort=cost,desc');
        $response->assertStatus(200);
    }

    public function testFailIfApiConsumedMoreThanFiveTimesInOneMinute()
    {
        $response = $this->get('/api/v1/cars/expenses');
        $response = $this->get('/api/v1/cars/expenses');
        $response = $this->get('/api/v1/cars/expenses');
        $response = $this->get('/api/v1/cars/expenses');
        $response = $this->get('/api/v1/cars/expenses');
        $response = $this->get('/api/v1/cars/expenses');
        $response->assertStatus(429);
    }

}
