<?php

declare(strict_types=1);

namespace RoMo\WorldManager\command;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;
use RoMo\WorldManager\form\WorldManagerForm;
use RoMo\WorldManager\WorldManager;

class WorldManagerCommand extends Command{

    public function __construct(){
        $cmd = WorldManager::getTranslator()->getCmd("world.manager");
        parent::__construct($cmd->getName(), $cmd->getDescription(), $cmd->getUsage(), $cmd->getAliases());
        $this->setPermission("manage-world");
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args){
        if(!$this->testPermission($sender)){
            return;
        }
        if(!$sender instanceof Player){
            $sender->sendMessage(WorldManager::getTranslator()->getMessage("must.do.in.game"));
            return;
        }
        $sender->sendForm(new WorldManagerForm());
    }
}