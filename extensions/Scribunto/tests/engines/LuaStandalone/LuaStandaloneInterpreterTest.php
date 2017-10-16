<?php

if ( PHP_SAPI !== 'cli' ) exit;
require_once( dirname( __FILE__ ) .'/../LuaCommon/LuaInterpreterTest.php' );

class Scribunto_LuaStandaloneInterpreterTest extends Scribunto_LuaInterpreterTest {
	var $stdOpts = array(
		'errorFile' => null,
		'luaPath' => null,
		'memoryLimit' => 50000000,
		'cpuLimit' => 30,
	);

	function getVsize( $pid ) {
		$size = wfShellExec( wfEscapeShellArg( 'ps', '-p', $pid, '-o', 'vsz', '--no-headers' ) );
		return $size * 1024;
	}

	function newInterpreter( $opts = array() ) {
		$opts = $opts + $this->stdOpts;
		$engine = new Scribunto_LuaStandaloneEngine( $this->stdOpts );
		return new Scribunto_LuaStandaloneInterpreter( $engine, $opts );
	}

	function testGetStatus() {
		$startTime = microtime( true );
		if ( php_uname( 's' ) !== 'Linux' ) {
			$this->markTestSkipped( "getStatus() not supported on platforms other than Linux" );
			return;
		}
		$interpreter = $this->newInterpreter();
		$status = $interpreter->getStatus();
		$pid = $status['pid'];
		$this->assertInternalType( 'integer', $status['pid'] );
		$initialVsize = $this->getVsize( $pid );
		$this->assertGreaterThan( 0, $initialVsize, 'Initial vsize' );

		$chunk = $this->getBusyLoop( $interpreter );

		while ( microtime( true ) - $startTime < 1 ) {
			$interpreter->callFunction( $chunk, 100 );
		}
		$status = $interpreter->getStatus();
		$vsize = $this->getVsize( $pid );
		$time = $status['time'] / $interpreter->engine->getClockTick();
		$this->assertGreaterThan( 0.1, $time, 'getStatus() time usage' );
		$this->assertLessThan( 1.5, $time, 'getStatus() time usage' );
		$this->assertEquals( $vsize, $status['vsize'], 'vsize', $vsize * 0.1 );
	}
}
