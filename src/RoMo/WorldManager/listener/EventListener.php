<?php

declare(strict_types=1);

namespace RoMo\WorldManager\listener;

use pocketmine\event\Listener;
use pocketmine\event\world\WorldLoadEvent;
use pocketmine\event\world\WorldUnloadEvent;
use RoMo\WorldManager\worldSetting\WorldSettingFactory;

class EventListener implements Listener{
    public function onLoadWorld(WorldLoadEvent $event){
        WorldSettingFactory::getInstance()->createWorldSetting($event->getWorld());
    }
    public function onUnloadWorld(WorldUnloadEvent $event){
        WorldSettingFactory::getInstance()->closeWorldSettingByWorld($event->getWorld());
    }
}