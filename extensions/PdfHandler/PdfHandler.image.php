<?php

 /**
  *
  * Copyright (C) 2007 Xarax <jodeldi@gmx.de>
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
  */

class PdfImage {

	function __construct( $filename ) {
		$this->mFilename = $filename;
	}

	public function isValid() {
		return true;
	}

	public function getImageSize() {
		$data = $this->retrieveMetadata();
		$size = self::getPageSize( $data, 1 );
		
		if( $size ) {
			$width = $size['width'];
			$height = $size['height'];
			return array( $width, $height, 'Pdf',
				"width=\"$width\" height=\"$height\"" );
		}
		return false;
	}
	
	public static function getPageSize( $data, $page ) {
		global $wgPdfHandlerDpi;

		if( isset( $data['pages'][$page]['Page size'] ) ) {
			$o = $data['pages'][$page]['Page size'];
		} elseif( isset( $data['Page size'] ) ) {
			$o = $data['Page size'];
		} else {
			$o = false;
		}

		if ( $o ) {
			$size = explode( "x", $o, 2 );

			if ( $size ) {
				$width  = intval( trim( $size[0] ) / 72 * $wgPdfHandlerDpi );
				$height = explode( " ", trim( $size[1] ), 2 );
				$height = intval( trim( $height[0] ) / 72 * $wgPdfHandlerDpi );

				return array(
					'width' => $width,
					'height' => $height
				);
			}
		}
		
		return false;
	}

	public function retrieveMetaData() {
		global $wgPdfInfo;

		if ( $wgPdfInfo ) {
			wfProfileIn( 'pdfinfo' );
			$cmd = wfEscapeShellArg( $wgPdfInfo ) .
				" -enc UTF-8 " . # Report metadata as UTF-8 text...
				" -l 9999999 " . # Report page sizes for all pages
				wfEscapeShellArg( $this->mFilename );
			$dump = wfShellExec( $cmd, $retval );
			$data = $this->convertDumpToArray( $dump );
			wfProfileOut( 'pdfinfo' );
		} else {
			$data = null;
		}
		return $data;
	}

	protected function convertDumpToArray( $dump ) {
		if ( strval( $dump ) == '' ) return false;

		$lines = explode("\n", $dump);
		$data = array();

		foreach( $lines as $line ) {
			$bits = explode( ':', $line, 2 );
			if( count( $bits ) > 1 ) {
				$key = trim( $bits[0] );
				$value = trim( $bits[1] );
				if( preg_match( '/^Page +(\d+) size$/', $key, $matches ) ) {
					$data['pages'][$matches[1]]['Page size'] = $value;
				} else {
					$data[$key] = $value;
				}
			}
		}
		return $data;
	}
}
