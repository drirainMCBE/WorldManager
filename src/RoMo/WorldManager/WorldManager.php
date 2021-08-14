<?php

namespace RoMo\WorldManager;

use pocketmine\plugin\PluginBase;
use pocketmine\utils\SingletonTrait;
use RoMo\WorldManager\lib\translateTrait;
use RoMo\WorldManager\listener\EventListener;
use RoMo\WorldManager\worldSetting\WorldSettingFactory;

class WorldManager extends PluginBase{

    use SingletonTrait;
    use translateTrait;

    public function onLoad() : void{
        self::$instance = $this;
    }

    public function onEnable() : void{
        self::initMessage("kor");
        WorldSettingFactory::init();
        $this->getServer()->getPluginManager()->registerEvents(new EventListener(), $this);
    }
}