<?php

namespace TesLex\RSC\socketio\models;

public class RunCommand {

	private String $command;

	public function RunCommand() {}

	public function RunCommand(String $command) {
		$this->command = $command;
	}

	public function getCommand() : String {
		return $this->command;
	}

	public function setCommand(String $command) {
		$this->command = $command;
	}
}
