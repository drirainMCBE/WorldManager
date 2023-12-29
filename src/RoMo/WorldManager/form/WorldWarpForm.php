<?php

declare(strict_types=1);

namespace RoMo\WorldManager\form;

use pocketmine\form\Form;
use pocketmine\player\Player;
use pocketmine\Server;
use pocketmine\world\World;
use RoMo\WorldManager\WorldManager;

class WorldWarpForm implements Form{

    /** @var World[] */
    private array $worldsForButton = [];

    public function jsonSerialize() : array{
        $buttons = [];
        foreach(Server::getInstance()->getWorldManager()->getWorlds() as $world){
            $this->worldsForButton[] = $world;
            $buttons[] = ["text" => WorldManager::getTranslator()->getTranslate("world.name.list.button", [$world->getFolderName()]) . "\n" . WorldManager::getTranslator()->getTranslate("world.warp.button")];
        }
        return [
            "title" => WorldManager::getTranslator()->getTranslate("form.title"),
            "type" => "form",
            "content" => "",
            "buttons" => $buttons
        ];
    }
    public function handleResponse(Player $player, $data) : void{
        if($data === null){
            return;
        }
        $world = $this->worldsForButton[$data];
        $player->teleport($world->getSpawnLocation());
        $player->sendMessage(WorldManager::getTranslator()->getMessage("warp.world" , [$world->getFolderName()]));
    }
}