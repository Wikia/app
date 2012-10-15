<?php


/**
 * Handler for the #coordinates parser function
 */
class CoordinatesParserFunction {
	/**
	 * @var Parser
	 */
	private $parser;

	/**
	 * @var ParserOutput
	 */
	private $output;

	private $named = array(),
		$unnamed = array(),
		$info;

	/**
	 * Constructor
	 * @param Parser $parser: Parser object to associate with
	 */
	public function __construct( Parser $parser ) {
		$this->parser = $parser;
		$this->info = GeoData::getCoordInfo();
	}

	/**
	 * #coordinates parser function callback
	 * 
	 * @param Parser $parser
	 * @param PPFrame $frame
	 * @param Array $args
	 * @return Mixed
	 */
	public function coordinates( $parser, $frame, $args ) {
		if ( $parser != $this->parser ) {
			throw new MWException( __METHOD__ . '() called by wrong parser' );
		}
		$this->output = $parser->getOutput();
		if ( !isset( $this->output->geoData ) ) {
			$this->output->geoData = new CoordinatesOutput();
		}

		$this->unnamed = array();
		$this->named = array();
		$first = trim( $frame->expand( array_shift( $args ) ) );
		$this->addArg( $first );
		foreach ( $args as $arg ) {
			$bits = $arg->splitArg();
			$value = trim( $frame->expand( $bits['value'] ) );
			if ( $bits['index'] === '' ) {
				$this->named[trim( $frame->expand( $bits['name'] ) )] = $value;
			} else {
				$this->addArg( $value );
			}
		}
		$this->parseTagArgs();
		$status = GeoData::parseCoordinates( $this->unnamed, $this->named['globe'] );
		if ( $status->isGood() ) {
			$coord = $status->value;
			$status = $this->applyTagArgs( $coord );
			if ( $status->isGood() ) {
				$status = $this->applyCoord( $coord );
				if ( $status->isGood() ) {
					return '';
				}
			}
		}

		$parser->addTrackingCategory( 'geodata-broken-tags-category' );
		$errorText = $this->errorText( $status );
		if ( $errorText == '&lt;&gt;' ) {
			// Error that doesn't require a message,
			// can't think of a better way to pass this condition
			return '';
		}
		return array( "<span class=\"error\">{$errorText}</span>", 'noparse' => false );
	}

	/**
	 * Add an unnamed parameter to the list, turining it into a named one if needed
	 * @param String $value: Parameter
	 */
	private function addArg( $value ) {
		if ( isset( $this->info['primary'][$value] ) ) {
			$this->named['primary'] = true;
		} elseif ( preg_match( '/\S+?:\S*?([ _]+\S+?:\S*?)*/', $value ) ) {
			$this->named['geohack'] = $value;
		} elseif ( $value != '' ) {
			$this->unnamed[] = $value;
		}
	}

	/**
	 * Applies a coordinate to parser output
	 *
	 * @param Coord $coord
	 * @return Status: whether save went OK
	 */
	private function applyCoord( Coord $coord ) {
		global $wgMaxCoordinatesPerPage, $wgContLang;
		$geoData = $this->output->geoData;
		if ( $wgMaxCoordinatesPerPage >= 0 && $geoData->getCount() >= $wgMaxCoordinatesPerPage ) {
			if ( $geoData->limitExceeded ) {
				return Status::newFatal( '' );
			}
			$geoData->limitExceeded = true;
			return Status::newFatal( 'geodata-limit-exceeded',
				$wgContLang->formatNum( $wgMaxCoordinatesPerPage )
			);
		}
		if ( $coord->primary ) {
			if ( $geoData->getPrimary() ) {
				return Status::newFatal( 'geodata-multiple-primary' );
			} else {
				$geoData->addPrimary( $coord );
			}
		} else {
			$geoData->addSecondary( $coord );
		}
		return Status::newGood();
	}

	/**
	 *
	 * @param Coord $coord
	 */
	private function parseTagArgs() {
		global $wgDefaultGlobe, $wgContLang;
		// fear not of overwriting the stuff we've just received from the geohack param, it has minimum precedence
		if ( isset( $this->named['geohack'] ) ) {
			$this->named = array_merge( $this->parseGeoHackArgs( $this->named['geohack'] ), $this->named );
		}
		$this->named['globe'] = isset( $this->named['globe'] )
			? $wgContLang->lc( $this->named['globe'] )
			: $wgDefaultGlobe;
	}

