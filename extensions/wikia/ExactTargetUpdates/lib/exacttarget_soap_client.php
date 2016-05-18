<?php 
require('soap-wsse.php');

class ExactTargetSoapClient extends SoapClient {
	public $username = NULL;
	public $password = NULL;

	function __doRequest($request, $location, $saction, $version, $one_way = 0) {
		$doc = new DOMDocument();
		$doc->loadXML($request);

		$objWSSE = new WSSESoap($doc);

		$objWSSE->addUserToken($this->username, $this->password, FALSE);

		return parent::__doRequest($objWSSE->saveXML(), $location, $saction, $version);
	 }
}
