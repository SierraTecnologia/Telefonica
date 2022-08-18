<?php

namespace Telefonica\Models\Kpi;

use Pedreiro\Models\Base;
use Bancario\Models\BankAccount;
use Telefonica\Models\Digital\Account;

class MetricStat extends Base
{

    protected $organizationPerspective = false;

    protected $table = 'metric_stats';     

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'value',
        'metric_id',
    ];

    protected $mappingProperties = array(
        /**
         * User Stat
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
    public function scopeByType($query, $name)
    {
        return $query->where('name', $name);
    }
    public function scopeByValue($query, $name)
    {
        return $query->where('value', $value);
    }
 
 
    /**
     * Get the metric of the book.
     */
    public function metric()
    {
        return $this->belongsTo(Metric::class);
    }

}
