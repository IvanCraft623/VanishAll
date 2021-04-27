<?php

declare(strict_types=1);

#Plugin by IvanCraft623 (Twitter: @IvanCraft623)

/*
	8888888                            .d8888b.                   .d888 888     .d8888b.   .d8888b.   .d8888b.  
	  888                             d88P  Y88b                 d88P"  888    d88P  Y88b d88P  Y88b d88P  Y88b 
	  888                             888    888                 888    888    888               888      .d88P 
	  888  888  888  8888b.  88888b.  888        888d888 8888b.  888888 888888 888d888b.       .d88P     8888"  
	  888  888  888     "88b 888 "88b 888        888P"      "88b 888    888    888P "Y88b  .od888P"       "Y8b. 
	  888  Y88  88P .d888888 888  888 888    888 888    .d888888 888    888    888    888 d88P"      888    888 
	  888   Y8bd8P  888  888 888  888 Y88b  d88P 888    888  888 888    Y88b.  Y88b  d88P 888"       Y88b  d88P 
	8888888  Y88P   "Y888888 888  888  "Y8888P"  888    "Y888888 888     "Y888  "Y8888P"  888888888   "Y8888P"  
*/

namespace IvanCraft623\VanishAll\Command;

use IvanCraft623\VanishAll\{VanishAll};

use pocketmine\{Server, Player};
use pocketmine\command\{PluginCommand, CommandSender};

class VallCommand extends PluginCommand {

	public function __construct(VanishAll $plugin) {
		parent::__construct('vall', $plugin);
		$this->setDescription('VanishAll System by IvanCraft623.');
	}

	public function execute(CommandSender $sender, string $label, array $args) : bool {
		if (isset($args[0])) {
			switch ($args[0]) {
				case 'on':
					if (!$sender->hasPermission("vanisall.use")) {
						$sender->sendMessage("§cYou do not have permission to use this command!");
						return true;
					}
					if (VanishAll::$vanisAll) {
						$sender->sendMessage("§cVanishAll is already activated!");
						return true;
					}
					$sender->sendMessage(VanishAll::getPrefix() . "§bYou have §aactivated§b VanishAll");
					VanishAll::$vanisAll = true;
				break;

				case 'off':
					if (!$sender->hasPermission("vanisall.use")) {
						$sender->sendMessage("§cYou do not have permission to use this command!");
						return true;
					}
					if (!VanishAll::$vanisAll) {
						$sender->sendMessage("§cVanishAll is already disabled!");
						return true;
					}
					$sender->sendMessage(VanishAll::getPrefix() . "§bYou have §cdisabled§b VanishAll");
					VanishAll::$vanisAll = false;
					foreach (Server::getInstance()->getOnlinePlayers() as $player) {
						foreach (Server::getInstance()->getOnlinePlayers() as $pl) {
							$pl->showPlayer($player);
						}
					}
				break;

				case 'view':
					if (!$sender->hasPermission("vanisall.use")) {
						$sender->sendMessage("§cYou do not have permission to use this command!");
						return true;
					}
					if (!$sender instanceof Player) {
						$sender->sendMessage("§cThis command is only available in the game!");
						return true;
					}
					if (isset($args[1])) {
						switch ($args[1]) {
							case 'on':
								if (in_array($sender->getName(), VanishAll::$allowView)) {
									$sender->sendMessage("§cYou are already allowed to view vanished players!");
									return true;
								}
								VanishAll::$allowView[] = $sender->getName();
								$sender->sendMessage(VanishAll::getPrefix() . "§aYou can now view vanished players");
							break;

							case 'off':
								foreach (VanishAll::$allowView as $index => $player) {
									if ($sender->getName() == $player) {
										unset(VanishAll::$allowView[$index]);
									}
								}
								$sender->sendMessage("§cYou can no longer view vanished players.!");
							break;
							
							default:
								$sender->sendMessage("§cUse: /vall view <on|off>");
							break;
						}
					} else {
						$sender->sendMessage("§cUse: /vall view <on|off>");
					}
				break;

				case 'credits':
					$sender->sendMessage(
						"§a---- §5Vanish§aAll §bCredits §a----"."\n"."\n".
						"§eAuthor: §7IvanCraft623 / IvanCraft236"."\n".
						"§eStatus: §7Public??"."\n"."\n".
						"§eCheck my server! §bendergames.ddns.net:25331"
					);
				break;
				
				default:
					self::sendUsageMessage($sender);
				break;
			}
		} else {
			self::sendUsageMessage($sender);
		}
		return true;
	}

	public static function sendUsageMessage($sender) {
		if ($sender->hasPermission("vanisall.use")) {
			$sender->sendMessage(
				"§a---- §5Vanish§aAll §bCommands §a----"."\n"."\n".
				"§eUse:§a /vall on|off §7(Set on/off the global vanish.)"."\n".
				"§eUse:§a /vall view §7(View vanished players.)"."\n".
				"§eUse:§a /vall credits §7(See VanishAll Credits.)"
			);
		} else {
			$sender->sendMessage(
				"§a---- §5Vanish§aAll §bCommands §a----"."\n"."\n".
				"§eUse:§a /vall credits §7(See VanishAll Credits.)"
			);
		}
	}
}
