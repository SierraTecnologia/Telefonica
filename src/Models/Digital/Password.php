<?php

namespace Telefonica\Models\Digital;

use Pedreiro\Models\Base;
use Bancario\Models\BankAccount;
use Telefonica\Models\Digital\Account;

class Password extends Base
{

    protected $organizationPerspective = false;

    protected $table = 'identity_passwords';     

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'value',
        'date',
        'is_active',
        'email', // @todo acho que nao deveria ter isso aqui
        'url', // @todo acho que nao deveria ter isso aqui
        'obs'
    ];

    protected $mappingProperties = array(
        /**
         * User Info
         */
        'value' => [
            'type' => 'string',
            "analyzer" => "standard",
        ],
        'date' => [
            'type' => 'string',
            "analyzer" => "standard",
        ],
    );

    /**
     * Get the owning passwordable model.
     * 
     * Esse é o morph sem ser de many to many
     */
    public function passwordable()
    {
        return $this->morphTo();
    }

    /**
     * Get all of the bankAccounts that are assigned this tag.
     * Esse é o morph de many to many
     */
    public function bankAccounts()
    {
        return $this->morphedByMany(BankAccount::class, 'passwordable');
    }



    /**
     * Get all of the accounts that are assigned this tag.
     * Esse é o morph de many to many
     */
    public function accounts()
    {
        return $this->morphedByMany(Account::class, 'passwordable');
    }








    // /**
    //  * Get all of the slaves that are assigned this tag.
    //  */
    // public function persons()
    // {
    //     return $this->morphedByMany(\Illuminate\Support\Facades\Config::get('sitec.core.models.person', \Telefonica\Models\Actors\Person::class), 'passwordable');
    // }

    // /**
    //  * Get all of the users that are assigned this tag.
    //  */
    // public function users()
    // {
    //     return $this->morphedByMany(\Illuminate\Support\Facades\Config::get('sitec.core.models.user', \App\Models\User::class), 'passwordable');
    // }
}
