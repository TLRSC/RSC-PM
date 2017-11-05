<?php

namespace TesLex\RSC\config;

public class Config {

	private String $host = "127.0.0.1";

	private int $port = 9094;

	private String $secret;

	public getHost() : String {
		return $this->host;
	}

	public function setHost(String $host) {
		$this->host = $host;
	}

	public function getPort() : int {
		return $this->port;
	}

	public function setPort(int $port) {
		$this->port = $port;
	}

	public getSecret() : String {
		return $this->secret;
	}

	public function setSecret(String $secret) {
		$this->secret = $secret;
	}

}