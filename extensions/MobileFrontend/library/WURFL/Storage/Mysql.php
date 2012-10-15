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
 * @package    WURFL_Storage
 * @copyright  ScientiaMobile, Inc.
 * @license    GNU Affero General Public License
 * @author     Fantayeneh Asres Gizaw
 * @version    $id$
 */
/**
 * WURFL Storage
 * @package    WURFL_Storage
 */
class WURFL_Storage_Mysql extends WURFL_Storage_Base {

    private $defaultParams = array(
        "host" => "localhost",
        "port" => 3306,
        "db" => "wurfl_persistence_db",    
        "user" => "",
        "pass" => "",
        "table" => "wurfl_object_cache",
        "keycolumn" => "key",
        "valuecolumn" => "value"
    );

	private $link;
	private $host;
	private $db;
	private $user;
	private $pass;
	private $port;
	private $table;
	private $keycolumn;
	private $valuecolumn;

	public function __construct($params) {
        $currentParams = is_array($params) ? array_merge($this->defaultParams,$params) : $this->defaultParams;
        foreach($currentParams as $key => $value) {
            $this->$key = $value;
        }
		$this->initialize();
	}

	private function initialize() {
		$this->_ensureModuleExistance();

		/* Initializes link to MySql */
		$this->link = mysql_connect("$this->host:$this->port",$this->user,$this->pass);
		if (mysql_error($this->link)) {
			throw new WURFL_Storage_Exception("Couldn't link to $this->host (".mysql_error($this->link).")");
		}

		/* Initializes link to database */
		$success=mysql_selectdb($this->db,$this->link);
		if (!$success) {
			throw new WURFL_Storage_Exception("Couldn't change to database $this->db (".mysql_error($this->link).")");
		}

		/* Is Table there? */
		$test = mysql_query("SHOW TABLES FROM $this->db LIKE '$this->table'",$this->link);
		if (!is_resource($test)) {
			throw new WURFL_Storage_Exception("Couldn't show tables from database $this->db (".mysql_error($this->link).")");
		}

		// create table if it's not there.
		if (mysql_num_rows($test)==0) {
			$sql="CREATE TABLE `$this->db`.`$this->table` (
                      `$this->keycolumn` varchar(255) collate latin1_general_ci NOT NULL,
                      `$this->valuecolumn` mediumblob NOT NULL,
                      `ts` timestamp NOT NULL default CURRENT_TIMESTAMP,
                      PRIMARY KEY  (`$this->keycolumn`)
                    ) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci";
			$success=mysql_query($sql,$this->link);
			if (!$success) {
				throw new WURFL_Storage_Exception("Table $this->table missing in $this->db (".mysql_error($this->link).")");
			}
		}

		if (is_resource($test)) mysql_free_result($test);
	}
	
	public function save($objectId, $object) {
		$object=mysql_escape_string(serialize($object));
		$objectId=$this->encode("",$objectId);
		$objectId=mysql_escape_string($objectId);
		$sql = "delete from `$this->db`.`$this->table` where `$this->keycolumn`='$objectId'";
		$success=mysql_query($sql,$this->link);
		if (!$success) {
			throw new WURFL_Storage_Exception("MySql error ".mysql_error($this->link)."deleting $objectId in $this->db");
		}

		$sql="insert into `$this->db`.`$this->table` (`$this->keycolumn`,`$this->valuecolumn`) VALUES ('$objectId','$object')";
		$success=mysql_query($sql,$this->link);
		if (!$success) {
			throw new WURFL_Storage_Exception("MySql error ".mysql_error($this->link)."setting $objectId in $this->db");
		}
		return $success;
	}

	public function load($objectId) {
		$objectId = $this->encode("", $objectId);
		$objectId = mysql_escape_string($objectId);

		$sql="select `$this->valuecolumn` from `$this->db`.`$this->table` where `$this->keycolumn`='$objectId'";
		$result=mysql_query($sql,$this->link);
		if (!is_resource($result)) {
			throw new WURFL_Storage_Exception("MySql error ".mysql_error($this->link)."in $this->db");
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

	public function clear() {
		$sql = "truncate table `$this->db`.`$this->table`";
		$success=mysql_query($sql,$this->link);
		if (mysql_error($this->link)) {
			throw new WURFL_Storage_Exception("MySql error ".mysql_error($this->link)." clearing $this->db.$this->table");
		}
		return $success;
	}



	/**
	 * Ensures the existance of the the PHP Extension mysql
	 * @throws WURFL_Xml_PersistenceProvider_Exception required extension is unavailable
	 */
	private function _ensureModuleExistance() {
		if(!extension_loaded("mysql")) {
			throw new WURFL_Storage_Exception("The PHP extension mysql must be installed and loaded in order to use the mysql.");
		}
	}

}