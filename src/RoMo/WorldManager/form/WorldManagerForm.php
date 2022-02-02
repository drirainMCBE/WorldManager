<?php

namespace RoMo\WorldManager\form;

use pocketmine\form\Form;
use pocketmine\player\Player;
use RoMo\WorldManager\WorldManager;

class WorldManagerForm implements Form{
    public function jsonSerialize() : array{
        return [
            "type" => "form",
            "title" => WorldManager::getTranslator()->getPrefix(),
            "content" => WorldManager::getTranslate("choose.to.do"),
            "buttons" => [
                [
                    "text" => WorldManager::getTranslator()->getTranslate("create.world.button.1") . "\n" . WorldManager::getTranslator()->getTranslate("create.world.button.2")
                ],
                [
                    "text" => WorldManager::getTranslator()->getTranslate("warp.to.world.button.1") . "\n" . WorldManager::getTranslator()->getTranslate("warp.to.world.button.2")
                ],
                [
                    "text" =>WorldManager::getTranslator()->getTranslate("setting.world.button.1") . "\n" . WorldManager::getTranslator()->getTranslate("setting.world.button.2")
                ]
            ]
        ];
    }

    public function handleResponse(Player $player, $data) : void{
        if($data === null){
            return;
        }
    }
}