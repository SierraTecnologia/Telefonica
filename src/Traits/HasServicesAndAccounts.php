<?php

namespace Telefonica\Traits;

use Log;

trait HasServicesAndAccounts
{
    /**
     * Get all of the post's accounts.
     */
    public function accounts()
    {
        return $this->morphToMany('Telefonica\Models\Digital\Account', 'accountable');
    }

    

}
