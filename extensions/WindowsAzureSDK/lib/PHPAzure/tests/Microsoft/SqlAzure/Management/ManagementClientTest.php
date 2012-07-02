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

require_once 'Microsoft/SqlAzure/Management/Client.php';

/**
 * @category   Microsoft
 * @package    Microsoft_SqlAzure
 * @subpackage UnitTests
 * @version    $Id: BlobStorageTest.php 14561 2009-05-07 08:05:12Z unknown $
 * @copyright  Copyright (c) 2009 - 2011, RealDolmen (http://www.realdolmen.com)
 * @license    http://phpazure.codeplex.com/license
 */
class Microsoft_SqlAzure_Management_ManagementClientTest extends PHPUnit_Framework_TestCase
{
	static $path;
	static $debug = true;
	static $serverName = '';
	
    public function __construct()
    {
        self::$path = dirname(__FILE__).'/_files/';
    }
    
    /**
     * Test teardown
     */
    protected function tearDown()
    {
        // Clean up server
        $managementClient = $this->createManagementClient();
        
        // Remove server
        try { $managementClient->dropServer(self::$serverName); } catch (Exception $ex) { }
    }
    
    protected function createManagementClient()
    {
    	return new Microsoft_SqlAzure_Management_Client(
	            TESTS_SQLMANAGEMENT_SUBSCRIPTIONID, self::$path . '/management.pem', TESTS_SQLMANAGEMENT_CERTIFICATEPASSWORD);
    }
    
    protected function log($message)
    {
    	if (self::$debug) {
    		echo date('Y-m-d H:i:s') . ' - ' . $message . "\r\n";
    	}
    }
    
    /**
     * Test create and configure server
     */
    public function testCreateAndConfigureServer()
    {
        if (TESTS_SQLMANAGEMENT_RUNTESTS) {
            // Create a management client
            $managementClient = $this->createManagementClient();
            
             // ** Step 1: create a server
	        $this->log('Creating server...');
	        $server = $managementClient->createServer('sqladm', '@@cool1OO', 'West Europe');
	        $this->assertEquals('sqladm', $server->AdministratorLogin);
	        $this->assertEquals('West Europe', $server->Location);
	        self::$serverName = $server->Name;
            $this->log('Created server.');
            
	        // ** Step 2: change password
	        $this->log('Changing password...');
	        $managementClient->setAdministratorPassword($server->Name, '@@cool1OO11');
	        $this->log('Changed password...');
	        
	        // ** Step 3: add firewall rule
	        $this->log('Creating firewall rule...');
			$managementClient->createFirewallRuleForMicrosoftServices($server->Name, true);
			$result = $managementClient->listFirewallRules($server->Name);
	        $this->assertEquals(1, count($result));
	        $this->log('Created firewall rule.');
	        
	        // ** Step 4: remove firewall rule
	        $this->log('Removing firewall rule...');
			$managementClient->createFirewallRuleForMicrosoftServices($server->Name, false);
			$result = $managementClient->listFirewallRules($server->Name);
	        $this->assertEquals(0, count($result));
	        $this->log('Removed firewall rule.');
            
			// ** Step 5: Drop server
	        $this->log('Dropping server...');
			$managementClient->dropServer($server->Name);
	        $this->log('Dropped server.');
        }
    }
}