	private function applyTagArgs( Coord $coord ) {
		global $wgContLang, $wgTypeToDim, $wgDefaultDim, $wgGeoDataWarningLevel, $wgGlobes ;
		$args = $this->named;
		$coord->primary = isset( $args['primary'] );
		$coord->globe = isset( $args['globe'] ) ? $wgContLang->lc( $args['globe'] ) : $wgDefaultGlobe;
		if ( !isset( $wgGlobes[$coord->globe] ) ) {
			if ( $wgGeoDataWarningLevel['unknown globe'] == 'fail' ) {
				return Status::newFatal( 'geodata-bad-globe', $coord->globe );
			} elseif ( $wgGeoDataWarningLevel['unknown globe'] == 'warn' ) {
				$this->parser->addTrackingCategory( 'geodata-unknown-globe-category' );
			}
		}
		$coord->dim = $wgDefaultDim;
		if ( isset( $args['type'] ) ) {
			$coord->type = preg_replace( '/\(.*?\).*$/', '', $args['type'] );
			if ( isset( $wgTypeToDim[$coord->type] ) ) {
				$coord->dim = $wgTypeToDim[$coord->type];
			} else {
				if ( $wgGeoDataWarningLevel['unknown type'] == 'fail' ) {
					return Status::newFatal( 'geodata-bad-type', $coord->type );
				} elseif ( $wgGeoDataWarningLevel['unknown type'] == 'warn' ) {
					$this->parser->addTrackingCategory( 'geodata-unknown-type-category' );
				}
			}
		}
		if ( isset( $args['scale'] ) ) {
			$coord->dim = $args['scale'] / 10;
		}
		if ( isset( $args['dim'] ) ) {
			$dim = $this->parseDim( $args['dim'] );
			if ( $dim !== false ) {
				$coord->dim = $dim;
			}
		}
		$coord->name = isset( $args['name'] ) ? $args['name'] : null;
		if ( isset( $args['region'] ) ) {
			$code = strtoupper( $args['region'] );
			if ( preg_match( '/^([A-Z]{2})(?:-([A-Z0-9]{1,3}))?$/', $code, $m ) ) {
				$coord->country = $m[1];
				$coord->region = isset( $m[2] ) ? $m[2] : null;
			} else {
				if ( $wgGeoDataWarningLevel['invalid region'] == 'fail' ) {
					return Status::newFatal( 'geodata-bad-region', $args['region'] );
				} elseif ( $wgGeoDataWarningLevel['invalid region'] == 'warn' ) {
					$this->parser->addTrackingCategory( 'geodata-unknown-region-category' );
				}
			}
		}
		return Status::newGood();
	}

	private function parseGeoHackArgs( $str ) {
		$result = array();
		$str = str_replace( '_', ' ', $str ); // per GeoHack docs, spaces and underscores are equivalent
		$parts = explode( ' ', $str );
		foreach ( $parts as $arg ) {
			$keyVal = explode( ':', $arg, 2 );
			if ( count( $keyVal ) != 2 ) {
				continue;
			}
			$result[$keyVal[0]] = $keyVal[1];
		}
		return $result;
	}

	private function parseDim( $str ) {
		if ( is_numeric( $str ) ) {
			return $str > 0 ? $str : false;
		}
		if ( !preg_match( '/^(\d+)(km|m)$/i', $str, $m ) ) {
			return false;
		}
		if ( strtolower( $m[2] ) == 'km' ) {
			return $m[1] * 1000;
		}
		return $m[1];
	}

	/**
	 * Returns wikitext of status error message in content language
	 *
	 * @param Status $s
	 * @return String
	 */
	private function errorText( Status $s ) {
		$errors = array_merge( $s->getErrorsArray(), $s->getWarningsArray() );
		if ( !count( $errors ) ) {
			return '';
		}
		$err = $errors[0];
		$message = array_shift( $err );
		return wfMessage( $message )->params( $err )->inContentLanguage()->plain();
	}
}

/**
 * Class that holds output of a parse opertion
 */
class CoordinatesOutput {
	public $limitExceeded = false;
	private $primary = false,
		$secondary = array();

	public function getCount() {
		return count( $this->secondary ) + ( $this->primary ? 1 : 0 );
	}

	public function addPrimary( Coord $c ) {
		if ( $this->primary ) {
			throw new MWException( 'Attempted to insert a second primary coordinate into ' . __CLASS__ );
		}
		$this->primary = $c;
	}

	public function addSecondary( Coord $c ) {
		if ( $c->primary ) {
			throw new MWException( 'Attempted to pass a primary coordinate into ' . __METHOD__ );
		}
		$this->secondary[] = $c;
	}

	public function getPrimary() {
		return $this->primary;
	}

	public function getSecondary() {
		return $this->secondary;
	}

	public function getAll() {
		$res = $this->secondary;
		if ( $this->primary ) {
			array_unshift( $res, $this->primary );
		}
		return $res;
	}
}