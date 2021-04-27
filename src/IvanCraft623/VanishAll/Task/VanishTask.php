<?php

declare(strict_types=1);

namespace IvanCraft623\VanishAll\Task;

use IvanCraft623\VanishAll\{VanishAll};

use pocketmine\{Server, Player, scheduler\Task};

class VanishTask extends Task {

	public $plugin;

	public function __construct(VanishAll $plugin) {
		$this->plugin = $plugin;
	}

	public function onRun(int $currentTick) : void {
		if (VanishAll::$vanisAll) {
			foreach (Server::getInstance()->getOnlinePlayers() as $player) { # Player to vanish
				foreach (Server::getInstance()->getOnlinePlayers() as $pl) { # Players that do that cant see player
					if (!in_array($pl->getName(), VanishAll::$allowView)) {
						$pl->hidePlayer($player);
					} else {
						$pl->showPlayer($player);
					}
				}
			}
		}
	}
}
