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
class WURFL_Storage_Memory extends WURFL_Storage_Base {

	const IN_MEMORY = "memory";

	protected $persistenceIdentifier = "MEMORY_PERSISTENCE_PROVIDER";

    private $defaultParams = array(
        "namespace" => "wurfl"
    );

    private $namespace;
	private $map;

	public function __construct($params=array()) {
        $currentParams = is_array($params) ? array_merge($this->defaultParams, $params) : $this->defaultParams;
        $this->namespace = $currentParams["namespace"];
		$this->map = array();
	}

	public function save($objectId, $object) {
		$this->map[$this->encode ( $this->namespace, $objectId )] = $object;
	}

	public function load($objectId) {
		$key = $this->encode ($this->namespace, $objectId);
		if (isset($this->map [$key])) {
			return $this->map [$key];
		}

		return NULL;

	}

	public function remove($objectId) {
		$key = $this->encode ($this->namespace, $objectId );
		if($this->map [$key]) {
			unset ( $this->map [$key] );
		}

	}

	/**
	 * Removes all entry from the Persistence Provier
	 *
	 */
	public function clear() {
		unset($this->map);
	}
}
