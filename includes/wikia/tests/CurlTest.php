<?php
/**
 * cURL wrapper
 *
 * @category Wikia
 * @package  Wikia_Test
 * @version $Id:$
 */

global $wgAutoloadClasses, $IP;
$wgAutoloadClasses['Curl']  =  $IP.'/includes/wikia/Curl.php';

/**
 * cURL wrapper test
 *
 * @category Wikia
 * @package  Wikia_Test
 * @see Curl
 * @group Infrastructure
 * @author Wojciech Szela <wojtek@wikia-inc.com>
 */
class CurlTest extends PHPUnit_Framework_TestCase {
	const CURL_TIMEOUT        = 10;
	const TEST_VALID_URL      = 'http://wikia.com';
	const TEST_INVALID_HANDLE = 6.6260693;
	
	private $proxy = null;
	
	public function setUp() {
		global $wgHTTPProxy;
		$this->proxy = $wgHTTPProxy;
	}
	/**
	 * cURL handle should be initialized only of URL is given in constructor
	 */
	function testEnsureCurlHandleIsLazyInitialized() {
		$curl = new Curl();
		$this->assertFalse($curl->hasHandle());
		
		$curl = new Curl(self::TEST_VALID_URL);
		$this->assertTrue($curl->hasHandle());
	}
	
	function testGettingVersionReturnsValidData() {
		$curl    = new Curl();
		$version = $curl->version();

		$this->assertInternalType('array', $version);
		$this->assertArrayHasKey('version_number', $version);
	}
	
	function testEnsureGettingErrorReturnsCorrectInfo() {
		$curl = new Curl(self::TEST_VALID_URL);

		$this->assertEquals(0, $curl->errno());
		$this->assertEquals('', $curl->error());
		
		$curl->setopt(CURLOPT_RETURNTRANSFER, 1);
		$curl->setopt(CURLOPT_PROXY, $this->proxy);
		$curl->exec();

		$this->assertEquals(0, $curl->errno());
		$this->assertEquals('', $curl->error());
	}
	
	function testEnsureGettingRequestInfoReturnsCorrectInfo() {
		$curl = new Curl(self::TEST_VALID_URL);
		$curl->setopt(CURLOPT_RETURNTRANSFER, 1);
		$curl->setopt(CURLOPT_PROXY, $this->proxy);
		$curl->exec();

		$info = $curl->getinfo();
		
		$this->assertInternalType('array', $info);
		$this->assertArrayHasKey('url', $info);
		$this->assertEquals(self::TEST_VALID_URL, $info['url']);
		$this->assertEquals(self::TEST_VALID_URL, $curl->getinfo(CURLINFO_EFFECTIVE_URL));
	}
	
	function testCurlWrapperCanDoHttpQueries() {
		$curl = new Curl(self::TEST_VALID_URL);
		$curl->setopt(CURLOPT_PROXY, $this->proxy);
		$this->assertTrue($curl->setopt(CURLOPT_RETURNTRANSFER, 1));
		$this->assertTrue($curl->setopt_array(array(
			CURLOPT_TIMEOUT        => self::CURL_TIMEOUT,
			CURLOPT_FOLLOWLOCATION => true
		)));
		
		$result = $curl->exec();
		$this->assertStringStartsWith('<!doctype html>', $result);
		
		$curl->close();
		$this->assertFalse($curl->hasHandle());
	}
	
	function testSettingInvalidHandleTypeThrowsException() {
		$curl = new Curl();
		$this->setExpectedException('WikiaException');
		$curl->setHandle(self::TEST_INVALID_HANDLE);
	}
	
	function testClonningMakesHandleCopy() {
		$curl = new Curl(self::TEST_VALID_URL);
		$copy = clone $curl;
		
		$this->assertNotEquals($curl->getHandle(), $copy->getHandle());
	}
}
