<?php

namespace Telefonica\Models\Actors;

use Muleta\Utils\Modificators\StringModificator;
use Pedreiro\Models\Base;
use Telefonica\Traits\AsHuman;

class Person extends Base
{
    use AsHuman;
    
    protected $table = 'persons';
    public $incrementing = false;
    protected $casts = [
        'code' => 'string',
    ];
    protected $primaryKey = 'code';
    protected $keyType = 'string';
}
