<?php

use \Wikia\Util\GlobalStateWrapper;
use PHPUnit\Framework\TestCase;

/**
 * WikiaBaseTest class - part of Wikia UnitTest Framework - W(U)TF
 * @author ADi
 * @author Owen
 * @author Władysław Bodzek <wladek@wikia-inc.com>
 * Usage:
 *		$this->mockGlobalVariable( 'wgCityId', '12345' );
 *		$this->mockGlobalFunction( 'getDB', $dbMock );
 *
 * Complications: Most extensions have a setup file.  If this setup file is NOT globally included, you will have to
 * include it yourself in the constructor for your unit test.  PHPUnit interacts weirdly with autoloader.
 *
 * function setUp() {
 *    $this->setupFile = __DIR__ . '/../MyExtension_setup.php';
 *    parent::setUp();
 * }
 */
abstract class WikiaBaseTest extends TestCase {
	use MockGlobalVariableTrait;

	const MOCK_DEV_NAME = 'mockdevname';

	protected static $alternativeConstructors = [
		'Article' => [ 'newFromID', 'newFromTitle', 'newFromWikiPage' ],
		'Title' => [ 'newFromDBkey', 'newFromText', 'newFromURL', 'newFromID', 'newFromRow' ],
		'User' => [ 'newFromName', 'newFromId', 'newFromToken', 'newFromRow' ],
	];


	/** @var string */
	protected $setupFile = null;
	/** @var WikiaApp */
	protected $app = null;

	/** @var array */
	private $mockedMessages = array();
	/** @var WikiaMockProxy */
	private $mockProxy = null;
	private $mockMessageCacheGet = null;

	private static $numberSlowTests = 0;

	protected function setUp() {
		$this->startTime = microtime(true);
		$this->app = F::app();

		if ($this->setupFile != null) {
			global $IP; 					// used by setup file
			global $app; 					// used by setup file
			global $wgAutoloadClasses; 		// used by setup file
			global $wgDevelEnvironment;  	// used by setup file
			require_once($this->setupFile);
		}

		if ( $this->mockProxy !== null ) {
			throw new Exception("Previous test did not execute tearDown()");
		}
		$this->mockProxy = new WikiaMockProxy();
		$this->mockProxy->enable();
	}

	protected function tearDown() {
		global $wgAnnotateTestSpeed;

		$this->unsetGlobals();
		$this->unsetMessages();
		if ( $this->mockProxy === null ) {
			throw new Exception("Current test did not execute setUp()");
		}
		$this->mockProxy->disable();
		$this->mockProxy = null;

		if ( WikiaTestSpeedAnnotator::isMarkedAsSlow($this->getAnnotations() ) ) {
			self::$numberSlowTests++;
		}

		if ($wgAnnotateTestSpeed) {
			WikiaTestSpeedAnnotator::add(get_class($this), $this->getName(false), microtime(true) - $this->startTime,
				$this->getAnnotations());
		}
	}

	/**
	 * Ugly hack
	 *
	 * @deprecated use getMockBuilder() or createMock() instead
	 * @param $originalClassName
	 * @param array $methods
	 * @param array $arguments
	 * @param string $mockClassName
	 * @param bool $callOriginalConstructor
	 * @param bool $callOriginalClone
	 * @param bool $callAutoload
	 * @param bool $cloneArguments
	 * @return PHPUnit_Framework_MockObject_MockObject
	 */
	protected function getMock( $originalClassName, $methods = [], array $arguments = [], $mockClassName = '', $callOriginalConstructor = true, $callOriginalClone = true, $callAutoload = true, $cloneArguments = true ) {
		$mockBuilder = $this->getMockBuilder( $originalClassName )
			->setMethods( $methods )
			->setConstructorArgs( $arguments )
			->setMockClassName( $mockClassName );

		if ( !$callOriginalConstructor ) {
			$mockBuilder = $mockBuilder->disableOriginalConstructor();
		}

		if ( !$callOriginalClone ) {
			$mockBuilder = $mockBuilder->disableOriginalClone();
		}

		if ( !$callAutoload ) {
			$mockBuilder = $mockBuilder->disableAutoload();
		}

		if ( !$cloneArguments ) {
			$mockBuilder = $mockBuilder->disableArgumentCloning();
		}

		return $mockBuilder->getMock();
	}

	/**
	 * @throws Exception
	 * @return WikiaMockProxy
	 */
	private function getMockProxy() {
		if ( empty( $this->mockProxy ) ) {
			throw new Exception("WikiaMockProxy is not initialized yet. Are you trying to mock anything in data provider?");
		}
		return $this->mockProxy;
	}

