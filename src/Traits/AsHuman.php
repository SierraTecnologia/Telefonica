<?php

namespace Telefonica\Traits;

use Log;

use Informate\Models\Tag;
use Informate\Models\Entytys\About\Skill;

trait AsHuman
{
    use AsOrganization;


    public function setTag($data)
    {
      $data = [
        'code' => $data
      ];
      
      return Tag::createAndAssociate($data, $this);
    }

    public function setSkill($data)
    {
      $data = [
        'code' => $data
      ];
      
      return Skill::createAndAssociate($data, $this);
    }


    /**
     * One To Many (Polymorphic) - Feature FA
     *
     * @return void
     */
    public function pircings()
    {
        return $this->morphMany('Population\Models\Identity\Fisicos\Pircing', 'pircingable');
    }
    public function pintinhas()
    {
        return $this->morphMany('Population\Models\Identity\Fisicos\Pintinha', 'pintinhable');
    }
    public function tatuages()
    {
        return $this->morphMany('Population\Models\Identity\Fisicos\Tatuage', 'tatuageable');
    }

    /**
     * Many To Many (Polymorphic)
     */
    public function productions()
    {
        return $this->morphToMany('Population\Models\Components\Productions\Production', 'productionable');
    }
    public function personagens()
    {
        return $this->morphToMany('Population\Models\Market\Actors\Personagem', 'personagenable');
    }
    

    /**
     * Events
     */
    public static function bootAsHuman()                                                                                                                                                             
    {

        // static::deleting(function (self $user) {
        //     optional($user->photos)->each(function (Photo $photo) {
        //         $photo->delete();
        //     });
        // });
    }
    

}
