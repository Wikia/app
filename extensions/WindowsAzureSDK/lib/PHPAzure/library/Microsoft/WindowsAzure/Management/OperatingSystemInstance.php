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
 * @property string $Version         The operating system version. This value corresponds to the configuration value for specifying that your service is to run on a particular version of the Windows Azure guest operating system. 
 * @property string $Label           A label for the operating system version.
 * @property string $IsDefault    	 Indicates whether this operating system version is the default version for a service that has not otherwise specified a particular version. The default operating system version is applied to services that are configured for auto-upgrade. An operating system family has exactly one default operating system version at any given time, for which the IsDefault element is set to true; for all other versions, IsDefault is set to false.
 * @property string $IsActive        Indicates whether this operating system version is currently active for running a service. If an operating system version is active, you can manually configure your service to run on that version.
 * @property string $Family          Indicates which operating system family this version belongs to. A value of 1 corresponds to the Windows Azure guest operating system that is substantially compatible with Windows Server 2008 SP2. A value of 2 corresponds to the Windows Azure guest operating system that is substantially compatible with Windows Server 2008 R2.
 * @property string $FamilyLabel     A label for the operating system family.
 */
class Microsoft_WindowsAzure_Management_OperatingSystemInstance
	extends Microsoft_WindowsAzure_Management_ServiceEntityAbstract
{    
    /**
     * Constructor
     * 
     * @param string $version         The operating system version. This value corresponds to the configuration value for specifying that your service is to run on a particular version of the Windows Azure guest operating system. 
     * @param string $label           A label for the operating system version.
     * @param string $isDefault    	  Indicates whether this operating system version is the default version for a service that has not otherwise specified a particular version. The default operating system version is applied to services that are configured for auto-upgrade. An operating system family has exactly one default operating system version at any given time, for which the IsDefault element is set to true; for all other versions, IsDefault is set to false.
     * @param string $isActive        Indicates whether this operating system version is currently active for running a service. If an operating system version is active, you can manually configure your service to run on that version.
     * @param string $family          Indicates which operating system family this version belongs to. A value of 1 corresponds to the Windows Azure guest operating system that is substantially compatible with Windows Server 2008 SP2. A value of 2 corresponds to the Windows Azure guest operating system that is substantially compatible with Windows Server 2008 R2.
     * @param string $familyLabel     A label for the operating system family.
	 */
    public function __construct($version, $label, $isDefault, $isActive, $family, $familyLabel) 
    {	        
        $this->_data = array(
            'version'        => $version,
            'label'          => base64_decode($label),
            'isdefault'      => $isDefault,
            'isactive'       => $isActive,
            'family'         => $family,
            'familylabel'    => base64_decode($familyLabel)        
        );
    }
}
