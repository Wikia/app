<?php

abstract class UserLoginBaseTest extends WikiaBaseTest {

	const TEST_CITY_ID = 79860;

	protected $skinOrg = null;

	public function setUp() {
		$this->setupFile = dirname(__FILE__) . '/../UserLogin.setup.php';
		parent::setUp();

		//Set up empty TempUser
		$this->setUpMockObject( 'TempUser', false, true );
	}

	protected function setUpMockObject( $objectName, $objectParams=null, $needSetInstance=false, $globalVarName=null, $objectValues=array(), $callOriginalConstructor=true ) {
		$mockObject = $objectParams;
		if ( is_array($objectParams) ) {

			//list of methods
			$methods = array_keys( $objectParams );

			//add methods from mockValueMap list if exists
			if( isset($objectParams['mockValueMap']) ) {
				$methodsForValMap = array_keys( $objectParams['mockValueMap'] );
				$methods = array_merge( $methods, $methodsForValMap);
			}

			if ( $callOriginalConstructor ) {
				$mockObject = $this->getMock( $objectName, $methods, $objectValues );
			} else {
				$mockObject = $this->getMock( $objectName, $methods, $objectValues, '', false );
			}

			foreach( $objectParams as $method => $value ) {
				if ( $method == 'params' || $method == 'mockValueMap' || $method == 'mockStatic' ) {
					// processed later
				} else if ( $value === null ) {
					$mockObject->expects( $this->any() )
						->method( $method );
				} else if ( is_array($value) && array_key_exists('mockExpTimes', $value) && array_key_exists('mockExpValues', $value) ) {
					if ( $value['mockExpValues'] == null ) {
						$mockObject->expects( $this->exactly($value['mockExpTimes']) )
							->method( $method );
					} else {
						$mockObject->expects( $this->exactly($value['mockExpTimes']) )
							->method( $method )
							->will( $this->returnValue($value['mockExpValues']) );

					}
				} else {
					$mockObject->expects( $this->any() )
						->method( $method )
						->will( $this->returnValue($value) );
				}
			}

			if ( !empty( $objectParams['params'] ) ) {
				$properties = $objectParams['params'];
				$reflCl = new ReflectionClass($mockObject);
				foreach ($properties as $name => $value) {
					$reflProp = $reflCl->getProperty($name);
					$reflProp->setAccessible(true);
					$reflProp->setValue($mockObject,$value);
				}
			}

			if ( !empty( $objectParams['mockValueMap'] ) ) {
				$parameters = $objectParams['mockValueMap'];
				foreach ($parameters as $method => $valueMap) {
					$mockObject->expects( $this->any() )
						->method( $method )
						->will( $this->returnValueMap( $valueMap ) );
				}
			}
		}

		if ( !empty($globalVarName) && $objectParams !== null ) {
			$this->mockGlobalVariable( $globalVarName, $mockObject );
		}

		if ( $needSetInstance ) {
			$this->mockClass( $objectName, $mockObject );
			if ( $objectName == 'User' ) {
				$this->mockClass( $objectName, $mockObject, 'newFromName' );
				$this->mockClass( $objectName, $mockObject, 'newFromId' );
				$this->mockClass( $objectName, $mockObject, 'newFromConfirmationCode' );
				$this->mockClass( $objectName, $mockObject, 'newFromSession' );
				$this->mockClass( $objectName, $mockObject, 'newFromRow' );
			}
			if ( $objectName == 'TempUser' ) {
				$this->mockClass( $objectName, $mockObject, 'getTempUserFromName' );
				$this->mockClass( $objectName, $mockObject, 'createNewFromUser' );
			}
			if ( !empty( $objectParams['mockStatic'] ) ) {
				$parameters = $objectParams['mockStatic'];
				foreach ($parameters as $method => $value) {
					$this->mockClass( $objectName, $value, $method );
				}
			}
		}
	}

