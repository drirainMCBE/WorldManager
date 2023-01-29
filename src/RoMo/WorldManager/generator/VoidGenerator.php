<?php

declare(strict_types=1);

namespace RoMo\WorldManager\generator;

use pocketmine\block\VanillaBlocks;
use pocketmine\world\ChunkManager;
use pocketmine\world\generator\Generator;

class VoidGenerator extends Generator{
    public function generateChunk(ChunkManager $world, int $chunkX, int $chunkZ) : void{
        if($chunkX == 16 && $chunkZ == 16){
            $world->getChunk($chunkX, $chunkZ)->setBlockStateId(0, 64, 0, VanillaBlocks::GLASS()->getStateId());
        }
    }
    public function populateChunk(ChunkManager $world, int $chunkX, int $chunkZ) : void{
        // TODO: Implement populateChunk() method.
    }
}