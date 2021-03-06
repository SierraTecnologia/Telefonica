<?php

namespace Telefonica\Models\Digital;

use Pedreiro\Models\Base;

class Sitio extends Base
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'url',
        'sitio_id'
    ];

    protected $mappingProperties = array(
        'name' => [
            'type' => 'string',
            "analyzer" => "standard",
        ],
        'url' => [
            'type' => 'string',
            "analyzer" => "standard",
        ],
        'sitio_id' => [
            'type' => 'string',
            "analyzer" => "standard",
        ],
    );

    /**
     * Get all of the businesses that are assigned this tag.
     */
    public function businesses()
    {
        return $this->morphedByMany(\Illuminate\Support\Facades\Config::get('sitec-tools.models.business', \Telefonica\Models\Actors\Business::class), 'sitioable');
    }

    /**
     * Get all of the girls that are assigned this tag.
     */
    public function girls()
    {
        return $this->morphedByMany('Population\Models\Market\Actors\Girl', 'sitioable');
    }

    /**
     * Get all of the users that are assigned this tag.
     */
    public function users()
    {
        return $this->morphedByMany(\Illuminate\Support\Facades\Config::get('sitec.core.models.user', \App\Models\User::class), 'sitioable');
    }

    /**
     * Aparece em videos
     */
    public function videos()
    {
        return $this->morphedByMany('Stalker\Models\Video', 'sitioable');
    }
}
