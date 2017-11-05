<?php

namespace TesLex\RSC\console;

use pocketmine\command\ConsoleCommandSender;

public class RSCCommandSender extends ConsoleCommandSender {

	public getName() : String {
		return "RSC";
	}

}