<?php 
require('soap-wsse.php');

class ExactTargetSoapClient extends SoapClient {
	public $username = NULL;
	public $password = NULL;

	/**
	 * @param bool $retryAttempt Is this call a repeated attempt to send data. Needs to be available for warning
	 * handler that decides whether to requeue request.
	 */
	function __doRequest($request, $location, $saction, $version, $one_way = 0, $retryAttempt = false) {
		$doc = new DOMDocument();
		$doc->loadXML($request);

		$objWSSE = new WSSESoap($doc);

		$objWSSE->addUserToken($this->username, $this->password, FALSE);
		set_error_handler('\Wikia\ExactTarget\ExactTargetSoapErrorHandler::requeueConnectionResetWarning', E_USER_WARNING);
		$response = parent::__doRequest($objWSSE->saveXML(), $location, $saction, $version);
		restore_error_handler();

		return $response;
	 }
}
