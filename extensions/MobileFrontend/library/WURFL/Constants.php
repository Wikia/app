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
 *
 * @category   WURFL
 * @package    WURFL
 * @copyright  ScientiaMobile, Inc.
 * @license    GNU Affero General Public License
 * @version    $id$
 */
/**
 * WURFL PHP API Constants
 * @package    WURFL
 */
class WURFL_Constants {

	private function __construct(){}
	
	/**
	 * @var string WURFL 'generic' device id
	 */
	const GENERIC = "generic";
	/**
	 * @var string WURFL 'generic_xhtml' device id
	 */
	const GENERIC_XHTML = "generic_xhtml";

	const ACCEPT_HEADER_VND_WAP_XHTML_XML = "application/vnd.wap.xhtml+xml";
	const ACCEPT_HEADER_XHTML_XML = "application/xhtml+xml";
	const ACCEPT_HEADER_TEXT_HTML = "application/text+html";

	const UA = "UA";
	
	const MEMCACHE = "memcache";
	const APC = "apc";
	const FILE = "file";
	const NULL_CACHE = "null";
	const EACCELERATOR = "eaccelerator";
	const SQLITE = "sqlite";
	const MYSQL = "mysql";
}