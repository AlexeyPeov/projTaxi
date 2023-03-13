<?php

namespace App\Controllers;
class CustomerController
{

    public function index () : void {
        require __DIR__ . '/../Views/customers/index.php';
    }

    public function show () {

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
