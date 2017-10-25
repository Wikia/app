<?php
/**
 * Unit tests for Wikia modifications DatabaseBase.
 *
 */

use Wikia\Util\Statistics\BernoulliTrial;

class DatabaseBaseTester extends DatabaseBase {
	protected function doQuery( $sql ) {}
	function open( $server, $user, $password, $dbName ) {}
	function getType() {}
	function fetchObject( $res ) {}
	function fetchRow( $res ) {}
	function numRows( $res ) {}
	function numFields( $res ) {}
	function fieldName( $res, $n ) {}
	function insertId() {}
	function dataSeek( $res, $row ) {}
	function lastErrno() {}
	function lastError() {}
	function fieldInfo( $table, $field ) {}
	function indexInfo( $table, $index, $fname = 'Database::indexInfo' ) {}
	function affectedRows() {}
	function strencode( $s ) {}
	function getSoftwareLink() {}
	function getServerVersion() {}
	function getServerInfo() {}

}

class DatabaseBaseTest extends \PHPUnit\Framework\TestCase {

	public function testLogSql() {
		$wikiaLoggerMock = $this->createMock( \Wikia\Logger\WikiaLogger::class );

		$wikiaLoggerMock->expects( $this->once() )
			->method( 'info' )
			->will( $this->returnValue( true ) );

		$wikiaLoggerMock->expects( $this->once() )
			->method( 'defaultLogger' )
			->willReturnSelf();

		$return = 'a value';
		$databaseBaseTesterMock = $this->getMockBuilder( DatabaseBaseTester::class )
			->setMethods( [ 'doQuery', 'getWikiaLogger', 'resultObject' ] )
			->getMock();
		$databaseBaseTesterMock->expects( $this->once() )
			->method( 'doQuery' )
			->will( $this->returnValue( $return ) );

		$databaseBaseTesterMock->expects( $this->once() )
			->method( 'getWikiaLogger' )
			->will( $this->returnValue( $wikiaLoggerMock ) );

		$databaseBaseTesterMock->expects( $this->once() )
			->method( 'resultObject' )
			->will( $this->returnValue( $return ) );

		$databaseBaseTesterMock->setSampler( new BernoulliTrial( 1.0 ) );

		$this->assertEquals( $return, $databaseBaseTesterMock->query( 'SELECT bar' ) );
	}

}
