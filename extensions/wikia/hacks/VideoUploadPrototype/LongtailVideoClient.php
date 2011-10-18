<?php
/**
 * Author: Sean Colombo
 * Date: 20110211
 *
 * Client to use BitsOnTheRun by LongtailVideo.
 *
 * For now this is being hacked together for a demo, so it is by no means complete.
 *
 * NOTE: This requires the $wgLongtailVideo_apiKey and $wgLongtailVideo_apiSecret globals
 * to be set in the site-configuration files (LocalSettings.php, CommonSettnigs.php, WikiFactory, whatever).
 *
 * NOTE: For playback of this video, Wikia's "youtube" extension must be installed an enabled for the <longtail/>
 * parser-tag to work.
 */

class LongtailVideoClient {
	// Should these consts just be define()s?
	var $LV_API_PROTOCOL;
	var $LV_API_SERVER;
	var $LV_API_VERSION;
	var $LV_API_FORMAT;

	var $LV_API_URL;

	public function __construct() {
		$this->LV_API_PROTOCOL = 'http';
		$this->LV_API_SERVER = 'api.bitsontherun.com';
		$this->LV_API_VERSION = 'v1';
		$this->LV_API_FORMAT = 'php';

		$this->LV_API_URL = $this->LV_API_PROTOCOL . '://' . $this->LV_API_SERVER . '/' . $this->LV_API_VERSION;
	} // end constructor

	/**
	 * Wrapper for the /videos/create call which returns data which can then be used in an upload form (or a post)
	 * to send the actual video-file to Longtail.
	 */
	public function videos_create($title='', $tags='', $description=''){
		wfProfileIn( __METHOD__ );

		$data = array(
			'title' => $title,
			'tags' => $tags,
			'description' => $description
		);

		$result = $this->makeCall('/videos/create', $data);

		wfProfileOut( __METHOD__ );
		return $result;
	}

	/**
	 * Wrapper for sending any call to the API.  Takes care of universally-applicable issues like
	 * authentication, deserialization, etc..
	 */
	private function makeCall($callPath, $data=array()){
		global $wgLongtailVideo_apiKey;
		wfProfileIn( __METHOD__ );

		$data['api_key'] = $wgLongtailVideo_apiKey;
		$data['api_timestamp'] = time();
		$data['api_nonce'] = $this->getNonce();
		$data['api_format'] = $this->LV_API_FORMAT;

		// This must be done after all other data has been set.
		$this->signRequest($data);

		// Make the call and turn the response into a value.
		$url = $this->LV_API_URL . $callPath . '?' . http_build_query($data);

		$result = Http::get( $url );

		//TODO: Error-handling.
		if ($result === false){
		} else {
			$result = unserialize( $result );
		}


		wfProfileOut( __METHOD__ );
		return $result;
	} // end makeCall()

	/**
	 * Return an 8-digit random number to be used as the API-nonce (helps prevent replay-attacks).
	 */
	private function getNonce(){
		return sprintf('%08d', mt_rand(0, 99999999));
	}

	/**
	 * Adds the api_signature to the data-array using the scheme described here:
	 * http://developer.longtailvideo.com/botr/system-api/authentication.html
	 *
	 * This function expects the api_key, api_timestamp, api_nonce, api_format, etc. to already
	 * exist in the data array.
	 */
	private function signRequest(&$data){
		global $wgLongtailVideo_apiSecret;
		wfProfileIn( __METHOD__ );

		// Urlencode all params
		foreach($data as $key => $val){
			if($key != urlencode($key)){
				unset($data[$key]);
				$data[urlencode($key)] = urlencode($val);
			} else {
				$data[$key] = urlencode($val);
			}
		}

		// Sort by lexicographical byte value of the keys (ascending).
		ksort($data);

		// Concatenate the params (separate key/value with = and pairs from each other using &)
		$queryString = http_build_query($data);

		// Calculate the sha1() of the string and the API shared secret.
		$signature = sha1($queryString . $wgLongtailVideo_apiSecret);

		$data['api_signature'] = $signature;

		wfProfileOut( __METHOD__ );
	} // end getSignature()

} // end class LongtailVideoClient