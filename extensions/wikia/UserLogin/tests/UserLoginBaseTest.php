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
