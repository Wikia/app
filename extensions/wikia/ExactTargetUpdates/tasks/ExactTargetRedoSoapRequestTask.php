<?php
namespace Wikia\ExactTarget;

class ExactTargetRedoSoapRequestTask {

	public function redoSoapRequestTask( $request, $location, $saction, $version, $one_way ) {
		$oExactTargetApiHelper = new ExactTargetApiHelper();
		$oExactTargetSoapClient = $oExactTargetApiHelper->getClient();
		$oExactTargetSoapClient->__doRequest( $request, $location, $saction, $version, $one_way, true );
		return 'OK';
	}

}
