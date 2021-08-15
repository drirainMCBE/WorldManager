<?php

namespace RoMo\WorldManager\command;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;
use RoMo\WorldManager\form\WorldManagerForm;
use RoMo\WorldManager\WorldManager;

class WorldManagerCommand extends Command{

    public function __construct(){
        $cmd = WorldManager::getCmd("world.manager");
        parent::__construct($cmd["name"], $cmd["description"], $cmd["usageMessage"], $cmd["aliases"]);
        $this->setPermission("manage-world");
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args){
        if(!$this->testPermission($sender)){
            return;
        }
        if(!$sender instanceof Player){
            $sender->sendMessage(WorldManager::getMessage("must.do.in.game"));
            return;
        }
        $sender->sendForm(new WorldManagerForm());
    }
}