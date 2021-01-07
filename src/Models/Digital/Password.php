<?php

namespace Telefonica\Models\Digital;

use Pedreiro\Models\Base;

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
     */
    public function passwordable()
    {
        return $this->morphTo();
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
