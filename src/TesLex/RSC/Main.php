<?php

namespace TesLex\RSC;

use pocketmine\plugin\PluginBase;
//import com.google.gson.Gson;
use TesLex\RSC\config\Config;
use TesLex\RSC\console\Console;
use TesLex\RSC\socketio\Server;
use TesLex\RSC\console\utils\JWT;

/*import java.io.BufferedReader;
import java.io.FileNotFoundException;
import java.io.FileReader;
import java.io.UnsupportedEncodingException;
import java.util.HashMap;
import java.util.Map;
import java.util.Random;*/

public class Main extends PluginBase {

	private $s;

	private static $config;

	private String $sign = mt_rand();

	public function onEnable() {
		$this->config = $this->loadCfg();

		if ($this->config->getSecret()->equalsIgnoreCase("0.0.0.0") ||
				$this->config->getSecret().equalsIgnoreCase("CHANGE IT")) {
			$this->getLogger()->info("§cERROR: CHANGE DEFAULT PARAMS IN CONFIG");
		} else {
			Console::startTailing();

			$s = new Server(getServer()->getIp(), $this->config->getPort(), $this, $this->config->getSecret());
			$s->start();

			$data = ["host" => $this->config->getHost(), "port" => $this->config->getPort(), "secret" => $this->config->getSecret()];

			try {
				$this->getLogger()->info("§eYOUR TOKEN: §a" . JWT::createToken($this->sign, $data));
			} catch (UnsupportedEncodingException $e) {
				$e->printStackTrace();
				$s->stop();
			}

		}
	}

	public function onDisable() {
		$this->s->stop();
	}


	private function loadCfg() : Config {
		$this->saveResource("config.json");
	}

	public static function getPConfig() : Config {
		return $config;
	}
}
