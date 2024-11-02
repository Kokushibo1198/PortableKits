<?php

/**
 * ██╗░░██╗░█████╗░██╗░░██╗██╗░░░██╗░██████╗██╗░░██╗██╗██████╗░░█████╗░
 * ██║░██╔╝██╔══██╗██║░██╔╝██║░░░██║██╔════╝██║░░██║██║██╔══██╗██╔══██╗
 * █████═╝░██║░░██║█████═╝░██║░░░██║╚█████╗░███████║██║██████╦╝██║░░██║
 * ██╔═██╗░██║░░██║██╔═██╗░██║░░░██║░╚═══██╗██╔══██║██║██╔══██╗██║░░██║
 * ██║░╚██╗╚█████╔╝██║░╚██╗╚██████╔╝██████╔╝██║░░██║██║██████╦╝╚█████╔╝
 * ╚═╝░░╚═╝░╚════╝░╚═╝░░╚═╝░╚═════╝░╚═════╝░╚═╝░░╚═╝╚═╝╚═════╝░░╚════╝░
 * 
 * Copyright (c) 2024 Kokushibo
 * 
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <http://www.gnu.org/licenses/>.
 *
 * Discord: 01_kokushibo_01
 */

namespace hcf\command\moderador;

use hcf\handler\kit\Portable\KitsPortable;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;
use pocketmine\utils\TextFormat;
use hcf\HCFLoader;

class PortableCommand extends Command {

  public function __construct() {
      parent::__construct('pk', 'portables');$this->setPermission('moderador.command');}

    public function execute(CommandSender $sender, string $commandLabel, array $args): void {
        if ($sender instanceof Player) {
            if(count($args) < 1) {
                $sender->sendMessage(TextFormat::RED . "Usage: /pk <kit/all>");
                return;
            }

            if($args[0] === "all") {
                $kitManager = HCFLoader::getInstance()->getHandlerManager()->getKitManager();
                foreach($kitManager->getKits() as $kit) {
                    KitsPortable::givePortable($sender, $kit);
                }
                $sender->sendMessage(TextFormat::GREEN . "You received all portable kits!");
                return;
            }

            $kitName = $args[0];
            $kit = HCFLoader::getInstance()->getHandlerManager()->getKitManager()->getKit($kitName);

            if($kit === null) {
                $sender->sendMessage(TextFormat::RED . "Kit not found!");
                return;
            }

            $target = $sender;
            KitsPortable::givePortable($target, $kit);
            $sender->sendMessage(TextFormat::GREEN . "You received a portable " . $kit->getNameFormat() . " kit!");
        }
    }
}
