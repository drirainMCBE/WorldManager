<?php

namespace RoMo\WorldManager\worldSetting;

use pocketmine\Server;
use pocketmine\world\World;

class WorldSetting{

    /** @var World */
    protected World $world;

    /** @var string */
    protected string $path;

    /** @var int */
    protected int $gamemode;

    /** @var bool */
    protected bool $isBlockPlaceAllow;
    protected bool $isBlockBreakAllow;
    protected bool $isPvpAllow;
    protected bool $isLeavesDecayAllow;

    public function __construct(World $world){
        $this->world = $world;
        $this->path = Server::getInstance()->getDataPath() . "world/" . $this->world->getFolderName() . "/setting.json";

        if(!file_exists($this->path)){
            file_put_contents($this->path, json_encode([
                WorldSettingFactory::GAMEMODE => 2,
                WorldSettingFactory::BLOCK_PLACE => false,
                WorldSettingFactory::BLOCK_BREAK => false,
                WorldSettingFactory::PVP => false,
                WorldSettingFactory::LEAVES_DECAY => false
            ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
        }

        $data = json_decode(file_get_contents($this->path), true);

        $this->gamemode = $data[WorldSettingFactory::GAMEMODE];
        $this->isBlockPlaceAllow = $data[WorldSettingFactory::BLOCK_PLACE];
        $this->isBlockBreakAllow = $data[WorldSettingFactory::BLOCK_BREAK];
        $this->isPvpAllow = $data[WorldSettingFactory::PVP];
        $this->isLeavesDecayAllow = $data[WorldSettingFactory::LEAVES_DECAY];
    }

    public function onUnload(){
        file_put_contents($this->path, json_encode([
            WorldSettingFactory::GAMEMODE => $this->gamemode,
            WorldSettingFactory::BLOCK_PLACE => $this->isBlockPlaceAllow,
            WorldSettingFactory::BLOCK_BREAK => $this->isBlockBreakAllow,
            WorldSettingFactory::PVP => $this->isPvpAllow,
            WorldSettingFactory::LEAVES_DECAY => $this->isLeavesDecayAllow
        ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    }

    public function getWorld() : World{
        return $this->world;
    }
}