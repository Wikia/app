<?php

/**
 * Main class for the Babel extension.
 *
 * @addtogroup Extensions
 */

class Babel {

	/**
	 * Define the three posisble genders as constants.
	 */
	const GENDER_FEMALE = 1;
	const GENDER_MALE   = 2;
	const GENDER_NEUTER = 0;

	/**
	 * Various values from the message cache.
	 */
	private $_prefixes, $_suffixes, $_cellspacing, $_directionality, $_url,
		$_title, $_footer;

	/**
	 * Whether or not male, female or neuter messages should be prefered.
	 */
	private $_gender = self::GENDER_NEUTER;

	/**
	 * Array: Language codes.
	 */
	private $_codes;

	/**
	 * Array: Preferred usageorder of ISO language code standards.
	 */
	private $_order = array(
		'ISO_639_1',
		'ISO_639_3',
	);

	/**
	 * Load the language codes from an array of standards to files into the
	 * language codes array.
	 *
	 * @param $file Array: Files to load language codes from.
	 */
	public function __construct( $files ) {

		// Loop through all standards.
		foreach( $this->_order as $standard ) {

			// Load file for the current standard.
			$this->_loadCodes( $standard, $files[ $standard ] );

		}

	}

	/**
	 * Render the Babel tower.
	 *
	 * @param $parser Object: Parser.
	 * @return string: Babel tower.
	 */
	public function Render( $parser ) {

		// Store all the parameters passed to this function in an array.
		$parameters = func_get_args();

		// Remove the first parameter (the parser object), the rest correspond
		// to the parameters passed to the babel parser function.
		unset( $parameters[ 0 ] );

		// Load the extension messages in basic languages (en, content and
		// user).
		wfLoadExtensionMessages( 'Babel' );

		// Load various often used messages into the message member variables.
		$this->_getMessages();

		// Parse the options and provide an array.
		$options = $this->_parseOptions( $parameters );

		// Process gender stuff.
		$this->_setGender( $options );

		// Do a link batch on all the parameters so that their information is
		// cached for use later on.
		$this->_doTemplateLinkBatch( $parameters );

		// Initialise an empty string for storing the contents of the tower.
		$contents = '';

		// Loop through each of the input parameters.
		foreach( $parameters as $name ) {

			// Check if the parameter is a valid template name, if it is then
			// include that template.
			if( $this->_templateExists( $name ) && $name !== '' ) {

				$contents .= $parser->replaceVariables( "{{{$this->_addFixes( $name,'template' )}}}" );

			} elseif( $chunks = $this->_parseParameter( $name ) ) {

				$contents .= $this->_generateBox(        $chunks[ 'code' ], $chunks[ 'level' ] );
				$contents .= $this->_generateCategories( $chunks[ 'code' ], $chunks[ 'level' ] );

			} elseif( $this->_validTitle( $name ) ) {

				// Non-existant page and invalid parameter syntax, red link.
				$contents .= "\n[[Template:{$this->_addFixes( $name,'template' )}]]";

			} else {

				// Invalid title, output raw.
				$contents .= "\nTemplate:{$this->_addFixes( $name,'template' )}";

			}

		}

		// Prepare footer row, if a footer is set.
		if( $this->_footer != '' ) {

			$footer = 'class="mw-babel-footer" | ' . $this->_footer;

		} else {

			$footer = '';

		}

		// Generate tower, filled with contents from loop.
		$r = <<<HEREDOC
{| cellspacing="{$this->_cellspacing}" class="mw-babel-wrapper"
! [[{$this->_url}|{$this->_top}]]
|-
| $contents
|-
$footer
|}
HEREDOC;

		// Outupt tower.
		return $r;


	}

