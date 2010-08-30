<?php
class ApiService extends Service {

	/**
	 * Simple wrapper for calling MW API
	 */
	static function call($params) {
		wfProfileIn(__METHOD__);

		$res = false;

		try {
			$api = new ApiMain(new FauxRequest($params));
			$api->execute();
			$res = $api->getResultData();
		}
		catch(Exception $e) {};

		wfProfileOut( __METHOD__ );
		return $res;
	}
}