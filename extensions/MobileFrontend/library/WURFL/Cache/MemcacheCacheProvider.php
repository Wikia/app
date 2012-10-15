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
 * An Implementation of the Cache using memcache module.(http://uk3.php.net/memcache.)
 *
 * @category   WURFL
 * @package    WURFL_Cache
 */
class WURFL_Cache_MemcacheCacheProvider implements WURFL_Cache_CacheProvider {

    const EXTENSION_MODULE_NAME = "memcache";
    const DEFAULT_HOST = "127.0.0.1";
    const DEFAULT_PORT = 11211;


    private $_memcache;
    private $_host;
    private $_port;

    private $expire;

    public function __construct($params) {
        if (is_array($params)) {
            $this->_host = isset($params["host"]) ? $params["host"] : self::DEFAULT_HOST;
            $this->_port = isset($params["port"]) ? $params["port"] : self::DEFAULT_PORT;
            $this->expire = isset($params[WURFL_Cache_CacheProvider::EXPIRATION]) ? $params[WURFL_Cache_CacheProvider::EXPIRATION] : WURFL_Cache_CacheProvider::NEVER;
        }
        $this->initialize();
    }

    /**
     * Initializes the Memcache Module
     *
     */
    public final function initialize() {
        $this->_ensureModuleExistence();
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


    function get($key) {
        $value = $this->_memcache->get($key);
        return $value ? $value : null;
    }

    function put($key, $value) {
        $expire = $this->expire > 0 ? $this->expire + time() : 0;
        $this->_memcache->set($key, $value, false, $expire);
    }

    function clear() {
        $this->_memcache->flush();
    }

    function close() {
        $this->_memcache->close();
        $this->_memcache = null;
    }

    /**
     * Ensures the existance of the the PHP Extension memcache
     * @throws WURFL_Xml_PersistenceProvider_Exception Extension is not loaded
     */
    private function _ensureModuleExistence() {
        if (!extension_loaded(self::EXTENSION_MODULE_NAME)) {
            throw new WURFL_Xml_PersistenceProvider_Exception("The PHP extension memcache must be installed and loaded in order to use the Memcached.");
        }
    }
}
