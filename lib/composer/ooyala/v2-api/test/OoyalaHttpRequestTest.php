<?php

require_once 'OoyalaApi.php';

class OoyalaHttpRequestTest extends PHPUnit_Framework_TestCase
{
    protected $baseUrl;
    protected $curlOptions;
    protected $contentType;
    protected $shouldFollowLocation;

    public function setUp()
    {
        $this->baseUrl = "http://127.0.0.1";
        $this->curlOptions = array(CURLOPT_FOLLOWLOCATION, true);
        $this->contentType = "text/plain";
        $this->shouldFollowLocation = true;
    }

    public function testInitialization()
    {
        $ooyalaHttpRequest = new OoyalaHttpRequest();
        $this->assertEmpty($ooyalaHttpRequest->curlOptions);
        $this->assertFalse($ooyalaHttpRequest->shouldFollowLocation);
        $this->assertNull($ooyalaHttpRequest->contentType);
    }

    public function testInitializationWithOptions()
    {
        $ooyalaHttpRequest = new OoyalaHttpRequest(array(
            'curlOptions' => $this->curlOptions,
            'shouldFollowLocation' => $this->shouldFollowLocation,
            'contentType' => $this->contentType));
        $this->assertEquals($ooyalaHttpRequest->curlOptions,
            $this->curlOptions);
        $this->assertEquals($ooyalaHttpRequest->shouldFollowLocation,
            $this->shouldFollowLocation);
        $this->assertEquals($ooyalaHttpRequest->contentType,
            $this->contentType);
    }

    /**
     * @expectedException OoyalaRequestErrorException
     */
    public function testExecuteWithError()
    {
        $ooyalaHttpRequest = new OoyalaHttpRequest();
        $ooyalaHttpRequest->execute('get', 'http://invalid');
    }

    /**
     * @expectedException OoyalaRequestErrorException
     */
    public function testExecuteWithResponseError()
    {
        $ooyalaHttpRequest = new OoyalaHttpRequest();
        $ooyalaHttpRequest->execute('get', 'http://127.0.0.1/invalid/location.json');
    }

    public function testWithOverridingOptions()
    {
        $ooyalaHttpRequest = new OoyalaHttpRequest();
        $response = $ooyalaHttpRequest->execute('get', 'http://127.0.0.1', array(
            'payload' => 'payload',
            'contentType' => $this->contentType));
        $this->assertEquals(200, $response['status']);
    }
}
