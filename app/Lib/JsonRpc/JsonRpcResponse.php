<?php
namespace App\Lib\JsonRpc;

class JsonRpcResponse {
	const VERSION = "2.0";
	private $result;
	private $id;
	private $error = array();
	public function setResult($result) {
		$this->result = $result;
		return $this;
	}

	public function setId($id) {
		$this->id = $id;
		return $this;
	}

	public function setError($code, $error) {
		$this->error[$code] = $error;
		return $this;
	}

	public function render() {
		return [
			"jsonrpc" => self::VERSION,
			"result" => $this->result,
			"error" => $this->error,
			"id" => $this->id
		];
	}
}