	/**
	 * Mock a class constructor so it returns the given object as a result.
	 * Handles both regular and static constructors.
	 *
	 * Example call:
	 * 	$this->mockClass('Article', $mockArticle);
	 *  $this->mockClass('Title', $mockTitle, 'newFromText');
	 * @param $className String
	 * @param $mock PHPUnit_Framework_MockObject_MockObject instance of Mock
	 * @param $functionName String name of static constructor
	 * @return void
	 * @throws Exception
	 */
	protected function mockClass($className, $mock, $functionName = null) {
		$functionNames = is_array( $functionName ) ? $functionName : array( $functionName );
		foreach ($functionNames as $functionName) {
			if ( empty( $mock ) && empty($functionName) ) {
				// constructor cannot return null
				trigger_error( sprintf( '%s: mock of class %s cannot be empty', __METHOD__, $className ), E_USER_WARNING );
				return;
			}
			if ( empty($functionName) ) { // regular constructor
				$action = $this->getMockProxy()->getClassConstructor($className);
			} else {
				$action = $this->getMockProxy()->getStaticMethod($className,$functionName);
			}
			$action->willReturn($mock);
		}
	}

	/**
	 * Mock a class constructor so it returns the given object as a result.
	 * Designed specifically for Mediawiki classes that have plenty of different static constructors.
	 * In that case this method hijacks calls to all of them and returns the provided object.
	 *
	 * @see WikiaBaseTest::$alternativeConstructors
	 *
	 * @param $className string Class name
	 * @param $mock PHPUnit_Framework_MockObject_MockObject Mocked object
	 */
	protected function mockClassEx( $className, $mock ) {
		$alternativeConstructors = isset( self::$alternativeConstructors[$className] )
			? self::$alternativeConstructors[$className] : array();
		$alternativeConstructors[] = null; // null stands for regular constructor
		$this->mockClass($className,$mock,$alternativeConstructors);
	}

	/**
	 * Create mocked object of a given class with list of methods and values they return provided
	 *
	 * @param string $className name of the class to be mocked
	 * @param array $methods list of methods and values they should return
	 * @param string $staticConstructor name of the "static" class constructor (e.g. Title::newFromText) that will return mocked object
	 * @return PHPUnit_Framework_MockObject_MockObject mocked object
	 */
	protected function mockClassWithMethods($className, Array $methods = array(), $staticConstructor = '') {
		$mock = $this->createConfiguredMock( $className, $methods );

		$this->mockClass($className, $mock, ($staticConstructor !== '') ? $staticConstructor : null);

		return $mock;
	}

	/**
	 * Mock a static method using single return value
	 *
	 * Example:
	 *
	 * $this->mockStaticMethod('Http', 'post', json_encode(['foo' => 'bar']));
	 *
	 * @param $className string class name
	 * @param $methodName string method name
	 * @param $retVal mixed result to be returned by mocked method
	 */
	protected function mockStaticMethod($className, $methodName, $retVal) {
		$this->getMockProxy()
			->getStaticMethod($className, $methodName)
			->willReturn($retVal);
	}

	/**
	 * Mock a static method using callback
	 *
	 * Example:
	 *
	 * $this->mockStaticMethodWithCallBack( 'Title', 'newFromID',
	 *   function ( $titleId ) {
	 *     $titleMock = $this->getMock( 'Title', [ 'getArticleID' ] );
	 *     $titleMock->expects( $this->any() )
	 *       ->method( 'getArticleID' )
	 *       ->willReturn( $titleId );
	 *     return $titleMock;
	 *   }
	 * );
	 * $this->assertEquals( 7, Title::newFromID( 7 )->getArticleID() );
	 * $this->assertEquals( 12, Title::newFromID( 12 )->getArticleID() );
	 * $this->assertEquals( 123, Title::newFromID( 123 )->getArticleID() );
	 *
	 * @param $className string
	 * @param $methodName string
	 * @param $callBack callable
	 */
	protected function mockStaticMethodWithCallBack( $className, $methodName, callable $callBack) {
		$this->getMockProxy()
			->getStaticMethod($className, $methodName)
			->willCall($callBack);
	}

	/**
	 * Mock global (wf...) function.
	 *
	 * @param $functionName string Global function name (including "wf" prefix)
	 * @param $returnValue mixed
	 * @param $callsNum int
	 * @param $inputParams array
	 * @throws Exception
	 */
	protected function mockGlobalFunction( $functionName, $returnValue ) {

		list( $namespace, $baseName ) = WikiaMockProxy::parseGlobalFunctionName( $functionName );

		$mock = $this->getGlobalFunctionMock( $functionName );
		$expect = $mock->expects( $this->any() )
						->method( $baseName );

		$expect->will( $this->returnValue( $returnValue ) );

		$this->getMockProxy()->getGlobalFunction($functionName)
			->willCall(array($mock,$functionName));
	}

