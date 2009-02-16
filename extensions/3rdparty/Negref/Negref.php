<?php
/**
 * WikiRuby
 * @package WikiRuby
 * @author Daniel Friesen (http://wiki-tools.com/wiki/User:Dantman) <dan_the_man@telus.net>
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 * 
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
 */

if( !defined( 'MEDIAWIKI' ) ) die( "This is an extension to the MediaWiki package and cannot be run standalone." );

$wgExtensionCredits['parserhook'][] = array (
	"name" => "Negref",
	"author" => "[http://mediawiki.org/wiki/User:Dantman Daniel Friesen]",
	"description" => "Provides a tag to negotiate the location of any <nowiki><ref/></nowiki> tags inside of input text to fix some template use cases."
);

$wgExtensionFunctions[] = 'efNegrefSetup';
$wgHooks['LanguageGetMagic'][]   = 'efNegrefSetupLanguageMagic';

function efNegrefSetup() {
	global $wgParser, $wgHooks;
	
	// Check for SFH_OBJECT_ARGS capability
	if ( defined( 'MW_SUPPORTS_PARSERFIRSTCALLINIT' ) ) {
		$wgHooks['ParserFirstCallInit'][] = 'efNegrefRegisterParser';
	} else {
		if ( class_exists( 'StubObject' ) && !StubObject::isRealObject( $wgParser ) ) {
			$wgParser->_unstub();
		}
		efNegrefRegisterParser( $wgParser );
	}
	
	return true;
}

function efNegrefRegisterParser( &$parser ) {
	$parser->setFunctionHook( 'negref', 'efNegrefHook' );
	return true;
}

function efNegrefSetupLanguageMagic( &$magicWords, $langCode ) {
        $magicWords['negref'] = array( 0, 'negref' );
        return true;
}

function efNegrefHook( $parser, $input, $replaceData, $replaceRef, $pattern ) {
	$data = $input;
	$ref = '';
	
	$keys = array_keys($parser->mStripState->general->getArray());
	foreach($keys as $key) {
		if(preg_match('/^'.preg_quote($parser->uniqPrefix(), '/').'-(ref)-.*$/', $key)) {
			if(substr_count($input, $key) > 0) {
				$data = str_replace($key, '', $data);
				$ref .= $key;
			}
		}
	}
	
	return str_replace($replaceRef, $ref, str_replace($replaceData, $data, $pattern));
}
