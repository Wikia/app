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
 * @package    Microsoft_Console
 * @subpackage Exception
 * @version    $Id: Exception.php 55733 2011-01-03 09:17:16Z unknown $
 * @copyright  Copyright (c) 2009 - 2011, RealDolmen (http://www.realdolmen.com)
 * @license    http://phpazure.codeplex.com/license
 */

/**
 * @see Microsoft_AutoLoader
 */
require_once dirname(__FILE__) . '/../../AutoLoader.php';

/**
 * Service commands
 * 
 * @category   Microsoft
 * @package    Microsoft_SqlAzure_CommandLine
 * @copyright  Copyright (c) 2009 - 2011, RealDolmen (http://www.realdolmen.com)
 * @license    http://phpazure.codeplex.com/license
 * 
 * @command-handler sqlazure
 * @command-handler-description Sql Azure Server commands
 * @command-handler-header Windows Azure SDK for PHP
 * @command-handler-header Copyright (c) 2009 - 2011, RealDolmen (http://www.realdolmen.com)
 * @command-handler-footer Note: Parameters that are common across all commands can be stored 
 * @command-handler-footer in two dedicated environment variables.
 * @command-handler-footer - SubscriptionId: The Windows Azure Subscription Id to operate on.
 * @command-handler-footer - Certificate The Windows Azure .cer Management Certificate.
 * @command-handler-footer 
 * @command-handler-footer All commands support the --ConfigurationFile or -F parameter.
 * @command-handler-footer The parameter file is a simple INI file carrying one parameter
 * @command-handler-footer value per line. It accepts the same parameters as one can
 * @command-handler-footer use from the command line command.
 */
class Microsoft_SqlAzure_CommandLine_SqlAzure
	extends Microsoft_Console_Command
{	
	/**
	 * List servers for a specified subscription.
	 * 
	 * @command-name List
	 * @command-description List servers for a specified subscription.
	 * @command-parameter-for $subscriptionId Microsoft_Console_Command_ParameterSource_Argv|Microsoft_Console_Command_ParameterSource_ConfigFile|Microsoft_Console_Command_ParameterSource_Env --SubscriptionId|-sid Required. This is the Windows Azure Subscription Id to operate on.
	 * @command-parameter-for $certificate Microsoft_Console_Command_ParameterSource_Argv|Microsoft_Console_Command_ParameterSource_ConfigFile|Microsoft_Console_Command_ParameterSource_Env --Certificate|-cert Required. This is the .pem certificate that user has uploaded to Windows Azure subscription as Management Certificate.
	 * @command-parameter-for $certificatePassphrase Microsoft_Console_Command_ParameterSource_Argv|Microsoft_Console_Command_ParameterSource_ConfigFile|Microsoft_Console_Command_ParameterSource_Prompt --Passphrase|-p Required. The certificate passphrase. If not specified, a prompt will be displayed.
	 * @command-example List servers for a specified subscription:
	 * @command-example List -sid="<your_subscription_id>" -cert="mycert.pem"
	 */
	public function listCommand($subscriptionId, $certificate, $certificatePassphrase)
	{
		$client = new Microsoft_SqlAzure_Management_Client($subscriptionId, $certificate, $certificatePassphrase);
		$result = $client->listServers();

		if (count($result) == 0) {
			echo 'No data to display.';
		}
		foreach ($result as $object) {
			$this->_displayObjectInformation($object, array('Name', 'AdministratorLogin'));
		}
	}
	
	/**
	 * Get server properties.
	 * 
	 * @command-name GetProperties
	 * @command-description Get server properties.
	 * @command-parameter-for $subscriptionId Microsoft_Console_Command_ParameterSource_Argv|Microsoft_Console_Command_ParameterSource_ConfigFile|Microsoft_Console_Command_ParameterSource_Env --SubscriptionId|-sid Required. This is the Windows Azure Subscription Id to operate on.
	 * @command-parameter-for $certificate Microsoft_Console_Command_ParameterSource_Argv|Microsoft_Console_Command_ParameterSource_ConfigFile|Microsoft_Console_Command_ParameterSource_Env --Certificate|-cert Required. This is the .pem certificate that user has uploaded to Windows Azure subscription as Management Certificate.
	 * @command-parameter-for $certificatePassphrase Microsoft_Console_Command_ParameterSource_Argv|Microsoft_Console_Command_ParameterSource_ConfigFile|Microsoft_Console_Command_ParameterSource_Prompt --Passphrase|-p Required. The certificate passphrase. If not specified, a prompt will be displayed.
	 * @command-parameter-for $serverName Microsoft_Console_Command_ParameterSource_Argv|Microsoft_Console_Command_ParameterSource_ConfigFile|Microsoft_Console_Command_ParameterSource_Env|Microsoft_Console_Command_ParameterSource_StdIn --Name Required. The server name to operate on.
	 * @command-example Get server properties for server "ie2l1ph28":
	 * @command-example GetProperties -sid="<your_subscription_id>" -cert="mycert.pem"
	 * @command-example --Name="ie2l1ph28"
	 */
	public function getPropertiesCommand($subscriptionId, $certificate, $certificatePassphrase, $serverName)
	{
		$client = new Microsoft_SqlAzure_Management_Client($subscriptionId, $certificate, $certificatePassphrase);
		$result = $client->listServers();

		$server = null;
		foreach ($result as $serverInstance) {
			if ($serverInstance->Name == $serverName) {
				$server = $serverInstance;
				break;
			}
		}

		$this->_displayObjectInformation($server, array('Name', 'DnsName', 'AdministratorLogin', 'Location'));
	}
	
	/**
	 * Get server property.
	 * 
	 * @command-name GetProperty
	 * @command-description Get server property.
	 * @command-parameter-for $subscriptionId Microsoft_Console_Command_ParameterSource_Argv|Microsoft_Console_Command_ParameterSource_ConfigFile|Microsoft_Console_Command_ParameterSource_Env --SubscriptionId|-sid Required. This is the Windows Azure Subscription Id to operate on.
	 * @command-parameter-for $certificate Microsoft_Console_Command_ParameterSource_Argv|Microsoft_Console_Command_ParameterSource_ConfigFile|Microsoft_Console_Command_ParameterSource_Env --Certificate|-cert Required. This is the .pem certificate that user has uploaded to Windows Azure subscription as Management Certificate.
	 * @command-parameter-for $certificatePassphrase Microsoft_Console_Command_ParameterSource_Argv|Microsoft_Console_Command_ParameterSource_ConfigFile|Microsoft_Console_Command_ParameterSource_Prompt --Passphrase|-p Required. The certificate passphrase. If not specified, a prompt will be displayed.
	 * @command-parameter-for $serverName Microsoft_Console_Command_ParameterSource_Argv|Microsoft_Console_Command_ParameterSource_ConfigFile|Microsoft_Console_Command_ParameterSource_Env|Microsoft_Console_Command_ParameterSource_StdIn --Name Required. The server name to operate on.
	 * @command-parameter-for $property Microsoft_Console_Command_ParameterSource_Argv|Microsoft_Console_Command_ParameterSource_ConfigFile --Property|-prop Required. The property to retrieve for the server.
	 * @command-example Get server property "Name" for service "ie2l1ph28":
	 * @command-example GetProperty -sid="<your_subscription_id>" -cert="mycert.pem"
	 * @command-example --Name="ie2l1ph28" --Property=Name
	 */
	public function getPropertyCommand($subscriptionId, $certificate, $certificatePassphrase, $serverName, $property)
	{
		$client = new Microsoft_SqlAzure_Management_Client($subscriptionId, $certificate, $certificatePassphrase);
		$result = $client->listServers();

		$server = null;
		foreach ($result as $serverInstance) {
			if ($serverInstance->Name == $serverName) {
				$server = $serverInstance;
				break;
			}
		}
		
		printf("%s\r\n", $server->$property);
	}
	
	/**
	 * Create server.
	 * 
	 * @command-name Create
	 * @command-description Create server.
	 * @command-parameter-for $subscriptionId Microsoft_Console_Command_ParameterSource_Argv|Microsoft_Console_Command_ParameterSource_ConfigFile|Microsoft_Console_Command_ParameterSource_Env --SubscriptionId|-sid Required. This is the Windows Azure Subscription Id to operate on.
	 * @command-parameter-for $certificate Microsoft_Console_Command_ParameterSource_Argv|Microsoft_Console_Command_ParameterSource_ConfigFile|Microsoft_Console_Command_ParameterSource_Env --Certificate|-cert Required. This is the .pem certificate that user has uploaded to Windows Azure subscription as Management Certificate.
	 * @command-parameter-for $certificatePassphrase Microsoft_Console_Command_ParameterSource_Argv|Microsoft_Console_Command_ParameterSource_ConfigFile|Microsoft_Console_Command_ParameterSource_Prompt --Passphrase|-p Required. The certificate passphrase. If not specified, a prompt will be displayed.
	 * @command-parameter-for $administratorLogin Microsoft_Console_Command_ParameterSource_Argv|Microsoft_Console_Command_ParameterSource_ConfigFile --Login|-l Required. The administrator login name for the server.
	 * @command-parameter-for $administratorPassword Microsoft_Console_Command_ParameterSource_Argv|Microsoft_Console_Command_ParameterSource_ConfigFile --Password|-pass Required. The administrator password for the server.
	 * @command-parameter-for $location Microsoft_Console_Command_ParameterSource_Argv|Microsoft_Console_Command_ParameterSource_ConfigFile --Location Required. The location where the server will be created.
	 * @command-parameter-for $waitForOperation Microsoft_Console_Command_ParameterSource_Argv|Microsoft_Console_Command_ParameterSource_ConfigFile --WaitFor|-w Optional. Wait for the operation to complete?
	 * @command-example Create server in West Europe
	 * @command-example Create -p="phpazure" --Login="sqladm" --Password="PHP@zure11" --Location="West Europe"
	 */
	public function createCommand($subscriptionId, $certificate, $certificatePassphrase, $administratorLogin, $administratorPassword, $location, $waitForOperation = false)
	{
		$client = new Microsoft_SqlAzure_Management_Client($subscriptionId, $certificate, $certificatePassphrase);
		$server = $client->createServer($administratorLogin, $administratorPassword, $location);
		echo $server->Name;
	}
	
	/**
	 * Drop server.
	 * 
	 * @command-name Drop
	 * @command-description Drop server.
	 * @command-parameter-for $subscriptionId Microsoft_Console_Command_ParameterSource_Argv|Microsoft_Console_Command_ParameterSource_ConfigFile|Microsoft_Console_Command_ParameterSource_Env --SubscriptionId|-sid Required. This is the Windows Azure Subscription Id to operate on.
	 * @command-parameter-for $certificate Microsoft_Console_Command_ParameterSource_Argv|Microsoft_Console_Command_ParameterSource_ConfigFile|Microsoft_Console_Command_ParameterSource_Env --Certificate|-cert Required. This is the .pem certificate that user has uploaded to Windows Azure subscription as Management Certificate.
	 * @command-parameter-for $certificatePassphrase Microsoft_Console_Command_ParameterSource_Argv|Microsoft_Console_Command_ParameterSource_ConfigFile|Microsoft_Console_Command_ParameterSource_Prompt --Passphrase|-p Required. The certificate passphrase. If not specified, a prompt will be displayed.
	 * @command-parameter-for $serverName Microsoft_Console_Command_ParameterSource_Argv|Microsoft_Console_Command_ParameterSource_ConfigFile|Microsoft_Console_Command_ParameterSource_StdIn --Name Required. The server name to operate on.
	 * @command-parameter-for $waitForOperation Microsoft_Console_Command_ParameterSource_Argv|Microsoft_Console_Command_ParameterSource_ConfigFile --WaitFor|-w Optional. Wait for the operation to complete?
	 * @command-example Drop server "ie2l1ph28":
	 * @command-example Drop -p="phpazure" --Name="ie2l1ph28"
	 */
	public function dropCommand($subscriptionId, $certificate, $certificatePassphrase, $serverName, $waitForOperation = false)
	{
		$client = new Microsoft_SqlAzure_Management_Client($subscriptionId, $certificate, $certificatePassphrase);
		$server = $client->dropServer($serverName);
	}
	
	/**
	 * Update administrator password for server.
	 * 
	 * @command-name UpdatePassword
	 * @command-description Update administrator password for server.
	 * @command-parameter-for $subscriptionId Microsoft_Console_Command_ParameterSource_Argv|Microsoft_Console_Command_ParameterSource_ConfigFile|Microsoft_Console_Command_ParameterSource_Env --SubscriptionId|-sid Required. This is the Windows Azure Subscription Id to operate on.
	 * @command-parameter-for $certificate Microsoft_Console_Command_ParameterSource_Argv|Microsoft_Console_Command_ParameterSource_ConfigFile|Microsoft_Console_Command_ParameterSource_Env --Certificate|-cert Required. This is the .pem certificate that user has uploaded to Windows Azure subscription as Management Certificate.
	 * @command-parameter-for $certificatePassphrase Microsoft_Console_Command_ParameterSource_Argv|Microsoft_Console_Command_ParameterSource_ConfigFile|Microsoft_Console_Command_ParameterSource_Prompt --Passphrase|-p Required. The certificate passphrase. If not specified, a prompt will be displayed.
	 * @command-parameter-for $serverName Microsoft_Console_Command_ParameterSource_Argv|Microsoft_Console_Command_ParameterSource_ConfigFile|Microsoft_Console_Command_ParameterSource_StdIn --Name Required. The server name to operate on.
	 * @command-parameter-for $administratorPassword Microsoft_Console_Command_ParameterSource_Argv|Microsoft_Console_Command_ParameterSource_ConfigFile --Password|-pass Required. The administrator password for the server.
	 * @command-parameter-for $waitForOperation Microsoft_Console_Command_ParameterSource_Argv|Microsoft_Console_Command_ParameterSource_ConfigFile --WaitFor|-w Optional. Wait for the operation to complete?
	 * @command-example Update administrator password for server "ie2l1ph28":
	 * @command-example UpdatePassword -p="phpazure" --Name="ie2l1ph28" --Password="PHP@zure11"
	 */
	public function updatePasswordCommand($subscriptionId, $certificate, $certificatePassphrase, $serverName, $administratorPassword, $waitForOperation = false)
	{
		$client = new Microsoft_SqlAzure_Management_Client($subscriptionId, $certificate, $certificatePassphrase);
		$server = $client->setAdministratorPassword($serverName, $administratorPassword);
	}
	
	/**
	 * Create firewall rule for server.
	 * 
	 * @command-name CreateFirewallRule
	 * @command-description Create firewall rule for server.
	 * @command-parameter-for $subscriptionId Microsoft_Console_Command_ParameterSource_Argv|Microsoft_Console_Command_ParameterSource_ConfigFile|Microsoft_Console_Command_ParameterSource_Env --SubscriptionId|-sid Required. This is the Windows Azure Subscription Id to operate on.
	 * @command-parameter-for $certificate Microsoft_Console_Command_ParameterSource_Argv|Microsoft_Console_Command_ParameterSource_ConfigFile|Microsoft_Console_Command_ParameterSource_Env --Certificate|-cert Required. This is the .pem certificate that user has uploaded to Windows Azure subscription as Management Certificate.
	 * @command-parameter-for $certificatePassphrase Microsoft_Console_Command_ParameterSource_Argv|Microsoft_Console_Command_ParameterSource_ConfigFile|Microsoft_Console_Command_ParameterSource_Prompt --Passphrase|-p Required. The certificate passphrase. If not specified, a prompt will be displayed.
	 * @command-parameter-for $serverName Microsoft_Console_Command_ParameterSource_Argv|Microsoft_Console_Command_ParameterSource_ConfigFile|Microsoft_Console_Command_ParameterSource_StdIn --Name Required. The server name to operate on.
	 * @command-parameter-for $ruleName Microsoft_Console_Command_ParameterSource_Argv|Microsoft_Console_Command_ParameterSource_ConfigFile --RuleName|-r Required. Firewall rule name.
	 * @command-parameter-for $startIpAddress Microsoft_Console_Command_ParameterSource_Argv|Microsoft_Console_Command_ParameterSource_ConfigFile --StartIp|-start Required. Start IP address.
	 * @command-parameter-for $endIpAddress Microsoft_Console_Command_ParameterSource_Argv|Microsoft_Console_Command_ParameterSource_ConfigFile --EndIp|-end Required. End IP address.
	 * @command-parameter-for $waitForOperation Microsoft_Console_Command_ParameterSource_Argv|Microsoft_Console_Command_ParameterSource_ConfigFile --WaitFor|-w Optional. Wait for the operation to complete?
	 * @command-example Create firewall rule for server "ie2l1ph28":
	 * @command-example CreateFirewallRule -p="phpazure" --Name="ie2l1ph28" -r="Rule1" -start="1.2.3.4" -end="1.2.3.4"
	 */
	public function createFirewallRuleCommand($subscriptionId, $certificate, $certificatePassphrase, $serverName, $ruleName, $startIpAddress, $endIpAddress, $waitForOperation = false)
	{
		$client = new Microsoft_SqlAzure_Management_Client($subscriptionId, $certificate, $certificatePassphrase);
		$rule = $client->createFirewallRule($serverName, $ruleName, $startIpAddress, $endIpAddress);
	}
	
	/**
	 * Allow access from Windows Azure to SQL Azure.
	 * 
	 * @command-name AllowWindowsAzure
	 * @command-description Allow access from Windows Azure to SQL Azure.
	 * @command-parameter-for $subscriptionId Microsoft_Console_Command_ParameterSource_Argv|Microsoft_Console_Command_ParameterSource_ConfigFile|Microsoft_Console_Command_ParameterSource_Env --SubscriptionId|-sid Required. This is the Windows Azure Subscription Id to operate on.
	 * @command-parameter-for $certificate Microsoft_Console_Command_ParameterSource_Argv|Microsoft_Console_Command_ParameterSource_ConfigFile|Microsoft_Console_Command_ParameterSource_Env --Certificate|-cert Required. This is the .pem certificate that user has uploaded to Windows Azure subscription as Management Certificate.
	 * @command-parameter-for $certificatePassphrase Microsoft_Console_Command_ParameterSource_Argv|Microsoft_Console_Command_ParameterSource_ConfigFile|Microsoft_Console_Command_ParameterSource_Prompt --Passphrase|-p Required. The certificate passphrase. If not specified, a prompt will be displayed.
	 * @command-parameter-for $serverName Microsoft_Console_Command_ParameterSource_Argv|Microsoft_Console_Command_ParameterSource_ConfigFile|Microsoft_Console_Command_ParameterSource_StdIn --Name Required. The server name to operate on.
	 * @command-parameter-for $allow Microsoft_Console_Command_ParameterSource_Argv|Microsoft_Console_Command_ParameterSource_ConfigFile --Allow|-a Required. Allow access from Windows Azure true/false.
	 * @command-parameter-for $waitForOperation Microsoft_Console_Command_ParameterSource_Argv|Microsoft_Console_Command_ParameterSource_ConfigFile --WaitFor|-w Optional. Wait for the operation to complete?
	 * @command-example Allow access from Windows Azure to SQL Azure for server "ie2l1ph28":
	 * @command-example AllowWindowsAzure -p="phpazure" --Name="ie2l1ph28" -Allow:true
	 */
	public function allowWindowsAzureCommand($subscriptionId, $certificate, $certificatePassphrase, $serverName, $allow = false, $waitForOperation = false)
	{
		$client = new Microsoft_SqlAzure_Management_Client($subscriptionId, $certificate, $certificatePassphrase);
		$rule = $client->createFirewallRuleForMicrosoftServices($serverName, $allow);
	}
	
	/**
	 * Delete firewall rule for server.
	 * 
	 * @command-name DeleteFirewallRule
	 * @command-description Delete firewall rule for server.
	 * @command-parameter-for $subscriptionId Microsoft_Console_Command_ParameterSource_Argv|Microsoft_Console_Command_ParameterSource_ConfigFile|Microsoft_Console_Command_ParameterSource_Env --SubscriptionId|-sid Required. This is the Windows Azure Subscription Id to operate on.
	 * @command-parameter-for $certificate Microsoft_Console_Command_ParameterSource_Argv|Microsoft_Console_Command_ParameterSource_ConfigFile|Microsoft_Console_Command_ParameterSource_Env --Certificate|-cert Required. This is the .pem certificate that user has uploaded to Windows Azure subscription as Management Certificate.
	 * @command-parameter-for $certificatePassphrase Microsoft_Console_Command_ParameterSource_Argv|Microsoft_Console_Command_ParameterSource_ConfigFile|Microsoft_Console_Command_ParameterSource_Prompt --Passphrase|-p Required. The certificate passphrase. If not specified, a prompt will be displayed.
	 * @command-parameter-for $serverName Microsoft_Console_Command_ParameterSource_Argv|Microsoft_Console_Command_ParameterSource_ConfigFile|Microsoft_Console_Command_ParameterSource_StdIn --Name Required. The server name to operate on.
	 * @command-parameter-for $ruleName Microsoft_Console_Command_ParameterSource_Argv|Microsoft_Console_Command_ParameterSource_ConfigFile --RuleName|-r Required. Firewall rule name.
	 * @command-parameter-for $waitForOperation Microsoft_Console_Command_ParameterSource_Argv|Microsoft_Console_Command_ParameterSource_ConfigFile --WaitFor|-w Optional. Wait for the operation to complete?
	 * @command-example Delete firewall rule for server "ie2l1ph28":
	 * @command-example DeleteFirewallRule -p="phpazure" --Name="ie2l1ph28" -r="Rule1"
	 */
	public function deleteFirewallRuleCommand($subscriptionId, $certificate, $certificatePassphrase, $serverName, $ruleName, $waitForOperation = false)
	{
		$client = new Microsoft_SqlAzure_Management_Client($subscriptionId, $certificate, $certificatePassphrase);
		$rule = $client->deleteFirewallRule($serverName, $ruleName);
	}
	
	/**
	 * List firewall rules for a specified server.
	 * 
	 * @command-name ListFirewallRules
	 * @command-description List firewall rules for a specified server.
	 * @command-parameter-for $subscriptionId Microsoft_Console_Command_ParameterSource_Argv|Microsoft_Console_Command_ParameterSource_ConfigFile|Microsoft_Console_Command_ParameterSource_Env --SubscriptionId|-sid Required. This is the Windows Azure Subscription Id to operate on.
	 * @command-parameter-for $certificate Microsoft_Console_Command_ParameterSource_Argv|Microsoft_Console_Command_ParameterSource_ConfigFile|Microsoft_Console_Command_ParameterSource_Env --Certificate|-cert Required. This is the .pem certificate that user has uploaded to Windows Azure subscription as Management Certificate.
	 * @command-parameter-for $certificatePassphrase Microsoft_Console_Command_ParameterSource_Argv|Microsoft_Console_Command_ParameterSource_ConfigFile|Microsoft_Console_Command_ParameterSource_Prompt --Passphrase|-p Required. The certificate passphrase. If not specified, a prompt will be displayed.
	 * @command-parameter-for $serverName Microsoft_Console_Command_ParameterSource_Argv|Microsoft_Console_Command_ParameterSource_ConfigFile|Microsoft_Console_Command_ParameterSource_StdIn --Name Required. The server name to operate on.
	 * @command-example List firewall rules for server "ie2l1ph28":
	 * @command-example ListFirewallRules -sid="<your_subscription_id>" --Name="ie2l1ph28"
	 */
	public function listFirewallRuleCommand($subscriptionId, $certificate, $certificatePassphrase, $serverName)
	{
		$client = new Microsoft_SqlAzure_Management_Client($subscriptionId, $certificate, $certificatePassphrase);
		$result = $client->listFirewallRules($serverName);

		if (count($result) == 0) {
			echo 'No data to display.';
		}
		foreach ($result as $object) {
			$this->_displayObjectInformation($object, array('Name', 'StartIpAddress', 'EndIpAddress'));
		}
	}
}

Microsoft_Console_Command::bootstrap($_SERVER['argv']);