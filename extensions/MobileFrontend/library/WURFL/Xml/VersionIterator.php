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
 * Extracts version information from XML file
 * @package    WURFL_Xml
 */
class WURFL_Xml_VersionIterator extends WURFL_Xml_AbstractIterator {
	
	public function readNextElement() {
		$version = "";
		$lastUpdated = "";
		$officialURL = "";
		while ( $this->xmlReader->read () ) {
			
			$nodeName = $this->xmlReader->name;
			switch ($this->xmlReader->nodeType) {
				case XMLReader::TEXT :
					$currentText = $this->xmlReader->value;
					break;
				case XMLReader::END_ELEMENT :
					switch ($nodeName) {
						case 'version' :
							$this->currentElement = new WURFL_Xml_Info ( $version, $lastUpdated, $officialURL );
							break 2;
						
						case 'ver' :
							$version = $currentText;
						break;						
						
						case 'last_updated' :
							$lastUpdated = $currentText;
							break;
						
						case "official_url" :
							$officialURL = $currentText;
							break;
					}
			}
		} // end of while
	

	}

}
