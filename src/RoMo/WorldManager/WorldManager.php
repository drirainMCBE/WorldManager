<?php

namespace RoMo\WorldManager;

use pocketmine\plugin\PluginBase;
use pocketmine\utils\SingletonTrait;
use RoMo\Translator\Translator;
use RoMo\Translator\TranslatorHolderTrait;
use RoMo\WorldManager\command\WorldManagerCommand;
use RoMo\WorldManager\listener\EventListener;
use RoMo\WorldManager\worldSetting\WorldSettingFactory;

class WorldManager extends PluginBase{

    use SingletonTrait;
    use TranslatorHolderTrait;

    public function onLoad() : void{
        self::$instance = $this;
    }

    public function onEnable() : void{
        $this->setTranslator(new Translator($this, $this->getFile(), $this->getDataFolder(), "kor", true));
        WorldSettingFactory::init();
        foreach($this->getServer()->getWorldManager()->getWorlds() as $world){
            WorldSettingFactory::getInstance()->createWorldSetting($world);
        }
        $this->getServer()->getPluginManager()->registerEvents(new EventListener(), $this);
        $this->getServer()->getCommandMap()->register("worldManager", new WorldManagerCommand());
    }
}