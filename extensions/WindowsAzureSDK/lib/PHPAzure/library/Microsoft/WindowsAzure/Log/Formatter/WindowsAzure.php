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
class Microsoft_WindowsAzure_Log_Formatter_WindowsAzure implements Microsoft_Log_Formatter_Interface
{
	/**
	 * Write a message to the table storage
	 *
	 * @param  array $event
	 * @return Microsoft_WindowsAzure_Storage_DynamicTableEntity
	 */
	public function format($event)
	{
		require_once 'Microsoft/WindowsAzure/Storage/DynamicTableEntity.php';

		// partition key is the current date, represented as YYYYMMDD
		// row key will always be the current timestamp. These values MUST be hardcoded.
		$logEntity = new Microsoft_WindowsAzure_Storage_DynamicTableEntity(
			date('Ymd'), microtime(true));
		// Windows Azure automatically adds the timestamp, but the timezone is most of the time
		// different compared to the origin server's timezone, so add this timestamp aswell.
		$event['server_timestamp'] = $event['timestamp'];
		unset($event['timestamp']);

		foreach ($event as $key => $value) {
			 if ((is_object($value) && !method_exists($value,'__toString'))
                || is_array($value)) {

                $value = gettype($value);
            }

			$logEntity->{$key} = $value;
		}

		return $logEntity;
	}
}