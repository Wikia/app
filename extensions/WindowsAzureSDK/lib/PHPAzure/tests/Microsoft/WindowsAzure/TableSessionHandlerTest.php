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
 * @version    $Id: BlobStorageTest.php 14561 2009-05-07 08:05:12Z unknown $
 * @copyright  Copyright (c) 2009 - 2011, RealDolmen (http://www.realdolmen.com)
 * @license    http://phpazure.codeplex.com/license
 */

date_default_timezone_set('UTC');
require_once dirname(__FILE__) . '/../../TestConfiguration.php';
require_once 'PHPUnit/Framework/TestCase.php';

require_once 'Microsoft/WindowsAzure/SessionHandler.php';
require_once 'Microsoft/WindowsAzure/Storage/Table.php';

/**
 * @category   Microsoft
 * @package    Microsoft_WindowsAzure
 * @subpackage UnitTests
 * @version    $Id: BlobStorageTest.php 14561 2009-05-07 08:05:12Z unknown $
 * @copyright  Copyright (c) 2009 - 2011, RealDolmen (http://www.realdolmen.com)
 * @license    http://phpazure.codeplex.com/license
 */
class Microsoft_WindowsAzure_TableSessionHandlerTest extends PHPUnit_Framework_TestCase
{
    public function __construct()
    {
    }
    
    /**
     * Test setup
     */
    protected function setUp()
    {
    }
    
    /**
     * Test teardown
     */
    protected function tearDown()
    {
        $storageClient = $this->createStorageInstance();
        for ($i = 1; $i <= self::$uniqId; $i++)
        {
            try { $storageClient->deleteTable(TESTS_SESSIONHANDLER_TABLENAME_PREFIX . $i); } catch (Exception $e) { }
        }
    }
    
    protected function createStorageInstance()
    {
        $storageClient = null;
        if (TESTS_SESSIONHANDLER_RUNONPROD) {
            $storageClient = new Microsoft_WindowsAzure_Storage_Table(TESTS_TABLE_HOST_PROD, TESTS_STORAGE_ACCOUNT_PROD, TESTS_STORAGE_KEY_PROD, false, Microsoft_WindowsAzure_RetryPolicy_RetryPolicyAbstract::retryN(10, 250));
        } else {
            $storageClient = new Microsoft_WindowsAzure_Storage_Table(TESTS_TABLE_HOST_DEV, TESTS_STORAGE_ACCOUNT_DEV, TESTS_STORAGE_KEY_DEV, true, Microsoft_WindowsAzure_RetryPolicy_RetryPolicyAbstract::retryN(10, 250));
        }
        
        if (TESTS_STORAGE_USEPROXY) {
            $storageClient->setProxy(TESTS_STORAGE_USEPROXY, TESTS_STORAGE_PROXY, TESTS_STORAGE_PROXY_PORT, TESTS_STORAGE_PROXY_CREDENTIALS);
        }

        return $storageClient;
    }
    
    protected function createSessionHandler($storageInstance, $tableName)
    {
        $sessionHandler = new Microsoft_WindowsAzure_SessionHandler(
            $storageInstance,
            $tableName
        );
        return $sessionHandler;
    }
    
    protected static $uniqId = 0;
    
    protected function generateName()
    {
        self::$uniqId++;
        return TESTS_SESSIONHANDLER_TABLENAME_PREFIX . self::$uniqId;
    }
    
    /**
     * Test register
     */
    public function testRegister()
    {
        if (TESTS_SESSIONHANDLER_RUNTESTS) {
            $storageClient = $this->createStorageInstance();
            $tableName = $this->generateName();
            $sessionHandler = $this->createSessionHandler($storageClient, $tableName);
            $result = $sessionHandler->register();
            
            $this->assertTrue($result);
        }
    }
    
    /**
     * Test open
     */
    public function testOpen()
    {
        if (TESTS_SESSIONHANDLER_RUNTESTS) {
            $storageClient = $this->createStorageInstance();
            $tableName = $this->generateName();
            $sessionHandler = $this->createSessionHandler($storageClient, $tableName);
            $result = $sessionHandler->open();

            $this->assertTrue($result);
            
            
            $verifyResult = $storageClient->listTables();
            $this->assertEquals($tableName, $verifyResult[0]->Name);
        }
    }
    
    /**
     * Test close
     */
    public function testClose()
    {
        if (TESTS_SESSIONHANDLER_RUNTESTS) {
            $storageClient = $this->createStorageInstance();
            $tableName = $this->generateName();
            $sessionHandler = $this->createSessionHandler($storageClient, $tableName);
            $sessionHandler->open();
            $result = $sessionHandler->close();
            
            $this->assertTrue($result);
        }
    }
    
    /**
     * Test read
     */
    public function testRead()
    {
        if (TESTS_SESSIONHANDLER_RUNTESTS) {
            $storageClient = $this->createStorageInstance();
            $tableName = $this->generateName();
            $sessionHandler = $this->createSessionHandler($storageClient, $tableName);
            $sessionHandler->open();
            
            $sessionId = $this->session_id();
            $sessionData = serialize( 'PHPAzure' );
            $sessionHandler->write($sessionId, $sessionData);
            
            $result = unserialize( $sessionHandler->read($sessionId) );
            
            $this->assertEquals('PHPAzure', $result);
        }
    }
    
    /**
     * Test write
     */
    public function testWrite()
    {
        if (TESTS_SESSIONHANDLER_RUNTESTS) {
            $storageClient = $this->createStorageInstance();
            $tableName = $this->generateName();
            $sessionHandler = $this->createSessionHandler($storageClient, $tableName);
            $sessionHandler->open();
            
            $sessionId = $this->session_id();
            $sessionData = serialize( 'PHPAzure' );
            $sessionHandler->write($sessionId, $sessionData);
            
            
            $verifyResult = $storageClient->retrieveEntities($tableName);
            $this->assertEquals(1, count($verifyResult));
        }
    }
    
    /**
     * Test write large
     */
    public function testWriteLarge()
    {
        if (TESTS_SESSIONHANDLER_RUNTESTS) {
            $storageClient = $this->createStorageInstance();
            $tableName = $this->generateName();
            $sessionHandler = $this->createSessionHandler($storageClient, $tableName);
            $sessionHandler->open();
            
            $sessionId = $this->session_id();
            
            $sessionData = '';
            for ($i = 0; $i < Microsoft_WindowsAzure_SessionHandler::MAX_TS_PROPERTY_SIZE; $i++) {
            	$sessionData .= 'a';
            }
            $sessionData = serialize( $sessionData );
            
            $exceptionThrown = false;
            try {
            	$sessionHandler->write($sessionId, $sessionData);
            } catch (Exception $ex) {
            	$exceptionThrown = true;
            }
            
            $this->assertTrue($exceptionThrown);
        }
    }
    
    /**
     * Test destroy
     */
    public function testDestroy()
    {
        if (TESTS_SESSIONHANDLER_RUNTESTS) {
            $storageClient = $this->createStorageInstance();
            $tableName = $this->generateName();
            $sessionHandler = $this->createSessionHandler($storageClient, $tableName);
            $sessionHandler->open();
            
            $sessionId = $this->session_id();
            $sessionData = serialize( 'PHPAzure' );
            $sessionHandler->write($sessionId, $sessionData);
            
            $result = $sessionHandler->destroy($sessionId);
            $this->assertTrue($result);
            
            $verifyResult = $storageClient->retrieveEntities($tableName);
            $this->assertEquals(0, count($verifyResult));
        }
    }
    
    /**
     * Test gc
     */
    public function testGc()
    {
        if (TESTS_SESSIONHANDLER_RUNTESTS) {
            $storageClient = $this->createStorageInstance();
            $tableName = $this->generateName();
            $sessionHandler = $this->createSessionHandler($storageClient, $tableName);
            $sessionHandler->open();
            
            $sessionId = $this->session_id();
            $sessionData = serialize( 'PHPAzure' );
            $sessionHandler->write($sessionId, $sessionData);
            
            sleep(1); // let time() tick
            
            $result = $sessionHandler->gc(0);
            $this->assertTrue($result);
            
            $verifyResult = $storageClient->retrieveEntities($tableName);
            $this->assertEquals(0, count($verifyResult));
        }
    }

    protected function session_id()
    {
        return md5(self::$uniqId);
    }
}