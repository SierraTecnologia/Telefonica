<?php

namespace Telefonica\Models\Digital;

use Pedreiro\Models\Base;
use Bancario\Models\BankAccount;
use Telefonica\Models\Digital\Account;

class Username extends Base
{

    protected $organizationPerspective = false;

    protected $table = 'identity_usernames';     

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'value'
    ];

    protected $mappingProperties = array(
        /**
         * User Info
         */
        'value' => [
            'type' => 'string',
            "analyzer" => "standard",
        ],
    );

    /**
     * Get the owning usernameable model.
     * 
     * Esse é o morph sem ser de many to many
     */
    public function usernameable()
    {
        return $this->morphTo();
    }



}
