<?php
# Copyright (C) 2004 Ryan Lane <rlane32@gmail.com>
#
# This program is free software; you can redistribute it and/or modify
# it under the terms of the GNU General Public License as published by
# the Free Software Foundation; either version 2 of the License, or
# (at your option) any later version.
#
# This program is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
# GNU General Public License for more details.
#
# You should have received a copy of the GNU General Public License along
# with this program; if not, write to the Free Software Foundation, Inc.,
# 59 Temple Place - Suite 330, Boston, MA 02111-1307, USA.
# http://www.gnu.org/copyleft/gpl.html

# SmoothGallery extension. Creates galleries of images that are in your wiki.
#
# SmoothGallery.php
#
# Extension info available at http://www.mediawiki.org/wiki/Extension:SmoothGallery
# SmoothGallery available at http://smoothgallery.jondesign.net/
#
# sgallery Parser Function changes contributed by David Claughton <dave@eclecticdave.com>
# infopane sliding and opacity patch provided by David Claughton <dave@eclecticdave.com>

if ( !defined( 'MEDIAWIKI' ) )
	die( -1 );

/**
 * Add extension information to Special:Version
 */
$wgExtensionCredits['other'][] = array(
	'path'           => __FILE__,
	'name'           => 'SmoothGallery parser extension',
	'version'        => '1.1g',
	'author'         => 'Ryan Lane',
	'description'    => 'Allows users to create galleries with images that have been uploaded. Allows most options of SmoothGallery',
	'descriptionmsg' => 'smoothgallery-desc',
	'url'            => 'http://www.mediawiki.org/wiki/Extension:SmoothGallery',
);

$wgExtensionFunctions[] = "efSmoothGallery";

$wgHooks['OutputPageParserOutput'][] = 'smoothGalleryParserOutput';

$dir = dirname( __FILE__ ) . '/';
$wgExtensionMessagesFiles['SmoothGallery'] = $dir . 'SmoothGallery.i18n.php';
if( version_compare( $wgVersion, '1.16alpha', '>=' ) ) {
	$wgExtensionMessagesFiles['SmoothGalleryMagic'] = $dir . 'SmoothGallery.i18n.magic.php';
} else {
	$wgHooks['LanguageGetMagic'][] = 'smoothGalleryLanguageGetMagic';
}
$wgAutoloadClasses['SmoothGallery'] = $dir . 'SmoothGalleryClass.php';
$wgAutoloadClasses['SmoothGalleryParser'] = $dir . 'SmoothGalleryParser.php';

// sane defaults. always initialize to avoid register_globals vulnerabilities
$wgSmoothGalleryDelimiter = "\n";
$wgSmoothGalleryExtensionPath = $wgScriptPath . '/extensions/SmoothGallery';
$wgSmoothGalleryAllowExternal = false;
$wgSmoothGalleryThumbHeight = "75px";
$wgSmoothGalleryThumbWidth = "100px";

function efSmoothGallery() {
	global $wgParser;

	$wgParser->setHook( 'sgallery', 'initSmoothGallery' );
	$wgParser->setHook( 'sgalleryset', 'initSmoothGallerySet' );

	$wgParser->setFunctionHook( 'sgallery', 'initSmoothGalleryPF' );
}

// FIXME: split off to a hook file and use $wgHooks['ParserFirstCallInit'] to init tags
function initSmoothGalleryPF( &$parser ) {
	global $wgSmoothGalleryDelimiter;

	$numargs = func_num_args();
	if ( $numargs < 2 ) {
		$input = "#SmoothGallery: no arguments specified";
		return str_replace( '§', '<', '§pre>§nowiki>' . $input . '§/nowiki>§/pre>' );
	}

	// fetch all user-provided arguments (skipping $parser)
	$input = "";
	$argv = array();
	$arg_list = func_get_args();
	for ( $i = 1; $i < $numargs; $i++ ) {
		$p1 = $arg_list[$i];

		$aParam = explode( '=', $p1, 2 );
		if ( count( $aParam ) < 2 ) {
			continue;
		}
		SmoothGallery::debug( 'sgallery tag parameter: ', $aParam );
		if ( $aParam[0] == "imagelist" ) {
			$input = $aParam[1];
			continue;
		}
		$sKey = trim( $aParam[0] );
		$sVal = trim( $aParam[1] );

		if ( $sKey != '' ) {
			$argv[$sKey] = $sVal;
		}
	}

	$output = initSmoothGallery( $input, $argv, $parser );
	return array( $output, 'noparse' => true, 'isHTML' => true );
}

function initSmoothGallery( $input, $argv, &$parser, $calledAsSet = false ) {
	$sgParser = new SmoothGalleryParser( $input, $argv, $parser, $calledAsSet );
	$sgGallery = new SmoothGallery();

	$sgGallery->setParser( $parser );
	$sgGallery->setSet( $calledAsSet );
	$sgGallery->setArguments( $sgParser->getArguments() );
	$sgGallery->setGalleries( $sgParser->getGalleries() );

	$sgGallery->checkForErrors();
	if ( $sgGallery->hasErrors() ) {
		return $sgGallery->getErrors();
	} else {
		return $sgGallery->toHTML();
	}
}

function initSmoothGallerySet( $input, $args, &$parser ) {
	$output = initSmoothGallery( $input, $args, $parser, true );

	return $output;
}

/**
 * Hook callback that injects messages and things into the <head> tag
 * Does nothing if $parserOutput->mSmoothGalleryTag is not set
 */
function smoothGalleryParserOutput( &$outputPage, &$parserOutput )  {
	if ( !empty( $parserOutput->mSmoothGalleryTag ) ) {
		SmoothGallery::setGalleryHeaders( $outputPage );
	}
	if ( !empty( $parserOutput->mSmoothGallerySetTag ) ) {
		SmoothGallery::setGallerySetHeaders( $outputPage );
	}
	return true;
}

/**
 * We ignore langCode - parser function names can be translated but
 * we are not using this feature
 */
function smoothGalleryLanguageGetMagic( &$magicWords, $langCode ) {
	$magicWords['sgallery']  = array( 0, 'sgallery' );
	return true;
}
