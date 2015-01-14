<?php

class Scribunto_LuaEnvironmentComparisonTest extends MediaWikiTestCase {
	var $sandboxOpts = array(
		'memoryLimit' => 50000000,
		'cpuLimit' => 30,
		'allowEnvFuncs' => true,
	);
	var $standaloneOpts = array(
		'errorFile' => null,
		'luaPath' => null,
		'memoryLimit' => 50000000,
		'cpuLimit' => 30,
		'allowEnvFuncs' => true,
	);

	protected $engines = array();

	function setUp() {
		parent::setUp();

		$parser = new Parser;
		$options = new ParserOptions;
		$options->setTemplateCallback( array( $this, 'templateCallback' ) );
		$parser->startExternalParse( Title::newMainPage(), $options, Parser::OT_HTML, true );

		try {
			$engine = new Scribunto_LuaSandboxEngine(
				array( 'parser' => $parser ) + $this->sandboxOpts
			);
			$engine->setTitle( $parser->getTitle() );
			$engine->getInterpreter();
			$this->engines['LuaSandbox'] = $engine;
		} catch ( Scribunto_LuaInterpreterNotFoundError $e ) {
			$this->markTestSkipped( "LuaSandbox interpreter not available" );
			return;
		}

		try {
			$engine = new Scribunto_LuaStandaloneEngine(
				array( 'parser' => $parser ) + $this->standaloneOpts
			);
			$engine->setTitle( $parser->getTitle() );
			$engine->getInterpreter();
			$this->engines['LuaStandalone'] = $engine;
		} catch ( Scribunto_LuaInterpreterNotFoundError $e ) {
			$this->markTestSkipped( "LuaStandalone interpreter not available" );
			return;
		}
	}

	function tearDown() {
		foreach ( $this->engines as $engine ) {
			$engine->destroy();
		}
		$this->engines = array();
		parent::tearDown();
	}

	private function getGlobalEnvironment( $engine ) {
		static $script = <<<LUA
			xxxseen = {}
			function xxxGetTable( t )
				if xxxseen[t] then
					return 'table'
				end
				local ret = {}
				xxxseen[t] = ret
				for k, v in pairs( t ) do
					if k ~= '_G' and string.sub( k, 1, 3 ) ~= 'xxx' then
						if type( v ) == 'table' then
							ret[k] = xxxGetTable( v )
						elseif type( v ) == 'string'
							or type( v ) == 'number'
							or type( v ) == 'boolean'
							or type( v ) == 'nil'
						then
							ret[k] = v
						else
							ret[k] = type( v )
						end
					end
				end
				return ret
			end
			return xxxGetTable( _G )
LUA;
		$func = $engine->getInterpreter()->loadString( $script, 'script' );
		return $engine->getInterpreter()->callFunction( $func );
	}

	function testGlobalEnvironment() {
		// Grab the first engine as the "standard"
		reset( $this->engines );
		list( $firstName, $firstEngine ) = each( $this->engines );
		$firstEnv = $this->getGlobalEnvironment( $firstEngine );

		// Test all others against it
		while ( list( $secondName, $secondEngine ) = each( $this->engines ) ) {
			$secondEnv = $this->getGlobalEnvironment( $secondEngine );
			$this->assertEquals( $firstEnv, $secondEnv,
				"Environments for $firstName and $secondName are not equivalent" );
		}
	}
}