	/**
	 * Get the main messages used by Babel (e.g. prefixes and suffixes etc.)
	 * and load them into several variables.
	 */
	private function _getMessages() {

		// Create an array of all prefixes.
		$this->_prefixes = array(
			'category' => wfMsgForContent( 'babel-category-prefix' ),
			'template' => wfMsgForContent( 'babel-template-prefix' ),
			'portal'   => wfMsgForContent( 'babel-portal-prefix'   ),
		);

		// Create an array of all suffixes.
		$this->_suffixes = array(
			'category' => wfMsgForContent( 'babel-category-suffix' ),
			'template' => wfMsgForContent( 'babel-template-suffix' ),
			'portal'   => wfMsgForContent( 'babel-portal-suffix'   ),
		);

		// Miscellaneous messages.
		$this->_url            = wfMsgForContent( 'babel-url'             );
		$this->_top            = wfMsgForContent( 'babel'                 );
		$this->_footer         = wfMsgForContent( 'babel-footer'          );
		$this->_directionality = wfMsgForContent( 'babel-directionality'  );
		$this->_cellspacing    = wfMsgForContent( 'babel-box-cellspacing' );

	}

	/**
	 * Adds prefixes and suffixes for a particular type to the string.
	 *
	 * @param $string String: Value to add prefixes and suffixes too.
	 * @param $type String: Type of prefixes and suffixes (template/portal/category).
	 * @return String: Value with prefixes and suffixes added.
	 */
	private function _addFixes( $string, $type ) {

		return $this->_prefixes[ $type ] . $string . $this->_suffixes[ $type ];

	}

	/**
	 * Performs a link batch on a series of templates.
	 *
	 * @param $parameters Array: Templates to perform the link batch on.
	 */
	private function _doTemplateLinkBatch( $parameters ) {

		// Prepare an array, this will be used to store the title objects for
		// each of the parameters.
		$titles = array();

		// Loop through the array passed to this function and generate a title
		// object for each, then add that title object to the title object
		// array if it is an object (invalid page names generate NULL rather
		// than a valid title object.
		foreach( $parameters as $name ) {

			// Create the title object.
			$title = Title::newFromText( $this->_addFixes( $name,'template' ), NS_TEMPLATE );

			// Check if the title object was created sucessfully.
			if( is_object( $title ) ) {

				// It was, add it to the array of title objects.
				$titles[] = $title;

			}

		}

		// Create the link batch object for the array of title objects that has
		// been generated.
		$batch = new LinkBatch( $titles );

		// Execute the link batch.
		$batch->execute();

	}

	/**
	 * Run through the array of parameters and generate an array of options
	 * (all parameters starting with a '#') and unset them from the parameters
	 * array.
	 * 
	 * @param $parameters Array: Parameters passed to the parser function.
	 * @return Array: All options with the options as keys.
	 */
	private function _parseOptions( array &$parameters ) {

		// Open empty options array.
		$options = array();

		// Get list of all options.
		foreach( $parameters as $index => $value ) {

			// Classed as option if the parameter begins with a # and has at
			// least one other character.
			if( strpos( $value, '#' ) === 0 && strlen( $value ) > 1 ) {

				// Add to options array as a key, this is so that each option
				// only gets registered once.
				$options[ substr( $value, 1 ) ] = true;

				// Unset it from the parameters array so it does not get
				// processed as a box.
				unset( $parameters[ $index ] );

			}

		}

		// Return the array of options.
		return $options;

	}

	/**
	 * Identify what gender has been specified within the function.
	 * 
	 * @param $options Array: Options.
	 */
	private function _setGender( array $options ) {

		// Identify whether #female or #male have been specified as options and
		// set gender as appropriate.
		if( array_key_exists( 'female', $options ) ) {

			$this->_gender = self::GENDER_FEMALE;

		} elseif( array_key_exists( 'male', $options ) ) {

			$this->_gender = self::GENDER_MALE;
	
		} else {

			$this->_gender = self::GENDER_NEUTER;

		}

	}

