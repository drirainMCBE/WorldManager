<?php

declare(strict_types=1);

namespace RoMo\WorldManager\listener;

use pocketmine\event\block\BlockBreakEvent;
use pocketmine\event\block\BlockPlaceEvent;
use pocketmine\event\block\LeavesDecayEvent;
use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\event\entity\EntityTeleportEvent;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerChatEvent;
use pocketmine\event\player\PlayerDropItemEvent;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\world\WorldLoadEvent;
use pocketmine\event\world\WorldUnloadEvent;
use pocketmine\player\GameMode;
use pocketmine\player\Player;
use RoMo\WorldManager\WorldManager;
use RoMo\WorldManager\worldSetting\WorldSettingFactory;

class EventListener implements Listener{
    public function onLoadWorld(WorldLoadEvent $event) : void{
        WorldSettingFactory::getInstance()->createWorldSetting($event->getWorld());
    }
    public function onUnloadWorld(WorldUnloadEvent $event) : void{
        WorldSettingFactory::getInstance()->closeWorldSettingByWorld($event->getWorld());
    }

    public function updateGamemode(Player $player) : void{
        if($player->hasPermission("manage-world")){
            return;
        }
        $world = $player->getWorld();
        if(($worldSetting = WorldSettingFactory::getInstance()->getWorldSetting($world)) === null){
            $worldSetting = WorldSettingFactory::getInstance()->createWorldSetting($world);
        }
        $player->setGamemode(GameMode::fromString((string) $worldSetting->getGamemode()));
    }

    public function onJoin(PlayerJoinEvent $event) : void{
        $this->updateGamemode($event->getPlayer());
    }

    public function onTeleport(EntityTeleportEvent $event) : void{
        if(($entity = $event->getEntity()) instanceof Player){
            $this->updateGamemode($entity);
        }
    }

    public function onBlockPlace(BlockPlaceEvent $event) : void{
        $player = $event->getPlayer();
        if($player->hasPermission("manage-world")){
            return;
        }
        $world = $player->getWorld();
        if(($worldSetting = WorldSettingFactory::getInstance()->getWorldSetting($world)) === null){
            $worldSetting = WorldSettingFactory::getInstance()->createWorldSetting($world);
        }
        if(!$worldSetting->isBlockPlaceAllow()){
            $event->cancel();
        }
    }

    public function onBlockBreak(BlockBreakEvent $event) : void{
        $player = $event->getPlayer();
        if($player->hasPermission("manage-world")){
            return;
        }
        $world = $player->getWorld();
        if(($worldSetting = WorldSettingFactory::getInstance()->getWorldSetting($world)) === null){
            $worldSetting = WorldSettingFactory::getInstance()->createWorldSetting($world);
        }
        if(!$worldSetting->isBlockBreakAllow()){
            $event->cancel();
        }
    }

    public function onEntityDamageByEntity(EntityDamageByEntityEvent $event) : void{
        $player = $event->getDamager();
        if(!$player instanceof Player){
            return;
        }
        if($player->hasPermission("manage-world")){
            return;
        }
        $world = $player->getWorld();
        if(($worldSetting = WorldSettingFactory::getInstance()->getWorldSetting($world)) === null){
            $worldSetting = WorldSettingFactory::getInstance()->createWorldSetting($world);
        }
        if(!$worldSetting->isPvpAllow()){
            $event->cancel();
        }
    }

    public function onChat(PlayerChatEvent $event) : void{
        $player = $event->getPlayer();
        if($player->hasPermission("manage-world")){
            return;
        }
        $world = $player->getWorld();
        if(($worldSetting = WorldSettingFactory::getInstance()->getWorldSetting($world)) === null){
            $worldSetting = WorldSettingFactory::getInstance()->createWorldSetting($world);
        }

        if(!$worldSetting->isChattingAllow()){
            $event->cancel();
            $player->sendMessage(WorldManager::getTranslator()->getTranslate("cant.chatting"));
        }
    }

    public function onDropItem(PlayerDropItemEvent $event) : void{
        $player = $event->getPlayer();
        if($player->hasPermission("manage-world")){
            return;
        }
        $world = $player->getWorld();
        if(($worldSetting = WorldSettingFactory::getInstance()->getWorldSetting($world)) === null){
            $worldSetting = WorldSettingFactory::getInstance()->createWorldSetting($world);
        }
        if(!$worldSetting->isItemDropAllow()){
            $event->cancel();
            $player->sendTip(WorldManager::getTranslator()->getTranslate("cant.drop.item"));
        }
    }

    public function onLeavesDecay(LeavesDecayEvent $event) : void{
        $world = $event->getBlock()->getPosition()->getWorld();
        if(($worldSetting = WorldSettingFactory::getInstance()->getWorldSetting($world)) === null){
            $worldSetting = WorldSettingFactory::getInstance()->createWorldSetting($world);
        }
        if(!$worldSetting->isLeavesDecayAllow()){
            $event->cancel();
        }
    }
}