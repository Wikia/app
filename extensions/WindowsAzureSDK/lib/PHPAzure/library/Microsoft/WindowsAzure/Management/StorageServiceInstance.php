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
 * @property string $Url             The address of the storage account.
 * @property string $ServiceName     The name of the storage account.
 * @property string $Description	 A description of the storage account.
 * @property string $AffinityGroup   The affinity group with which this storage account is associated.
 * @property string $Location        The geo-location of the storage account in Windows Azure, if your storage account is not associated with an affinity group.
 * @property string $Label           The label for the storage account.
 */
class Microsoft_WindowsAzure_Management_StorageServiceInstance
	extends Microsoft_WindowsAzure_Management_ServiceEntityAbstract
{    
    /**
     * Constructor
     * 
     * @param string $url             The address of the storage account.
     * @param string $serviceName     The name of the storage account.
	 * @param string $description	  A description of the storage account.
	 * @param string $affinityGroup   The affinity group with which this storage account is associated.
	 * @param string $location        The geo-location of the storage account in Windows Azure, if your storage account is not associated with an affinity group.
	 * @param string $label           The label for the storage account.
	 */
    public function __construct($url, $serviceName, $description = '', $affinityGroup = '', $location = '', $label = '') 
    {	        
        $this->_data = array(
            'url'              => $url,
            'servicename'      => $serviceName,
            'description'      => $description,
            'affinitygroup'    => $affinityGroup,
            'location'         => $location,
            'label'            => base64_decode($label)        
        );
    }
}
