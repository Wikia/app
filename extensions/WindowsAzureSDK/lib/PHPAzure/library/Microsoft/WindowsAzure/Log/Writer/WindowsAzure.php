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
 * @subpackage Storage
 * @copyright  Copyright (c) 2009 - 2011, RealDolmen (http://www.realdolmen.com)
 * @license    http://phpazure.codeplex.com/license
 * @version    $Id: Storage.php 21617 2009-06-12 10:46:31Z unknown $
 */

/**
 * @see Microsoft_AutoLoader
 */
require_once dirname(__FILE__) . '/../../../AutoLoader.php';

/**
 * @category   Microsoft
 * @package    Microsoft_WindowsAzure
 * @subpackage Log
 * @copyright  Copyright (c) 2009 - 2011, RealDolmen (http://www.realdolmen.com)
 * @license    http://phpazure.codeplex.com/license
 */
class Microsoft_WindowsAzure_Log_Writer_WindowsAzure extends Microsoft_Log_Writer_Abstract
{
	/**
	 * @var Microsoft_Log_Formatter_Interface
	 */
	protected $_formatter;

	/**
	 * Connection to a windows Azure 
	 * 
	 * @var Microsoft_Service_WindowsAzure_Storage_Table
	 */
	protected $_tableStorageConnection = null;

	/**
	 * Name of the table to use for logging purposes
	 *
	 * @var string
	 */
	protected $_tableName = null;

	/**
	 * Whether to keep all messages to be logged in an external buffer until the script ends and
	 * only then to send the messages in batch to the logging component.
	 *
	 * @var bool
	 */
	protected $_bufferMessages = false;

	/**
	 * If message buffering is activated, it will store all the messages in this buffer and only
	 * write them to table storage (in a batch transaction) when the script ends.
	 *
	 * @var array
	 */
	protected $_messageBuffer = array();

	/**
	 * @param Microsoft_Service_WindowsAzure_Storage_Table $tableStorageConnection
	 * @param string $tableName
	 * @param bool   $createTable create the Windows Azure table for logging if it does not exist
	 */
	public function __construct(Microsoft_WindowsAzure_Storage_Table $tableStorageConnection,
		$tableName, $createTable = true, $bufferMessages = true)
	{
		if ($tableStorageConnection == null) {
			require_once 'Microsoft/Log/Exception.php';
			throw new Microsoft_Log_Exception('No connection to the Windows Azure tables provided.');
		}

		if (!is_string($tableName)) {
			require_once 'Microsoft/Log/Exception.php';
			throw new Microsoft_Log_Exception('Provided Windows Azure table name must be a string.');
		}

		$this->_tableStorageConnection = $tableStorageConnection;
		$this->_tableName              = $tableName;

		// create the logging table if it does not exist. It will add some overhead, so it's optional
		if ($createTable) {
			$this->_tableStorageConnection->createTableIfNotExists($this->_tableName);
		}

		// keep messages to be logged in an internal buffer and only send them over the wire when
		// the script execution ends
		if ($bufferMessages) {
			$this->_bufferMessages = $bufferMessages;
		}

		$this->_formatter = new Microsoft_WindowsAzure_Log_Formatter_WindowsAzure();
	}

	/**
	 * If the log messages have been stored in the internal buffer, just send them
	 * to table storage.
	 */
	public function shutdown() {
		parent::shutdown();
		if ($this->_bufferMessages) {
			$batch = $this->_tableStorageConnection->startBatch();
			foreach ($this->_messageBuffer as $logEntity) {
				$this->_tableStorageConnection->insertEntity($this->_tableName, $logEntity);
			}
			$batch->commit();
		}
	}

	/**
     * Create a new instance of Microsoft_Log_Writer_WindowsAzure
     *
     * @param  array $config
     * @return Microsoft_Log_Writer_WindowsAzure
     * @throws Microsoft_Log_Exception
     */
    static public function factory($config)
    {
        $config = self::_parseConfig($config);
        $config = array_merge(array(
            'connection'  => null,
            'tableName'   => null,
            'createTable' => true,
        ), $config);

        return new self(
            $config['connection'],
            $config['tableName'],
            $config['createTable']
        );
    }

	/**
     * The only formatter accepted is already  loaded in the constructor
	 *
	 * @todo enable custom formatters using the WindowsAzure_Storage_DynamicTableEntity class
     */
    public function setFormatter(Microsoft_Log_Formatter_Interface $formatter)
    {
        require_once 'Microsoft/Log/Exception.php';
        throw new Microsoft_Log_Exception(get_class($this) . ' does not support formatting');
    }

	/**
	 * Write a message to the table storage. If buffering is activated, then messages will just be
	 * added to an internal buffer.
	 *
	 * @param  array $event
	 * @return void
	 * @todo   format the event using a formatted, not in this method
	 */
	protected function _write($event)
	{
		$logEntity = $this->_formatter->format($event);

		if ($this->_bufferMessages) {
			$this->_messageBuffer[] = $logEntity;
		} else {
			$this->_tableStorageConnection->insertEntity($this->_tableName, $logEntity);
		}
	}
}