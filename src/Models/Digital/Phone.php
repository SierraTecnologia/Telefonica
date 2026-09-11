<?php

namespace Telefonica\Models\Digital;

use Illuminate\Database\Eloquent\Model;

class Phone extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'country',
        'state',
        'number',
        'whatsapp',
    ];

    protected $mappingProperties = array(
        /**
         * User Info
         */
        'number' => [
            'type' => 'string',
            "analyzer" => "standard",
        ],
    );
    
    /**
     * Get all of the slaves that are assigned this tag.
     */
    public function persons()
    {
        return $this->morphedByMany(\Illuminate\Support\Facades\Config::get('sitec.core.models.person', \Telefonica\Models\Actors\Person::class), 'phoneable');
    }

    /**
     * Get all of the users that are assigned this tag.
     */
    public function users()
    {
        return $this->morphedByMany(\Illuminate\Support\Facades\Config::get('sitec.core.models.user', \App\Models\User::class), 'phoneable');
    }
}
