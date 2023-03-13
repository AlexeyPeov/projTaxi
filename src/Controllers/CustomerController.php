<?php

namespace App\Controllers;
use App\Services\OrderService;

class CustomerController
{
    private OrderService $orderService;
    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    public function index () : void {
        require __DIR__ . '/../Views/customers/index.php';
    }

    public function show () {
        $orm = $this->orderService->getORM();
        $customer = $orm->findById('customers', $_SESSION['id']);
        $taxiDriver = null;
        $orders = $orm->findByValue('orders', 'customer_id', $customer->id);
        if(!is_array($orders)){
            $orders = [$orders];
        }
        require __DIR__ . '/../Views/customers/show.php';
    }

    public function create () {

    }

    public function store () {

    }

    public function edit () {

    }

    public function update (){

    }

    public function destroy(){

    }

}
