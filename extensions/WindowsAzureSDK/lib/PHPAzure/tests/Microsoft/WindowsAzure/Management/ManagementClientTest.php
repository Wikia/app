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
require_once dirname(__FILE__) . '/../../../TestConfiguration.php';
require_once 'PHPUnit/Framework/TestCase.php';

require_once 'Microsoft/WindowsAzure/Management/Client.php';

/**
 * @category   Microsoft
 * @package    Microsoft_WindowsAzure
 * @subpackage UnitTests
 * @version    $Id: BlobStorageTest.php 14561 2009-05-07 08:05:12Z unknown $
 * @copyright  Copyright (c) 2009 - 2011, RealDolmen (http://www.realdolmen.com)
 * @license    http://phpazure.codeplex.com/license
 */
class Microsoft_WindowsAzure_Management_ManagementClientTest extends PHPUnit_Framework_TestCase
{
	static $path;
	static $debug = true;
	protected $packageUrl;
	
    public function __construct()
    {
        self::$path = dirname(__FILE__).'/_files/';
    }
    
    /**
     * Test setup
     */
    protected function setUp()
    {
    	// Upload sample package to Windows Azure
    	$storageClient = $this->createStorageInstance();
    	$storageClient->createContainerIfNotExists(TESTS_MANAGEMENT_CONTAINER);
    	$storageClient->putBlob(TESTS_MANAGEMENT_CONTAINER, 'PhpOnAzure.cspkg', self::$path . 'PhpOnAzure.cspkg');

    	$this->packageUrl = $storageClient->listBlobs(TESTS_MANAGEMENT_CONTAINER);
        $this->packageUrl = $this->packageUrl[0]->Url;
    }
    
    /**
     * Test teardown
     */
    protected function tearDown()
    {
    	// Clean up storage
        $storageClient = $this->createStorageInstance();
        $storageClient->deleteContainer(TESTS_MANAGEMENT_CONTAINER);
        
        // Clean up subscription
        $managementClient = $this->createManagementClient();
        
        // Remove deployment
        try { $managementClient->updateDeploymentStatusBySlot(TESTS_MANAGEMENT_SERVICENAME, 'production', 'suspended'); $managementClient->waitForOperation(); } catch (Exception $ex) { }
		try { $managementClient->deleteDeploymentBySlot(TESTS_MANAGEMENT_SERVICENAME, 'production'); $managementClient->waitForOperation(); } catch (Exception $ex) { }

		// Remove hosted service
        try { $managementClient->deleteHostedService(TESTS_MANAGEMENT_SERVICENAME); $managementClient->waitForOperation(); } catch (Exception $ex) { }
        
        // Remove affinity group
        try { $managementClient->deleteAffinityGroup('test'); } catch (Exception $ex) { }
    }
    
    protected function createStorageInstance()
    {
        return new Microsoft_WindowsAzure_Storage_Blob(TESTS_BLOB_HOST_PROD, TESTS_STORAGE_ACCOUNT_PROD, TESTS_STORAGE_KEY_PROD, false, Microsoft_WindowsAzure_RetryPolicy_RetryPolicyAbstract::retryN(10, 250));
    }
    
    protected function createManagementClient()
    {
    	return new Microsoft_WindowsAzure_Management_Client(
	            TESTS_MANAGEMENT_SUBSCRIPTIONID, self::$path . '/management.pem', TESTS_MANAGEMENT_CERTIFICATEPASSWORD);
    }
    
    protected function log($message)
    {
    	if (self::$debug) {
    		echo date('Y-m-d H:i:s') . ' - ' . $message . "\r\n";
    	}
    }
    
    /**
     * Test hosted service
     */
    public function testHostedService()
    {
        if (TESTS_MANAGEMENT_RUNTESTS) {
        	// Create a deployment name
        	$deploymentName = 'deployment' . time();
        	
            // Create a management client
            $managementClient = $this->createManagementClient();
            
             // ** Step 1: create an affinity group
	        $this->log('Creating affinity group...');
            $managementClient->createAffinityGroup('test', 'test', 'A test affinity group.', 'North Central US');
            $this->log('Created affinity group.');
            
	        // ** Step 2: create a hosted service
	        $this->log('Creating hosted service...');
	        $managementClient->createHostedService(TESTS_MANAGEMENT_SERVICENAME, TESTS_MANAGEMENT_SERVICENAME, TESTS_MANAGEMENT_SERVICENAME, null, 'test');
	        $managementClient->waitForOperation();
	        $this->log('Created hosted service.');
	        
	        // ** Step 3: create a new deployment
	        $this->log('Creating staging deployment...');
	        $managementClient->createDeployment(TESTS_MANAGEMENT_SERVICENAME, 'staging', $deploymentName, $deploymentName, $this->packageUrl, self::$path . 'ServiceConfiguration.cscfg', false, false);
	        $managementClient->waitForOperation();
	        $this->log('Created staging deployment.');
	            
	        // ** Step 4: Run the deployment
	        $this->log('Changing status of staging deployment to running...');
	        $managementClient->updateDeploymentStatusBySlot(TESTS_MANAGEMENT_SERVICENAME, 'staging', 'running');
	        $managementClient->waitForOperation();
	        $this->log('Changed status of staging deployment to running.');
            
			// ** Step 5: Swap production <-> staging
	        $this->log('Performing VIP swap...');
			$result = $managementClient->getHostedServiceProperties(TESTS_MANAGEMENT_SERVICENAME);
			$managementClient->swapDeployment(TESTS_MANAGEMENT_SERVICENAME, $deploymentName, $result->Deployments[0]->Name);
	        $managementClient->waitForOperation();
	        $this->log('Performed VIP swap.');
	        
	        // ** Step 6: Scale to two instances
	        $this->log('Scaling out...');
			$managementClient->setInstanceCountBySlot(TESTS_MANAGEMENT_SERVICENAME, 'production', 'PhpOnAzure.Web', 2);
	        $managementClient->waitForOperation();
	        $this->log('Scaled out.');
	        
	        // ** Step 7: Scale back
	        $this->log('Scaling in...');
			$managementClient->setInstanceCountBySlot(TESTS_MANAGEMENT_SERVICENAME, 'production', 'PhpOnAzure.Web', 1);
	        $managementClient->waitForOperation();
	        $this->log('Scaled in.');
	        
			// ** Step 8: Reboot
	        $this->log('Rebooting...');
			$managementClient->rebootRoleInstanceBySlot(TESTS_MANAGEMENT_SERVICENAME, 'production', 'PhpOnAzure.Web_IN_0');
	        $managementClient->waitForOperation();
	        $this->log('Rebooted.');
            
            // Dumb assertion...
            $this->assertTrue(true);
        }
    }
}