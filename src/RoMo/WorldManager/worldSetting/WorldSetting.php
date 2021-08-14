<?php

namespace RoMo\WorldManager\worldSetting;

use pocketmine\world\World;

class WorldSetting{

    /** @var World */
    protected World $world;

    public function __construct(World $world){
        $this->world = $world;
    }
}