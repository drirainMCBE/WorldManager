<?php

namespace RoMo\WorldManager\listener;

use pocketmine\event\Listener;
use pocketmine\event\world\WorldLoadEvent;
use RoMo\WorldManager\worldSetting\WorldSettingFactory;

class EventListener implements Listener{
    public function onLoadWorld(WorldLoadEvent $event){
        WorldSettingFactory::getInstance()->createWorldSetting($event->getWorld());
    }
}