	/**
	 * Mock given message
	 *
	 * @param string $messageKey
	 * @param string $messageContent
	 * @param string $langCode
	 */
	protected function mockMessage($messageKey, $messageContent, $langCode = 'en') {
		MessageCache::singleton()->mExtensionMessages[$langCode][lcfirst( $messageKey )] =
			$messageContent;
	}

	/**
	 * Return the database connection handler mock
	 *
	 * @param array $methods
	 * @return PHPUnit_Framework_MockObject_MockObject
	 */
	protected function getDatabaseMock( $methods = [] ) {
		return
			$this->getMockBuilder( DatabaseMysqli::class )
				->setMethods( $methods )
				->getMock();
	}

	/**
	 * Get a PHPUnit mock associated with global function
	 *
	 * @param $functionName string Global function name
	 * @return PHPUnit_Framework_MockObject_MockObject Mock
	 */
	protected function getGlobalFunctionMock( $functionName ) {
		list($namespace,$baseName) = WikiaMockProxy::parseGlobalFunctionName( $functionName );
		$mock =
			$this->getMockBuilder( stdClass::class )
				->setMethods( [ $baseName ] )
				->getMock();

		$this->getMockProxy()->getGlobalFunction($functionName)
			->willCall(array($mock,$baseName));
		return $mock;
	}

	/**
	 * Get a PHPUnit mock associated with static class method
	 *
	 * @param $className string Class name
	 * @param $methodName string Method name
	 * @return PHPUnit_Framework_MockObject_MockObject Mock
	 */
	protected function getStaticMethodMock( $className, $methodName ) {
		is_callable( "{$className}::{$methodName}" ); // autoload
		$mock =
			$this->getMockBuilder( stdClass::class )
				->setMethods( [ $methodName ] )
				->getMock();

		$this->getMockProxy()->getStaticMethod($className,$methodName)
			->willCall(array($mock,$methodName));
		return $mock;
	}

	/**
	 * Get a PHPUnit mock associated with regular class method
	 *
	 * @param $className string Class name
	 * @param $methodName string Method name
	 * @return PHPUnit_Framework_MockObject_MockObject Mock
	 */
	protected function getMethodMock( $className, $methodName ) {
		is_callable( "{$className}::{$methodName}" ); // autoload
		$mock =
			$this->getMockBuilder( stdClass::class )
				->setMethods( [ $methodName ] )
				->getMock();

		$this->getMockProxy()->getMethod($className,$methodName)
			->willCall(array($mock,$methodName));
		return $mock;
	}

	protected function getMessageMock( $messageKey ) {
		if ( empty( $this->mockMessageCacheGet ) ) {
			$mockMessageCache = $this->mockMessageCacheGet = $this->getMethodMock( 'MessageCache', 'get' );

			$mockMessageCache->expects( $this->any() )
				->method( 'get' )
				->will( $this->returnCallback( array( $this, '__retrieveMessageMock' ) ) );
		}

		$mock =
			$this->getMockBuilder( stdClass::class )
				->setMethods( [ 'get' ] )
				->getMock();
		$this->mockedMessages[$messageKey] = $mock;
		return $mock;
	}

	/**
	 * Call an original global function
	 *
	 * @param $functionName string Global function name
	 * @param $args array Arguments
	 * @return mixed Value returned by global function
	 */
	protected function callOriginalGlobalFunction( $functionName, $args ) {
		return $this->getMockProxy()->callOriginalGlobalFunction( $functionName, $args );
	}

	/**
	 * Call an original regular class method
	 *
	 * @param $object object Object to call method on
	 * @param $functionName string Method name
	 * @param $args array Arguments
	 * @return mixed Value returned by method
	 */
	protected function callOriginalMethod( $object, $functionName, $args ) {
		return $this->getMockProxy()->callOriginalMethod( $object, $functionName, $args );
	}

	/**
	 * Call an original static class method
	 *
	 * @param $className string Class name
	 * @param $functionName string Method name
	 * @param $args array Arguments
	 * @return mixed Value returned by method
	 */
	protected function callOriginalStaticMethod( $className, $functionName, $args ) {
		return $this->getMockProxy()->callOriginalStaticMethod( $className, $functionName, $args );
	}

	/**
	 * @return WikiaMockProxyInvocation
	 */
	protected function getCurrentInvocation() {
		return WikiaMockProxyAction::currentInvocation();
	}

