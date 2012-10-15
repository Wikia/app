<?php
/**
 * Payflow API test
 *
 * @category Wikia
 * @package  Wikia_Test
 * @version $Id:$
 */

/**
 * Payflow API test
 *
 * @category Wikia
 * @package  Wikia_Test
 * @see PayflowAPI
 * @author Wojciech Szela <wojtek@wikia-inc.com>
 */
class PayflowAPITest extends PHPUnit_Framework_TestCase {
	private $payflowOptions = array(
		'partner'   => 'partner',
		'vendor'    => 'vendor',
		'user'      => 'user',
		'password'  => 'password',
		'APIUrl'    => 'APIUrl',
		'HTTPProxy' => 'HTTPProxy'
	);
	private $wgPayflowProCredentialsBackup;
	private $wgPayflowProAPIUrlBackup;
	private $wgHTTPProxyBackup;

	protected function setUp(){

		global $wgPayflowProCredentials, $wgPayflowProAPIUrl, $wgHTTPProxy;
		$this->wgPayflowProCredentialsBackup = $wgPayflowProCredentials;
		$this->wgPayflowProAPIUrlBackup = $wgPayflowProAPIUrl;
		$this->wgHTTPProxyBackup = $wgHTTPProxy;
	}

	protected function tearDown(){

		global $wgPayflowProCredentials, $wgPayflowProAPIUrl, $wgHTTPProxy;
		$wgPayflowProCredentials = $this->wgPayflowProCredentialsBackup;
		$wgPayflowProAPIUrl = $this->wgPayflowProAPIUrlBackup;
		$wgHTTPProxy = $this->wgHTTPProxyBackup;
	}

	public function testConstructorReadsFromGlobalsIfOptionsAreNotGiven() {
		global $wgPayflowProCredentials, $wgPayflowProAPIUrl, $wgHTTPProxy;

		$wgPayflowProCredentials = array(
			'partner'  => 'global partner',
			'vendor'   => 'global vendor',
			'user'     => 'global user',
			'password' => 'global password'
		);
		$wgPayflowProAPIUrl = 'global api url';
		$wgHTTPProxy        = 'global http proxy';
		$returnUrl          = 'http://return.url';
		$cancelUrl          = 'http://cancel.url';
		
		$curl = $this->getMock('Curl');
		$curl->expects($this->once())
		     ->method('init');
		$curl->expects($this->once())
		     ->method('setopt_array')
		     ->with($this->equalTo(array(
  				CURLOPT_URL => $wgPayflowProAPIUrl,
  				CURLOPT_SSL_VERIFYPEER => false,
  				CURLOPT_SSL_VERIFYHOST => false,
  				CURLOPT_RETURNTRANSFER => 1,
  				CURLOPT_POST => 1,
  				CURLOPT_PROXY => $wgHTTPProxy,
  				CURLOPT_TIMEOUT => 45,
  				CURLOPT_HTTPHEADER => array(
    				0 => 'Content-Type: text/namevalue',
  				),
  				CURLOPT_POSTFIELDS => 'PARTNER[14]=' . $wgPayflowProCredentials['partner']
				                    . '&VENDOR[13]=' . $wgPayflowProCredentials['vendor']
				                    . '&PWD[15]=' . $wgPayflowProCredentials['password']
				                    . '&USER[11]=' . $wgPayflowProCredentials['user']
				                    . '&TENDER[1]=P&TRXTYPE[1]=A'
				                    . '&ACTION[1]=S'
				                    . '&AMT[4]=0.00'
				                    . '&BILLINGTYPE[24]=MerchantInitiatedBilling'
				                    . '&PAYMENTTYPE[3]=any'
				                    . '&RETURNURL[17]=' . $returnUrl
				                    . '&CANCELURL[17]=' . $cancelUrl
				                    . '&BA_DESC[18]=Wikia+subscription',
		)));
		$curl->expects($this->once())
		     ->method('exec')
		     ->will($this->returnValue(true));
		$curl->expects($this->once())
		     ->method('close');
		     
		$payflowApi = new PayflowAPI();
		$payflowApi->setCurl($curl);
		$this->assertEquals(array(), $payflowApi->setExpressCheckout($returnUrl, $cancelUrl));
	}

