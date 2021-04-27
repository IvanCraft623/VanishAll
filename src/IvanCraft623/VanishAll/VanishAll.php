<?php

declare(strict_types=1);

#Plugin By:

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

namespace IvanCraft623\VanishAll;

use IvanCraft623\VanishAll\{Command\VallCommand, Task\VanishTask};

use pocketmine\{Server, Player, plugin\PluginBase};

class VanishAll extends PluginBase {

	public static $instance;

	public static $vanisAll = false;

	public static $allowView = [];

	public function onLoad() : void {
		self::$instance = $this;
	}
	public function onEnable() : void {
		$this->getScheduler()->scheduleRepeatingTask(new VanishTask($this), 20);
		$this->loadCommands();
	}

	public static function getInstance() : self {
		return self::$instance;
	}

	public static function getPrefix() : string {
		return "§l§5Vanish§aAll §r§7» ";
	}

	public function loadCommands() : void {
		$values = [new VallCommand($this)];
		foreach ($values as $commands) {
			$this->getServer()->getCommandMap()->register('_cmd', $commands);
		}
		unset($values);
	}
}
