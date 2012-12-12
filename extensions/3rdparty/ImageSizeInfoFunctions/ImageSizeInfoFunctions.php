<?php
// ImageSizeInfoFunctions MediaWiki Extension.
// Give two parser functions returning width and height of a given image.
//
// Copyright (C) 2007, Dario de Judicibus.
//
// This program is free software; you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation; either version 2 of the License, or
// (at your option) any later version.
//
// This program is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with this program; if not, write to the Free Software
// Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA

if ( !defined( 'MEDIAWIKI' ) ) {
	die( 'This file is a MediaWiki extension, it is not a valid entry point' );
}

$wgExtensionFunctions[] = 'wfSetupImageSizeInfoFunctions';
$wgExtensionCredits['parserhook'][] = array(
	'name' => 'ImageSizeInfoFunctions',
	'version' => '1.0.1~wikia',
	'url' => 'http://www.mediawiki.org/wiki/Extension:ImageSizeInfoFunctions',
	'author' => 'Dario de Judicibus',
	'description' => 'Enhance parser with image size info functions',
);

$wgExtensionMessagesFiles['ImageSizeInfoFunctions'] =  dirname( __FILE__ ) . '/ImageSizeInfoFunctions.i18n.php';

class ExtImageSizeInfoFunctions {

	function clearState() {
		return true;
	}

	function imageWidth( &$parser, $image = '' ) {
		try {
			$title = Title::newFromText($image,NS_IMAGE);
			$file = function_exists( 'wfFindFile' ) ? wfFindFile( $title ) : new Image( $title );
			$width = (is_object( $file ) && $file->exists()) ? $file->getWidth() : 0;
			return $width;
		} catch(Exception $e) {
			return $e->getMessage();
		}
	}

	function imageHeight( &$parser, $image = '' ) {
		try {
			$title = Title::newFromText($image,NS_IMAGE);
			$file = function_exists( 'wfFindFile' ) ? wfFindFile( $title ) : new Image( $title );
			$height = (is_object( $file ) && $file->exists()) ? $file->getHeight() : 0;
			return $height;
		} catch(Exception $e) {
			return $e->getMessage();
		}
	}
}

function wfSetupImageSizeInfoFunctions() {
	global $wgParser, $wgExtInfoFunctions, $wgHooks;

	$wgExtInfoFunctions = new ExtImageSizeInfoFunctions;

	/* @var Parser $wgParser */
	$wgParser->setFunctionHook( 'imgw', array( &$wgExtInfoFunctions, 'imageWidth' ) );
	$wgParser->setFunctionHook( 'imgh', array( &$wgExtInfoFunctions, 'imageHeight' ) );

	$wgHooks['ParserClearState'][] = array( &$wgExtInfoFunctions, 'clearState' );
}
