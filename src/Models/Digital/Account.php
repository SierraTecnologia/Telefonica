<?php

namespace Telefonica\Models\Digital;

use Pedreiro\Models\Base;
use Muleta\Traits\Models\ComplexRelationamentTrait;
use Integrations\Models\Integration;
use Telefonica\Models\Actors\Business;

class Account extends Base
{
    // use ComplexRelationamentTrait;
    
    // protected static $COMPLEX_RELATIONAMENT_MODELS = [
    //     \App\Models\Photo::class,
    //     \App\Models\Video::class
    // ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username',
        'password',
        'email',
        'customize_url',
        'status',
        'integration_id',
        'obs',
    ];

    protected $mappingProperties = array(
        'username' => [
            'type' => 'string',
            "analyzer" => "standard",
        ],
        'password' => [
            'type' => 'string',
            "analyzer" => "standard",
        ],
        'email' => [
            'type' => 'string',
            "analyzer" => "standard",
        ],
        'customize_url' => [
            'type' => 'string',
            "analyzer" => "standard",
        ],
        'integration_id' => [
            'type' => 'string',
            "analyzer" => "standard",
        ],
    );
    public $formFields = [
        [
            'name' => 'username',
            'label' => 'username',
            'type' => 'text'
        ],
        [
            'name' => 'password',
            'label' => 'password',
            'type' => 'text'
        ],
        [
            'name' => 'email',
            'label' => 'email',
            'type' => 'text'
        ],
        [
            'name' => 'customize_url',
            'label' => 'customize_url',
            'type' => 'text'
        ],
        // ['name' => 'init', 'label' => 'Inicio', 'type' => 'date'],
        // ['name' => 'end', 'label' => 'End', 'type' => 'date'],
        // [
        //     'name' => 'status',
        //     'label' => 'Status',
        //     'type' => 'checkbox'
        // ],
        [
            'name' => 'obs',
            'label' => 'Observations',
            'type' => 'textarea'
        ],
        ['name' => 'integration_id', 'label' => 'Integração', 'type' => 'select', 'relationship' => 'integration'],
        // ['name' => 'tags', 'label' => 'Tags', 'type' => 'select_multiple', 'relationship' => 'tags'],
    ];

    public $indexFields = [
        'username',
        'description',
        'password',
        'email',
        'customize_url',
        'integration_id',
        'obs'
    ];
    
    public function getUser()
    {
        return $this->username;
        return $this->email; // @todo
    }

    public function getPassword()
    {
        return $this->password;
    }


    /**
     * Get all of the business that are assigned this tag.
     */
    public function business()
    {
        return $this->businesses();
    }

    /**
     * Get all of the businesses that are assigned this item.
     */
    public function businesses()
    {
        return $this->morphedByMany(\Illuminate\Support\Facades\Config::get('sitec-tools.models.business', \Telefonica\Models\Actors\Business::class), 'accountable');
    }

    /**
     * Get all of the users that are assigned this tag.
     */
    public function users()
    {
        return $this->morphedByMany(\Illuminate\Support\Facades\Config::get('sitec.core.models.user', \App\Models\User::class), 'accountable');
    }

    /**
     * Get all of the persons that are assigned this tag.
     */
    public function persons()
    {
        return $this->morphedByMany(\Illuminate\Support\Facades\Config::get('sitec.core.models.person', \Telefonica\Models\Actors\Person::class), 'accountable');
    }

    /**
     * Relation for the user that created this entity.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function integration()
    {
        return $this->belongsTo(Integration::class);
    }


    public function save(array $options = [])
    {
        // If no author has been assigned, assign the current user's id as the author of the post
        if (!$this->username || empty($this->username)) {
            $this->username = $this->email;
        }

        parent::save();
    }

    /**
     * Get all of the passwords that are assigned this tag.
     */
    public function passwords()
    {
        return $this->morphToMany(Password::class, 'passwordable');
    }

    public static function boot()
    {
        parent::boot();

        self::created(
            function ($model) {
                $pass = Password::firstOrCreate([
                    'value' => $model->password,
                ]);
                $model->passwords()->attach($pass);
            }
        );

    }
}
