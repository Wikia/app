<?php

class Sailthru_Client_ExceptionTest extends PHPUnit_Framework_TestCase {
    /**
     * @expectedException Sailthru_Client_Exception
     */
    public function testSailthru_Client_Exception() {
        $api_key = "invalid_key";
        $api_secret = "invalid_secret";
        $api_url = "https://api.invalid_url.com";
        $sailthruClient = new Sailthru_Client($api_key, $api_secret, $api_url);
        $sailthruClient->getEmail("praj@sailthru.com");
    }
}
