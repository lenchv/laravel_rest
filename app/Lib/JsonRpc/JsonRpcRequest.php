<?php
namespace App\Lib\JsonRpc;

class JsonRpcRequest {
	public $version;
	public $method;
	public $params;
	public $id;
	
	public function __construct($data) {
		$arData = json_decode($data);
		$this->version = $arData["jsonrpc"];
		$this->method = $arData["method"];
		$this->params = $arData["params"];
		$this->id = $arData["id"];
	}
}