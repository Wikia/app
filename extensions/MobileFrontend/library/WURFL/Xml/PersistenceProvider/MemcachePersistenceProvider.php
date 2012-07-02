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
 * @package    WURFL_Xml_PersistenceProvider
 * @copyright  ScientiaMobile, Inc.
 * @license    GNU Affero General Public License
 * @version    $id$
 */
/**
 * Memcache persistence provider
 * @package    WURFL_Xml_PersistenceProvider
 */
class WURFL_Xml_PersistenceProvider_MemcachePersistenceProvider extends WURFL_Xml_PersistenceProvider_AbstractPersistenceProvider {

    const EXTENSION_MODULE_NAME = "memcache";
    const DEFAULT_HOST = "127.0.0.1";
    const DEFAULT_PORT = 11211;
    const DEFUALT_APPLICATION_KEY = "";

    protected $persistenceIdentifier = "MEMCACHE_PERSISTENCE_PROVIDER";

    private $_memcache;
    private $_host;
    private $_port;

    public function __construct($params = array()) {
        if (is_array($params)) {
            $this->_host = isset($params["host"]) ? $params["host"] : self::DEFAULT_HOST;
            $this->_port = isset($params["port"]) ? $params["port"] : self::DEFAULT_PORT;
            $this->_applicationKey = isset($params["application_key"]) ? $params["application_key"] : self::DEFUALT_APPLICATION_KEY;
        } else {
            $this->_host = self::DEFAULT_HOST;
            $this->_port = self::DEFAULT_PORT;
        }
        $this->initialize();
    }

    /**
     * Initializes the Memcache Module
     *
     */
    public final function initialize() {
        $this->_ensureModuleExistance();
        $this->_memcache = new Memcache();
        // support multiple hosts using semicolon to separate hosts
        $hosts = explode(";", $this->_host);
        // different ports for each hosts the same way
        $ports = explode(";", $this->_port);

        if (count($hosts) > 1) {
            if (count($ports) < 1) {
                $ports = array_pad(count($hosts), self::DEFAULT_PORT);
            } elseif (count($ports) == 1) {
                // if we have just one port, use it for all hosts
                $_p = $ports[0];
                $ports = array_fill(0, count($hosts), $_p);
            }
            foreach ($hosts as $i => $host) {
                $this->_memcache->addServer($host, $ports[$i]);
            }
        } else {
            // just connect to the single host
            $this->_memcache->connect($hosts[0], $ports[0]);
        }
    }
    
    public function save($objectId, $object) {
        return $this->_memcache->set($this->encode($objectId), $object);
    }

    public function load($objectId) {
        $value = $this->_memcache->get($this->encode($objectId));
        return $value ? $value : null;
    }


    public function clear() {
        $this->_memcache->flush();
    }


    /**
     * Ensures the existance of the the PHP Extension memcache
     *
     */
    private function _ensureModuleExistance() {
        if (!extension_loaded(self::EXTENSION_MODULE_NAME)) {
            throw new WURFL_Xml_PersistenceProvider_Exception("The PHP extension memcache must be installed and loaded in order to use the Memcached persistence provider.");
        }
    }

}