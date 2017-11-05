<?php

namespace TesLex\RSC\console;

use pocketmine\command\CommandSender;
use TesLex\RSC\console\events\ConsoleUpdate;
use TesLex\RSC\console\events\ConsoleUpdateEvent;
use pocketmine\Server;

public class Console {

	private static $consoleUpdate;

	public static function startTailing() {
		$this->consoleUpdate = new ConsoleUpdate("server.log");
		$this->consoleUpdate->start();
	}

	public static function addUpdateListener(ConsoleUpdateEvent $consoleUpdateEvent) {
		$this->consoleUpdate->addUpdateListener($consoleUpdateEvent);
	}

	public static function dispachCommand(CommandSender $commandSender, String $cmd) {
		Server::getInstance()->getScheduler()->scheduleTask(()->Server::getInstance()->dispatchCommand($commandSender, $cmd));
	}

}
