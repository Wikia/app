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
 * @version    $Id: BlobStreamTest.php 24354 2009-07-24 08:48:54Z unknown $
 * @copyright  Copyright (c) 2009 - 2011, RealDolmen (http://www.realdolmen.com)
 * @license    http://phpazure.codeplex.com/license
 */

date_default_timezone_set('UTC');
require_once dirname(__FILE__) . '/../../TestConfiguration.php';
require_once 'PHPUnit/Framework/TestCase.php';

require_once 'Microsoft/WindowsAzure/Storage/Blob.php';

/**
 * @category   Microsoft
 * @package    Microsoft_WindowsAzure
 * @subpackage UnitTests
 * @version    $Id: BlobStreamTest.php 24354 2009-07-24 08:48:54Z unknown $
 * @copyright  Copyright (c) 2009 - 2011, RealDolmen (http://www.realdolmen.com)
 * @license    http://phpazure.codeplex.com/license
 */
class Microsoft_WindowsAzure_BlobStreamTest extends PHPUnit_Framework_TestCase
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
        $storageClient = $this->createStorageInstance();
        for ($i = 1; $i <= self::$uniqId; $i++)
        {
            try { $storageClient->deleteContainer(TESTS_BLOBSTREAM_CONTAINER_PREFIX . $i); } catch (Exception $e) { }
            try { $storageClient->unregisterStreamWrapper('azure'); } catch (Exception $e) { }
        }
    }

    protected function createStorageInstance()
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
        return TESTS_BLOBSTREAM_CONTAINER_PREFIX . self::$uniqId;
    }
    
    /**
     * Test read file
     */
    public function testReadFile()
    {
    	if (TESTS_BLOB_RUNTESTS) {
            $containerName = $this->generateName();
            $fileName = 'azure://' . $containerName . '/test.txt';
            
            $storageClient = $this->createStorageInstance();
            $storageClient->registerStreamWrapper();
            
            $fh = fopen($fileName, 'w');
            fwrite($fh, "Hello world!");
            fclose($fh);
            
            $result = file_get_contents($fileName);
            
            $storageClient->unregisterStreamWrapper();
            
            $this->assertEquals('Hello world!', $result);
        }
    }
    
    /**
     * Test write file
     */
    public function testWriteFile()
    {
    	if (TESTS_BLOB_RUNTESTS) {
            $containerName = $this->generateName();
            $fileName = 'azure://' . $containerName . '/test.txt';
            
            $storageClient = $this->createStorageInstance();
            $storageClient->registerStreamWrapper();
            
            $fh = fopen($fileName, 'w');
            fwrite($fh, "Hello world!");
            fclose($fh);
            
            $storageClient->unregisterStreamWrapper();
            
            $instance = $storageClient->getBlobInstance($containerName, 'test.txt');
            $this->assertEquals('test.txt', $instance->Name);
        }
    }
    
    /**
     * Test unlink file
     */
    public function testUnlinkFile()
    {
    	if (TESTS_BLOB_RUNTESTS) {
            $containerName = $this->generateName();
            $fileName = 'azure://' . $containerName . '/test.txt';
            
            $storageClient = $this->createStorageInstance();
            $storageClient->registerStreamWrapper();
            
            $fh = fopen($fileName, 'w');
            fwrite($fh, "Hello world!");
            fclose($fh);
            
            unlink($fileName);
            
            $storageClient->unregisterStreamWrapper();
            
            $result = $storageClient->listBlobs($containerName);
            $this->assertEquals(0, count($result));
        }
    }
    
    /**
     * Test copy file
     */
    public function testCopyFile()
    {
    	if (TESTS_BLOB_RUNTESTS) {
            $containerName = $this->generateName();
            $sourceFileName = 'azure://' . $containerName . '/test.txt';
            $destinationFileName = 'azure://' . $containerName . '/test2.txt';
            
            $storageClient = $this->createStorageInstance();
            $storageClient->registerStreamWrapper();
            
            $fh = fopen($sourceFileName, 'w');
            fwrite($fh, "Hello world!");
            fclose($fh);

            copy($sourceFileName, $destinationFileName);

            $storageClient->unregisterStreamWrapper();
            
            $instance = $storageClient->getBlobInstance($containerName, 'test2.txt');
            $this->assertEquals('test2.txt', $instance->Name);
        }
    }
    
    /**
     * Test rename file
     */
    public function testRenameFile()
    {
    	if (TESTS_BLOB_RUNTESTS) {
            $containerName = $this->generateName();
            $sourceFileName = 'azure://' . $containerName . '/test.txt';
            $destinationFileName = 'azure://' . $containerName . '/test2.txt';
            
            $storageClient = $this->createStorageInstance();
            $storageClient->registerStreamWrapper();
            
            $fh = fopen($sourceFileName, 'w');
            fwrite($fh, "Hello world!");
            fclose($fh);
            
            rename($sourceFileName, $destinationFileName);
            
            $storageClient->unregisterStreamWrapper();
            
            $instance = $storageClient->getBlobInstance($containerName, 'test2.txt');
            $this->assertEquals('test2.txt', $instance->Name);
        }
    }
    
    /**
     * Test mkdir
     */
    public function testMkdir()
    {
    	if (TESTS_BLOB_RUNTESTS) {
            $containerName = $this->generateName();
            
            $storageClient = $this->createStorageInstance();
            $storageClient->registerStreamWrapper();
            
            mkdir('azure://' . $containerName);
            
            $storageClient->unregisterStreamWrapper();
            
            $result = $storageClient->listContainers();
            
            $this->assertEquals(1, count($result));
            $this->assertEquals($containerName, $result[0]->Name);
        }
    }
    
    /**
     * Test rmdir
     */
    public function testRmdir()
    {
    	if (TESTS_BLOB_RUNTESTS) {
            $containerName = $this->generateName();
            
            $storageClient = $this->createStorageInstance();
            $storageClient->registerStreamWrapper();
            
            mkdir('azure://' . $containerName);
            rmdir('azure://' . $containerName);
            
            $storageClient->unregisterStreamWrapper();
            
            $result = $storageClient->listContainers();
            
            $this->assertEquals(0, count($result));
        }
    } 
    
    /**
     * Test opendir
     */
    public function testOpendir()
    {
        if (TESTS_BLOB_RUNTESTS) {
            $containerName = $this->generateName();
            $storageClient = $this->createStorageInstance();
            $storageClient->createContainer($containerName);
            
            $storageClient->putBlob($containerName, 'images/WindowsAzure1.gif', self::$path . 'WindowsAzure.gif');
            $storageClient->putBlob($containerName, 'images/WindowsAzure2.gif', self::$path . 'WindowsAzure.gif');
            $storageClient->putBlob($containerName, 'images/WindowsAzure3.gif', self::$path . 'WindowsAzure.gif');
            $storageClient->putBlob($containerName, 'images/WindowsAzure4.gif', self::$path . 'WindowsAzure.gif');
            $storageClient->putBlob($containerName, 'images/WindowsAzure5.gif', self::$path . 'WindowsAzure.gif');
            
            $result1 = $storageClient->listBlobs($containerName);
  
            $storageClient->registerStreamWrapper();
            
            $result2 = array();
            if ($handle = opendir('azure://' . $containerName)) {
                while (false !== ($file = readdir($handle))) {
                    $result2[] = $file;
                }
                closedir($handle);
            }
            
            $storageClient->unregisterStreamWrapper();
            
            $result = $storageClient->listContainers();
            
            $this->assertEquals(count($result1), count($result2));
        }
    } 
}