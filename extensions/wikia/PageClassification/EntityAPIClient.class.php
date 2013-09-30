<?php
/**
 * @author Jacek Jursza
 */

class EntityAPIClient {

	protected $logLevel = 1;
	protected $classifierEndpoint = "http://db-sds-s2:8081/graph-0.3.1/classifications/";
	protected $saveEndpoint = "http://db-sds-s2:8081/knowledge-0.2.1/entitycollections";
	protected $decisionsEndpoint = "http://db-sds-s2:8081/knowledge-0.2.1/decisions/";
	protected $indexedWikisEndpoint = "http://db-sds-s2:8081/knowledge-0.2.1/wikis/";


	public function getIndexedWikisEndpoint() {
		return $this->indexedWikisEndpoint;
	}

	public function getClassifierEndpoint( $wikiUrl, $pageTitle ) {
		return $this->classifierEndpoint .urldecode( $wikiUrl ).'/'.$pageTitle;
	}

	public function getSaveEndpoint() {
		return $this->saveEndpoint;
	}

	public function getDecisionsEndpoint( $wikiId, $articleId = 0 ) {
		return $this->decisionsEndpoint . $wikiId . ( $articleId == 0 ? '' : '/'.$articleId );
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
			'timeout' => 220
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
			$response = iconv('UTF-8', 'UTF-8//IGNORE', utf8_encode($response));
			$responseCode = $req->getStatus();
			$decodedResponse = json_decode ( $response );
		}

		return array( 'code' => $responseCode, 'response' => $decodedResponse );
	}

	public function post( $url, $data ) {

	}

	/**
	 * @param int $logLevel
	 */
	public function setLogLevel( $logLevel ) {
		$this->logLevel = $logLevel;
	}

	/**
	 * @return int
	 */
	public function getLogLevel() {
		return $this->logLevel;
	}



}
