<?php
/**
 * Copyright (c) 2011 ScientiaMobile, Inc.
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as
 * published by the Free Software Foundation, either version 3 of the
 * License, or (at your option) any later version.
 *
 * Refer to the COPYING file distributed with this package.
 *
 * @category   WURFL
 * @package    WURFL_Cache
 * @copyright  ScientiaMobile, Inc.
 * @license    GNU Affero General Public License
 * @version    $id$
 */
/**
 * MySQL Cache Provider
 * @package    WURFL_Cache
 */
class WURFL_Cache_MysqlCacheProvider implements WURFL_Cache_CacheProvider {

	const EXTENSION_MODULE_NAME = "mysql";
	const DEFAULT_HOST = "localhost";
	const DEFAULT_USER = "";
	const DEFAULT_PASS = "";
	const DEFAULT_DB = "";
	const DEFAULT_TABLE = "wurfl_object_cache";
	const DEFAULT_PORT = 3306;
	const DEFAULT_KEYCOLUMN = "key";
	const DEFAULT_VALUECOLUMN = "value";
	
	/**
	 * @var int mysql link resource
	 */
	private $_link;
	/**
	 * @var string mysql host 
	 */
	private $_host;
	/**
	 * @var string mysql database name 
	 */
	private $_db;
	/**
	 * @var string mysql user 
	 */
	private $_user;
	/**
	 * @var string mysql password 
	 */
	private $_pass;
	/**
	 * @var string mysql port 
	 */
	private $_port;
	/**
	 * @var string mysql table for storing cached data 
	 */
	private $_table;
	/**
	 * @var string mysql key column name 
	 */
	private $_keycolumn;
	/**
	 * @var string mysql value column name 
	 */
	private $_valuecolumn;
	
	/**
	 * Creates a new MySQL Cache Provider with the given $params
	 * @param array $params
	 */
	public function __construct($params) {
		if (is_array($params)) {
			$this->_host = isset($params["host"]) ? $params["host"] : self::DEFAULT_HOST;
			$this->_port = isset($params["port"]) ? $params["port"] : self::DEFAULT_PORT;
			$this->_user = isset($params["user"]) ? $params["user"] : self::DEFAULT_USER;
			$this->_pass = isset($params["pass"]) ? $params["pass"] : self::DEFAULT_PASS;
			$this->_db = isset($params["db"]) ? $params["db"] : self::DEFAULT_DB;			
			$this->_table = isset($params["table"]) ? $params["table"] : self::DEFAULT_TABLE;			
			$this->_keycolumn = isset($params["keycolumn"]) ? $params["keycolumn"] : self::DEFAULT_KEYCOLUMN;
			$this->_valuecolumn = isset($params["valuecolumn"]) ? $params["valuecolumn"] : self::DEFAULT_VALUECOLUMN;
		}
		$this->initialize();
	}

	/**
	 * Initializes the MySQL Module
	 * @throws WURFL_Xml_PersistenceProvider_Exception Various database errors
	 */
	public final function initialize() {
		$this->_ensureModuleExistance();
		// Initializes link to MySQL
		$this->_link = mysql_connect("$this->_host:$this->_port", $this->_user, $this->_pass);
		if (!$this->_link) {
			throw new WURFL_Xml_PersistenceProvider_Exception("Couldn't connect to $this->_host (".mysql_error($this->_link).")");
		}
		
		// Initializes link to database
		if (!mysql_select_db($this->_db, $this->_link)) {
			throw new WURFL_Xml_PersistenceProvider_Exception("Couldn't change to database to $this->_db (".mysql_error($this->_link).")");
		}
		
		// Check for database
		$test = mysql_query("SHOW TABLES FROM $this->_db LIKE '$this->_table'",$this->_link);
		if (!is_resource($test)) {
			throw new WURFL_Xml_PersistenceProvider_Exception("Couldn't show tables from database $this->_db (".mysql_error($this->_link).")");
		}
		
		// create table if it's not there.
		if (mysql_num_rows($test) == 0) {
			$query = sprintf("CREATE TABLE `%s`.`%s` (
                      `%s` varchar(255) collate latin1_general_ci NOT NULL,
                      `%s` mediumblob NOT NULL,
                      `ts` timestamp NOT NULL default CURRENT_TIMESTAMP,
                      PRIMARY KEY  (`%s`)
                    ) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci",
				$this->_db,
				$this->_table,
				$this->_keycolumn,
				$this->_valuecolumn,
				$this->_keycolumn
			);
			$success = mysql_query($query, $this->_link);
			if (!$success) {
				throw new WURFL_Xml_PersistenceProvider_Exception("Table $this->_table missing in $this->_db (".mysql_error($this->_link).")");
			}
		} 
		
		if (is_resource($test)) {
			mysql_free_result($test);
		}
	}

	function get($key) {
		$key = mysql_escape_string($key);
		$sql="select `value` from `$this->_db`.`$this->_table` where `key`='$key'";
		$result=mysql_query($sql,$this->_link);
		if (!is_resource($result)) {
			throw new WURFL_Xml_PersistenceProvider_Exception("MySql error ".mysql_error($this->_link)."in $this->_db");
		}
		$row = mysql_fetch_assoc($result);
		if (is_array($row)) {
			$return = unserialize($row['value']);
		} else {
			$return=false;
		}
		if (is_resource($result)) mysql_free_result($result);
		return $return;
	}

	function put($key, $value) {
		$value = mysql_escape_string(serialize($value));
		$key = mysql_escape_string($key);
		$sql = sprintf("DELETE FROM `%s`.`%s` WHERE `key` = '%s'", $this->_db, $this->_table, $key);
		$success = mysql_query($sql, $this->_link);
		if (!$success) {
			throw new WURFL_Xml_PersistenceProvider_Exception("MySql error ".mysql_error($this->_link)." while deleting $key in $this->_db");
		}

		$sql = sprintf("INSERT INTO `%s`.`%s` (`key`,`value`) VALUES ('%s','%s')", $this->_db, $this->_table, $key, $value);
		$success = mysql_query($sql,$this->_link);
		if (!$success) {
			throw new WURFL_Xml_PersistenceProvider_Exception("MySql error ".mysql_error($this->_link)." while setting $key in $this->_db");
		}
		return $success;
	}

	function clear() {
		
	}
	
	function close() {
		mysql_close($this->_link);
		$this->_link = null;
	}

	/**
	 * Ensures the existance of the the PHP Extension memcache
	 * @throws WURFL_Xml_PersistenceProvider_Exception mysql extension is not present
	 */
	private function _ensureModuleExistance() {
		if(!extension_loaded(self::EXTENSION_MODULE_NAME)) {
			throw new WURFL_Xml_PersistenceProvider_Exception("The PHP extension mysql must be installed and loaded in order to use the mysql cache provider.");
		}
	}
}