	public function testRequestingExpressCheckoutSendsProperApiRequest() {
		$returnUrl = 'http://return.url';
		$cancelUrl = 'http://cancel.url';
		
		$curl = $this->getMock('Curl');
		$curl->expects($this->once())
		     ->method('init');
		$curl->expects($this->once())
		     ->method('setopt_array')
		     ->with($this->equalTo(array(
  				CURLOPT_URL => $this->payflowOptions['APIUrl'],
  				CURLOPT_SSL_VERIFYPEER => false,
  				CURLOPT_SSL_VERIFYHOST => false,
  				CURLOPT_RETURNTRANSFER => 1,
  				CURLOPT_POST => 1,
  				CURLOPT_PROXY => $this->payflowOptions['HTTPProxy'],
  				CURLOPT_TIMEOUT => 45,
  				CURLOPT_HTTPHEADER => array(
    				0 => 'Content-Type: text/namevalue',
  				),
  				CURLOPT_POSTFIELDS => 'PARTNER[7]=' . $this->payflowOptions['partner']
				                    . '&VENDOR[6]=' . $this->payflowOptions['vendor']
				                    . '&PWD[8]=' . $this->payflowOptions['password']
				                    . '&USER[4]=' . $this->payflowOptions['user']
				                    . '&TENDER[1]=P&TRXTYPE[1]=A'
				                    . '&ACTION[1]=S'
				                    . '&AMT[4]=0.00'
				                    . '&BILLINGTYPE[24]=MerchantInitiatedBilling'
				                    . '&PAYMENTTYPE[3]=any'
				                    . '&RETURNURL[17]=' . $returnUrl
				                    . '&CANCELURL[17]=' . $cancelUrl
				                    . '&BA_DESC[18]=Wikia+subscription',
		)));
		$curl->expects($this->once())
		     ->method('exec')
		     ->will($this->returnValue(true));
		$curl->expects($this->once())
		     ->method('close');
		     
		$payflowApi = new PayflowAPI($this->payflowOptions);
		$payflowApi->setCurl($curl);
		$this->assertEquals(array(), $payflowApi->setExpressCheckout($returnUrl, $cancelUrl));
	}

	public function testGettingExpressCheckoutSendsProperApiRequest() {
		$token = 'token';
		
		$curl = $this->getMock('Curl');
		$curl->expects($this->once())
		     ->method('init');
		$curl->expects($this->once())
		     ->method('setopt_array')
		     ->with($this->equalTo(array(
  				CURLOPT_URL => $this->payflowOptions['APIUrl'],
  				CURLOPT_SSL_VERIFYPEER => false,
  				CURLOPT_SSL_VERIFYHOST => false,
  				CURLOPT_RETURNTRANSFER => 1,
  				CURLOPT_POST => 1,
  				CURLOPT_PROXY => $this->payflowOptions['HTTPProxy'],
  				CURLOPT_TIMEOUT => 45,
  				CURLOPT_HTTPHEADER => array(
    				0 => 'Content-Type: text/namevalue',
  				),
  				CURLOPT_POSTFIELDS => 'PARTNER[7]=' . $this->payflowOptions['partner']
				                    . '&VENDOR[6]=' . $this->payflowOptions['vendor']
				                    . '&PWD[8]=' . $this->payflowOptions['password']
				                    . '&USER[4]=' . $this->payflowOptions['user']
				                    . '&TENDER[1]=P&TRXTYPE[1]=A'
				                    . '&ACTION[1]=G'
				                    . '&TOKEN[5]=' . $token
		)));
		$curl->expects($this->once())
		     ->method('exec')
		     ->will($this->returnValue(true));
		$curl->expects($this->once())
		     ->method('close');
		     
		$payflowApi = new PayflowAPI($this->payflowOptions);
		$payflowApi->setCurl($curl);
		$this->assertEquals(array(), $payflowApi->getExpressCheckoutDetails($token));
	}

