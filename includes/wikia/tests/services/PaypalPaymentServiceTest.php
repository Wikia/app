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
	const TEST_TOKEN         = 'EC-00000001';
	const TEST_REQID         = 'REQ-0000001';
	const TEST_BAID          = 'BA-00000001';
	const TEST_AMT           = 4.99;
	const TEST_RESPMSG       = 'TEST RESPMSG';
	const TEST_CORRID        = 'TEST CORRID';
	const TEST_PNREF         = 'TEST PNREF';
	const TEST_PPREF         = 'TEST PPREF';
	const TEST_FEEAMT        = 0.99;
	const TEST_PAYMENTTYPE   = 'TEST PT';
	const TEST_PENDINGREASON = 'TEST PR';

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
		$dbw->delete( 'pp_payments', array( 'ppp_baid' => self::TEST_BAID ), __METHOD__ );
		$dbw->delete( 'pp_agreements', array( 'ppa_baid' => self::TEST_BAID ), __METHOD__ );
	}

	public function universalDataProvider() {
		return array (
			array( true, true, 0 ),
			array( false, true, 1 ),
			array( false, false, null )
		);
	}

	/**
	 * @dataProvider universalDataProvider
	 */
	public function testFetchTokenIsStoredInDB( $expectedResult, $hasResult, $resultValue ) {
		$returnUrl = 'http://return.url';
		$cancelUrl = 'http://cancel.url';

		$returnValue = array( 'RESULT' => $resultValue, 'TOKEN' => self::TEST_TOKEN, 'RESPMSG' => self::TEST_RESPMSG, 'CORRELATIONID' => self::TEST_CORRID);
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
		$this->assertEquals( self::TEST_RESPMSG, $dbTestRESPMSG );

		$dbTestCORRELATIONID = $dbw->selectField( 'pp_tokens', 'ppt_correlationid', array( 'ppt_token' => self::TEST_TOKEN ), __METHOD__ );
		$this->assertEquals( self::TEST_CORRID, $dbTestCORRELATIONID );
	}

	/**
	 * @dataProvider universalDataProvider
	 */
	public function testCollectingPayment( $expectedResult, $hasResult, $resultValue ) {
		$returnValue = array(
			'RESULT' => $resultValue,
			'RESPMSG' => self::TEST_RESPMSG,
			'CORRELATIONID' => self::TEST_CORRID,
			'PNREF' => self::TEST_PNREF,
			'PPREF' => self::TEST_PPREF,
			'FEEAMT' => self::TEST_FEEAMT,
			'PAYMENTTYPE' => self::TEST_PAYMENTTYPE,
			'PENDINGREASON' => self::TEST_PENDINGREASON
		);

		if( !$hasResult ) {
			unset( $returnValue['RESULT'] );
		}

		$payflowAPI = $this->getMock( 'PayflowAPI' );
		$payflowAPI->expects($this->once())
		           ->method('doExpressCheckoutPayment')
		           ->with($this->anything(), $this->equalTo( self::TEST_BAID ), $this->equalTo( self::TEST_AMT ) )
		           ->will($this->returnValue( $returnValue ));

		$this->paypalService->setPayflowAPI( $payflowAPI );

		$requestId = $this->paypalService->collectPayment( self::TEST_BAID, self::TEST_AMT );

		if( $expectedResult ) {
			$this->assertGreaterThan( 0, $requestId );

			$dbw = wfGetDB( DB_MASTER, array(), $this->paypalService->getPaypalDBName() );

			$dbBAId = $dbw->selectField( 'pp_payments', 'ppp_baid', array( 'ppp_id' => $requestId ), __METHOD__ );
			$this->assertEquals( self::TEST_BAID, $dbBAId );

			$dbAmount = $dbw->selectField( 'pp_payments', 'ppp_amount', array( 'ppp_id' => $requestId ), __METHOD__ );
			$this->assertEquals( self::TEST_AMT, $dbAmount );

			$dbResult = $dbw->selectField( 'pp_payments', 'ppp_result', array( 'ppp_id' => $requestId ), __METHOD__ );
			$this->assertEquals( $resultValue, $dbResult );

			$dbRespmsg = $dbw->selectField( 'pp_payments', 'ppp_respmsg', array( 'ppp_id' => $requestId ), __METHOD__ );
			$this->assertEquals( self::TEST_RESPMSG, $dbRespmsg );

			$dbCorrId = $dbw->selectField( 'pp_payments', 'ppp_correlationid', array( 'ppp_id' => $requestId ), __METHOD__ );
			$this->assertEquals( self::TEST_CORRID, $dbCorrId );

			$dbPnref = $dbw->selectField( 'pp_payments', 'ppp_pnref', array( 'ppp_id' => $requestId ), __METHOD__ );
			$this->assertEquals( self::TEST_PNREF, $dbPnref );

			$dbPpref = $dbw->selectField( 'pp_payments', 'ppp_ppref', array( 'ppp_id' => $requestId ), __METHOD__ );
			$this->assertEquals( self::TEST_PPREF, $dbPpref );

			$dbFeeamt = $dbw->selectField( 'pp_payments', 'ppp_feeamt', array( 'ppp_id' => $requestId ), __METHOD__ );
			$this->assertEquals( self::TEST_FEEAMT, $dbFeeamt );

			$dbPaymenttype = $dbw->selectField( 'pp_payments', 'ppp_paymenttype', array( 'ppp_id' => $requestId ), __METHOD__ );
			$this->assertEquals( self::TEST_PAYMENTTYPE, $dbPaymenttype );

			$dbPendingreason = $dbw->selectField( 'pp_payments', 'ppp_pendingreason', array( 'ppp_id' => $requestId ), __METHOD__ );
			$this->assertEquals( self::TEST_PENDINGREASON, $dbPendingreason );
		}
		else {
			$this->assertEquals( 0, $requestId );
		}


	}

	/**
	 * @dataProvider universalDataProvider
	 */
	public function testCreateBillingAgreement( $expectedResult, $hasResult, $resultValue ) {
		$this->paypalService->setToken( self::TEST_TOKEN );

		$returnValue = array(
			'RESULT' => $resultValue,
			'RESPMSG' => self::TEST_RESPMSG,
			'CORRELATIONID' => self::TEST_CORRID,
			'PNREF' => self::TEST_PNREF,
			'BAID' => self::TEST_BAID
		);

		if( !$hasResult ) {
			unset( $returnValue['RESULT'] );
		}

		$payflowAPI = $this->getMock( 'PayflowAPI' );
		$payflowAPI->expects($this->once())
		           ->method('createCustomerBillingAgreement')
		           ->with($this->anything(), $this->equalTo( self::TEST_TOKEN ) )
		           ->will($this->returnValue( $returnValue ));

		$this->paypalService->setPayflowAPI( $payflowAPI );

		$BAId = $this->paypalService->createBillingAgreement();

		if( $expectedResult) {
			$this->assertEquals( self::TEST_BAID, $BAId );
		}
		else {
			$this->assertFalse( $BAId );
		}

		$dbw = wfGetDB( DB_MASTER, array(), $this->paypalService->getPaypalDBName() );

		$dbResult = $dbw->selectField( 'pp_agreements', 'ppa_result', array( 'ppa_baid' => self::TEST_BAID ), __METHOD__ );
		$this->assertEquals( $resultValue, $dbResult );

		$dbRespmsg = $dbw->selectField( 'pp_agreements', 'ppa_respmsg', array( 'ppa_baid' => self::TEST_BAID ), __METHOD__ );
		$this->assertEquals( self::TEST_RESPMSG, $dbRespmsg );

		$dbCorrId = $dbw->selectField( 'pp_agreements', 'ppa_correlationid', array( 'ppa_baid' => self::TEST_BAID ), __METHOD__ );
		$this->assertEquals( self::TEST_CORRID, $dbCorrId );

		$dbPnref = $dbw->selectField( 'pp_agreements', 'ppa_pnref', array( 'ppa_baid' => self::TEST_BAID ), __METHOD__ );
		$this->assertEquals( self::TEST_PNREF, $dbPnref );

	}

	/**
	 * @dataProvider universalDataProvider
	 */
	public function testCheckBillingAgreement( $expectedResult, $hasResult, $resultValue ) {
		if( $hasResult ) {
			$returnValue = array( 'RESULT' => $resultValue );
		}
		else {
			$returnValue = array();
		}

		$payflowAPI = $this->getMock( 'PayflowAPI' );
		$payflowAPI->expects($this->once())
		           ->method('checkCustomerBillingAgreement')
		           ->with($this->equalTo( self::TEST_BAID ) )
		           ->will($this->returnValue( $returnValue ));

		$this->paypalService->setPayflowAPI( $payflowAPI );

		$result = $this->paypalService->checkBillingAgreement( self::TEST_BAID );

		if( $expectedResult ) {
			$this->assertTrue( $result );
		}
	}

	public function cancelBAIdDataProvider() {
		return array(
			array( true, true, 0 ),
			array( true, true, 12 ),
			array( false, true, 1 ),
			array( false, false, null )
		);
	}

	/**
	 * @dataProvider cancelBAIdDataProvider
	 */
	public function testCancelBillingAgreement( $expectedResult, $hasResult, $resultValue ) {
		if( $hasResult ) {
			$returnValue = array( 'RESULT' => $resultValue, 'RESPMSG' => 'Declined: 10201-Billing Agreement was cancelled' );
		}
		else {
			$returnValue = array();
		}

		$payflowAPI = $this->getMock( 'PayflowAPI' );
		$payflowAPI->expects($this->once())
		           ->method('cancelCustomerBillingAgreement')
		           ->with($this->equalTo( self::TEST_BAID ) )
		           ->will($this->returnValue( $returnValue ));

		$this->paypalService->setPayflowAPI( $payflowAPI );

		$result = $this->paypalService->cancelBillingAgreement( self::TEST_BAID );

		if( $expectedResult ) {
			$this->assertTrue( $result );
		}
	}
}