	/**
	 * Identify whether or not the template exists or not.
	 *
	 * @param $title String: Name of the template to check.
	 * @return Boolean: Indication of whether the template exists.
	 */
	private function _templateExists( $title ) {

		// Make title object from the templates title.
		$titleObj = Title::newFromText( $this->_addFixes( $title,'template' ), NS_TEMPLATE );

		// If the title object has been created (is of a valid title) and the template
		// exists return true, otherwise return false.
		return ( is_object( $titleObj ) && $titleObj->exists() );

	}

	/**
	 * Identify whether or not the passed string would make a valid title.
	 *
	 * @param $title string: Name of title to check.
	 * @return Boolean: Indication of whether or not the title is valid.
	 */
	private function _validTitle( $title ) {

		// Make title object from the templates title.
		$titleObj = Title::newFromText( $this->_addFixes( $title, 'template' ), NS_TEMPLATE );

		// If the title object has been created (is of a valid title) return true.
		return is_object( $titleObj );

	}

	/**
	 * Parse a parameter, getting a language code and level.
	 *
	 * @param $parameter String: Parameter.
	 * @return Array: { 'code' => xx, 'level' => xx }
	 */
	private function _parseParameter( $parameter ) {

		// Break up the parameter on - (which seperates it's two parts).
		$chunks = explode( '-', $parameter );

		// Initialise the return array.
		$return = array();

		// Actually parse the parameter.
		if( count( $chunks ) == 1 ) {

			// The parameter is in the form 'xx'.

			// Check whether the language code is valid.
			if( $this->_checkCode( $chunks[ 0 ] ) ) {

				// Set the code for returning.
				$return[ 'code' ] = $this->_getCode( $chunks[ 0 ] );

				// This form defaults to level 'N'.
				$return[ 'level' ] = 'N';

				// Everything needed has been gathered, return.
				return $return;

			} else {

				// Invalid language code, return false.
				return false;

			}

		} elseif( count( $chunks ) == 2 ) {

			// The parameter is in the form 'xx-x'.

			// Check whether the language code is valid.
			if( $this->_checkCode( $chunks[ 0 ] ) ) {

				// Set the code for returning.
				$return[ 'code' ] = $this->_getCode( $chunks[ 0 ] );

			} else {

				// Invalid language code, return false.
				return false;

			}

			// Check whether the level is valid.
			if( strtoupper( $chunks[ 1 ] ) == 'N' ) {

				$return[ 'level' ] = 'N';

			} elseif( $chunks[ 1 ] >= 0 && $chunks[ 1 ] <= 5 ) {

				$return[ 'level' ] = $chunks[ 1 ];

			} else {

				// Invalid language code.
				return false;

			}

			// Parameters decided, return parameters.
			return $return;

		} else {

			// Invalid parameters.
			return false;

		}

	}

	/**
	 * Generate a babel box for the given language and level.
	 *
	 * @param $code String: Language code to use.
	 * @param $level String or Integer: Level of ability to use.
	 */
	private function _generateBox( $code, $level ) {

		// Get code in favoured standard.
		$code = $this->_getCode( $code );

		// Generate the text displayed on the left hand side of the
		// box.
		$header = "[[{$this->_addFixes( $code,'portal' )}|$code]]-$level";

		// Get MediaWiki supported language codes\names.
		$nativeNames = Language::getLanguageNames();

		// Load extension messages for box language and it's fallback if it is
		// a valid MediaWiki language.
		if( array_key_exists( $code, $nativeNames ) ) {
			wfLoadExtensionMessages( 'Babel', $code );
			wfLoadExtensionMessages( 'Babel', Language::getFallbackFor( $code ) );
		}

		// Get the language names.
		if( class_exists( 'LanguageNames' ) ) {
			$names = LanguageNames::getNames( $code );
		} else {
			$names = $nativeNames;
		}

		// Ensure the language code has a corresponding name.
		if( array_key_exists( $code, $names ) ) {
			$name = $names[ $code ];
		} else {
			$name = $this->_nameCode( $code, 'en' );
		}

		// Generate the text displayed on the right hand side of the
		// box.
		$text = $this->_getText( $name, $code, $level );

		// Get the directionality for the current language.
		$dir = wfMsgExt( "babel-directionality",
			array( 'language' => $code )
		);

		// Generate box and add return.
		return <<<HEREDOC
<div class="mw-babel-box mw-babel-box-$level" dir="{$this->_directionality}">
{| cellspacing="{$this->_cellspacing}"
!  dir="{$this->_directionality}" | $header
|  dir="$dir" | $text
|}
</div>
HEREDOC;

	}

