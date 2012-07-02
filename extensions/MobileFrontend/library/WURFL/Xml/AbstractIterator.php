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
 * @package    WURFL_Xml
 * @copyright  ScientiaMobile, Inc.
 * @license    GNU Affero General Public License
 * @version    $id$
 *
 */
/**
 * Iterates over a WURFL/Patch XML file
 * @package    WURFL_Xml
 */
abstract class WURFL_Xml_AbstractIterator implements Iterator {
	
	/**
	 * @var string filename with path to wurfl.xml or patch file
	 */
	private $inputFile;
	
	/**
	 * @var XMLReader
	 */
	protected $xmlReader;
	
	protected $currentElement;
	
	protected $currentElementId;
	
	/**
	 * Loads given XML $inputFile
	 * @param string $inputFile
	 */
	function __construct($inputFile) {
		if(!file_exists($inputFile)) {
			throw new InvalidArgumentException("cannot locate [$inputFile] file!");
		}
		$this->inputFile = WURFL_Xml_Utils::getXMLFile($inputFile);
	}
	
	/**
	 * Returns the current XML element
	 * @return XMLReader Current XML element
	 */
	public function current() {
		return $this->currentElement;
	}
	
	/**
	 * Prepare for next XML element
	 */
	public function next() {
		$this->currentElement = null;
	}
	
	/**
	 * Returns the current element id
	 * @return string Current element id
	 */
	public function key() {
		return $this->currentElementId;
	}
	
	/**
	 * Returns true if the current XML element is valid for processing
	 * @return bool
	 */
	public function valid() {
		if($this->currentElement === null) {
			$this->readNextElement();
		}
		return $this->currentElement != null;
	}
	
	/**
	 * Open the input file and position cursor at the beginning
	 * @see $inputFile
	 */
	public function rewind() {
		$this->xmlReader = new XMLReader();
		$this->xmlReader->open($this->inputFile);
		$this->currentElement = null;
		$this->currentElementId = null;
	}
	
	/**
	 * Move the XMLReader pointer to the next element and read data
	 */
	abstract public function readNextElement();
}