	private function unsetMessages() {
		$this->mockedMessages = array();
	}

	/**
	 * (internal use only)
	 * Get a message contents taking into accounts all the configured message mocks
	 *
	 * @param $key string Message key
	 * @return string Message contents
	 */
	public function __retrieveMessageMock( $key ) {
		if ( array_key_exists( $key, $this->mockedMessages ) ) {
			/** @var $mock PHPUnit_Framework_MockObject_MockObject Mock */
			$mock = $this->mockedMessages[$key];
			return $mock->get();
		}

		return $this->callOriginalMethod( MessageCache::singleton(), 'get', func_get_args() );
	}

	/**
	 * Mocks global $wgMemc->get() so it always returns null
	 */
	protected function disableMemCache() {
		$this->mockGlobalVariable( 'wgMemc', new EmptyBagOStuff() );
	}

	/**
	 * Run given callback in a context that has memcache disabled
	 *
	 * @see PLATFORM-1337
	 *
	 * @param callable $callback function to run
	 * @return mixed the value returned by $callback
	 */
	protected function memCacheDisabledSection( callable $callback ) {
		$globalState = new GlobalStateWrapper( [
			'wgMemc' => new EmptyBagOStuff()
		] );

		return $globalState->wrap( $callback );
	}

	protected function mockPreviewEnv() {
		$this->mockGlobalVariable( 'wgDevelEnvironment', false );
		$this->mockGlobalVariable( 'wgStagingEnvironment', true );
		$this->mockGlobalVariable( 'wgWikiaEnvironment', WIKIA_ENV_PREVIEW );
	}

	protected function mockStagingEnv() {
		$this->mockGlobalVariable( 'wgDevelEnvironment', false );
		$this->mockGlobalVariable( 'wgWikiaBaseDomain', 'wikia-staging.com' );
		$this->mockGlobalVariable( 'wgWikiaEnvironment', WIKIA_ENV_STAGING );
	}

	protected function mockVerifyEnv() {
		$this->mockGlobalVariable( 'wgDevelEnvironment', false );
		$this->mockGlobalVariable( 'wgStagingEnvironment', true );
		$this->mockGlobalVariable( 'wgWikiaEnvironment', WIKIA_ENV_VERIFY );
	}

	protected function mockStableEnv() {
		$this->mockGlobalVariable( 'wgDevelEnvironment', false );
		$this->mockGlobalVariable( 'wgStagingEnvironment', true );
		$this->mockGlobalVariable( 'wgWikiaEnvironment', WIKIA_ENV_STABLE );
	}

	protected function mockSandboxEnv() {
		$this->mockGlobalVariable( 'wgDevelEnvironment', false );
		$this->mockGlobalVariable( 'wgStagingEnvironment', false );
		$this->mockGlobalVariable( 'wgWikiaEnvironment', WIKIA_ENV_SANDBOX );
		$this->getStaticMethodMock( 'WikiFactory', 'getExternalHostName' )
			->expects( $this->any() )
			->method( 'getExternalHostName' )
			->willReturn( 'sandbox-s1' );
	}

	protected function mockProdEnv() {
		$this->mockGlobalVariable( 'wgDevelEnvironment', false );
		$this->mockGlobalVariable( 'wgWikiaBaseDomain', 'wikia.com' );
		$this->mockGlobalVariable( 'wgWikiaEnvironment', WIKIA_ENV_PROD );
	}

	protected function mockDevEnv() {
		$this->mockGlobalVariable( 'wgDevelEnvironmentName', self::MOCK_DEV_NAME );
		$this->mockGlobalVariable( 'wgDevDomain', self::MOCK_DEV_NAME . '.wikia-dev.us' );
		$this->getStaticMethodMock( 'WikiFactory', 'getExternalHostName' )
			->expects( $this->any() )
			->method( 'getExternalHostName' )
			->willReturn( self::MOCK_DEV_NAME );
	}

	protected function mockEnvironment( $environment ) {
		switch ( $environment ) {
			case WIKIA_ENV_PROD:
				$this->mockProdEnv();
				break;
			case WIKIA_ENV_PREVIEW:
				$this->mockPreviewEnv();
				break;
			case WIKIA_ENV_STAGING:
				$this->mockStagingEnv();
				break;
			case WIKIA_ENV_VERIFY:
				$this->mockVerifyEnv();
				break;
			case WIKIA_ENV_SANDBOX:
				$this->mockSandboxEnv();
				break;
			case WIKIA_ENV_DEV:
				$this->mockDevEnv();
				break;
			case WIKIA_ENV_STABLE:
				$this->mockStableEnv();
				break;
		}
	}
}
