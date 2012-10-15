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
 * @version    $Id: QueueStorageTest.php 24241 2009-07-22 09:43:13Z unknown $
 * @copyright  Copyright (c) 2009 - 2011, RealDolmen (http://www.realdolmen.com)
 * @license    http://phpazure.codeplex.com/license
 */

date_default_timezone_set('UTC');
require_once dirname(__FILE__) . '/../../TestConfiguration.php';
require_once 'PHPUnit/Framework/TestCase.php';

require_once 'Microsoft/WindowsAzure/Storage/Queue.php';

/**
 * @category   Microsoft
 * @package    Microsoft_WindowsAzure
 * @subpackage UnitTests
 * @version    $Id: QueueStorageTest.php 24241 2009-07-22 09:43:13Z unknown $
 * @copyright  Copyright (c) 2009 - 2011, RealDolmen (http://www.realdolmen.com)
 * @license    http://phpazure.codeplex.com/license
 */
class Microsoft_WindowsAzure_QueueStorageTest extends PHPUnit_Framework_TestCase
{   
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
            try { $storageClient->deleteQueue(TESTS_QUEUE_PREFIX . $i); } catch (Exception $e) { }
        }
    }

    protected function createStorageInstance()
    {
        $storageClient = null;
        if (TESTS_QUEUE_RUNONPROD) {
            $storageClient = new Microsoft_WindowsAzure_Storage_Queue(TESTS_QUEUE_HOST_PROD, TESTS_STORAGE_ACCOUNT_PROD, TESTS_STORAGE_KEY_PROD, false, Microsoft_WindowsAzure_RetryPolicy_RetryPolicyAbstract::retryN(10, 250));
        } else {
            $storageClient = new Microsoft_WindowsAzure_Storage_Queue(TESTS_QUEUE_HOST_DEV, TESTS_STORAGE_ACCOUNT_DEV, TESTS_STORAGE_KEY_DEV, true, Microsoft_WindowsAzure_RetryPolicy_RetryPolicyAbstract::retryN(10, 250));
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
        return TESTS_QUEUE_PREFIX . self::$uniqId;
    }
    
    /**
     * Test queue exists
     */
    public function testQueueExists()
    {
    	if (TESTS_QUEUE_RUNTESTS) {
            $queueName1 = $this->generateName();
            $queueName2 = $this->generateName();
            $storageClient = $this->createStorageInstance();
            $storageClient->createQueue($queueName1);
            $storageClient->createQueue($queueName2);

            $result = $storageClient->queueExists($queueName1);
            $this->assertTrue($result);
            
            $result = $storageClient->queueExists(md5(time()));
            $this->assertFalse($result);
        }
    }
    
    /**
     * Test create queue
     */
    public function testCreateQueue()
    {
    	if (TESTS_QUEUE_RUNTESTS) {
            $queueName = $this->generateName();
            $storageClient = $this->createStorageInstance();
            $result = $storageClient->createQueue($queueName);
            $this->assertEquals($queueName, $result->Name);
        }
    }
    
    /**
     * Test create queue if not exists
     */
    public function testCreateQueueIfNotExists()
    {
    	if (TESTS_QUEUE_RUNTESTS) {
            $queueName = $this->generateName();
            $storageClient = $this->createStorageInstance();
            
            $result = $storageClient->queueExists($queueName);
            $this->assertFalse($result);
            
            $storageClient->createQueueIfNotExists($queueName);
            
            $result = $storageClient->queueExists($queueName);
            $this->assertTrue($result);
            
            $storageClient->createQueueIfNotExists($queueName);
        }
    }
    
    /**
     * Test set queue metadata
     */
    public function testSetQueueMetadata()
    {
    	if (TESTS_QUEUE_RUNTESTS) {
            $queueName = $this->generateName();
            $storageClient = $this->createStorageInstance();
            $storageClient->createQueue($queueName);
            
            $storageClient->setQueueMetadata($queueName, array(
                'createdby' => 'PHPAzure',
            ));
            
            $metadata = $storageClient->getQueueMetadata($queueName);
            $this->assertEquals('PHPAzure', $metadata['createdby']);
        }
    }
    
    /**
     * Test get queue
     */
    public function testGetQueue()
    {
    	if (TESTS_QUEUE_RUNTESTS) {
            $queueName = $this->generateName();
            $storageClient = $this->createStorageInstance();
            $storageClient->createQueue($queueName);
            
            $queue = $storageClient->getQueue($queueName);
            $this->assertEquals($queueName, $queue->Name);
            $this->assertEquals(0, $queue->ApproximateMessageCount);
        }
    }
    
    /**
     * Test list queues
     */
    public function testListQueues()
    {
    	if (TESTS_QUEUE_RUNTESTS) {
            $queueName1 = 'testlist1';
            $queueName2 = 'testlist2';
            $queueName3 = 'testlist3';
            $storageClient = $this->createStorageInstance();
            $storageClient->createQueue($queueName1);
            $storageClient->createQueue($queueName2);
            $storageClient->createQueue($queueName3);
            $result1 = $storageClient->listQueues('testlist');
            $result2 = $storageClient->listQueues('testlist', 1);
    
            // cleanup first
            $storageClient->deleteQueue($queueName1);
            $storageClient->deleteQueue($queueName2);
            $storageClient->deleteQueue($queueName3);
            
            $this->assertEquals(3, count($result1));
            $this->assertEquals($queueName2, $result1[1]->Name);
            
            $this->assertEquals(1, count($result2));
        }
    }
    
    /**
     * Test list queues with metadata
     */
    public function testListQueuesWithMetadata()
    {
    	if (TESTS_QUEUE_RUNTESTS) {
            $queueName = $this->generateName();
            $storageClient = $this->createStorageInstance();
            $storageClient->createQueue($queueName, array(
                'createdby' => 'PHPAzure',
                'ownedby' => 'PHPAzure',
            ));
            
            $result = $storageClient->listQueues($queueName, null, null, 'metadata');
            
            $this->assertEquals('PHPAzure', $result[0]->Metadata['createdby']);
            $this->assertEquals('PHPAzure', $result[0]->Metadata['ownedby']);
        }
    }
    
    /**
     * Test put message
     */
    public function testPutMessage()
    {
    	if (TESTS_QUEUE_RUNTESTS) {
            $queueName = $this->generateName();
            $storageClient = $this->createStorageInstance();
            $storageClient->createQueue($queueName);
            $storageClient->putMessage($queueName, 'Test message', 120);
            
            sleep(5); // wait for the message to appear in the queue...
            
            $messages = $storageClient->getMessages($queueName);
            $this->assertEquals(1, count($messages));
            $this->assertEquals('Test message', $messages[0]->MessageText);
        }
    }
    
    /**
     * Test get messages
     */
    public function testGetMessages()
    {
        if (TESTS_QUEUE_RUNTESTS) {
            $queueName = $this->generateName();
            $storageClient = $this->createStorageInstance();
            $storageClient->createQueue($queueName);
            $storageClient->putMessage($queueName, 'Test message 1', 120);
            $storageClient->putMessage($queueName, 'Test message 2', 120);
            $storageClient->putMessage($queueName, 'Test message 3', 120);
            $storageClient->putMessage($queueName, 'Test message 4', 120);
            
            sleep(5); // wait for the messages to appear in the queue...
            
            $messages1 = $storageClient->getMessages($queueName, 2);
            $messages2 = $storageClient->getMessages($queueName, 2);
            $messages3 = $storageClient->getMessages($queueName);
            
            $this->assertEquals(2, count($messages1));
            $this->assertEquals(2, count($messages2));
            $this->assertEquals(0, count($messages3));
        }
    }
    
    /**
     * Test peek messages
     */
    public function testPeekMessages()
    {
        if (TESTS_QUEUE_RUNTESTS) {
            $queueName = $this->generateName();
            $storageClient = $this->createStorageInstance();
            $storageClient->createQueue($queueName);
            $storageClient->putMessage($queueName, 'Test message 1', 120);
            $storageClient->putMessage($queueName, 'Test message 2', 120);
            $storageClient->putMessage($queueName, 'Test message 3', 120);
            $storageClient->putMessage($queueName, 'Test message 4', 120);
            
            sleep(5); // wait for the messages to appear in the queue...
            
            $messages1 = $storageClient->peekMessages($queueName, 4);
            $hasMessages = $storageClient->hasMessages($queueName);
            $messages2 = $storageClient->getMessages($queueName, 4);
            
            $this->assertEquals(4, count($messages1));
            $this->assertTrue($hasMessages);
            $this->assertEquals(4, count($messages2));
        }
    }
    
    /**
     * Test dequeuecount
     */
    public function testDequeueCount()
    {
        if (TESTS_QUEUE_RUNTESTS) {
            $queueName = $this->generateName();
            $storageClient = $this->createStorageInstance();
            $storageClient->createQueue($queueName);
            $storageClient->putMessage($queueName, 'Test message 1', 120);
            
            sleep(5); // wait for the message to appear in the queue...
            
            $expectedDequeueCount = 3;
            for ($i = 0; $i < $expectedDequeueCount - 1; $i++) {
	            $storageClient->getMessages($queueName, 1, 1);
	            sleep(3);
            }
            
            $messages = $storageClient->getMessages($queueName, 1);
            
            $this->assertEquals($expectedDequeueCount, $messages[0]->DequeueCount);
        }
    }
    
    /**
     * Test clear messages
     */
    public function testClearMessages()
    {
        if (TESTS_QUEUE_RUNTESTS) {
            $queueName = $this->generateName();
            $storageClient = $this->createStorageInstance();
            $storageClient->createQueue($queueName);
            $storageClient->putMessage($queueName, 'Test message 1', 120);
            $storageClient->putMessage($queueName, 'Test message 2', 120);
            $storageClient->putMessage($queueName, 'Test message 3', 120);
            $storageClient->putMessage($queueName, 'Test message 4', 120);
            
            sleep(5); // wait for the messages to appear in the queue...
            
            $messages1 = $storageClient->peekMessages($queueName, 4);
            $storageClient->clearMessages($queueName);
            
            sleep(5); // wait for the GC...
            
            $messages2 = $storageClient->peekMessages($queueName, 4);
            
            $this->assertEquals(4, count($messages1));
            $this->assertEquals(0, count($messages2));
        }
    }
    
    /**
     * Test delete message
     */
    public function testDeleteMessage()
    {
        if (TESTS_QUEUE_RUNTESTS) {
            $queueName = $this->generateName();
            $storageClient = $this->createStorageInstance();
            $storageClient->createQueue($queueName);
            $storageClient->putMessage($queueName, 'Test message 1', 120);
            $storageClient->putMessage($queueName, 'Test message 2', 120);
            $storageClient->putMessage($queueName, 'Test message 3', 120);
            $storageClient->putMessage($queueName, 'Test message 4', 120);
            
            sleep(5); // wait for the messages to appear in the queue...
            
            $messages1 = $storageClient->getMessages($queueName, 2, 10);
            foreach ($messages1 as $message)
            {
                $storageClient->deleteMessage($queueName, $message);
            }
            
            sleep(5); // wait for the GC...
            
            $messages2 = $storageClient->getMessages($queueName, 4);
            
            $this->assertEquals(2, count($messages1));
            $this->assertEquals(2, count($messages2));
        }
    }
}