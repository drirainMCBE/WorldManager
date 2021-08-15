<?php

namespace RoMo\WorldManager\worldSetting;

use pocketmine\utils\SingletonTrait;
use pocketmine\world\World;

class WorldSettingFactory{

    use SingletonTrait;

    public const GAMEMODE = "gamemode";
    public const BLOCK_PLACE = "block_place";
    public const BLOCK_BREAK = "block_break";
    public const PVP = "pvp";
    public const LEAVES_DECAY = "leaves_decay";

    /** @var WorldSetting[] */
    protected array $worldSettings = [];

    public static function init(){
        self::$instance = new self();
    }

    private function __construct(){}

    public function createWorldSetting(World $world) : WorldSetting{
        return $this->worldSettings[] = new WorldSetting($world);
    }
}