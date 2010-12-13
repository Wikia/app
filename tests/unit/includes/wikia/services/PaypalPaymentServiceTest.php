<?php
/**
 * PaypalPaymentService test
 *
 * @category Wikia
 * @package  Wikia_Test
 * @version $Id:$
 */

/**
 * PaypalPaymentService test
 *
 * @category Wikia
 * @package  Wikia_Test
 * @see PaypalPaymentService
 * @author Wojciech Szela <wojtek@wikia-inc.com>
 */
class PaypalPaymentServiceTest extends PHPUnit_Framework_TestCase {
	const TEST_TOKEN = 'EC-00000001';
	private $paypalService;

	protected function setUp() {
		$this->paypalService = new PaypalPaymentService(array());
		$this->dbCleanup();
	}

	protected function tearDown() {
		$this->dbCleanup();
		$this->paypalService = null;
	}

	public function dbCleanup() {
		$dbw = wfGetDB( DB_MASTER, array(), $this->paypalService->getPaypalDBName() );
		$dbw->delete( 'pp_tokens', array( 'ppt_token' => self::TEST_TOKEN ), __METHOD__ );
	}

	public function testFetchTokenIsStoredInDBDataProvider() {
		return array (
			array( true, true, 0 ),
			array( false, true, 1 ),
			array( false, false, null )
		);
	}

	/**
	 * @dataProvider testFetchTokenIsStoredInDBDataProvider
	 * @param unknown_type $expectedResult
	 * @param unknown_type $hasResult
	 * @param unknown_type $resuyltValue
	 */
	public function testFetchTokenIsStoredInDB( $expectedResult, $hasResult, $resultValue ) {
		$returnUrl = 'http://return.url';
		$cancelUrl = 'http://cancel.url';
		$testRESPMSG = 'testRESPMSG';
		$testCORRELATIONID = 'testCID';

		$returnValue = array( 'RESULT' => $resultValue, 'TOKEN' => self::TEST_TOKEN, 'RESPMSG' => $testRESPMSG, 'CORRELATIONID' => $testCORRELATIONID);
		if( !$hasResult ) {
			unset($returnValue['RESULT']);
		}

		$payflowAPI = $this->getMock( 'PayflowAPI' );
		$payflowAPI->expects($this->once())
		           ->method('setExpressCheckout')
		           ->with($this->equalTo( $returnUrl ), $this->equalTo( $cancelUrl ) )
		           ->will($this->returnValue( $returnValue ));

		$this->paypalService->setPayflowAPI( $payflowAPI );

		$this->assertEquals( $expectedResult, $this->paypalService->fetchToken( $returnUrl, $cancelUrl ) );
		if( $expectedResult ) {
			$this->assertEquals( self::TEST_TOKEN, $this->paypalService->getToken() );
		}
		else {
			$this->assertNull( $this->paypalService->getToken(), 'Token isn\'t NULL !?' );
		}

		$dbw = wfGetDB( DB_MASTER, array(), $this->paypalService->getPaypalDBName() );

		$dbTestRESPMSG = $dbw->selectField( 'pp_tokens', 'ppt_respmsg', array( 'ppt_token' => self::TEST_TOKEN ), __METHOD__ );
		$this->assertEquals( $testRESPMSG, $dbTestRESPMSG );

		$dbTestCORRELATIONID = $dbw->selectField( 'pp_tokens', 'ppt_correlationid', array( 'ppt_token' => self::TEST_TOKEN ), __METHOD__ );
		$this->assertEquals( $testCORRELATIONID, $dbTestCORRELATIONID );
	}
}
