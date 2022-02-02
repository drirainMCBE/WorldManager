<?php

declare(strict_types=1);


namespace RoMo\WorldManager\worldSetting;

use pocketmine\utils\SingletonTrait;
use pocketmine\world\World;

class WorldSettingFactory{

    use SingletonTrait;

    public const GAMEMODE = "gamemode";
    public const BLOCK_PLACE = "block_place";
    public const BLOCK_BREAK = "block_break";
    public const PVP = "pvp";
    public const CHATTING = "chatting";
    public const ITEM_DROP = "item_drop";
    public const LEAVES_DECAY = "leaves_decay";

    /** @var WorldSetting[] */
    protected array $worldSettings = [];

    public static function init(){
        self::$instance = new self();
    }

    private function __construct(){}

    public function getWorldSetting(World $world) : ?WorldSetting{
        if(isset($this->worldSettings[$world->getFolderName()])){
            return $this->worldSettings[$world->getFolderName()];
        }
        return null;
    }

    public function createWorldSetting(World $world) : WorldSetting{
        if(($worldSetting = $this->getWorldSetting($world)) !== null){
            $this->closeWorldSetting($worldSetting);
        }
        return $this->worldSettings[$world->getFolderName()] = new WorldSetting($world);
    }

    public function closeWorldSetting(WorldSetting $worldSetting) : void{
        $worldSetting->onUnload();
        if(isset($this->worldSettings[$worldSetting->getWorld()->getFolderName()])){
            unset($this->worldSettings[$worldSetting->getWorld()->getFolderName()]);
        }
    }

    public function closeWorldSettingByWorld(World $world) : void{
        if(($worldSetting = $this->getWorldSetting($world)) !== null){
            $this->closeWorldSetting($worldSetting);
        }
    }
}