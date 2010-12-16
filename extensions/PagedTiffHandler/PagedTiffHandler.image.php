<?php
 /**
  *
  * Copyright (C) Wikimedia Deuschland, 2009
  * Authors Hallo Welt! Medienwerkstatt GmbH
  * Authors Sebastian Ulbricht, Daniel Lynge, Marc Reymann, Markus Glaser
  *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along
 * with this program; if not, write to the Free Software Foundation, Inc.,
 * 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA.
 * http://www.gnu.org/copyleft/gpl.html
 *
 */

/**
 * inspired by djvuimage from brion vibber
 * modified and written by xarax
 * adapted to tiff by Hallo Welt! - Medienwerkstatt GmbH
 */

class PagedTiffImage {
	protected $_meta = NULL;
	protected $mFilename;
	
	function __construct( $filename ) {
		$this->mFilename = $filename;
	}
	
	/**
	* Customize the exiv shell command.
	*/
	static function exivCommand( &$cmd, $filename ) {
		return true;
	}
	
	/**
	* Called by MimeMagick functions.
	*/
	public function isValid() {
		return count($this->retrieveMetaData());
	}
	
	/**
	* Returns an array that corresponds to the native PHP function getimagesize().
	*/
	public function getImageSize() {
		$data = $this->retrieveMetaData();
		$size = $this->getPageSize( $data, 1 );
	
		if( $size ) {
			$width = $size['width'];
			$height = $size['height'];
			return array( $width, $height, 'Tiff',
			"width=\"$width\" height=\"$height\"" );
		}
		return false;
	}
	
	/**
	* Returns an array with width and height of the tiff page.
	*/
	public static function getPageSize( $data, $page ) {
		if( isset( $data['pages'][$page] ) ) {
			return array('width'  => $data['pages'][$page]['width'],
			'height' => $data['pages'][$page]['height']);
		}
		return false;
	}
	
	/**
	* Reads metadata of the tiff file via shell command and returns an associative array.
	* layout:
	* meta['Pages'] = amount of pages
	* meta['pages'] = metadata per page
	* meta['exif']  = Exif, XMP and IPTC
	* meta['errors'] = identify-errors
	* meta['warnings'] = identify-warnings
	*/
	public function retrieveMetaData() {
		global $wgImageMagickIdentifyCommand, $wgTiffExivCommand, $wgTiffUseExiv, $wgMemc, $wgTiffErrorCacheTTL;
	
		$imgKey = wfMemcKey('PagedTiffHandler-ThumbnailGeneration', $this->mFilename);
		$isCached = $wgMemc->get($imgKey);
		if($isCached) {
			return -1;
		}
		$wgMemc->add($imgKey, 1, $wgTiffErrorCacheTTL);
	
		if($this->_meta === NULL) {
			if ( $wgImageMagickIdentifyCommand ) {
	
				wfProfileIn( 'PagedTiffImage' );
				/**
				* ImageMagick is used in order to get the basic metadata of embedded files.
				* This is not reliable in exiv2m since it is not possible to name a set of required fields.
				*/
				$cmd = wfEscapeShellArg( $wgImageMagickIdentifyCommand ) .
					' -format "[BEGIN]page=%p\nalpha=%A\nalpha2=%r\nheight=%h\nwidth=%w\ndepth=%z[END]" ' .
					wfEscapeShellArg( $this->mFilename ) . ' 2>&1';
				
				wfProfileIn( 'identify' );
				wfDebug( __METHOD__.": $cmd\n" );
				$dump = wfShellExec( $cmd, $retval );
				wfProfileOut( 'identify' );
				if($retval) {
					return false;
				}
				$this->_meta = $this->convertDumpToArray( $dump );
				$this->_meta['exif'] = array();
				
				if($wgTiffUseExiv) {
					$cmd = wfEscapeShellArg( $wgTiffExivCommand ) .
						' -u -psix -Pnt ' . // read EXIF, XMP, IPTC as name-tag => interpreted data -ignore unknown fields
						// exiv2-doc @link http://www.exiv2.org/sample.html
						wfEscapeShellArg( $this->mFilename );
	
					wfRunHooks( "PagedTiffHandlerExivCommand", array( &$cmd, $this->mFilename ) );
	
					wfProfileIn( 'exiv2' );
					wfDebug( __METHOD__.": $cmd\n" );
					$dump = wfShellExec( $cmd, $retval );
					wfProfileOut( 'exiv2' );
					$result = array();
					preg_match_all('/(\w+)\s+(.+)/', $dump, $result, PREG_SET_ORDER);
	
					foreach($result as $data) {
						$this->_meta['exif'][$data[1]] = $data[2];
					}
				}
				else {
					$cmd = wfEscapeShellArg( $wgImageMagickIdentifyCommand ) .
						' -verbose ' .
						wfEscapeShellArg( $this->mFilename )."[0]";
	
					wfProfileIn( 'identify -verbose' );
					wfDebug( __METHOD__.": $cmd\n" );
					$dump = wfShellExec( $cmd, $retval );
					wfProfileOut( 'identify -verbose' );
					$this->_meta['exif'] = $this->parseVerbose($dump);
				}
				wfProfileOut( 'PagedTiffImage' );
			}
		}
		unset($this->_meta['exif']['Image']);
		unset($this->_meta['exif']['filename']);
		unset($this->_meta['exif']['Base filename']);
		return $this->_meta;
	}
	
