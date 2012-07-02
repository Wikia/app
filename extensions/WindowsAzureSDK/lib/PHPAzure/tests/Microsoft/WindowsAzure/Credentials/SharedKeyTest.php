<?php
/**
 * Copyright (c) 2009 - 2011, RealDolmen
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions are met:
 *     * Redistributions of source code must retain the above copyright
 *       notice, this list of conditions and the following disclaimer.
 *     * Redistributions in binary form must reproduce the above copyright
 *       notice, this list of conditions and the following disclaimer in the
 *       documentation and/or other materials provided with the distribution.
 *     * Neither the name of RealDolmen nor the
 *       names of its contributors may be used to endorse or promote products
 *       derived from this software without specific prior written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY RealDolmen ''AS IS'' AND ANY
 * EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED
 * WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE
 * DISCLAIMED. IN NO EVENT SHALL RealDolmen BE LIABLE FOR ANY
 * DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES
 * (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
 * LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND
 * ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS
 * SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 * @category   Microsoft
 * @package    Microsoft_WindowsAzure
 * @subpackage UnitTests
 * @version    $Id$
 * @copyright  Copyright (c) 2009 - 2011, RealDolmen (http://www.realdolmen.com)
 * @license    http://phpazure.codeplex.com/license
 */

date_default_timezone_set('UTC');
require_once dirname(__FILE__) . '/../../../TestConfiguration.php';
require_once 'PHPUnit/Framework/TestCase.php';

require_once 'Microsoft/WindowsAzure/Credentials/SharedKey.php';

/**
 * @category   Microsoft
 * @package    Microsoft_WindowsAzure
 * @subpackage UnitTests
 * @version    $Id$
 * @copyright  Copyright (c) 2009 - 2011, RealDolmen (http://www.realdolmen.com)
 * @license    http://phpazure.codeplex.com/license
 */
class Microsoft_WindowsAzure_Credentials_SharedKeyTest extends PHPUnit_Framework_TestCase
{
    /**
     * Test signing for devstore with root path
     */
    public function testSignForDevstoreWithRootPath()
    {
        $credentials = new Microsoft_WindowsAzure_Credentials_SharedKey(Microsoft_WindowsAzure_Credentials_SharedKey::DEVSTORE_ACCOUNT, Microsoft_WindowsAzure_Credentials_SharedKey::DEVSTORE_KEY, true);
        $signedHeaders = $credentials->signRequestHeaders(
                              'GET',
                              '/',
                              array(),
                              array("x-ms-date" => "Wed, 29 Apr 2009 13:12:47 GMT"),
                              false
                          );
                          
        $this->assertInternalType('array', $signedHeaders);
        $this->assertEquals(2, count($signedHeaders));
        $this->assertEquals("SharedKey devstoreaccount1:9tokqwSDIqvRioVZ1k0mv5m/iseHsGRYmAMGJVu6NcU=", $signedHeaders["Authorization"]);
    }
    
    /**
     * Test signing for devstore with other path
     */
    public function testSignForDevstoreWithOtherPath()
    {
        $credentials = new Microsoft_WindowsAzure_Credentials_SharedKey(Microsoft_WindowsAzure_Credentials_SharedKey::DEVSTORE_ACCOUNT, Microsoft_WindowsAzure_Credentials_SharedKey::DEVSTORE_KEY, true);
        $signedHeaders = $credentials->signRequestHeaders(
                              'GET',
                              '/test',
                              array(),
                              array("x-ms-date" => "Wed, 29 Apr 2009 13:12:47 GMT"),
                              false
                          );
  
        $this->assertInternalType('array', $signedHeaders);
        $this->assertEquals(2, count($signedHeaders));
        $this->assertEquals("SharedKey devstoreaccount1:YHPfUXoeL/XZjEYii2pfSZi3CsOB++5sA4QT7CAvPig=", $signedHeaders["Authorization"]);
    }
    
    /**
     * Test signing for devstore with query string
     */
    public function testSignForDevstoreWithQueryString()
    {
        $credentials = new Microsoft_WindowsAzure_Credentials_SharedKey(Microsoft_WindowsAzure_Credentials_SharedKey::DEVSTORE_ACCOUNT, Microsoft_WindowsAzure_Credentials_SharedKey::DEVSTORE_KEY, true);
        $signedHeaders = $credentials->signRequestHeaders(
                              'GET',
                              '/',
                              array('test' => 'true'),
                              array("x-ms-date" => "Wed, 29 Apr 2009 13:12:47 GMT"),
                              false
                          );
  
        $this->assertInternalType('array', $signedHeaders);
        $this->assertEquals(2, count($signedHeaders));
        $this->assertEquals("SharedKey devstoreaccount1:S1+AcI8z19N0EP0eRTEj4UUCtPbKyUcZDAt299AWudw=", $signedHeaders["Authorization"]);
    }
    
    /**
     * Test signing for production with root path
     */
    public function testSignForProductionWithRootPath()
    {
        $credentials = new Microsoft_WindowsAzure_Credentials_SharedKey('testing', 'abcdefg');
        $signedHeaders = $credentials->signRequestHeaders(
                              'GET',
                              '/',
                              array(),
                              array("x-ms-date" => "Wed, 29 Apr 2009 13:12:47 GMT"),
                              false
                          );
                          
        $this->assertInternalType('array', $signedHeaders);
        $this->assertEquals(2, count($signedHeaders));
        $this->assertEquals("SharedKey testing:amg3/Z6Yx0KxwhRz9yn1ZCPZXYWIp5aEDCeZ1H5UIwo=", $signedHeaders["Authorization"]);
    }
    
    /**
     * Test signing for production with other path
     */
    public function testSignForProductionWithOtherPath()
    {
        $credentials = new Microsoft_WindowsAzure_Credentials_SharedKey('testing', 'abcdefg');
        $signedHeaders = $credentials->signRequestHeaders(
                              'GET',
                              '/test',
                              array(),
                              array("x-ms-date" => "Wed, 29 Apr 2009 13:12:47 GMT"),
                              false
                          );
  
        $this->assertInternalType('array', $signedHeaders);
        $this->assertEquals(2, count($signedHeaders));
        $this->assertEquals("SharedKey testing:ISA0m0Gy2SrxxjBO9ogtIbz0xNNyJ/GujUv5s1ibQrY=", $signedHeaders["Authorization"]);
    }
    
    /**
     * Test signing for production with query string
     */
    public function testSignForProductionWithQueryString()
    {
        $credentials = new Microsoft_WindowsAzure_Credentials_SharedKey('testing', 'abcdefg');
        $signedHeaders = $credentials->signRequestHeaders(
                              'GET',
                              '/',
                              array('test' => 'true'),
                              array("x-ms-date" => "Wed, 29 Apr 2009 13:12:47 GMT"),
                              false
                          );
  
        $this->assertInternalType('array', $signedHeaders);
        $this->assertEquals(2, count($signedHeaders));
        $this->assertEquals("SharedKey testing:vlfVjEbBaRVTv35e924cR4B/Z5zCaSYjbtMz9/k3UCY=", $signedHeaders["Authorization"]);
    }
}