	public function testCreatingCustomerBillingAgreementSendsProperApiRequest() {
		$reqId = 'reqid';
		$token = 'token';
		
		$curl = $this->getMock('Curl');
		$curl->expects($this->once())
		     ->method('init');
		$curl->expects($this->once())
		     ->method('setopt_array')
		     ->with($this->equalTo(array(
  				CURLOPT_URL => $this->payflowOptions['APIUrl'],
  				CURLOPT_SSL_VERIFYPEER => false,
  				CURLOPT_SSL_VERIFYHOST => false,
  				CURLOPT_RETURNTRANSFER => 1,
  				CURLOPT_POST => 1,
  				CURLOPT_PROXY => $this->payflowOptions['HTTPProxy'],
  				CURLOPT_TIMEOUT => 45,
  				CURLOPT_HTTPHEADER => array(
    				0 => 'Content-Type: text/namevalue',
    				1 => 'X-VPS-Request-ID: X' . $reqId
  				),
  				CURLOPT_POSTFIELDS => 'PARTNER[7]=' . $this->payflowOptions['partner']
				                    . '&VENDOR[6]=' . $this->payflowOptions['vendor']
				                    . '&PWD[8]=' . $this->payflowOptions['password']
				                    . '&USER[4]=' . $this->payflowOptions['user']
				                    . '&TENDER[1]=P&TRXTYPE[1]=A'
				                    . '&ACTION[1]=X'
				                    . '&TOKEN[5]=' . $token
		)));
		$curl->expects($this->once())
		     ->method('exec')
		     ->will($this->returnValue(true));
		$curl->expects($this->once())
		     ->method('close');
		     
		$payflowApi = new PayflowAPI($this->payflowOptions);
		$payflowApi->setCurl($curl);
		$this->assertEquals(array(), $payflowApi->createCustomerBillingAgreement($reqId, $token));
	}

	public function testCancelingCustomerBillingAgreementSendsProperApiRequest() {
		$baid = 'bid';
		
		$curl = $this->getMock('Curl');
		$curl->expects($this->once())
		     ->method('init');
		$curl->expects($this->once())
		     ->method('setopt_array')
		     ->with($this->equalTo(array(
  				CURLOPT_URL => $this->payflowOptions['APIUrl'],
  				CURLOPT_SSL_VERIFYPEER => false,
  				CURLOPT_SSL_VERIFYHOST => false,
  				CURLOPT_RETURNTRANSFER => 1,
  				CURLOPT_POST => 1,
  				CURLOPT_PROXY => $this->payflowOptions['HTTPProxy'],
  				CURLOPT_TIMEOUT => 45,
  				CURLOPT_HTTPHEADER => array(
    				0 => 'Content-Type: text/namevalue'
  				),
  				CURLOPT_POSTFIELDS => 'PARTNER[7]=' . $this->payflowOptions['partner']
				                    . '&VENDOR[6]=' . $this->payflowOptions['vendor']
				                    . '&PWD[8]=' . $this->payflowOptions['password']
				                    . '&USER[4]=' . $this->payflowOptions['user']
				                    . '&TENDER[1]=P'
				                    . '&ACTION[1]=U'
				                    . '&BAID[3]=' . $baid
				                    . '&BA_STATUS[6]=cancel'
		)));
		$curl->expects($this->once())
		     ->method('exec')
		     ->will($this->returnValue(true));
		$curl->expects($this->once())
		     ->method('close');
		     
		$payflowApi = new PayflowAPI($this->payflowOptions);
		$payflowApi->setCurl($curl);
		$this->assertEquals(array(), $payflowApi->cancelCustomerBillingAgreement($baid));
	}

