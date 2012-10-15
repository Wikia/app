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
 */
/**
 * WURFL XML Utilities Static Class
 * @package    WURFL_Xml
 */
class WURFL_Xml_Utils {
	
	// 
	private function __construct() {}
	private function __clone() {}
	
	
	/**
	 * Returns the file path of the $xmlResource; if the $xmlResource is zipped it is uncompressed first
	 * @param string $xmlResource XML Resource file
	 * @return string XML Resource file
	 */
	public static function getXMLFile($xmlResource) {
		if (self::isZipFile($xmlResource)) {
			return self::getZippedFile($xmlResource);
		}
		return $xmlResource;
	}
	
	/**
	 * Returns a XML Resource filename for the uncompressed contents of the provided zipped $filename
	 * @param string $filename of zipped XML data
	 * @throws WURFL_WURFLException ZipArchive extension is not loaded or the ZIP file is corrupt
	 * @return string Full filename and path of extracted XML file
	 */
	private static function getZippedFile($filename) {
		if(!self::zipModuleLoaded()) {
			throw new WURFL_WURFLException("The ZipArchive extension is not loaded. Load the extension or use the flat wurfl.xml file");
		}
		$tmpDir = sys_get_temp_dir();
		$zip = new ZipArchive();

		if ($zip->open($filename) !== true) {
			throw new WURFL_WURFLException("The Zip file <$filename> could not be opened");
		}

		$zippedFile = $zip->statIndex(0);
		$wurflFile = $zippedFile['name'];
		
		//$wurflFile = md5(uniqid(rand(), true)); 
		//$zip->extractTo($tmpDir, $wurflFile);
		
		$zip->extractTo($tmpDir);
		$zip->close();
		
		return $tmpDir.DIRECTORY_SEPARATOR.$wurflFile;
	}
	
	/**
	 * Returns true if the $filename is that of a Zip file
	 * @param string $fileName
	 * @return bool
	 */
	private static function isZipFile($fileName) {
		return strcmp("zip", substr($fileName, -3)) === 0 ? TRUE : FALSE;
	}
	
	/**
	 * Returns true if the ZipArchive extension is loaded
	 * @return bool
	 */
	private static function zipModuleLoaded() {
		return class_exists('ZipArchive');
	}
}