<?php

namespace TesLex\RSC\console\events;

use pocketmine\Thread;

public class ConsoleUpdate extends Thread {

	private $listeners = [];

	private String $consoleFile;

	public function ConsoleUpdate(String $consoleFile) {
		$this->consoleFile = $consoleFile;
	}

	public function run() {
		$input = null;
		try {
			$input = new BufferedReader(new FileReader($consoleFile));
		} catch (FileNotFoundException $e) {
			$e->printStackTrace();
		}
		String $currentLine = null;

		while (true) {
			try {
				if (($currentLine = $input->readLine()) != null) {
					String $finalCurrentLine = $currentLine;
					$listeners->forEach($e -> $e->onText($finalCurrentLine));
					continue;
				}
			} catch (IOException $e) {
				$e->printStackTrace();
			}

			try {
				Thread::sleep(1000);
			} catch (InterruptedException $e) {
				Thread::currentThread()->interrupt();
				break;
			}

		}

		try {
			$input->close();
		} catch (IOException $e) {
			$e->printStackTrace();
		}
	}

	public function addUpdateListener(ConsoleUpdateEvent $consoleUpdateEvent) {
		$this->listeners->add($consoleUpdateEvent);
	}

}