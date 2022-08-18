<?php

namespace Telefonica\Models\Kpi;

use Pedreiro\Models\Base;

class Metric extends Base
{

    protected $organizationPerspective = false;

    protected $table = 'metrics';     

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
     * Get the owning metricable model.
     * 
     * Esse é o morph sem ser de many to many
     */
    public function metricable()
    {
        return $this->morphTo();
    }
        /**
     * Get all of the post's infos.
     */
    public function infos()
    {
        return $this->hasMany(MetricInfo::class);
    }
    
    /**
    * Get all of the post's stats.
    */
   public function stats()
   {
       return $this->hasMany(MetricStat::class);
   }

    public function addInfo($name, $value)
    {
        if (!$info = $this->infos()->where()->byType($name)->withValue($value)) {
            $info = $this->infos()->create([
                'name' => $name,
                'value' => $value,
            ]);
        }
        return true;
    }


    public function addStat($name, $value)
    {
        if (!$stat = $this->stats()->where()->byType($name)->withValue($value)) {
            $stat = $this->stats()->create([
                'name' => $name,
                'value' => $value,
            ]);
        }
        return true;
    }



}