	/**
	 * Get the text to display in the language box for specific language and
	 * level.
	 * 
	 * @param $language String: Language code of language to use.
	 * @param $level String: Level to use.
	 * @return String: Text for display, in wikitext format.
	 */
	private function _getText( $name, $language, $level ) {

		// If gender not neuter then try getting the gender specific message.
		if( $this->_gender === self::GENDER_FEMALE ) {

			// Try the language of the box in female.
			$text = wfMsgExt( "babel-$level-n-female",
				array( 'language' => $language ),
				":Category:{$this->_addFixes( "$language-$level",'category' )}",
				":Category:{$this->_addFixes( $language,'category' )}"
			);
		
			// Get the fallback message for comparison in female.
			$fallback = wfMsgExt( "babel-$level-n-female",
				array( 'language' => Language::getFallbackfor( $language ) ),
				":Category:{$this->_addFixes( "$language-$level",'category' )}",
				":Category:{$this->_addFixes( $language,'category' )}"
			);
		
			// Translation not found, use the generic translation of the
			// highest level fallback possible in female.
			if( $text == $fallback ) {
		
				$text = wfMsgExt( "babel-$level-female",
					array( 'language' => $language ),
					":Category:{$this->_addFixes( "$language-$level",'category')}",
					":Category:{$this->_addFixes( $language,'category' )}",
					$name
				);
		
			}

			// Not empty, return.
			if( $text != '' ) {
		
				return $text;
		
			}

		} elseif( $this->_gender === self::GENDER_MALE ) {

			// Try the language of the box in male.
			$text = wfMsgExt( "babel-$level-n-male",
				array( 'language' => $language ),
				":Category:{$this->_addFixes( "$language-$level",'category' )}",
				":Category:{$this->_addFixes( $language,'category' )}"
			);
		
			// Get the fallback message for comparison in male.
			$fallback = wfMsgExt( "babel-$level-n-male",
				array( 'language' => Language::getFallbackfor( $language ) ),
				":Category:{$this->_addFixes( "$language-$level",'category' )}",
				":Category:{$this->_addFixes( $language,'category' )}"
			);
		
			// Translation not found, use the generic translation of the
			// highest level fallback possible in male.
			if( $text == $fallback ) {
		
				$text = wfMsgExt( "babel-$level-male",
					array( 'language' => $language ),
					":Category:{$this->_addFixes( "$language-$level",'category')}",
					":Category:{$this->_addFixes( $language,'category' )}",
					$name
				);
		
			}

			// Not empty, return.
			if( $text != '' ) {
		
				return $text;
		
			}

		}

		// Try the language of the box.
		$text = wfMsgExt( "babel-$level-n",
			array( 'language' => $language ),
			":Category:{$this->_addFixes( "$language-$level",'category' )}",
			":Category:{$this->_addFixes( $language,'category' )}"
		);

		// Get the fallback message for comparison.
		$fallback = wfMsgExt( "babel-$level-n",
			array( 'language' => Language::getFallbackfor( $language ) ),
			":Category:{$this->_addFixes( "$language-$level",'category' )}",
			":Category:{$this->_addFixes( $language,'category' )}"
		);

		// Translation not found, use the generic translation of the
		// highest level fallback possible.
		if( $text == $fallback ) {

			$text = wfMsgExt( "babel-$level",
				array( 'language' => $language ),
				":Category:{$this->_addFixes( "$language-$level",'category')}",
				":Category:{$this->_addFixes( $language,'category' )}",
				$name
			);

		}

		return $text;

	}