	public function testCheckingCustomerBillingAgreementSendsProperApiRequest() {
		$baid = 'bid';
		
		$curl = $this->getMock('Curl');
		$curl->expects($this->once())
		     ->method('init');
		$curl->expects($this->once())
		     ->method('setopt_array')
		     ->with($this->equalTo(array(
  				CURLOPT_URL => $this->payflowOptions['APIUrl'],
  				CURLOPT_SSL_VERIFYPEER => false,
  				CURLOPT_SSL_VERIFYHOST => false,
  				CURLOPT_RETURNTRANSFER => 1,
  				CURLOPT_POST => 1,
  				CURLOPT_PROXY => $this->payflowOptions['HTTPProxy'],
  				CURLOPT_TIMEOUT => 45,
  				CURLOPT_HTTPHEADER => array(
    				0 => 'Content-Type: text/namevalue'
  				),
  				CURLOPT_POSTFIELDS => 'PARTNER[7]=' . $this->payflowOptions['partner']
				                    . '&VENDOR[6]=' . $this->payflowOptions['vendor']
				                    . '&PWD[8]=' . $this->payflowOptions['password']
				                    . '&USER[4]=' . $this->payflowOptions['user']
				                    . '&TENDER[1]=P'
				                    . '&ACTION[1]=U'
				                    . '&BAID[3]=' . $baid
		)));
		$curl->expects($this->once())
		     ->method('exec')
		     ->will($this->returnValue(true));
		$curl->expects($this->once())
		     ->method('close');
		     
		$payflowApi = new PayflowAPI($this->payflowOptions);
		$payflowApi->setCurl($curl);
		$this->assertEquals(array(), $payflowApi->checkCustomerBillingAgreement($baid));
	}

	public function testDoExpressCheckoutPaymentSendsProperApiRequest() {
		$reqId  = 'reqid';
		$baid   = 'bid';
		$amount = 3.1415;
		
		$curl = $this->getMock('Curl');
		$curl->expects($this->once())
		     ->method('init');
		$curl->expects($this->once())
		     ->method('setopt_array')
		     ->with($this->equalTo(array(
  				CURLOPT_URL => $this->payflowOptions['APIUrl'],
  				CURLOPT_SSL_VERIFYPEER => false,
  				CURLOPT_SSL_VERIFYHOST => false,
  				CURLOPT_RETURNTRANSFER => 1,
  				CURLOPT_POST => 1,
  				CURLOPT_PROXY => $this->payflowOptions['HTTPProxy'],
  				CURLOPT_TIMEOUT => 45,
  				CURLOPT_HTTPHEADER => array(
    				0 => 'Content-Type: text/namevalue',
    				1 => 'X-VPS-Request-ID: D' . $reqId
  				),
  				CURLOPT_POSTFIELDS => 'PARTNER[7]=' . $this->payflowOptions['partner']
				                    . '&VENDOR[6]=' . $this->payflowOptions['vendor']
				                    . '&PWD[8]=' . $this->payflowOptions['password']
				                    . '&USER[4]=' . $this->payflowOptions['user']
				                    . '&TENDER[1]=P'
				                    . '&TRXTYPE[1]=S'
				                    . '&ACTION[1]=D'
				                    . '&AMT[4]=3.14'
				                    . '&BAID[3]=' . $baid
		)));
		$curl->expects($this->once())
		     ->method('exec')
		     ->will($this->returnValue(true));
		$curl->expects($this->once())
		     ->method('close');
		     
		$payflowApi = new PayflowAPI($this->payflowOptions);
		$payflowApi->setCurl($curl);
		$this->assertEquals(array(), $payflowApi->doExpressCheckoutPayment($reqId, $baid, $amount));
	}

