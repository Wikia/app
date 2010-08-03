<?php

//////////////////////////////////////////////////////////////////////////
//
// WikiHiero - A PHP convert from text using "Manual for the encoding of
// hieroglyphic texts for computer input" syntax to HTML entities (table and
// images).
//
// Copyright (C) 2004 Guillaume Blanchard (Aoineko)
//
// This program is free software; you can redistribute it and/or
// modify it under the terms of the GNU General Public License
// as published by the Free Software Foundation; either version 2
// of the License, or any later version.
//
// This program is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with this program; if not, write to the Free Software
// Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
//
//////////////////////////////////////////////////////////////////////////

// Register MediaWiki extension
if ( defined( 'MW_SUPPORTS_PARSERFIRSTCALLINIT' ) ) {
	$wgHooks['ParserFirstCallInit'][] = 'WH_Register';
} else {
	$wgExtensionFunctions[] = 'WH_Register';
}

$wgExtensionCredits['parserhook'][] = array(
	'name'           => 'WikiHiero',
	'author'         => 'Guillaume Blanchard',
	'url'            => 'http://www.mediawiki.org/wiki/Extension:WikiHiero',
	'svn-date' => '$LastChangedDate: 2008-06-06 22:38:04 +0200 (ptk, 06 cze 2008) $',
	'svn-revision' => '$LastChangedRevision: 35980 $',
	'description'    => 'Syntax to display hieroglyph',
	'descriptionmsg' => 'wikihiero-desc',
);
$wgExtensionMessagesFiles['Wikihiero'] =  dirname(__FILE__) . '/wikihiero.i18n.php';

function WH_Register() {
	global $wgParser;
	$wgParser->setHook( 'hiero', 'WikiHieroLoader' );
	return true;
}

function WikiHieroLoad() {
	static $loaded = false;
	if ( !$loaded ) {
		require( dirname( __FILE__ ) . '/wh_main.php' );
		$loaded = true;
	}
}

// MediaWiki entry point
function WikiHieroLoader( $text, $attribs, &$parser ) {
	WikiHieroLoad();
	$parser->setHook( 'hiero', 'WikiHieroHook' );
	return WikiHieroHook( $text, $attribs, $parser );
}

// Generic embedded entry point
function WikiHiero($hiero, $mode=WH_MODE_DEFAULT, $scale=WH_SCALE_DEFAULT, $line=false) {
	WikiHieroLoad();
	return _WikiHiero( $hiero, $mode, $scale, $line );
}

// If anyone needs WikiHieroHTML() etc., loader functions should be put here.
// Hopefully everyone's using the general-purpose entry point above.

