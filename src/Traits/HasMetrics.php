<?php

namespace Telefonica\Traits;

use Telefonica\Models\Kpi\Metric;
use Log;

trait HasMetrics
{
    //   /**
    //  * Get all of the metrics for the post.
    //  */
    // public function metrics()
    // {
    //     return $this->morphToMany(Metric::class, 'taggable');
    // }
    
        /**
     * Get the user's metric.
     */
    public function metric()
    {
        return $this->morphOne(Metric::class, 'metricable');
    }


    public function getMetric()
    {
      if (!$metric = $this->metric) {
        $metric = $this->metric()->create();
      }
        return $metric;
    }


    public function addInfo($name, $value)
    {
        return $metric->addInfo($name, $value);
    }


    public function addStat($name, $value)
    {
      return $metric->addStat($name, $value);
    }


}
