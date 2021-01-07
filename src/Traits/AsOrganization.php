<?php

namespace Telefonica\Traits;

use Bancario\Traits\MakeEconomicActions;
// Podem Seguir
use Log;
use Muleta\Traits\Models\HasPersonality;
use Overtrue\LaravelFollow\Traits\CanBeFollowed;
use Overtrue\LaravelFollow\Traits\CanBookmark;
use Overtrue\LaravelFollow\Traits\CanFavorite;
use Overtrue\LaravelFollow\Traits\CanFollow;
// Podem Serem Seguidos
use Overtrue\LaravelFollow\Traits\CanLike;

use Overtrue\LaravelFollow\Traits\CanSubscribe;
use Overtrue\LaravelFollow\Traits\CanVote;
use Stalker\Traits\HasPhoto;
use Telefonica\Traits\HasRoutine;
use Telefonica\Traits\HasTask;

trait AsOrganization
{
    use HasPersonality;
    use MakeEconomicActions, HasTask, HasRoutine;
    use HasServicesAndAccounts, HasContacts, AsFofocavel;

    use CanFollow, CanLike, CanFavorite, CanSubscribe, CanVote, CanBookmark;
    use CanBeFollowed;

    // @todo Nao precisa do Stalker -> Eu tinha removido mas voltei pq ta dando bill
    use HasPhoto; 

    /**
     * Aparece em videos
     */
    public function videos()
    {
        return $this->morphToMany('Stalker\Models\Video', 'videoable');
    }

    /**
     * Aparece em fotos
     */
    public function imagens()
    {
        return $this->morphToMany('Stalker\Models\Imagen', 'imagenable');
    }

        
    /**
     * Get all of the owning personable models.
     */
    public function savePassword($password = '', $type = '')
    {
        // @todo Fazer
        return true;
    }
    /**
     *
     */

    /**
     * Projetos do Usuario - Refazer
     *
     * @param  array $data
     * @return void
     */
    public function addProject($data)
    {
        // @todo Refazer
        return $this->infos()->create(
            [
            'text' => implode(';', $data)
            ]
        );
    }

    /**
     * Events
     */
    public static function bootAsOrganization()
    {

        // static::deleting(function (self $user) {
        //     optional($user->photos)->each(function (Photo $photo) {
        //         $photo->delete();
        //     });
        // });
    }
}
