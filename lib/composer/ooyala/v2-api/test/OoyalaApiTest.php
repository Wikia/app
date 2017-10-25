<?php

require_once 'OoyalaApi.php';

class OoyalaApiTest extends PHPUnit_Framework_TestCase
{
    protected $ooyalaApi;
    protected $secretKey;
    protected $apiKey;

    public function setUp()
    {
        $this->apiKey    = '7ab06';
        $this->secretKey = '329b5b204d0f11e0a2d060334bfffe90ab18xqh5';
        $this->ooyalaApi = new OoyalaApi($this->apiKey, $this->secretKey);
    }

    public function testInitialization()
    {
        $api = new OoyalaApi($this->apiKey, $this->secretKey);
        $this->assertEquals($api->secretKey, $this->secretKey);
        $this->assertEquals($api->apiKey, $this->apiKey);
        $this->assertEquals($api->baseUrl, 'https://api.ooyala.com');
        $this->assertEquals($api->cacheBaseUrl, 'http://cdn.api.ooyala.com');
        $this->assertEquals($api->expirationWindow, 15);
    }

    public function testInitializationWithOptions()
    {
        $api = new OoyalaApi('', '', array(
            'baseUrl' => 'http://example.com',
            'expirationWindow' => 0));
        $this->assertEquals($api->baseUrl, 'http://example.com');
        $this->assertEquals($api->expirationWindow, 0);
    }

    public function testGenerateSignature()
    {
        $params = array('api_key' => '7ab06', 'expires' => '1299991855');
        $body   = 'test';
        $this->assertEquals('OugvH8gjMEqhq8nyoJQeBtSI57nMbIOp%2B7KGaxx9v8I',
            $this->ooyalaApi->generateSignature('GET', '/v2/players/HbxJKM',
            array()));
        $this->assertEquals('p9DG%2F%2BummS0YcTNOYHtykdjw5N2n5s81OigJfdgHPTA',
            $this->ooyalaApi->generateSignature('GET', '/v2/players/HbxJKM',
            $params));
        $this->assertEquals('fJrWCcIqeRBZUqa61OV%2B6XOWfpkab6RdW5hJZmZh1CI',
            $this->ooyalaApi->generateSignature('post', '/v2/players/HbxJKM',
            $params, $body));
    }

    public function testBuildUrl()
    {
        $params = array('api_key' => '7ab06', 'test' => 'true');
        $url = $this->ooyalaApi->buildUrl('GET', '/v2/players/HbxJKM');
        $this->assertContains('http://cdn.api.ooyala.com', $url);
        $this->assertContains('/v2/players/HbxJKM', $url);
        $url = $this->ooyalaApi->buildUrl('POST', '/v2/players/HbxJKM', $params);
        $this->assertContains('https://api.ooyala.com', $url);
        $this->assertContains('api_key=7ab06', $url);
        $this->assertContains('test=true', $url);
    }

    public function testBuildUrlWithCustomBaseUrl()
    {
        $this->ooyalaApi->cacheBaseUrl = 'http://example.com';
        $url = $this->ooyalaApi->buildUrl('GET', '');
        $this->assertContains('http://example.com', $url);
        $this->ooyalaApi->baseUrl = 'http://example.com';
        $url = $this->ooyalaApi->buildUrl('POST', '');
    }

    /**
     * @expectedException OoyalaMethodNotSupportedException
     */
    public function testSendRequestWithNotSupportedMethod()
    {
        $this->ooyalaApi->sendRequest('INVALID', '/');
    }

    /**
     * @expectedException OoyalaRequestErrorException
     */
    public function testSendRequestWithAnException()
    {
        $httpRequest = $this->getMock('OoyalaHttpRequest');
        $httpRequest->expects($this->once())
            ->method('execute')
            ->with($this->equalTo('POST'),
                $this->stringContains('api.ooyala.com/v2/players/HbxJKM'),
                $this->anything())
            ->will($this->throwException(new OoyalaRequestErrorException));
        $this->ooyalaApi->httpRequest = $httpRequest;
        $this->ooyalaApi->sendRequest('post', 'players/HbxJKM');
    }

    public function testSendSuccessfulRequest()
    {
        $this->ooyalaApi->cacheBaseUrl = 'http://127.0.0.1';
        $response = $this->ooyalaApi->sendRequest('get', '/v2/..');
        $this->assertEquals("", $response);
    }

