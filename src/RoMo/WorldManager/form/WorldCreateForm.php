<?php

declare(strict_types=1);

namespace RoMo\WorldManager\form;

use pocketmine\form\Form;
use pocketmine\player\Player;
use pocketmine\Server;
use pocketmine\world\generator\Flat;
use pocketmine\world\generator\hell\Nether;
use pocketmine\world\generator\normal\Normal;
use pocketmine\world\WorldCreationOptions;
use RoMo\WorldManager\WorldManager;

class WorldCreateForm implements Form{
    public function jsonSerialize() : array{
        return [
            "title" => WorldManager::getTranslator()->getTranslate("form.title"),
            "type" => "custom_form",
            "content" => [
                [
                    "type" => "input",
                    "text" => WorldManager::getTranslator()->getTranslate("world.name.input")
                ],
                [
                    "type" => "dropdown",
                    "text" => WorldManager::getTranslator()->getTranslate("world.generator.dropdown"),
                    "options" => [
                        WorldManager::getTranslator()->getTranslate("world.generator.normal"),
                        WorldManager::getTranslator()->getTranslate("world.generator.flat"),
                        WorldManager::getTranslator()->getTranslate("world.generator.nether")
                    ]
                ],
                [
                    "type" => "input",
                    "text" => WorldManager::getTranslator()->getTranslate("world.seed")
                ],
                [
                    "type" => "input",
                    "text" => WorldManager::getTranslator()->getTranslate("world.preset")
                ]
            ]
        ];
    }
    public function handleResponse(Player $player, $data) : void{
        if($data === null){
            return;
        }
        $translator = WorldManager::getTranslator();
        if(!isset($data[0]) || $data[0] == ""){
            $player->sendMessage($translator->getMessage("input.world.name"));
            return;
        }
        $worldManager = Server::getInstance()->getWorldManager();
        if($worldManager->isWorldGenerated($data[0])){
            $player->sendMessage($translator->getMessage("already.exist.world"));
            return;
        }
        $generator = match ($data[1]){
            0 => Normal::class,
            1 => Flat::class,
            2 => Nether::class
        };
        $worldCreationOptions = new WorldCreationOptions();
        $worldCreationOptions->setGeneratorClass($generator);
        if(isset($data[2]) && $data[2] != "" && !is_numeric($data[2])){
            $worldCreationOptions->setSeed((int) $data[2]);
        }
        if(isset($data[3]) && $data[3] != ""){
            $worldCreationOptions->setGeneratorOptions((string) $data[3]);
        }
        $worldManager->generateWorld($data[0], $worldCreationOptions);
        $player->sendMessage($translator->getMessage("create.world", [$data[0]]));
    }
}