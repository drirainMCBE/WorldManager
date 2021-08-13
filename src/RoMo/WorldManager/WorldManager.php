<?php

namespace RoMo\WorldManager;

use pocketmine\plugin\PluginBase;
use pocketmine\utils\SingletonTrait;
use RoMo\WorldManager\lib\translateTrait;

class WorldManager extends PluginBase{

    use SingletonTrait;
    use translateTrait;

    public function onLoad() : void{
        self::$instance = $this;
    }

    public function onEnable() : void{
        self::initMessage("kor");
    }
}