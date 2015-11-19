<?php

namespace Wikia\Sass\Compiler;
use Wikia\Sass\Source\Source;
use Wikia;

/**
 * LibSassCompiler implements a libsass PHP extension interface
 *
 * @author Maciej Brencz <macbre@wikia-inc.com>
 */
class LibSassCompiler extends Compiler {

	use Wikia\Logger\Loggable;

	private $sass;
	private $libSassVersion;

	protected $sassVariables = array();
	protected $rootDir;

	/**
	 * Create a new instance and configure it with provided options
	 *
	 * @param $options array
	 */
	public function __construct( $options = array() ) {
		parent::__construct( $options );

		$this->sass = new \Sass();
		$this->libSassVersion =  $this->sass->getLibraryVersion();

		# set SASS @import statements include path
		$this->sass->setIncludePath( $this->rootDir );
	}

	/**
	 * @return string SASS encoded variables
	 */
	private function getEncodedVariables() {
		$sassVariables = $this->sassVariables;

		# post-process SASS variables to encode strings properly
		array_walk(
			$sassVariables,
			function( &$item, $key ) {
				$item = $this->quoteIfNeeded( $item, $key );
			}
		);

		return self::encodeSassMap( $sassVariables );
	}

	/**
	 * Compile the given SASS source
	 *
	 * @param Source $source Sass source
	 * @throws Wikia\Sass\Exception
	 * @return string CSS stylesheet
	 */
	public function compile( Source $source ) {
		wfProfileIn( __METHOD__ );

		$sassVariables = $this->getEncodedVariables();

		// define get_command_line_param() function to get the SASS variables
		// @see http://sass-lang.com/documentation/file.SASS_REFERENCE.html#maps
		$sass = <<<SASS
@function get_command_line_param(\$varName, \$defaultValue){
	\$sassVariables: $sassVariables;

	@if map-has-key(\$sassVariables, \$varName) {
		@return map-get(\$sassVariables, \$varName);
	}
	@else {
		@return \$defaultValue;
	}
}
SASS;

		// import the file that we want to render
		global $IP;
		$sass .= sprintf( '@import "%s";', $source->getLocalFile() );

		$styles = $this->sass->compile( $sass );

		wfProfileOut( __METHOD__ );
		return $styles;
	}

	/**
	 * Return an array encoded as SASS map
	 *
	 * @see http://sass-lang.com/documentation/file.SASS_REFERENCE.html#maps
	 *
	 * @param array $map map to be encoded (key => value array)
	 * @return string map encoded for SASS
	 */
	public static function encodeSassMap( Array $map ) {
		$pairs = [];

		foreach ( $map as $key => $value ) {
			// properly encode empty strings
			if ( $value === '' ) {
				$value = '""';
			}

			$pairs[] = sprintf( '"%s": %s', $key, $value );
		}

		return sprintf( "(%s)", join( ', ', $pairs ) );
	}

	public function quoteIfNeeded( $item, $key ) {
		if ( !is_numeric( $item ) && strpos( $key, 'color' ) === false ) {
			// escape only single quotes, as they are used as wrappers for each $item
			$item = addcslashes( $item, "'" );
			$item = "'{$item}'";
		}
		return $item;
	}
}
