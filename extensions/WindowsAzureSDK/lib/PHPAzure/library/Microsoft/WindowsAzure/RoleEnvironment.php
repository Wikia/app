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
 * @copyright  Copyright (c) 2009 - 2011, RealDolmen (http://www.realdolmen.com)
 * @license    http://phpazure.codeplex.com/license
 * @version    $Id: Storage.php 61042 2011-04-19 10:03:39Z unknown $
 */

/**
 * @see Microsoft_AutoLoader
 */
require_once dirname(__FILE__) . '/../AutoLoader.php';

/**
 * @category   Microsoft
 * @package    Microsoft_WindowsAzure
 * @copyright  Copyright (c) 2009 - 2011, RealDolmen (http://www.realdolmen.com)
 * @license    http://phpazure.codeplex.com/license
 */
class Microsoft_WindowsAzure_RoleEnvironment
{
	/**
	 * First-level command cache
	 * 
	 * @var array
	 */
	private static $_commandCache = array();
		// TODO: may be interesting to cache commands for subsequent requests as well

	/**
	 * Is the Windows Azure role environment available? Will return true on Windows Azure and Development Fabric, false when run in any other environment.
	 * 
	 * @return boolean
	 */
	public static function isAvailable()
	{
		$value = strtolower(self::_runCommand('IsAvailable'));
		return $value == 'true';
	}
	
	/**
	 * Is the application running in the development fabric?
	 * 
	 * @return boolean
	 */
	public static function isDevFabric()
	{
		$value = strtolower(self::_runCommand('IsEmulated'));
		return $value == 'true';
	}
	
	/**
	 * Gets the current role instance ID. Note that this method will return null when not hosted on Windows Azure.
	 * 
	 * @return string
	 */
	public static function getCurrentRoleInstanceId()
	{
		if (!self::isAvailable()) {
			return null;
		}
		
		$value = self::_runCommand('GetCurrentRoleInstanceId');
		return $value;
	}
	
	/**
	 * Gets the current role name. Note that this method will return null when not hosted on Windows Azure.
	 * 
	 * @return string
	 */
	public static function getCurrentRoleName() 
	{
		if (!self::isAvailable()) {
			return null;
		}
		
		$value = self::_runCommand('GetCurrentRoleName');
		return $value;
	}
	
	/**
	 * Gets the current deployment ID. Note that this method will return null when not hosted on Windows Azure.
	 * 
	 * @return string
	 */
	public static function getDeploymentId() 
	{
		if (!self::isAvailable()) {
			return null;
		}
		
		$value = self::_runCommand('GetDeploymentId');
		return $value;
	}

	/**
	 * Get configuration setting value from ServiceConfiguration.cscfg. Note that this method will return null when not hosted on Windows Azure.
	 * 
	 * @param string $configurationKey Configuration key.
	 * @return string
	 */
	public static function getConfigurationSettingValue($configurationKey)
	{
		if (!self::isAvailable()) {
			return null;
		}
		
		$value = self::_runCommand('GetConfigurationSettingValue', array($configurationKey));
		return $value;
	}

	/**
	 * Get local resource root path from ServiceDefinition.csdef. Note that this method will return null when not hosted on Windows Azure.
	 * 
	 * @param string $localResourceKey Local resource key.
	 * @return string
	 */
	public static function getLocalResource($localResourceKey)
	{
		if (!self::isAvailable()) {
			return null;
		}
		
		$value = self::_runCommand('GetLocalResource', array($localResourceKey));
		return $value;
	}

	/**
	 * Run a command through RoleEnvironmentProxy.exe.
	 * 
	 * @param string $command Command to run.
	 * @param array $parameters Command parameters.
	 * @return mixed
	 */
	protected static function _runCommand($command, $parameters = array())
	{
		for ($i = 0; $i < count($parameters); $i++) {
			$parameters[$i] = escapeshellarg($parameters[$i]);
		}
		$parameters = implode(' ', $parameters);
		$command = escapeshellarg($command) . ' ' . $parameters;

		// Check for cached result
		if (array_key_exists($command, self::$_commandCache)) {
			return self::$_commandCache[$command];
		}

		// Run command
		$h = popen(dirname(__FILE__) . '/bin/RoleEnvironmentProxy.exe ' . $command . ' 2>&1', 'r');
		$value = '';
		while (!feof($h)) {
		  $value .= fread($h, 8192);
		}
		pclose($h);
		
		// Parse value
		if ($value == 'null') {
			$value = null;
		}
		self::$_commandCache[$command] = $value;
		return $value;
	}
}
