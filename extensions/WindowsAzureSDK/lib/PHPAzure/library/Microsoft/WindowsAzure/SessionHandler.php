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
 * @subpackage Session
 * @copyright  Copyright (c) 2009 - 2011, RealDolmen (http://www.realdolmen.com)
 * @license    http://phpazure.codeplex.com/license
 * @version    $Id: Storage.php 21617 2009-06-12 10:46:31Z unknown $
 */

/**
 * @see Microsoft_AutoLoader
 */
require_once dirname(__FILE__) . '/../AutoLoader.php';

/**
 * @category   Microsoft
 * @package    Microsoft_WindowsAzure
 * @subpackage Session
 * @copyright  Copyright (c) 2009 - 2011, RealDolmen (http://www.realdolmen.com)
 * @license    http://phpazure.codeplex.com/license
 */
class Microsoft_WindowsAzure_SessionHandler
{
	/**
	 * Maximal property size in table storage.
	 * 
	 * @var int
	 * @see http://msdn.microsoft.com/en-us/library/dd179338.aspx
	 */
	const MAX_TS_PROPERTY_SIZE = 65536;
	
	/** Storage backend type */
	const STORAGE_TYPE_TABLE = 'table';
	const STORAGE_TYPE_BLOB = 'blob';
	
    /**
     * Storage back-end
     * 
     * @var Microsoft_WindowsAzure_Storage_Table|Microsoft_WindowsAzure_Storage_Blob
     */
    protected $_storage;
    
    /**
     * Storage backend type
     * 
     * @var string
     */
    protected $_storageType;
    
    /**
     * Session container name
     * 
     * @var string
     */
    protected $_sessionContainer;
    
    /**
     * Session container partition
     * 
     * @var string
     */
    protected $_sessionContainerPartition;
	
    /**
     * Creates a new Microsoft_WindowsAzure_SessionHandler instance
     * 
     * @param Microsoft_WindowsAzure_Storage_Table|Microsoft_WindowsAzure_Storage_Blob $storage Storage back-end, can be table storage and blob storage
     * @param string $sessionContainer Session container name
     * @param string $sessionContainerPartition Session container partition
     */
    public function __construct(Microsoft_WindowsAzure_Storage $storage, $sessionContainer = 'phpsessions', $sessionContainerPartition = 'sessions')
	{
		// Validate $storage
		if (!($storage instanceof Microsoft_WindowsAzure_Storage_Table || $storage instanceof Microsoft_WindowsAzure_Storage_Blob)) {
			throw new Microsoft_WindowsAzure_Exception('Invalid storage back-end given. Storage back-end should be of type Microsoft_WindowsAzure_Storage_Table or Microsoft_WindowsAzure_Storage_Blob.');
		}
		
		// Validate other parameters
		if ($sessionContainer == '' || $sessionContainerPartition == '') {
			throw new Microsoft_WindowsAzure_Exception('Session container and session partition should be specified.');
		}
		
		// Determine storage type
		$storageType = self::STORAGE_TYPE_TABLE;
		if ($storage instanceof Microsoft_WindowsAzure_Storage_Blob) {
			$storageType = self::STORAGE_TYPE_BLOB;
		}
		
	    // Set properties
		$this->_storage = $storage;
		$this->_storageType = $storageType;
		$this->_sessionContainer = $sessionContainer;
		$this->_sessionContainerPartition = $sessionContainerPartition;
	}
	
	/**
	 * Object destructor
	 */
	public function __destruct() {
		session_write_close();
	}
	
	/**
	 * Registers the current session handler as PHP's session handler
	 * 
	 * @return boolean
	 */
	public function register()
	{
        return session_set_save_handler(array($this, 'open'),
                                        array($this, 'close'),
                                        array($this, 'read'),
                                        array($this, 'write'),
                                        array($this, 'destroy'),
                                        array($this, 'gc')
        );
	}
	
    /**
     * Open the session store
     * 
     * @return bool
     */
    public function open()
    {
    	// Make sure storage container exists
    	if ($this->_storageType == self::STORAGE_TYPE_TABLE) {
    		$this->_storage->createTableIfNotExists($this->_sessionContainer);
    	} else if ($this->_storageType == self::STORAGE_TYPE_BLOB) {
    		$this->_storage->createContainerIfNotExists($this->_sessionContainer);
    	}
    	
		// Ok!
		return true;
    }

    /**
     * Close the session store
     * 
     * @return bool
     */
    public function close()
    {
        return true;
    }
    
    /**
     * Read a specific session
     * 
     * @param int $id Session Id
     * @return string
     */
    public function read($id)
    {
    	// Read data
       	if ($this->_storageType == self::STORAGE_TYPE_TABLE) {
    		// In table storage
	        try
	        {
	            $sessionRecord = $this->_storage->retrieveEntityById(
	                $this->_sessionContainer,
	                $this->_sessionContainerPartition,
	                $id
	            );
	            return unserialize(base64_decode($sessionRecord->serializedData));
	        }
	        catch (Microsoft_WindowsAzure_Exception $ex)
	        {
	            return '';
	        }
       	} else if ($this->_storageType == self::STORAGE_TYPE_BLOB) {
    		// In blob storage
    	    try
	        {
    			$data = $this->_storage->getBlobData(
    				$this->_sessionContainer,
    				$this->_sessionContainerPartition . '/' . $id
    			);
	            return unserialize(base64_decode($data));
	        }
	        catch (Microsoft_WindowsAzure_Exception $ex)
	        {
	            return false;
	        }
    	}
    }
    
    /**
     * Write a specific session
     * 
     * @param int $id Session Id
     * @param string $serializedData Serialized PHP object
     * @throws Exception
     */
    public function write($id, $serializedData)
    {
    	// Encode data
    	$serializedData = base64_encode(serialize($serializedData));
    	if (strlen($serializedData) >= self::MAX_TS_PROPERTY_SIZE && $this->_storageType == self::STORAGE_TYPE_TABLE) {
    		throw new Microsoft_WindowsAzure_Exception('Session data exceeds the maximum allowed size of ' . self::MAX_TS_PROPERTY_SIZE . ' bytes that can be stored using table storage. Consider switching to a blob storage back-end or try reducing session data size.');
    	}
    	
    	// Store data
       	if ($this->_storageType == self::STORAGE_TYPE_TABLE) {
    		// In table storage
       	    $sessionRecord = new Microsoft_WindowsAzure_Storage_DynamicTableEntity($this->_sessionContainerPartition, $id);
	        $sessionRecord->sessionExpires = time();
	        $sessionRecord->serializedData = $serializedData;
	        
	        $sessionRecord->setAzurePropertyType('sessionExpires', 'Edm.Int32');
	
	        try
	        {
	            $this->_storage->updateEntity($this->_sessionContainer, $sessionRecord);
	        }
	        catch (Microsoft_WindowsAzure_Exception $unknownRecord)
	        {
	            $this->_storage->insertEntity($this->_sessionContainer, $sessionRecord);
	        }
    	} else if ($this->_storageType == self::STORAGE_TYPE_BLOB) {
    		// In blob storage
    		$this->_storage->putBlobData(
    			$this->_sessionContainer,
    			$this->_sessionContainerPartition . '/' . $id,
    			$serializedData,
    			array('sessionexpires' => time())
    		);
    	}
    }
    
    /**
     * Destroy a specific session
     * 
     * @param int $id Session Id
     * @return boolean
     */
    public function destroy($id)
    {
		// Destroy data
       	if ($this->_storageType == self::STORAGE_TYPE_TABLE) {
    		// In table storage
       	    try
	        {
	            $sessionRecord = $this->_storage->retrieveEntityById(
	                $this->_sessionContainer,
	                $this->_sessionContainerPartition,
	                $id
	            );
	            $this->_storage->deleteEntity($this->_sessionContainer, $sessionRecord);
	            
	            return true;
	        }
	        catch (Microsoft_WindowsAzure_Exception $ex)
	        {
	            return false;
	        }
    	} else if ($this->_storageType == self::STORAGE_TYPE_BLOB) {
    		// In blob storage
    	    try
	        {
    			$this->_storage->deleteBlob(
    				$this->_sessionContainer,
    				$this->_sessionContainerPartition . '/' . $id
    			);
	            
	            return true;
	        }
	        catch (Microsoft_WindowsAzure_Exception $ex)
	        {
	            return false;
	        }
    	}
    }
    
    /**
     * Garbage collector
     * 
     * @param int $lifeTime Session maximal lifetime
     * @see session.gc_divisor  100
     * @see session.gc_maxlifetime 1440
     * @see session.gc_probability 1
     * @usage Execution rate 1/100 (session.gc_probability/session.gc_divisor)
     * @return boolean
     */
    public function gc($lifeTime)
    {
       	if ($this->_storageType == self::STORAGE_TYPE_TABLE) {
    		// In table storage
       	    try
	        {
	            $result = $this->_storage->retrieveEntities($this->_sessionContainer, 'PartitionKey eq \'' . $this->_sessionContainerPartition . '\' and sessionExpires lt ' . (time() - $lifeTime));
	            foreach ($result as $sessionRecord)
	            {
	                $this->_storage->deleteEntity($this->_sessionContainer, $sessionRecord);
	            }
	            return true;
	        }
	        catch (Microsoft_WindowsAzure_exception $ex)
	        {
	            return false;
	        }
    	} else if ($this->_storageType == self::STORAGE_TYPE_BLOB) {
    		// In blob storage
    	    try
	        {
	            $result = $this->_storage->listBlobs($this->_sessionContainer, $this->_sessionContainerPartition, '', null, null, 'metadata');
	            foreach ($result as $sessionRecord)
	            {
	            	if ($sessionRecord->Metadata['sessionexpires'] < (time() - $lifeTime)) {
	                	$this->_storage->deleteBlob($this->_sessionContainer, $sessionRecord->Name);
	            	}
	            }
	            return true;
	        }
	        catch (Microsoft_WindowsAzure_exception $ex)
	        {
	            return false;
	        }
    	}
    }
}
