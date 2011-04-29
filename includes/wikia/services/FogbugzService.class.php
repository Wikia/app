<?php

class FogbugzService extends Service {

	/**
	 * curl wrapper
	 * @var Curl
	 */
	protected $curl;
	protected $login;
	protected $passwd;
	protected $params = array();
	protected $token = null;
	protected $HTTPProxy = null;

	public function __construct( $url, $login = '', $passwd = '', $HTTPProxy = null ) {
		$this->setCurl( F::build( 'Curl', array( 'url' => $url ) ) );
		$this->setLogin( $login );
		$this->setPasswd( $passwd );
		$this->setHTTPProxy( $HTTPProxy );
	}

	public function setCurl(Curl $curl) {
		$this->curl = $curl;
	}

	public function setLogin($value) {
		$this->login = $value;
	}

	public function setPasswd($value) {
		$this->passwd = $value;
	}

	public function setHTTPProxy($value) {
		$this->HTTPProxy = $value;
	}

	private function getCurlOptions() {
		$curlOptions = array();
		if( !empty( $this->HTTPProxy ) ) {
			$curlOptions[CURLOPT_PROXY] = $this->HTTPProxy;
		}

		$curlOptions[CURLOPT_TIMEOUT] = 30;
		$curlOptions[CURLOPT_RETURNTRANSFER] = 1;
		$curlOptions[CURLOPT_POSTFIELDS] = $this->getFormattedParams();

		return $curlOptions;
	}

	/**
	 * login to Fogbugz API
	 * @return FogbugzService
	 */
	public function logon() {
		$this->resetParams();
		$this->setParam( 'cmd', 'logon' );
		$this->setParam( 'email', $this->login );
		$this->setParam( 'password', $this->passwd );

		$this->curl->setopt_array( $this->getCurlOptions() );
		$xml = $this->curl->exec();

		if( !empty( $xml ) ) {
			$dom = new DOMDocument;
			$dom->loadXML( $xml );

			$error = $dom->getElementsByTagName( 'error' )->item(0);
			if( $error instanceof DOMElement ) {
				throw new WikiaException("Fogbugz login failed");
			}
			else {
				$this->token = $dom->getElementsByTagName( 'token' )->item(0)->nodeValue;
			}
		}
		else {
			throw new WikiaException("Fogbugz connection failed");
		}
		return $this;
	}

	/**
	 * logout from Fogbugz API
	 * @return FogbugzService
	 */
	public function logoff() {
		$this->resetParams();
		$this->setParam( 'cmd', 'logoff' );
		$this->setParam( 'token', $this->token );

		$this->curl->setopt_array( $this->getCurlOptions() );
		$xml = $this->curl->exec();

		if( !empty( $xml ) ) {
			$this->token = null;
			return $this;
		}
		else {
			throw new WikiaException("Fogbugz connection failed");
		}
	}

	/**
	 * get list of areas
	 * @param int $projectId project id
	 * @return FogbugzService
	 */
	public function getAreas( $projectId = null) {
		$results = array();
		if( !empty($this->token) ) {
			$this->resetParams();
			$this->setParam( 'cmd', 'listAreas' );
			$this->setParam( 'token', $this->token );

			$this->curl->setopt_array( $this->getCurlOptions() );

			$xml = $this->curl->exec();
			if( !empty( $xml ) ) {
				$dom = new DOMDocument;
				$dom->loadXML( $xml );
				$areas = $dom->getElementsByTagName( 'area' );
				foreach( $areas as $area ) {
					$areaProjectId = $area->getElementsByTagName( 'ixProject' )->item(0)->nodeValue;
					if( ( $projectId == null ) || ( $projectId == $areaProjectId ) ) {
						$results[] = array(
							'id' => $area->getElementsByTagName( 'ixArea' )->item(0)->nodeValue,
							'name' => $area->getElementsByTagName( 'sArea' )->item(0)->nodeValue,
							'projectId' => $areaProjectId
						);
					}
				}
			}
			else {
				throw new WikiaException("Fogbugz connection failed");
			}
		}
		return $results;
	}

	/**
	 * create new case in Fogbugz
	 * @param int $areaId
	 * @param string $title
	 * @param int $priority
	 * @param string $message
	 * @param array $tags
	 * @param string $customerEmail
	 * @param int $projectId
	 */
	public function createCase( $areaId, $title, $priority, $message, Array $tags = null, $customerEmail = '', $projectId = null ) {
		if( !empty($this->token) ) {
			$this->resetParams();
			$this->setParam( 'cmd', 'new' );
			$this->setParam( 'token', $this->token );
			$this->setParam( 'sTitle', $title );
			$this->setParam( 'ixArea', $areaId );
			$this->setParam( 'ixPriority', $priority );
			$this->setParam( 'sEvent', $message );
			if( !empty($tags) ) {
				$this->setParam( 'sTags', implode( ',', $tags ));
			}
			if( !empty( $customerEmail ) ) {
				$this->setParam( 'sCustomerEmail', $customerEmail );
			}
			if( !empty( $projectId ) ) {
				$this->setParam( 'ixProject', $projectId );
			}

			$this->curl->setopt_array( $this->getCurlOptions() );

			$xml = $this->curl->exec();
			if( !empty( $xml ) ) {
				$dom = new DOMDocument;
				$dom->loadXML( $xml );
				$case = $dom->getElementsByTagName( 'case' )->item(0);
				if( $case instanceof DOMNode ) {
					return array( 'caseId' => $case->attributes->getNamedItem( 'ixBug' )->nodeValue );
				}
				else {
					throw new WikiaException("Fogbugz creating case Failed");
				}
			}
			else {
				throw new WikiaException("Fogbugz connection failed");
			}
		}
	}

	protected function setParam( $name, $value ) {
		$this->params[$name] = $value;
	}

	protected function resetParams() {
		$this->params = array();
	}

	private function getFormattedParams() {
		$params = '';
		foreach( $this->params as $k => $v ) {
			if( $params != '' ) {
				$params .= '&';
			}
			$params .= $k . '=' . $v;
		}
		return $params;
	}

}