	/**
	 * Generate categories for the given language and level.
	 *
	 * @param $code String: Language code to use.
	 * @param $level String or Integer: Level of ability to use.
	 */
	private function _generateCategories( $code, $level ) {

		// Get whether or not to use main categories.
		global $wgBabelUseMainCategories;

		// Get whether or not to use level zero categories.
		global $wgBabelUseLevelZeroCategory;

		// Get whether or not to use simple categories.
		global $wgBabelUseSimpleCategories;

		// Get user object.
		global $wgUser;

		// Intialise return value.
		$r = '';

		// Add to main language category if the level is not zero.
		if( $wgBabelUseMainCategories && ( $level === 'N' || ( $wgBabelUseLevelZeroCategory && $level === 0 ) || $level > 0 ) ) {

			// Add category wikitext to box tower.
			$r .= "[[Category:{$this->_addFixes( $code,'category' )}|$level{$wgUser->getName()}]]";

		}

		// Add to level categories, only adding it to the level 0
		// one if it is set to be used.
		if( !$wgBabelUseSimpleCategories && ( $level === 'N' || ( $wgBabelUseLevelZeroCategory && $level === 0 ) || $level > 0 ) ) {

			// Add category wikitext to box tower.
			$r .= "[[Category:{$this->_addFixes( "$code-$level",'category' )}|{$wgUser->getName()}]]";

		}

		// Return categories.
		return $r;

	}

	/**
	 * Load the language codes from a given file into the language codes array.
	 *
	 * @param $standard Integer: Standard for the codes being loaded.
	 * @param $file String: File to load language codes from.
	 */
	private function _loadCodes( $standard, $file ) {

		// Include the codes file.
		include( $file );

		// Push the array of codes into the class method.
		$this->_codes[ $standard ] = $codes;

	}

	/**
	 * Check if the specified code is a valid language code.
	 *
	 * @param $code String: Code to check.
	 * @return Boolean: Whether or not the code is valid.
	 */
	private function _checkCode( $code ) {

		// Check if the specified code has a key in the codes array for each of the
		// standards and return result.
		foreach( $this->_order as $index ) {

			if( array_key_exists( strtolower( $code ), $this->_codes[ $index ] ) ) {
				return true;
			}

		}

	}

	/**
	 * Get the language code to use for a specific language, in the highest
	 * ordered standard possible.
	 *
	 * @param $code String: Code to get language code for.
	 * @return String: Correct code.
	 */
	private function _getCode( $code ) {

		// Loop through all the standards trying to find the language code
		// specified.
		foreach( $this->_order as $standard1 ) {

			if( array_key_exists( strtolower( $code ), $this->_codes[ $standard1 ] ) ) {

				// Loop through all the standards again to find the highest
				// level alternate code.
				foreach( $this->_order as $standard2 ) {

					if( $standard1 == $standard2 ) {

							return $code;

					} elseif( array_key_exists( $standard2, $this->_codes[ $standard1 ][ $code ] ) ) {

							return $this->_codes[ $standard1 ][ $code ][ $standard2 ];

					}

				}

			}

		}

		// Nothing found, return input.
		return $code;

	}

	/**
	 * Get the name of a language in a specific language (currently only eng
	 * supported until a index of ISO 639-1 is built with language names).
	 *
	 * @param $code String: Code to get name for.
	 * @param $lang String: Language to get name of code in.
	 * @return String: Name of language in specified language.
	 */
	private function _nameCode( $code, $lang = 'eng' ) {

		$code = $this->_getCode( $code );

		if( array_key_exists( $code, $this->_codes[ 'ISO_639_3' ] ) && array_key_exists( "name_$lang", $this->_codes[ 'ISO_639_3' ][ $code ] ) ) {
			return $this->_codes[ 'ISO_639_3' ][ $code ][ "name_$lang" ];
		}

		// Nothing found, return input.
		return $code;

	}

}