	public function testDoExpressCheckoutAuthorizationSendsProperApiRequest() {
		$reqId  = 'reqid';
		$baid   = 'bid';
		$amount = 3.1415;
		
		$curl = $this->getMock('Curl');
		$curl->expects($this->once())
		     ->method('init');
		$curl->expects($this->once())
		     ->method('setopt_array')
		     ->with($this->equalTo(array(
  				CURLOPT_URL => $this->payflowOptions['APIUrl'],
  				CURLOPT_SSL_VERIFYPEER => false,
  				CURLOPT_SSL_VERIFYHOST => false,
  				CURLOPT_RETURNTRANSFER => 1,
  				CURLOPT_POST => 1,
  				CURLOPT_PROXY => $this->payflowOptions['HTTPProxy'],
  				CURLOPT_TIMEOUT => 45,
  				CURLOPT_HTTPHEADER => array(
    				0 => 'Content-Type: text/namevalue',
    				1 => 'X-VPS-Request-ID: A' . $reqId
  				),
  				CURLOPT_POSTFIELDS => 'PARTNER[7]=' . $this->payflowOptions['partner']
				                    . '&VENDOR[6]=' . $this->payflowOptions['vendor']
				                    . '&PWD[8]=' . $this->payflowOptions['password']
				                    . '&USER[4]=' . $this->payflowOptions['user']
				                    . '&TENDER[1]=P'
				                    . '&TRXTYPE[1]=A'
				                    . '&ACTION[1]=D'
				                    . '&AMT[4]=3.14'
				                    . '&BAID[3]=' . $baid
		)));
		$curl->expects($this->once())
		     ->method('exec')
		     ->will($this->returnValue(true));
		$curl->expects($this->once())
		     ->method('close');
		     
		$payflowApi = new PayflowAPI($this->payflowOptions);
		$payflowApi->setCurl($curl);
		$this->assertEquals(array(), $payflowApi->doExpressCheckoutAuthorization($reqId, $baid, $amount));
	}

	public function testDoExpressCheckoutVoidSendsProperApiRequest() {
		$reqId  = 'reqid';
		$origId = 'origid';
		
		$curl = $this->getMock('Curl');
		$curl->expects($this->once())
		     ->method('init');
		$curl->expects($this->once())
		     ->method('setopt_array')
		     ->with($this->equalTo(array(
  				CURLOPT_URL => $this->payflowOptions['APIUrl'],
  				CURLOPT_SSL_VERIFYPEER => false,
  				CURLOPT_SSL_VERIFYHOST => false,
  				CURLOPT_RETURNTRANSFER => 1,
  				CURLOPT_POST => 1,
  				CURLOPT_PROXY => $this->payflowOptions['HTTPProxy'],
  				CURLOPT_TIMEOUT => 45,
  				CURLOPT_HTTPHEADER => array(
    				0 => 'Content-Type: text/namevalue',
    				1 => 'X-VPS-Request-ID: V' . $reqId
  				),
  				CURLOPT_POSTFIELDS => 'PARTNER[7]=' . $this->payflowOptions['partner']
				                    . '&VENDOR[6]=' . $this->payflowOptions['vendor']
				                    . '&PWD[8]=' . $this->payflowOptions['password']
				                    . '&USER[4]=' . $this->payflowOptions['user']
				                    . '&TENDER[1]=P'
				                    . '&TRXTYPE[1]=V'
				                    . '&ORIGID[6]=' . $origId
		)));
		$curl->expects($this->once())
		     ->method('exec')
		     ->will($this->returnValue(true));
		$curl->expects($this->once())
		     ->method('close');
		     
		$payflowApi = new PayflowAPI($this->payflowOptions);
		$payflowApi->setCurl($curl);
		$this->assertEquals(array(), $payflowApi->doExpressCheckoutVoid($reqId, $origId));
	}

