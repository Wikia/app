<?php
require(__DIR__ . '/../sailthru/Sailthru_Client.php');
require(__DIR__ . '/../sailthru/Sailthru_Client_Exception.php');
require(__DIR__ . '/../sailthru/Sailthru_Util.php');

class Sailthru_ClientTest extends PHPUnit_Framework_TestCase {
    private $api_key = "my_api_key";
    private $api_secret = 'my_secret';
    private $api_url = 'https://api.sailthru.com';

    public function testDefaultTimeoutParameter() {
        $sailthru_client = new Sailthru_Client($this->api_key, $this->api_secret, $this->api_url);
        $this->assertEquals(10000, $sailthru_client->getTimeout());
        $this->assertEquals(10000, $sailthru_client->getConnectTimeout());
    }

    public function testCustomTimeoutParameter() {
        $sailthru_client = new Sailthru_Client($this->api_key, $this->api_secret, $this->api_url,
                                                     array('timeout' => 1, 'connect_timeout' => 2));
        $this->assertEquals(1, $sailthru_client->getTimeout());
        $this->assertEquals(2, $sailthru_client->getConnectTimeout());
    }

    public function testSendWhenTemplateNameIsInvalid() {
        $template_name = 'invalid_template';
        $email = 'praj@sailthru.com';
        $json_response = json_encode(array('error' => 14, 'errormsg' => 'Unknown template: ' . $template_name));
        $mock = $this->getMock('Sailthru_Client', array('send'), array($this->api_key, $this->api_secret, $this->api_url));
        $mock->expects($this->once())
                ->method('send')
                ->will($this->returnValue($json_response));
         $this->assertEquals($json_response, $mock->send($template_name, $email));
    }

    public function testSendWhenTemplateIsValid() {
        $template_name = 'my_template';
        $email = 'praj@sailthru.com';
        $json_response = json_encode(array('email' => $email, 'send_id' => 'some_unique_id', 'template' => $template_name, 'status' => 'unknown'));
        $mock = $this->getMock('Sailthru_Client', array('send'), array($this->api_key, $this->api_secret, $this->api_url));
        $mock->expects($this->once())
                ->method('send')
                ->will($this->returnvalue($json_response));
        $this->assertEquals($json_response, $mock->send($template_name, $email));
    }

    public function testApiPostWithValidJsonResponse() {
        $mock = $this->getMock('Sailthru_Client', array('apiPost'), array($this->api_key, $this->api_secret, $this->api_url));
        $json_response = array(
            'email' => 'praj@infynyxx.com',
            'profile_id' => '4f284c28a3a627b6389bfb4c',
            'verified' => 0,
            'vars' => array(
                'name' => 'Prajwal Tuladhar'
            )
        );
        $mock->expects($this->once())
            ->method('apiPost')
            ->will($this->returnValue($json_response));
        $this->assertTrue(is_array($mock->apiPost('email', $json_response)));
    }

    
    /**
     * @expectedException Sailthru_Client_Exception
     */
    public function testApiPostWithInvalidJsonResponse() {
        $mock = $this->getMock('Sailthru_Client', array('apiPost'), array($this->api_key, $this->api_secret, $this->api_url));
        $mock->expects($this->once())
            ->method('apiPost')
            ->will($this->throwException(new Sailthru_Client_Exception()));
        $response = $mock->apiPost('email', array('email' => 'praj@infynyxx.com'));
        $this->assertTrue(is_array($response)); // this will never be called
    }

    public function testPrepareJsonPayload() {
        $this->sailthru_client = new Sailthru_Client($this->api_key, $this->api_secret, $this->api_url);
        $method = new ReflectionMethod('Sailthru_Client', 'prepareJsonPayload');
        $method->setAccessible(true);
        $json_payload_without_binary_data = array(
            'email' => 'praj@infynyxx.com',
            'vars' => array(
                'name' => 'Prajwal Tuladhar'
            ),
            'action' => 'user'
        );
        $invoked = $method->invoke($this->sailthru_client, $json_payload_without_binary_data);
        $this->assertEquals($invoked['api_key'], $this->api_key);
        $this->assertTrue(isset($invoked['sig']));
    }

    public function testPrepareJsonPayloadWithBinaryData() {
        $this->sailthru_client = new Sailthru_Client($this->api_key, $this->api_secret, $this->api_url);
        $method = new ReflectionMethod('Sailthru_Client', 'prepareJsonPayload');
        $method->setAccessible(true);
        $json_payload = array(
            'email' => 'praj@infynyxx.com',
            'vars' => array(
                'name' => 'Prajwal Tuladhar'
            ),
            'action' => 'user'
        );
        $binary_data_param = array('file' => '/tmp/file.txt');
        $invoked = $method->invoke($this->sailthru_client, $json_payload, $binary_data_param);
        $this->assertEquals($invoked['api_key'], $this->api_key);
        $this->assertEquals($invoked['file'], $binary_data_param['file']);
    }

    public function testParseRateLimitHeaders() {
        $sailthru_client = new Sailthru_Client($this->api_key, $this->api_secret, $this->api_url);
        $method = new ReflectionMethod("Sailthru_Client", "parseRateLimitHeaders");
        $method->setAccessible(true);
        $headers = <<<HEADERS
HTTP/1.1 200 OK
Date: Mon, 28 Mar 2016 14:43:05 GMT
Server: Apache
X-Rate-Limit-Limit: 40
X-Rate-Limit-Remaining: 3
X-Rate-Limit-Reset: 1459190520
Content-Length: 2
Content-Type: application/json"
HEADERS;

        $parsed_rate_limit = $method->invoke($sailthru_client, $headers);
        $expected = ['limit' => 40, 'remaining' => 3, "reset" => 1459190520];
        $this->assertEquals($expected, $parsed_rate_limit);
    }
}
