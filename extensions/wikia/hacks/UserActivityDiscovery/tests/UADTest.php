<?php
//require_once dirname(__FILE__) . '/../UAD.php';

class UADTest extends WikiaBaseTest {

	const TEST_TOKEN_ID = 10;

	/**
	 * @var UAD
	 */
	protected $object = null;
	protected $app = null;

	protected function setUp() {
		$this->markTestSkipped('hack');
		$this->app = $this->getMock('WikiaApp', array(), array(), '', false);
		$this->object = $this->getMock('UAD', array( 'getDb' ), array( $this->app ));
	}

	/**
	 * @group Hack
	 */
	public function testCreatingToken() {
		$dbMock = $this->getMock( 'DatabaseMysql', array( 'insert', 'insertId', 'update', 'commit' ) );

		$dbMock->expects( $this->once() )
		       ->method( 'insert' )
		       ->with( $this->equalTo( UAD::TOKEN_DB_NAME ), $this->equalTo( array( 'uto_created' => date('Y-m-d H:i:s') ) ), $this->equalTo( 'UAD::createToken' ) );

		$dbMock->expects( $this->once() )
		       ->method( 'insertId' )
		       ->will( $this->returnValue( self::TEST_TOKEN_ID ) );

		$dbMock->expects( $this->once() )
		       ->method( 'update' )
		       ->with( $this->equalTo( UAD::TOKEN_DB_NAME ), $this->equalTo( array( 'uto_value' => md5( self::TEST_TOKEN_ID ) ) ), $this->equalTo( array( 'uto_id' => self::TEST_TOKEN_ID ) ), $this->equalTo( 'UAD::createToken' ) );

		$dbMock->expects( $this->once() )
		       ->method( 'commit' );

		$this->object->expects( $this->once() )
		          ->method( 'getDb' )
		          ->will( $this->returnValue( $dbMock ) );

		$token = $this->object->createToken();

		$this->assertEquals( md5( self::TEST_TOKEN_ID ), $token );
	}

	/**
	 * @expectedException WikiaException
	 * @group Hack
	 */
	public function testCreatingTokenException() {
		$dbMock = $this->getMock( 'DatabaseMysql', array( 'insert', 'insertId', 'update', 'commit' ) );
		$dbMock->expects( $this->once() )
		       ->method( 'insert' )
		       ->with( $this->equalTo( UAD::TOKEN_DB_NAME ), $this->anything(), $this->equalTo( 'UAD::createToken' ) );

		$dbMock->expects( $this->once() )
		       ->method( 'insertId' )
		       ->will( $this->returnValue( 0 ) );

		$this->object->expects( $this->once() )
		          ->method( 'getDb' )
		          ->will( $this->returnValue( $dbMock ) );

		$this->object->createToken();
	}

	public function storingEventsDataProvider() {
		$events1 = new stdClass();
		$events1->visit = 3;
		$events1->visitedWikis = array( 1, 2 );

		$events2 = new stdClass();
		$events2->visit = 0;
		$events2->visitedWikis = array();

		return array(
			array( $events1 ),
			array( $events2 )
		);
	}

	/**
	 * @group Hack
	 * @dataProvider storingEventsDataProvider
	 */
	public function testStoringEvents( $events) {
		$date = date('Y-m-d');
		$token = md5( self::TEST_TOKEN_ID);
		$insertsNum = ( $events->visit > 0 ? 1 : 0 ) + count( $events->visitedWikis );

		$dbMock = $this->getMock( 'DatabaseMysql', array( 'insert', 'commit' ) );
		if( $insertsNum > 0 ) {
			$dbMock->expects( $this->exactly( $insertsNum ) )
			       ->method( 'insert' )
			       ->with( $this->equalTo( UAD::EVENT_DB_NAME ), $this->anything(), $this->equalTo( 'UAD::storeEvents' ) );
		}
		else {
			$dbMock->expects( $this->never() )
			       ->method( 'insert' );
		}

		$dbMock->expects( $this->once() )
		       ->method( 'commit' );

		$this->object->expects( $this->once() )
		          ->method( 'getDb' )
		          ->will( $this->returnValue( $dbMock ) );

		$this->object->storeEvents( $token, $date, $events );

	}
}