    public function testSendRequestShouldCompleteTheRoute()
    {
        $httpRequest = $this->getMock('OoyalaHttpRequest');
        $this->ooyalaApi->httpRequest = $httpRequest;
        $httpRequest->expects($this->once())
            ->method('execute')
            ->with($this->equalTo('POST'),
                $this->stringContains(
                    'https://api.ooyala.com/v2/players/HbxJKM'),
                $this->anything());
        $this->ooyalaApi->sendRequest('post', 'players/HbxJKM');

        $httpRequest = $this->getMock('OoyalaHttpRequest');
        $this->ooyalaApi->httpRequest = $httpRequest;
        $httpRequest->expects($this->once())
            ->method('execute')
            ->with($this->equalTo('GET'),
                $this->stringContains(
                    'http://cdn.api.ooyala.com/v2/players/HbxJKM'),
                $this->anything());
        $this->ooyalaApi->sendRequest('get', '/v2/players/HbxJKM');
    }

    public function testSendRequestShouldAddNeededParams()
    {
        $httpRequest = $this->getMock('OoyalaHttpRequest');
        $this->ooyalaApi->httpRequest = $httpRequest;
        $httpRequest->expects($this->once())
            ->method('execute')
            ->with($this->equalTo('POST'),
                $this->stringContains('api_key=' . $this->apiKey),
                $this->anything());
        $this->ooyalaApi->sendRequest('post', '/v2/players/HbxJKM');

        $httpRequest = $this->getMock('OoyalaHttpRequest');
        $this->ooyalaApi->httpRequest = $httpRequest;
        $httpRequest->expects($this->once())
            ->method('execute')
            ->with($this->equalTo('POST'),
                $this->stringContains('signature='),
                $this->anything());
        $this->ooyalaApi->sendRequest('post', '/v2/players/HbxJKM');
    }

    public function testSendARequestWithPayload()
    {
        $httpRequest = $this->getMock('OoyalaHttpRequest');
        $httpRequest->expects($this->once())
            ->method('execute')
            ->with($this->equalTo('POST'),
                $this->stringContains('api.ooyala.com'),
                $this->equalTo(array('payload' => 'payload')))
            ->will($this->returnValue(array('status' => 200,
                'body' => '{"success": true}')));
        $this->ooyalaApi->httpRequest = $httpRequest;
        $response = $this->ooyalaApi->sendRequest('post', '/', array(),
            'payload');
        $this->assertTrue($response->success);
    }

    public function testGet()
    {
        $httpRequest = $this->getMock('OoyalaHttpRequest');
        $httpRequest->expects($this->once())
            ->method('execute')
            ->with($this->equalTo('GET'),
                $this->stringContains('api.ooyala.com/v2/assets'),
                $this->anything())
            ->will($this->returnValue(array('status' => 200,
                'body' => '{"success": true}')));
        $this->ooyalaApi->httpRequest = $httpRequest;
        $response = $this->ooyalaApi->get('/v2/assets');
        $this->assertTrue($response->success);
    }

    public function testGetWithParams()
    {
        $httpRequest = $this->getMock('OoyalaHttpRequest');
        $httpRequest->expects($this->once())
            ->method('execute')
            ->with($this->equalTo('GET'),
                $this->stringContains('test=true'),
                $this->anything())
            ->will($this->returnValue(array('status' => 200,
                'body' => '{"success": true}')));
        $this->ooyalaApi->httpRequest = $httpRequest;
        $response = $this->ooyalaApi->get('/v2/assets',
            array('test' => 'true'));
        $this->assertTrue($response->success);
    }

    public function testPost()
    {
        $httpRequest = $this->getMock('OoyalaHttpRequest');
        $httpRequest->expects($this->once())
            ->method('execute')
            ->with($this->equalTo('POST'),
                $this->stringContains('api.ooyala.com/v2/assets'),
                $this->anything())
            ->will($this->returnValue(array('status' => 200,
                'body' => '{"success": true}')));
        $this->ooyalaApi->httpRequest = $httpRequest;
        $response = $this->ooyalaApi->post('/v2/assets');
        $this->assertTrue($response->success);
    }

    public function testPostWithParams()
    {
        $httpRequest = $this->getMock('OoyalaHttpRequest');
        $httpRequest->expects($this->once())
            ->method('execute')
            ->with($this->equalTo('POST'),
                $this->stringContains('test=true'),
                $this->anything())
            ->will($this->returnValue(array('status' => 200,
                'body' => '{"success": true}')));
        $this->ooyalaApi->httpRequest = $httpRequest;
        $response = $this->ooyalaApi->post('/v2/assets', '',
            array('test' => 'true'));
        $this->assertTrue($response->success);
    }

    public function testPostWithPayload()
    {
        $httpRequest = $this->getMock('OoyalaHttpRequest');
        $httpRequest->expects($this->once())
            ->method('execute')
            ->with($this->equalTo('POST'),
                $this->anything(),
                $this->equalTo(array('payload' => '{"test":true}')))
            ->will($this->returnValue(array('status' => 200,
                'body' => '{"success": true}')));
        $this->ooyalaApi->httpRequest = $httpRequest;
        $response = $this->ooyalaApi->post('/v2/assets', array('test' => true),
            array('test' => 'true'));
        $this->assertTrue($response->success);
    }

