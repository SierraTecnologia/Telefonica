<?php

namespace Telefonica\Http\Controllers\Painel;

use Telefonica\Models\Actors\Person;
use Pedreiro\CrudController;

class PersonController extends Controller
{
    use CrudController;

    public function __construct(Person $model)
    {
        $this->model = $model;
        parent::__construct();
    }
}
