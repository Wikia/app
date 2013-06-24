<?php
/**
 * @author Jacek Jursza
 */

class EntityAPIClient {

	protected $logLevel = 1;
	protected $classifierEndpoint = "http://db-sds-s1:8081/graph-0.3.1/classifications/";
	protected $saveEndpoint = "http://db-sds-s1:8081/knowledge/entitycollections";

	public function getClassifierEndpoint( $wikiUrl, $pageTitle ) {
		return $this->classifierEndpoint .urldecode( $wikiUrl ).'/'.$pageTitle;
	}

	public function getSaveEndpoint() {
		return $this->saveEndpoint;
	}

	protected function log( $text, $level = 1 ) {
		if ( $level >= $this->logLevel  ) {
			echo "$text \n";
		}
	}

	public function postJson( $url, $jsonString ) {

		$this->log( "Connect: $url ", 1);
		if ( is_array( $jsonString ) ) {
			$jsonString = json_encode( $jsonString );
		}
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
		curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonString);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
				'Content-Type: application/json',
				'Content-Length: ' . strlen($jsonString) )
		);
		$result = curl_exec($ch);
		$info = curl_getinfo($ch);
		curl_close($ch);
		return array( 'response' => $result, 'code' => $info['http_code'] );
	}

	public function get( $url, $postData = false  ) {

		$this->log( "Connect: $url ", 1);
		$options = array( 'followRedirects' => true,
			'noProxy' => true,
			'timeout' => 120
		);

		if ( $postData !== false ) {
			$options['postData'] = $postData;
			print_r( $postData );
		}

		$req = MWHttpRequest::factory( $url, $options );
		$status = $req->execute();

		$decodedResponse = null;

		if( $status->isOK() ) {
			$response = $req->getContent();
			$responseCode = $req->getStatus();
			$decodedResponse = json_decode ( $response );
		}

		return array( 'code' => $responseCode, 'response' => $decodedResponse );
	}

	public function post( $url, $data ) {

	}

}
