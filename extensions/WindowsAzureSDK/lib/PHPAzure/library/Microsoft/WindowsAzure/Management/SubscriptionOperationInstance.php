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
 * @subpackage Management
 * @copyright  Copyright (c) 2009 - 2011, RealDolmen (http://www.realdolmen.com)
 * @license    http://phpazure.codeplex.com/license
 * @version    $Id: BlobInstance.php 53615 2010-11-16 20:45:11Z unknown $
 */

/**
 * @see Microsoft_AutoLoader
 */
require_once dirname(__FILE__) . '/../../AutoLoader.php';

/**
 * @category   Microsoft
 * @package    Microsoft_WindowsAzure
 * @subpackage Management
 * @copyright  Copyright (c) 2009 - 2011, RealDolmen (http://www.realdolmen.com)
 * @license    http://phpazure.codeplex.com/license
 * 
 * @property string $OperationId The globally unique identifier (GUID) of the operation.
 * @property string $OperationObjectId The target object for the operation. 
 * @property string $OperationName The name of the performed operation.
 * @property array  $OperationParameters The collection of parameters for the performed operation.
 * @property array  $OperationCaller A collection of attributes that identifies the source of the operation.
 * @property array  $OperationStatus The current status of the operation.
 * @property string $OperationStartedTime The time that the operation started to execute.
 * @property string $OperationCompletedTime The time that the operation finished executing.
 */
class Microsoft_WindowsAzure_Management_SubscriptionOperationInstance
	extends Microsoft_WindowsAzure_Management_ServiceEntityAbstract
{    
    /**
     * Constructor
     * 
     * @param string $operationId The globally unique identifier (GUID) of the operation.
     * @param string $operationObjectId The target object for the operation. 
     * @param string $operationName The name of the performed operation.
     * @param array  $operationParameters The collection of parameters for the performed operation.
     * @param array  $operationCaller A collection of attributes that identifies the source of the operation.
     * @param array  $operationStatus The current status of the operation.
     * @param string $operationStartedTime The time that the operation started to execute.
     * @param string $operationCompletedTime The time that the operation finished executing.
     */
    public function __construct($operationId, $operationObjectId, $operationName, $operationParameters = array(), $operationCaller = array(), $operationStatus = array(), $operationStartedTime = '', $operationCompletedTime = '') 
    {	        
        $this->_data = array(
            'operationid'            => $operationId,
	        'operationobjectid'      => $operationObjectId,
	        'operationname'          => $operationName,
	        'operationparameters'    => $operationParameters,
	        'operationcaller'        => $operationCaller,
	        'operationstatus'        => $operationStatus,
	        'operationstartedtime'   => $operationStartedTime,
	        'operationcompletedtime' => $operationCompletedTime
        );
    }
    
	/**
	 * Add operation parameter
	 * 
 	 * @param	string	$name	Name
 	 * @param	string	$value  Value
	 */
    public function addOperationParameter($name, $value)
    {
    	$this->_data['operationparameters'][$name] = $value;
    }
}
