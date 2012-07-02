<?php

/**
 * Part of WikiCitation extension for Mediawiki.
 *
 * @ingroup WikiCitation
 * @file
 */

/**
 * Factory function, which parses the raw parser function arguments upon construction.
 * Class createWCStyle instantiates an appropriate child class based on the first
 * parameter after the colon.
 */
class WCArgumentReader {

	/**
	 * citation type
	 *
	 * note, biblio, or inline
	 * @var WCCitationTypeEnum
	 */
	public $citationType;

	/**
	 * Citation length
	 *
	 * long or short
	 * @var WCCitationLengthEnum
	 */
	public $citationLength;

	/**
	 * Array of flag values.
	 * @var array
	 */
	public $flags = array();
	/**
	 * Array of parameters values keyed to parameter names.
	 * @var array
	 */
	public $parameters = array();

	# The name of the style class (e.g., WCChicagoStyle)
	private $styleClassName;

	# private data
	private $parser;
	private $frame;
	private $args;
	private static $styleMagicWords;

	/**
	 * Static initializer.
	 */
	public static function init() {
		global $wgWCCitationStyles;
		$citationStyleList = array_keys( $wgWCCitationStyles );
		self::$styleMagicWords = new MagicWordArray( $citationStyleList );
	}

	/**
	 * Constructor. Parses the arguments, recognizes the citation style,
	 * and stores flags and parameters internally.
	 * @param PPFrame_DOM $frame
	 * @param array $args
	 */
	public function __construct(Parser $parser, PPFrame_DOM $frame, array $args) {
		$this->parser = $parser;
		$this->frame = $frame;
		$this->args = $args;

		$this->parseArguments();
	}

	/**
	 * Get the name of the style class.
	 * @return string|boolean
	 */
	public function getStyleClassName() {
		return $this->styleClassName;
	}


	public function isEmpty() {
		return empty( $this->parameters );
	}


	public function getCitationType() {
		return $this->citationType;
	}


	public function getCitationLength() {
		return $this->citationLength;
	}


	/**
	 * Parse options from $this->mArgs.
	 * Sets $this->citationStyle, $this->flags, and $this->parameters
	 * @internal
	 */
	private function parseArguments() {

		/**
		 * Parameter after the colon designates an explicit citation style.
		 * $this->arg[0] is a string, while the other arguments are of type
		 * PPNode_DOM. It is expanded anyway, in case the Parser class is
		 * revised in the future. See documentation for
		 * Parser::setFunctionHook().
		 * @var
		 */
		$firstArg = reset( $this->args );
		$style = trim( $this->frame->expand( $firstArg ) );
		$this->styleClassName = $this->matchStyleClassName( $style );

		# Check args for initial flags after the colon, but prior to any named parameters.
		while (( $arg = next( $this->args ) ) !== False) {
			list( $var, $value ) = $this->parseArgument( $arg );
			if ($var) {
				$this->parameters[$var] = $value;
				break;
			}
			$this->flags[] = $value;
		}

		# Match the flags and set defaults.
		$this->matchFlags();

		# From now on, only look for named parameters.
		while (( $arg = next( $this->args ) ) !== False) {
			list( $var, $value ) = $this->parseArgument($arg);
			if (!$var) {
				continue;
			}
			$this->parameters[$var] = $value;
		}
	}

	/**
	 * Parses an argument to extract a variable and/or a value
	 *
	 * @internal
	 * @param PPNode_DOM $arg Argument
	 * @return array a tuple of the variable (if exists) its corresponding value
	 */
	protected function parseArgument( PPNode_DOM $arg ) {
		/* if ( $arg instanceof PPNode_DOM ) { # See below: */
		$bits = $arg->splitArg();
		$index = $bits['index'];
		if ($index === '') {
			# Found
			$var = trim($this->frame->expand($bits['name']));
			$value = trim($this->frame->expand($bits['value']));
		} else { # Not found
			$var = Null;
			$value = trim($this->frame->expand($arg));
		}
		/* This commented-out code would be required if $this->arg[0]
		 * were passed to this function, since that argument is pre-expanded
		 * and not a PPNode_DOM object, at least in the version of MediaWiki
		 * when this was written.
		  } else {
		  $parts = array_map('trim', explode( '=', $arg, 2 ) );
		  if ( count( $parts ) == 2 ) {
		  # Found "="
		  $var = $parts[ 0 ];
		  $value = $parts[ 1 ];
		  } else {
		  # Not found
		  $var = NULL;
		  $value = $arg;
		  }
		  }
		 */
		return array( $var, $value );
	}


	protected static function matchStyleClassName( $styleText ) {
		if ( $styleText ) {
			$styleID = self::$styleMagicWords->matchStartToEnd( $styleText );
			if ( $styleID === False && $wikiCitationValidateArguments ) {
				throw new WCException( 'wc-style-not-recognized', $styleText );
			}
			global $wgWCCitationStyles;
			return $wgWCCitationStyles[ $styleID ];
		} else {
			return Null;
		}
	}


	/**
	 * Recognize and process the flags.
	 *
	 * @global type $wikiCitationValidateArguments
	 */
	protected function matchFlags() {
		global $wikiCitationValidateArguments;
		foreach( $this->flags as $flag ) {
			# Match flag for citation type.
			$citationType = WCCitationTypeEnum::match( $flag );
			if ( $citationType ) {
				$this->citationType = $citationType;
				continue;
			}
			# Match flag for citation length.
			$citationLength = WCCitationLengthEnum::match( $flag );
			if ( $citationLength ) {
				$this->citationLength = $citationLength;
				continue;
			}
			# If the function encounters an unknown flag, an error is thrown.
			if ( $wikiCitationValidateArguments ) {
				throw new WCException( 'wc-flag-unknown', $flag );
			}
		}

		# Throw exception for explicit "short bibliography" citation.
		if ( isset( $this->citationLength )
			&& isset( $this->citationLength )
			&& $this->citationLength->key == WCCitationLengthEnum::short
			&& $this->citationType->key == WCCitationTypeEnum::biblio
			&& $wikiCitationValidateArguments )
		{
			if ( $wikiCitationValidateArguments) {
				throw new WCException(
					'wc-incompatible-flags',
					new WCCitationLengthEnum( WCCitationLengthEnum::short ),
					new WCCitationTypeEnum( WCCitationTypeEnum::biblio )
				);
			} else {
				$this->citationLength->key = WCCitationLengthEnum::long;
			}
		}

	}


}


/**
 * Static initializer.
 */
WCArgumentReader::init();
