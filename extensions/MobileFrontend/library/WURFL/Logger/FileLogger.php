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
 * @package    WURFL_Logger
 * @copyright  ScientiaMobile, Inc.
 * @license    GNU Affero General Public License
 * @version    $id$
 */
/**
 * WURFL File Logger
 * 
 * @package    WURFL_Logger
 */
class WURFL_Logger_FileLogger implements WURFL_Logger_Interface  {

	/**
	 * @var string DEBUG Log level
	 */
	const DEBUG = "DEBUG";
	/**
	 * @var string INFO Log level
	 */
	const INFO = "INFO";
	
	/**
	 * @var int File pointer
	 */
	private $fp;
	
	/**
	 * Creates a new FileLogger object
	 * @param string $fileName
	 * @throws InvalidArgumentException Log file specified is not writable
	 * @throws WURFL_WURFLException Unable to open log file
	 */
	public function __construct($fileName) {
		if(!is_writable($fileName)) {
			throw new InvalidArgumentException("Log file specified is not writable");
		}
		$this->fp = @fopen($fileName, "a");
		if(!$this->fp){
			throw new WURFL_WURFLException("Unable to open log file: ");
		}
	}
	
	public function log($message, $type="") {
		$time = date("F jS Y, h:iA");
		$fullMessage = "[$time] [$type] $message";
		fwrite($this->fp, $fullMessage."\n");
	}
	
	public function info($message) {
		$this->log($message, self::INFO);
	}
	
	
	public function debug($message) {
		$this->log($message, self::DEBUG);
	}
	
	/**
	 * Close open files
	 */
	public function __destruct() {
		fclose($this->fp);
	}
}