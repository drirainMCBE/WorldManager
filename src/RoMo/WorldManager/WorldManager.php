<?php

namespace RoMo\WorldManager;

use pocketmine\plugin\PluginBase;
use pocketmine\utils\SingletonTrait;
use RoMo\Translator\Translator;
use RoMo\Translator\TranslatorHolderTrait;
use RoMo\WorldManager\command\WorldManagerCommand;
use RoMo\WorldManager\listener\EventListener;
use RoMo\WorldManager\worldSetting\WorldSettingFactory;
use Webmozart\PathUtil\Path;

class WorldManager extends PluginBase{

    use SingletonTrait;
    use TranslatorHolderTrait;

    public function onLoad() : void{
        self::$instance = $this;
    }

    public function onEnable() : void{
        $this->setTranslator(new Translator($this, $this->getFile(), $this->getDataFolder(), "kor"));
        WorldSettingFactory::init();
        foreach($this->getServer()->getWorldManager()->getWorlds() as $world){
            WorldSettingFactory::getInstance()->createWorldSetting($world);
        }
        $this->getServer()->getPluginManager()->registerEvents(new EventListener(), $this);
        $this->getServer()->getCommandMap()->register("worldManager", new WorldManagerCommand());

        foreach(array_diff(scandir(Path::join($this->getServer()->getDataPath(), "worlds")), ["..", ".", "islands"]) as $worldName){
            $this->getServer()->getWorldManager()->loadWorld($worldName);
        }
    }

    public function onDisable() : void{
        WorldSettingFactory::getInstance()->shutdown();
    }
}