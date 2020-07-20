<?php

namespace Telefonica\Traits;

use Log;


trait HasContacts
{


    /**
     * Contatos
     */
    public function phones()
    {
        return $this->morphToMany('Telefonica\Models\Digital\Phone', 'phoneable');
    }
    public function emails()
    {
        return $this->morphToMany('Telefonica\Models\Digital\Email', 'emailable');
    }


    /**
     * Get all of the addresses for the post.
     */
    public function addresses()
    {
        return $this->morphToMany('Locaravel\Models\Address', 'addresseable');
    }

    /**
     * Outros Relatiosn Nad a aver
     *
     * @return void
     */
    public function sitios()
    {
        return $this->morphToMany('Telefonica\Models\Digital\Sitio', 'sitioable');
    }
}
