<?php

declare(strict_types=1);

namespace RoMo\WorldManager\form;

use pocketmine\form\Form;
use pocketmine\player\Player;
use RoMo\WorldManager\WorldManager;
use RoMo\WorldManager\worldSetting\WorldSetting;

class WorldSettingForm implements Form{

    /** @var WorldSetting */
    private WorldSetting $worldSetting;

    public function __construct(WorldSetting $worldSetting){
        $this->worldSetting = $worldSetting;
    }
    public function jsonSerialize() : array{
        return [
            "title" => WorldManager::getTranslator()->getTranslate("form.title"),
            "type" => "custom_form",
            "content" => [
                [
                    "type" => "dropdown",
                    "text" => WorldManager::getTranslator()->getTranslate("setting.gamemode"),
                    "options" => [
                        WorldManager::getTranslator()->getTranslate("setting.gamemode.survival"),
                        WorldManager::getTranslator()->getTranslate("setting.gamemode.adventure")
                    ],
                    "default" => match ($this->worldSetting->getGamemode()){
                        0 => 0,
                        2 => 1
                    }
                ],
                [
                    "type" => "toggle",
                    "text" => WorldManager::getTranslator()->getTranslate("setting.block.place"),
                    "default" => $this->worldSetting->isBlockPlaceAllow()
                ],
                [
                    "type" => "toggle",
                    "text" => WorldManager::getTranslator()->getTranslate("setting.block.break"),
                    "default" => $this->worldSetting->isBlockBreakAllow()
                ],
                [
                    "type" => "toggle",
                    "text" => WorldManager::getTranslator()->getTranslate("setting.pvp"),
                    "default" => $this->worldSetting->isPvpAllow()
                ],
                [
                    "type" => "toggle",
                    "text" => WorldManager::getTranslator()->getTranslate("setting.chatting"),
                    "default" => $this->worldSetting->isChattingAllow()
                ],
                [
                    "type" => "toggle",
                    "text" => WorldManager::getTranslator()->getTranslate("setting.item.drop"),
                    "default" => $this->worldSetting->isItemDropAllow()
                ],
                [
                    "type" => "toggle",
                    "text" => WorldManager::getTranslator()->getTranslate("setting.leave.decay"),
                    "default" => $this->worldSetting->isLeavesDecayAllow()
                ]
            ]
        ];
    }
    public function handleResponse(Player $player, $data) : void{
        if($data === null){
            return;
        }
        $this->worldSetting->setGamemode(match ($data[0]){
            0 => 0,
            1 => 2
        });
        $this->worldSetting->setBlockPlaceAllow($data[1]);
        $this->worldSetting->setBlockBreakAllow($data[2]);
        $this->worldSetting->setPvpAllow($data[3]);
        $this->worldSetting->setChattingAllow($data[4]);
        $this->worldSetting->setItemDropAllow($data[5]);
        $this->worldSetting->setLeavesDecayAllow($data[6]);
        $player->sendMessage(WorldManager::getTranslator()->getMessage("setting.world", [$this->worldSetting->getWorld()->getFolderName()]));
    }
}