	/**
	 * Mocks wfMessage global function
	 * parepares $this->returnMessageMap based on param $map
	 *
	 * returnMessageMap is prepared in a way that will return message key as result value
	 * (means returnMessageMap is $map with added result values as last item in each sub array)
	 * returnMessageMap is used by messageMockCallback to return result values
	 *
	 * 	Example returnMessageMap
	 * 		$map = array(
	 * 			array( 'usersignup-confirmation-email-sent', self::TEST_USERNAME, 'usersignup-confirmation-email-sent' ),
	 * 			array( 'usersignup-confirmation-heading', 'usersignup-confirmation-heading' ),
	 * 			array( 'another-message-key', $messageParam1, 'another-message-key' ),
	 * 		);
	 *
	 * @param $map Array consists of arrays of message parameters
	 * (all message parameters have to be specified, even default ones)
	 *
	 * 	Example $map
	 * 		$mockMessagesMap1 = array(
	 * 			array( 'usersignup-confirmation-email-sent', self::TEST_USERNAME ),
	 * 			array( 'usersignup-confirmation-heading' ),
	 * 			array( 'another-message-key', $messageParam1 ),
	 * 		);
	 */
	protected function mockWfMessage( $map ) {

		$returnMap = array();
		foreach( $map as $msgParams ) {
			$msgClassMock = $this->getMessageMock( $msgParams[0] /* we want message mock to return just message key */);
			$msgParams[] = $msgClassMock;
			$returnMap[] = $msgParams;
		}

		$this->emptyMessageMock = $this->getMessageMock();
		$this->returnMessageMap = $returnMap;

		$mock = $this->getGlobalFunctionMock( 'wfMessage' );
		$mock->expects( $this->any() )
			->method( 'wfMessage' )
			->will( $this->returnCallback(
					array($this, 'messageMockCallback')
				)
			);

	}

	/**
	 * Callback for preparing results of wfMessage calls
	 * return either Message object mock from returnMessageMap that matches parameters
	 * or default empty Message object mock
	 *
	 * requre $this->returnMessageMap and $this->emptyMessageMock to be set by mockWfMessage
	 * 
	 * @return $returnVal Message
	 */
	public function messageMockCallback() {

		$params = func_get_args();

		foreach( $this->returnMessageMap as $mapItem ) {

			$lastId = count( $mapItem ) - 1;
			$returnVal = $mapItem[ $lastId ];
			unset( $mapItem[ $lastId ] );

			if ($mapItem == $params) {
				return $returnVal;
			}

		}

		return $this->emptyMessageMock;

	}

	/**
	 * Returns Message class mock - used by mockWfMessage
	 * mocks all wfMessage output methods plain, text, parse, escaped and inLanguage
	 *
	 * @param $retVal String value to be returned when one of wfMessage output methods will be invoked
	 * @return $msgClassMock Mock of Message class
	 */
	protected function getMessageMock( $retVal = '' ) {

		$msgClassMock = $this->getMock( 'Message', array('plain','parse','escaped','inLanguage'), array('keyname') );

		$msgClassMock->expects( $this->any() )
			->method( 'plain' )
			->will( $this->returnValue( $retVal ) );

		$msgClassMock->expects( $this->any() )
			->method( 'text' )
			->will( $this->returnValue( $retVal ) );

		$msgClassMock->expects( $this->any() )
			->method( 'parse' )
			->will( $this->returnValue( $retVal ) );

		$msgClassMock->expects( $this->any() )
			->method( 'escaped' )
			->will( $this->returnValue( $retVal ) );

		//inLanguage returns Message so return value should be Message mock
		$msgClassMock->expects( $this->any() )
			->method( 'inLanguage' )
			->will( $this->returnValue( $msgClassMock ) );

		return $msgClassMock;
	}

	protected function setUpRequest( $params=array() ) {
		$wgRequest = new WebRequest();
		foreach( $params as $key => $value ) {
			$wgRequest->setVal( $key, $value );
		}
		$this->mockGlobalVariable('wgRequest', $wgRequest);
	}

	protected function setUpSession( $params=array() ) {
		if ( !empty($params) ) {
			foreach( $params as $key => $value ) {
				$_SESSION[$key] = $value;
			}
		}
	}

	protected function tearDownSession( $params=array() ) {
		if ( !empty($params) ) {
			foreach( $params as $key => $value ) {
				unset($_SESSION[$key]);
			}
		}
	}

	protected function setUpMobileSkin( $mobileSkin ) {
		$this->skinOrg = RequestContext::getMain()->getSkin();
		RequestContext::getMain()->setSkin( $mobileSkin );
	}

	protected function tearDownMobileSkin() {
		RequestContext::getMain()->setSkin( $this->skinOrg );
	}

}
