<?php

/**
 * This is the subclass for Lua library tests. It will automatically run all
 * tests against LuaSandbox and LuaStandalone.
 *
 * Most of the time, you'll only need to override the following:
 * - $moduleName: Name of the module being tested
 * - getTestModules(): Add a mapping from $moduleName to the file containing
 *   the code.
 */
abstract class Scribunto_LuaEngineTestBase extends MediaWikiTestCase {
	private static $engineConfigurations = array(
		'LuaSandbox' => array(
			'memoryLimit' => 50000000,
			'cpuLimit' => 30,
			'allowEnvFuncs' => true,
		),
		'LuaStandalone' => array(
			'errorFile' => null,
			'luaPath' => null,
			'memoryLimit' => 50000000,
			'cpuLimit' => 30,
			'allowEnvFuncs' => true,
		),
	);

	private static $staticEngineName = null;
	private $engineName = null;
	private $engine = null;
	private $luaDataProvider = null;

	/**
	 * Name to display instead of the default
	 * @var string
	 */
	protected $luaTestName = null;

	/**
	 * Name of the module being tested
	 * @var string
	 */
	protected static $moduleName = null;

	/**
	 * Class to use for the data provider
	 * @var string
	 */
	protected static $dataProviderClass = 'Scribunto_LuaDataProvider';

	function __construct( $name = null, array $data = array(), $dataName = '', $engineName = null ) {
		if ( $engineName === null ) {
			$engineName = self::$staticEngineName;
		}
		$this->engineName = $engineName;
		parent::__construct( $name, $data, $dataName );
	}

	public static function suite( $className ) {
		return self::makeSuite( $className );
	}

	protected static function makeSuite( $className, $group = null ) {
		$suite = new PHPUnit_Framework_TestSuite;
		$suite->setName( $className );

		$class = new ReflectionClass( $className );
		$parser = new Parser;
		$parser->startExternalParse( Title::newMainPage(), new ParserOptions, Parser::OT_HTML, true );

		foreach ( self::$engineConfigurations as $engineName => $opts ) {
			if ( $group !== null && $group !== $engineName ) {
				continue;
			}

			try {
				$engineClass = "Scribunto_{$engineName}Engine";
				$engine = new $engineClass(
					self::$engineConfigurations[$engineName] + array( 'parser' => $parser )
				);
				$engine->setTitle( $parser->getTitle() );
				$engine->getInterpreter();
			} catch ( Scribunto_LuaInterpreterNotFoundError $e ) {
				$suite->addTest(
					new $className( 'skipUnavailable', array(), '', $engineName ),
					array( 'Lua', $engineName )
				);
				continue;
			}

			// Work around PHPUnit breakage: the only straightforward way to
			// get the data provider is to call
			// PHPUnit_Util_Test::getProvidedData, but that instantiates the
			// class without passing any parameters to the constructor. But we
			// *need* that engine name.
			self::$staticEngineName = $engineName;

			$engineSuite = new PHPUnit_Framework_TestSuite;
			$engineSuite->setName( "$engineName: $className" );

			foreach ( $class->getMethods() as $method ) {
				if ( PHPUnit_Framework_TestSuite::isPublicTestMethod( $method ) ) {
					$name = $method->getName();
					$groups = PHPUnit_Util_Test::getGroups( $className, $name );
					$groups[] = 'Lua';
					$groups[] = $engineName;
					$groups = array_unique( $groups );

					$data = PHPUnit_Util_Test::getProvidedData( $className, $name );
					if ( is_array( $data ) || $data instanceof Iterator ) {
						// with @dataProvider
						$dataSuite = new PHPUnit_Framework_TestSuite_DataProvider(
							$className . '::' . $name
						);
						foreach ( $data as $k => $v ) {
							$dataSuite->addTest(
								new $className( $name, $v, $k, $engineName ),
								$groups
							);
						}
						$engineSuite->addTest( $dataSuite );
					} elseif ( $data === false ) {
						// invalid @dataProvider
						$engineSuite->addTest( new PHPUnit_Framework_Warning(
							"The data provider specified for {$className}::$name is invalid."
						) );
					} else {
						// no @dataProvider
						$engineSuite->addTest(
							new $className( $name, array(), '', $engineName ),
							$groups
						);
					}
				}
			}

			$suite->addTest( $engineSuite );
		}

		return $suite;
	}

	function tearDown() {
		if ( $this->luaDataProvider ) {
			$this->luaDataProvider->destroy();
			$this->luaDataProvider = null;
		}
		if ( $this->engine ) {
			$this->engine->destroy();
			$this->engine = null;
		}
		parent::tearDown();
	}

	function getEngine() {
		if ( !$this->engine ) {
			$parser = new Parser;
			$options = new ParserOptions;
			$options->setTemplateCallback( array( $this, 'templateCallback' ) );
			$parser->startExternalParse( Title::newMainPage(), $options, Parser::OT_HTML, true );
			$class = "Scribunto_{$this->engineName}Engine";
			$this->engine = new $class(
				self::$engineConfigurations[$this->engineName] + array( 'parser' => $parser )
			);
			$this->engine->setTitle( $parser->getTitle() );
		}
		return $this->engine;
	}

	function skipUnavailable() {
		$this->markTestSkipped( "interpreter for $this->engineName is not available" );
	}

	function templateCallback( $title, $parser ) {
		if ( isset($this->extraModules[$title->getFullText()]) ) {
			return array(
				'text' => $this->extraModules[$title->getFullText()],
				'finalTitle' => $title,
				'deps' => array()
			);
		}

		$modules = $this->getTestModules();
		foreach ( $modules as $name => $fileName ) {
			$modTitle = Title::makeTitle( NS_MODULE, $name );
			if ( $modTitle->equals( $title ) ) {
				return array(
					'text' => file_get_contents( $fileName ),
					'finalTitle' => $title,
					'deps' => array()
				);
			}
		}
		return Parser::statelessFetchTemplate( $title, $parser );
	}

	function toString() {
		// When running tests written in Lua, return a nicer representation in
		// the failure message.
		if ( $this->luaTestName ) {
			return $this->engineName . ': ' . $this->luaTestName;
		}
		return $this->engineName . ': ' . parent::toString();
	}

	function getTestModules() {
		return array(
			'TestFramework' => __DIR__ . '/TestFramework.lua',
		);
	}

	function provideLuaData() {
		if ( !$this->luaDataProvider ) {
			$class = static::$dataProviderClass;
			$this->luaDataProvider = new $class ( $this->getEngine(), static::$moduleName );
		}
		return $this->luaDataProvider;
	}

	/** @dataProvider provideLuaData */
	function testLua( $key, $testName, $expected ) {
		$this->luaTestName = static::$moduleName."[$key]: $testName";
		$actual = $this->provideLuaData()->run( $key );
		$this->assertSame( $expected, $actual );
		$this->luaTestName = null;
	}
}