    public function testPut()
    {
        $httpRequest = $this->getMock('OoyalaHttpRequest');
        $httpRequest->expects($this->once())
            ->method('execute')
            ->with($this->equalTo('PUT'),
                $this->stringContains('api.ooyala.com/v2/assets'),
                $this->anything())
            ->will($this->returnValue(array('status' => 200,
                'body' => '{"success": true}')));
        $this->ooyalaApi->httpRequest = $httpRequest;
        $response = $this->ooyalaApi->put('/v2/assets');
        $this->assertTrue($response->success);
    }

    public function testPutWithParams()
    {
        $httpRequest = $this->getMock('OoyalaHttpRequest');
        $httpRequest->expects($this->once())
            ->method('execute')
            ->with($this->equalTo('PUT'),
                $this->stringContains('test=true'),
                $this->anything())
            ->will($this->returnValue(array('status' => 200,
                'body' => '{"success": true}')));
        $this->ooyalaApi->httpRequest = $httpRequest;
        $response = $this->ooyalaApi->put('/v2/assets', '',
            array('test' => 'true'));
        $this->assertTrue($response->success);
    }

    public function testPutWithPayload()
    {
        $httpRequest = $this->getMock('OoyalaHttpRequest');
        $httpRequest->expects($this->once())
            ->method('execute')
            ->with($this->equalTo('PUT'),
                $this->anything(),
                $this->equalTo(array('payload' => '{"test":true}')))
            ->will($this->returnValue(array('status' => 200,
                'body' => '{"success": true}')));
        $this->ooyalaApi->httpRequest = $httpRequest;
        $response = $this->ooyalaApi->put('/v2/assets', array('test' => true),
            array('test' => 'true'));
        $this->assertTrue($response->success);
    }

    public function testPatch()
    {
        $httpRequest = $this->getMock('OoyalaHttpRequest');
        $httpRequest->expects($this->once())
            ->method('execute')
            ->with($this->equalTo('PATCH'),
                $this->stringContains('api.ooyala.com/v2/assets'),
                $this->anything())
            ->will($this->returnValue(array('status' => 200,
                'body' => '{"success": true}')));
        $this->ooyalaApi->httpRequest = $httpRequest;
        $response = $this->ooyalaApi->patch('/v2/assets');
        $this->assertTrue($response->success);
    }

    public function testPatchWithParams()
    {
        $httpRequest = $this->getMock('OoyalaHttpRequest');
        $httpRequest->expects($this->once())
            ->method('execute')
            ->with($this->equalTo('PATCH'),
                $this->stringContains('test=true'),
                $this->anything())
            ->will($this->returnValue(array('status' => 200,
                'body' => '{"success": true}')));
        $this->ooyalaApi->httpRequest = $httpRequest;
        $response = $this->ooyalaApi->patch('/v2/assets', '',
            array('test' => 'true'));
        $this->assertTrue($response->success);
    }

    public function testPatchWithPayload()
    {
        $httpRequest = $this->getMock('OoyalaHttpRequest');
        $httpRequest->expects($this->once())
            ->method('execute')
            ->with($this->equalTo('PATCH'),
                $this->anything(),
                $this->equalTo(array('payload' => '{"test":true}')))
            ->will($this->returnValue(array('status' => 200,
                'body' => '{"success": true}')));
        $this->ooyalaApi->httpRequest = $httpRequest;
        $response = $this->ooyalaApi->patch('/v2/assets', array('test' => true),
            array('test' => 'true'));
        $this->assertTrue($response->success);
    }

    public function testDelete()
    {
        $httpRequest = $this->getMock('OoyalaHttpRequest');
        $httpRequest->expects($this->once())
            ->method('execute')
            ->with($this->equalTo('DELETE'),
                $this->stringContains('api.ooyala.com/v2/assets'),
                $this->anything())
            ->will($this->returnValue(array('status' => 200,
                'body' => '{"success": true}')));
        $this->ooyalaApi->httpRequest = $httpRequest;
        $response = $this->ooyalaApi->delete('/v2/assets');
        $this->assertTrue($response->success);
    }

    public function testDeleteWithParams()
    {
        $httpRequest = $this->getMock('OoyalaHttpRequest');
        $httpRequest->expects($this->once())
            ->method('execute')
            ->with($this->equalTo('DELETE'),
                $this->stringContains('test=true'),
                $this->anything())
            ->will($this->returnValue(array('status' => 200,
                'body' => '{"success": true}')));
        $this->ooyalaApi->httpRequest = $httpRequest;
        $response = $this->ooyalaApi->delete('/v2/assets',
            array('test' => 'true'));
        $this->assertTrue($response->success);
    }
}