	public function testCreatingRecurringProfileSendsProperApiRequest() {
		$reqId = 'regid';
		$baid = 'baid';
		$profileName = 'aprofile';
		$amount = -3.147;
		$startDate = '12-10-2010';
		$term = 0;
		$payPeriod = "MONT";
		$retryNumDays = 3;
		$initialFee = true;
		$description = "desc";
		
		$curl = $this->getMock('Curl');
		$curl->expects($this->once())
		     ->method('init');
		$curl->expects($this->once())
		     ->method('setopt_array')
		     ->with($this->equalTo(array(
  				CURLOPT_URL => $this->payflowOptions['APIUrl'],
  				CURLOPT_SSL_VERIFYPEER => false,
  				CURLOPT_SSL_VERIFYHOST => false,
  				CURLOPT_RETURNTRANSFER => 1,
  				CURLOPT_POST => 1,
  				CURLOPT_PROXY => $this->payflowOptions['HTTPProxy'],
  				CURLOPT_TIMEOUT => 45,
  				CURLOPT_HTTPHEADER => array(
    				0 => 'Content-Type: text/namevalue',
    				1 => 'X-VPS-Request-ID: X' . $reqId
  				),
  				CURLOPT_POSTFIELDS => 'PARTNER[7]=' . $this->payflowOptions['partner']
				                    . '&VENDOR[6]=' . $this->payflowOptions['vendor']
				                    . '&PWD[8]=' . $this->payflowOptions['password']
				                    . '&USER[4]=' . $this->payflowOptions['user']
				                    . '&TENDER[1]=P'
				                    . '&TRXTYPE[1]=R'
				                    . '&ACTION[1]=A'
				                    . '&PROFILENAME[8]=' . $profileName
				                    . '&BAID[4]=' . $baid
				                    . '&AMT[4]=3.15'
				                    . '&START[8]=10122010'
				                    . '&TERM[1]=0'
				                    . '&PAYPERIOD[4]=MONT'
				                    . '&RETRYNUMDAYS[1]=3'
				                    . '&DESC[4]=desc'
				                    . '&OPTIONALTRX[1]=S'
				                    . '&OPTIONALTRXAMT[4]=3.15'
		)));
		$curl->expects($this->once())
		     ->method('exec')
		     ->will($this->returnValue(true));
		$curl->expects($this->once())
		     ->method('close');
		     
		$payflowApi = new PayflowAPI($this->payflowOptions);
		$payflowApi->setCurl($curl);
		$this->assertEquals(array(), $payflowApi->createRecurringProfile($reqId, $baid, $profileName, $amount, $startDate, $term, $payPeriod, $retryNumDays, $initialFee, $description));
	}

	public function testExceptionIsThrowInThereIsNoResponseFromAPI() {
		$curl = $this->getMock('Curl');
		$curl->expects($this->once())
		     ->method('init');
		$curl->expects($this->once())
		     ->method('setopt_array');
		$curl->expects($this->once())
		     ->method('exec')
		     ->will($this->returnValue(false));
		$curl->expects($this->once())
		     ->method('close');
		     
		$payflowApi = new PayflowAPI($this->payflowOptions);
		$payflowApi->setCurl($curl);
		$this->setExpectedException('Exception');
		$this->assertEquals(array(), $payflowApi->doExpressCheckoutVoid(null, null));
	}

	public function testEncodingResponse() {
		$curl = $this->getMock('Curl');
		$curl->expects($this->once())
		     ->method('init');
		$curl->expects($this->once())
		     ->method('setopt_array');
		$curl->expects($this->once())
		     ->method('exec')
		     ->will($this->returnValue('foo=bar&baz=a+b'));
		$curl->expects($this->once())
		     ->method('close');
		     
		$payflowApi = new PayflowAPI($this->payflowOptions);
		$payflowApi->setCurl($curl);
		$this->assertEquals(array('foo' => 'bar', 'baz' => 'a b'), $payflowApi->doExpressCheckoutVoid(null, null));
	}
}
