<?php

declare(strict_types=1);

namespace RoMo\WorldManager\worldSetting;

use pocketmine\Server;
use pocketmine\world\World;

class WorldSetting{

    /** @var World */
    private World $world;

    /** @var string */
    private string $path;

    /** @var int */
    private int $gamemode = 2;

    /** @var bool */
    private bool $isBlockPlaceAllow = false;
    private bool $isBlockBreakAllow = false;
    private bool $isPvpAllow = false;
    private bool $isChattingAllow = true;
    private bool $isItemDropAllow = true;
    private bool $isLeavesDecayAllow = false;

    public function __construct(World $world){
        $this->world = $world;
        $this->path = Server::getInstance()->getDataPath() . "worlds/" . $this->world->getFolderName() . "/setting.json";

        if(!file_exists($this->path)){
            $this->onUnload();
        }

        $data = json_decode(file_get_contents($this->path), true);

        $this->gamemode = $data[WorldSettingFactory::GAMEMODE];
        $this->isBlockPlaceAllow = $data[WorldSettingFactory::BLOCK_PLACE];
        $this->isBlockBreakAllow = $data[WorldSettingFactory::BLOCK_BREAK];
        $this->isPvpAllow = $data[WorldSettingFactory::PVP];
        $this->isChattingAllow = $data[WorldSettingFactory::CHATTING];
        $this->isItemDropAllow = $data[WorldSettingFactory::ITEM_DROP];
        $this->isLeavesDecayAllow = $data[WorldSettingFactory::LEAVES_DECAY];
    }

    public function onUnload(){
        file_put_contents($this->path, json_encode([
            WorldSettingFactory::GAMEMODE => $this->gamemode,
            WorldSettingFactory::BLOCK_PLACE => $this->isBlockPlaceAllow,
            WorldSettingFactory::BLOCK_BREAK => $this->isBlockBreakAllow,
            WorldSettingFactory::PVP => $this->isPvpAllow,
            WorldSettingFactory::CHATTING => $this->isChattingAllow,
            WorldSettingFactory::ITEM_DROP => $this->isItemDropAllow,
            WorldSettingFactory::LEAVES_DECAY => $this->isLeavesDecayAllow
        ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    }

    public function getWorld() : World{
        return $this->world;
    }

    public function getGamemode() : int{
        return $this->gamemode;
    }

    public function isBlockPlaceAllow() : bool{
        return $this->isBlockPlaceAllow;
    }

    public function isBlockBreakAllow() : bool{
        return $this->isBlockBreakAllow;
    }

    public function isPvpAllow() : bool{
        return $this->isPvpAllow;
    }

    public function isChattingAllow() : bool{
        return $this->isChattingAllow;
    }

    public function isItemDropAllow() : bool{
        return $this->isItemDropAllow;
    }

    public function isLeavesDecayAllow() : bool{
        return $this->isLeavesDecayAllow;
    }

    public function setGamemode(int $gamemode) : void{
        if($gamemode < 0){
            $gamemode = 0;
        }
        if($gamemode > 2){
            $gamemode = 2;
        }
        $this->gamemode = $gamemode;
    }

    public function setBlockPlaceAllow(bool $isBlockPlaceAllow) : void{
        $this->isBlockPlaceAllow = $isBlockPlaceAllow;
    }

    public function setBlockBreakAllow(bool $isBlockBreakAllow) : void{
        $this->isBlockBreakAllow = $isBlockBreakAllow;
    }

    public function setPvpAllow(bool $isPvpAllow) : void{
        $this->isPvpAllow = $isPvpAllow;
    }

    public function setChattingAllow(bool $isChattingAllow) : void{
        $this->isChattingAllow = $isChattingAllow;
    }
    public function setItemDropAllow(bool $isItemDropAllow) : void{
        $this->isItemDropAllow = $isItemDropAllow;
    }

    public function setLeavesDecayAllow(bool $isLeavesDecayAllow) : void{
        $this->isLeavesDecayAllow = $isLeavesDecayAllow;
    }
}