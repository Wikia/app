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
 * @version    $Id: BlobStorageSharedAccessTest.php 25258 2009-08-14 08:40:41Z unknown $
 * @copyright  Copyright (c) 2009 - 2011, RealDolmen (http://www.realdolmen.com)
 * @license    http://phpazure.codeplex.com/license
 */

date_default_timezone_set('UTC');
require_once dirname(__FILE__) . '/../../TestConfiguration.php';
require_once 'PHPUnit/Framework/TestCase.php';

require_once 'Microsoft/WindowsAzure/Storage/Blob.php';
require_once 'Microsoft/WindowsAzure/Credentials/SharedAccessSignature.php';

/**
 * @category   Microsoft
 * @package    Microsoft_WindowsAzure
 * @subpackage UnitTests
 * @version    $Id: BlobStorageSharedAccessTest.php 25258 2009-08-14 08:40:41Z unknown $
 * @copyright  Copyright (c) 2009 - 2011, RealDolmen (http://www.realdolmen.com)
 * @license    http://phpazure.codeplex.com/license
 */
class Microsoft_WindowsAzure_BlobStorageSharedAccessTest extends PHPUnit_Framework_TestCase
{
    static $path;
    
    public function __construct()
    {
        self::$path = dirname(__FILE__).'/_files/';
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
        $storageClient = $this->createAdministrativeStorageInstance();
        for ($i = 1; $i <= self::$uniqId; $i++)
        {
            try { $storageClient->deleteContainer(TESTS_BLOBSA_CONTAINER_PREFIX . $i); } catch (Exception $e) { }
        }
        try { $storageClient->deleteContainer('$root'); } catch (Exception $e) { }
    }

    protected function createStorageInstance()
    {
        $storageClient = null;
        if (TESTS_BLOB_RUNONPROD) {
            $storageClient = new Microsoft_WindowsAzure_Storage_Blob(TESTS_BLOB_HOST_PROD, TESTS_STORAGE_ACCOUNT_PROD, TESTS_STORAGE_KEY_PROD, false, Microsoft_WindowsAzure_RetryPolicy_RetryPolicyAbstract::retryN(10, 250));
            $storageClient->setCredentials(
                new Microsoft_WindowsAzure_Credentials_SharedAccessSignature(TESTS_STORAGE_ACCOUNT_PROD, TESTS_STORAGE_KEY_PROD, false)
            );
        } else {
            $storageClient = new Microsoft_WindowsAzure_Storage_Blob(TESTS_BLOB_HOST_DEV, TESTS_STORAGE_ACCOUNT_DEV, TESTS_STORAGE_KEY_DEV, true, Microsoft_WindowsAzure_RetryPolicy_RetryPolicyAbstract::retryN(10, 250));
            $storageClient->setCredentials(
                new Microsoft_WindowsAzure_Credentials_SharedAccessSignature(TESTS_STORAGE_ACCOUNT_DEV, TESTS_STORAGE_KEY_DEV, true)
            );
        }
        
        if (TESTS_STORAGE_USEPROXY) {
            $storageClient->setProxy(TESTS_STORAGE_USEPROXY, TESTS_STORAGE_PROXY, TESTS_STORAGE_PROXY_PORT, TESTS_STORAGE_PROXY_CREDENTIALS);
        }

        return $storageClient;
    }
    
    protected function createAdministrativeStorageInstance()
    {
        $storageClient = null;
        if (TESTS_BLOB_RUNONPROD) {
            $storageClient = new Microsoft_WindowsAzure_Storage_Blob(TESTS_BLOB_HOST_PROD, TESTS_STORAGE_ACCOUNT_PROD, TESTS_STORAGE_KEY_PROD, false, Microsoft_WindowsAzure_RetryPolicy_RetryPolicyAbstract::retryN(10, 250));
        } else {
            $storageClient = new Microsoft_WindowsAzure_Storage_Blob(TESTS_BLOB_HOST_DEV, TESTS_STORAGE_ACCOUNT_DEV, TESTS_STORAGE_KEY_DEV, true, Microsoft_WindowsAzure_RetryPolicy_RetryPolicyAbstract::retryN(10, 250));
        }
        
        if (TESTS_STORAGE_USEPROXY) {
            $storageClient->setProxy(TESTS_STORAGE_USEPROXY, TESTS_STORAGE_PROXY, TESTS_STORAGE_PROXY_PORT, TESTS_STORAGE_PROXY_CREDENTIALS);
        }

        return $storageClient;
    }
    
    protected static $uniqId = 0;
    
    protected function generateName()
    {
        self::$uniqId++;
        return TESTS_BLOBSA_CONTAINER_PREFIX . self::$uniqId;
    }
    
    /**
     * Test shared access, only write
     */
    public function testSharedAccess_OnlyWrite()
    {
    	if (TESTS_BLOB_RUNTESTS) {
            $containerName = $this->generateName();
            
            // Account owner performs this part
            $administrativeStorageClient = $this->createAdministrativeStorageInstance();
            $administrativeStorageClient->createContainer($containerName);
            
            $sharedAccessUrl = $administrativeStorageClient->generateSharedAccessUrl(
                $containerName,
                '',
            	'c', 
            	'w',
            	$administrativeStorageClient->isoDate(time() - 500),
            	$administrativeStorageClient->isoDate(time() + 3000)
            );

            
            // Reduced permissions user performs this part
            $storageClient = $this->createStorageInstance();
            $credentials = $storageClient->getCredentials();
            $credentials->setPermissionSet(array(
                $sharedAccessUrl
            ));

            $result = $storageClient->putBlob($containerName, 'images/WindowsAzure.gif', self::$path . 'WindowsAzure.gif');
    
            $this->assertEquals($containerName, $result->Container);
            $this->assertEquals('images/WindowsAzure.gif', $result->Name);
            
            
            
            // Now make sure reduced permissions user can not view the uploaded blob
            $exceptionThrown = false;
            try {
                $storageClient->getBlob($containerName, 'images/WindowsAzure.gif', self::$path . 'WindowsAzure.gif');
            } catch (Exception $ex) {
                $exceptionThrown = true;
            }
            $this->assertTrue($exceptionThrown);
        }
    }
    
    /**
     * Test different accounts
     */
    public function testDifferentAccounts()
    {
        if (TESTS_BLOB_RUNTESTS) {
            $containerName = $this->generateName();
            
            // Account owner performs this part
            $administrativeStorageClient = $this->createAdministrativeStorageInstance();
            $administrativeStorageClient->createContainer($containerName);
            
            $sharedAccessUrl1 = $administrativeStorageClient->generateSharedAccessUrl(
                $containerName,
                '',
            	'c', 
            	'w',
            	$administrativeStorageClient->isoDate(time() - 500),
            	$administrativeStorageClient->isoDate(time() + 3000)
            );
            $sharedAccessUrl2 = str_replace($administrativeStorageClient->getAccountName(), 'bogusaccount', $sharedAccessUrl1);

            
            // Reduced permissions user performs this part and should fail,
            // because different accounts have been used
            $storageClient = $this->createStorageInstance();
            $credentials = $storageClient->getCredentials();

            $exceptionThrown = false;
            try {
	            $credentials->setPermissionSet(array(
	                $sharedAccessUrl1,
	                $sharedAccessUrl2
	            ));
            } catch (Exception $ex) {
                $exceptionThrown = true;
            }
            $this->assertTrue($exceptionThrown);
        }
    }
}