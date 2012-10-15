<?php
/**
 * TemplateAdventures is for recreation of popular but demanding templates
 * in PHP.  Wikicode is powerful, but slow.  Templates such as cite core
 * suffers greatly from this.
 * 
 * 
 * Copyright (C) 2010 'Svip', 'MZMcBride' and others.
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 2 of the License, or
 * (at your option) any later version; or the DWTFYWWI License version 1, 
 * as detailed below.
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
 * -----------------------------------------------------------------
 *                          DWTFYWWI LICENSE
 *                      Version 1, January 2006
 *
 * Copyright (C) 2006 Ævar Arnfjörð Bjarmason
 *
 *                        DWTFYWWI LICENSE
 *  TERMS AND CONDITIONS FOR COPYING, DISTRIBUTION AND MODIFICATION
 * 0. The author grants everyone permission to do whatever the fuck they
 * want with the software, whatever the fuck that may be.
 * -----------------------------------------------------------------
 */

$wgExtensionCredits['parserhook'][] = array(
	'path'        => __FILE__,
	'name'        => 'Template Adventures',
	'author'      => array( 'Svip' ),
	'url'         => 'https://www.mediawiki.org/wiki/Extension:TemplateAdventures',
	'descriptionmsg' => 'ta-desc',
	'version'     => '0.3'
);


$dir = dirname(__FILE__);
$wgExtensionMessagesFiles['TemplateAdventures'] = "$dir/TemplateAdventures.i18n.php";
$wgExtensionMessagesFiles['TemplateAdventuresMagic'] = "$dir/TemplateAdventures.i18n.magic.php";

# Citation classes.
$wgAutoloadClasses['Citation'] = $dir . '/Templates/Citation.php';
$wgAutoloadClasses['CitationStyleWiki'] = $dir . '/Templates/CitationStyleWiki.php';
$wgAutoloadClasses['CitationStyleChicago'] = $dir . '/Templates/CitationStyleChicago.php';

$wgHooks['ParserFirstCallInit'][] = 'TemplateAdventures::onParserFirstCallInit';

$wgParserTestFiles[] = dirname( __FILE__ ) . "/taParserTests.txt";

class TemplateAdventures {
	
	public static function onParserFirstCallInit( $parser ) {
		$parser->setFunctionHook( 
			'ta_citation', 
			array( __CLASS__, 'citation' ), 
			SFH_OBJECT_ARGS 
		);
		return true;
	}

	/**
	 * Render {{#citation:}}
	 *
	 * @param $parser Parser
	 * @param $frame PPFrame_DOM
	 * @param $args Array
	 * @return wikicode parsed
	 */
	public static function citation( $parser, $frame, $args ) {
		if ( count( $args ) == 0 )
			return '';
		$style = self::getCitationStyle ( $frame, $args );
		switch ( strtolower( $style ) ) {
			case 'chicago':
				$obj = new CitationStyleChicago( $parser, $frame, $args );
				break;
			case 'wiki':
				# In the future, default: will depend on a global variable.
			default:
				$obj = new CitationStyleWiki( $parser, $frame, $args );
				break;
		}
		$obj->render();

		return $obj->output();
	}
	
	/**
	 * Find the style for a citation.  However, this usage means that arguments
	 * will in worse case scenarios always be run twice, which on heavy pages
	 * might decrease speed significantly.
	 *
	 * It might be possible to find a way to parse the data while finding the
	 * style, then transferring the found data to the new Style classes.  But
	 * for now, this will do.
	 *
	 * @param $frame The frame.
	 * @param $args The arguments.
	 * @return The style; if none found, it returns null.
	 */
	private static function getCitationStyle ( $frame, $args ) {
		foreach ( $args as $arg ) {
			if ( $arg instanceof PPNode_DOM ) {
				$bits = $arg->splitArg();
				$index = $bits['index'];
				if ( $index === '' ) { # Found
					$var = trim( $frame->expand( $bits['name'] ) );
					if ( strtolower( $var ) == 'style' )
						return trim( $frame->expand( $bits['value'] ) );
				}
			} else {
				$parts = array_map( 'trim', explode( '=', $arg, 2 ) );
				if ( count( $parts ) == 2 ) { # Found "="
					$var = $parts[0];
					if ( strtolower( $var ) == 'style' )
						return $parts[1];
				}
			}
		}
		return null;
	}
}

class TemplateAdventureBasic {
	
	protected $mParser;
	protected $mFrame;
	public $mArgs;
	protected $mOutput;
	
	/**
	 * Constructor
	 * @param $parser Parser
	 * @param $frame PPFrame_DOM
	 * @param $args Array
	 */
	public function __construct( &$parser, &$frame, &$args ){
		$this->mParser = $parser;
		$this->mFrame = $frame;
		$this->mArgs = $args;
	}

	/**
	 * Outputter
	 */
	public function output() {
		return $this->mOutput;
	}

	/**
	 * Do stuff.
	 */
	public function render() {
		return;
	}

	/**
	 * Read options from $this->mArgs.  Let the children handle the options.
	 */
	protected function readOptions ( ) {
		
 		$args = $this->mArgs;
 
		# an array of items not options
		$this->mReaditems = array();

		# first input is a bit different than the rest,
		# so we'll treat that differently
		$primary = trim( $this->mFrame->expand( array_shift( $args ) ) );
		$primary = $this->handlePrimaryItem( $primary );
		
		# check the rest for options
		foreach( $args as $arg ) {
			$item = $this->handleInputItem( $arg );
		}
	}

	/**
	 * This functions handles individual items found in the arguments,
	 * and decides whether it is an option or not.
	 * If it is, then it handles the option (and applies it).
	 * If it isn't, then it just returns the string it found. 
	 *
	 * @param $arg String Argument
	 * @return String if element, else return false
	 */
	protected function handleInputItem( $arg ) {
		if ( $arg instanceof PPNode_DOM ) {
			$bits = $arg->splitArg();
			$index = $bits['index'];
			if ( $index === '' ) { # Found
				$var = trim( $this->mFrame->expand( $bits['name'] ) );
				$value = trim( $this->mFrame->expand( $bits['value'] ) );
			} else { # Not found
				return trim( $this->mFrame->expand( $arg ) );
			}
		} else {
			$parts = array_map( 'trim', explode( '=', $arg, 2 ) );
			if ( count( $parts ) == 2 ) { # Found "="
				$var = $parts[0];
				$value = $parts[1];
			} else { # Not found
				return $arg;
			}
		}
		# Still here?  Then it must be an option
		return $this->optionParse( $var, $value );
	}

	/**
	 * This functions handles the primary item.  It is supposed to be
	 * overwriteable
	 *
	 * @param $arg String Argument
	 * @return String if understood, else return false
	 */
	protected function handlePrimaryItem( $arg ) {
		return false;
	}

	/**
	 * Parse the option.
	 * This should be rewritten in classes inheriting this class.
	 *
	 * @param $var
	 * @param $value
	 * @return False if option else element
	 */
	protected function optionParse( $var, $value ) {
		return $arg instanceof PPNode_DOM
			? trim( $this->mFrame->expand( $arg ) )
			: $arg;
	}

	/**
	 * Using magic to store all known names for each option
	 *
	 * @param $input String
	 * @return The option found; otherwise false
	 */
	protected function parseOptionName( $value ) {
		return false;
	}
}