	/**
	* helper function of retrieveMetaData().
	* parses shell return from identify-command into an array.
	*/
	protected function convertDumpToArray( $dump ) {
		global $wgTiffIdentifyRejectMessages, $wgTiffIdentifyBypassMessages;
		if ( strval( $dump ) == '' ) return false;
		$infos = NULL;
		preg_match_all('/\[BEGIN\](.+?)\[END\]/si', $dump, $infos, PREG_SET_ORDER);
		$data = array();
		$data['Pages'] = count($infos);
		$data['pages'] = array();
		foreach($infos as $info) {
			$entry = array();
			$lines = explode("\n", $info[1]);
			foreach($lines as $line) {
				if(trim($line) == '') {
					continue;
				}
				$parts = explode('=', $line);
				if(trim($parts[0]) == 'alpha' && trim($parts[1]) == '%A') {
					continue;
				}
				if(trim($parts[0]) == 'alpha2' && !isset($entry['alpha'])) {
					switch(trim($parts[1])) {
						case 'DirectClassRGBMatte':
						case 'DirectClassRGBA':
							$entry['alpha'] = 'true';
							break;
						default:
							$entry['alpha'] = 'false';
							break;
					}
					continue;
				}
				$entry[trim($parts[0])] = trim($parts[1]);
			}
			$entry['pixels'] = $entry['height'] * $entry['width'];
			$data['pages'][$entry['page']] = $entry;
		}
	
		$dump = preg_replace('/\[BEGIN\](.+?)\[END\]/si', '', $dump);
		if(strlen($dump)) {
			$errors = explode("\n", $dump);
			foreach($errors as $error) {
				$knownError = false;
				foreach($wgTiffIdentifyRejectMessages as $msg) {
					if (preg_match($msg, trim($error))) {
						$data['errors'][] = $error;
						$knownError = true;
						break;
					}
				}
				if(!$knownError) {
					foreach($wgTiffIdentifyBypassMessages as $msg) {
						if (preg_match($msg, trim($error))) {
							$data['warnings'][] = $error;
							$knownError = true;
							break;
						}
					}
				}
				if(!$knownError) {
					$data['unknownErrors'][] = $error;
				}
			}
		}
		return $data;
	}
	
	/**
	* helper function of retrieveMetaData().
	* parses shell return from identify-verbose-command into an array.
	*/
	protected function parseVerbose($dump) {
		$data = array();
		$dump = explode("\n", $dump);
		$lastwhite = 0;
		$lastkey   = false;
		foreach($dump as $line) {
			if(preg_match('/^(\s*?)(\w([\w\s]+?)?):(.*?)$/sim', $line, $res)) {
				if($lastwhite == 0 || strlen($res[1]) == $lastwhite) {
					if(strlen(trim($res[4]))) {
						$data[trim($res[2])] = trim($res[4]);
					}
					else {
						$data[trim($res[2])] = "  Data:\n";
					}
					$lastkey = trim($res[2]);
					$lastwhite = strlen($res[1]);
				}
				else {
					$data[$lastkey] .= $line."\n";
				}
			}
		}
		return $data;
	}
}
