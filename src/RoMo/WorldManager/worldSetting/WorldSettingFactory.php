<?php

namespace RoMo\WorldManager\worldSetting;

use pocketmine\utils\SingletonTrait;
use pocketmine\world\World;

class WorldSettingFactory{

    use SingletonTrait;

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