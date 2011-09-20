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
	public $token = null;
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

	private function getMemcKey($ixBug){
		$key = wfSharedMemcKey( __CLASS__ , 'Cases', $ixBug ); 
		return $key;
	}

	private function getFromMemCache($ixBug){
		global $wgMemc;
		return $wgMemc->get( FogbugzService::getMemcKey($ixBug), null);
	}

	private function sendToMemCache(Array $case){
		global $wgMemc;
		$wgMemc->set( FogbugzService::getMemcKey($case["ixBug"]), $case );
	}

	/**
	 * @author: Piotr Paw³owski (Pepe)
	 *
	 * get info about case(cases) passed as a parameter and all children cases, which main parrent(parrents) is(are) $casesIDs
	 * @param int/array $casesIDs
	 * @return array $results
	 *
	 */
	public function getCasesBasicInfo( $casesIDs ) { 
		// returns set of info of cases passed as a parameter and all subcases
		//$mysqlCommand = 'select * from fogbugz_cases where ixBug in ('.implode(',', $casesIDs).')';
		$results = array();
		$IDsToGet = $casesIDs;
		$childrenIDs = array();
		if ( !empty( $this->token ) ) {
			while ( !empty( $IDsToGet ) ) {
				foreach ($IDsToGet as $index => $value) {
					$memc = $this->getFromMemCache($value);
					if ($memc != null) {
						$buffer =  $memc;
						$results[] = $buffer;
						
						unset($IDsToGet[$index]);
						$childrenIDs = array_merge( $childrenIDs, $buffer['ixBugChildren'] );
					}
				}

				if (!empty($IDsToGet)){
					
					$casesList = implode(',', $IDsToGet);
					$res = $this->findAndSaveCasesToMemc($casesList);
				
					$results = array_merge($results, $res);

					foreach( $res as $case){
						//$this->sendToMemCache($case);
						$childrenIDs = array_merge( $childrenIDs, $case['ixBugChildren'] );
					}
				}

				$IDsToGet = $childrenIDs;
				unset( $childrenIDs );
				$childrenIDs = array();
			}
			return $results;

		} else {
			throw new WikiaException("Fogbugz connection failed");
		}
	}

	

	/**
	 * Find and save result of query 
	 * @param string $q - query 
	 * @return null/array $results  
	 */
	public function findAndSaveCasesToMemc($q, $saveToMemc = true, $columns = '' ){
		$cols = '';
		if ( $columns == '' ) {
			$cols = 'sTitle,ixBug,sStatus,ixBugChildren,ixBugParent,ixPriority,ixProject,ixCategory,dtOpened,dtResolved,dtClosed,dtLastUpdated';	
		} else {
			$cols = $columns;
		}
		
		//$results = array();
		$this->resetParams();
		$this->setParam( 'cmd', 'search' );
		$this->setParam( 'token', $this->token );
		$this->setParam( 'q', $q );
		$this->setParam( 'cols', $cols );

		
		$this->curl->setopt_array( $this->getCurlOptions() );
		$xml = $this->curl->exec();

		if( !empty( $xml ) ) {
			$dom = new DOMDocument;
			$dom->loadXML( $xml );
			$cases = $dom->getElementsByTagName( 'case' );
			foreach( $cases as  $case ) {
				$titles = explode( ",", $cols );
				$ixBugChildren = '';
				$sTags = '';
				if (in_array('ixBugChildren', $titles)) {
					$ixBugChildren = $case->getElementsByTagName( 'ixBugChildren' )->item(0)->nodeValue;
				}				
				if ( strlen($ixBugChildren) > 0 ) {
					$ixBugChildren = explode( ",", $ixBugChildren );
				} else {
					$ixBugChildren = array();
				}
				
				//pawelrychly - tags repair
				if ( in_array( 'tags', $titles ) ){ 
					$tags = $case->getElementsByTagName( 'tags' );
					$tagsList = "";
					foreach ( $tags as $tag_list ) {
						$tag = $tag_list->getElementsByTagName( 'tag' );
						for ( $i=0; $i < $tag->length; $i++ ) {
							$tagsList .= $tag->item($i)->nodeValue;
							if ( $i != $tag->length-1 ) {
								$tagsList .= ', ';	
							}
			
						}
					}
				}
			
				if (!isset($case->getElementsByTagName( 'sTags' )->item(0)->nodeValue)) {
					$sTags = '';
				} else {
					$sTags = $case->getElementsByTagName( 'sTags' )->item(0)->nodeValue;
				}
				
				$res = array();
				
				foreach ( $titles as $title ) {
					if ( $title == 'ixBugChildren' ) {
						$res[$title] = $ixBugChildren;
					} else if ( $title == 'sTags' ) {
						$res[$title] = $sTags;
					} else if ( $title == 'tags' ) {
						$res[$title] = $tagsList; 
					}else {	
						$res[$title] = $case->getElementsByTagName( $title )->item(0)->nodeValue;
					}
				}
				$results[] = $res;
			
				if ($saveToMemc == true) {
					$this->sendToMemCache($results[count($results)-1] );
				}
			}
		}

		if (isset($results)){
			return $results;
		} else {
			return array();
		}

	}
	//pawelrychly, piotrp
	/**
	 * Function return info about user with given id or email
	 * @param int/string $idOrEmail
	 * @param string $infolist list of columns which we want to get ( comma is a separator )
	 * @return array informations about user
	 */
	public function getPersonInfo( $idOrEmail, $infolist ) {
		unset($result);
		$result = array();
		$this->resetParams();
		$this->setParam( 'cmd', 'viewPerson' );
		$this->setParam( 'token', $this->token );
		if ( is_int( $idOrEmail ) ) {
			$this->setParam( 'ixPerson', $idOrEmail );
		} else {
			$this->setParam( 'sEmail', $idOrEmail );
		}
		$this->curl->setopt_array( $this->getCurlOptions() );
		$xml = $this->curl->exec();
		if( !empty( $xml ) ) {
			$dom = new DOMDocument;
			$dom->loadXML( $xml );
			$person = $dom->getElementsByTagName( 'person' );
			
			if ( !is_array( $infolist ) ) {
				$infolist = explode(',', $infolist);
			}
	
			foreach ($person as $per) {
				foreach ( $infolist as $data ) {
					$result[$data] = $per->getElementsByTagName( $data )->item(0)->nodeValue;
				}
			}	
		}
		return $result;
	}
	/**
	 *
	 * Return case's comments; I assume that there wouldn't be single requests for events of more than 1 case
	 * (comments should be show when user clicks on proper button
	 * Important: Function is not ready and not used yet.
	 * that might be corrected/developed in future
	 * 
	 * THIS NO WORK !!!
	 * THIS NO WORK !!!
	 * 
	 * @param int $caseID
	 */
	public function getComments($caseID) {
		$res ='No comments for this case.';
		$this->resetParams();
		$this->setParam( 'cmd', 'search' );
		$this->setParam( 'token', $this->token );
		$this->setParam( 'q', $caseID );
		$this->setParam( 'cols', 'events' );
		$this->curl->setopt_array( $this->getCurlOptions() );
		$xml = $this->curl->exec();
		if( !empty( $xml ) ) {
			$dom = new DOMDocument;
			$dom->loadXML( $xml );
			//$case = $dom->getElementsByTagName( 'case' );
			$events = $dom->getElementsByTagName( 'event' );//->item(0)->nodeValue;
			unset($res);
			$res = array();

			foreach ($events as $event) {
				$res[] = array(
						'ixPerson' => $event->getElementsByTagName( 'ixPerson' )->item(0)->nodeValue,
						'sPerson' => $event->getElementsByTagName( 'sPerson' )->item(0)->nodeValue,
						'ixPersonAssignedTo' => $event->getElementsByTagName( 'ixPersonAssignedTo' )->item(0)->nodeValue,
						'dt' => $event->getElementsByTagName( 'dt' )->item(0)->nodeValue,
						'evtDescription' => $event->getElementsByTagName( 'evtDescription' )->item(0)->nodeValue,
						'sChanges' => $event->getElementsByTagName( 'sChanges' )->item(0)->nodeValue
				);

			}
		}
		return $res;
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