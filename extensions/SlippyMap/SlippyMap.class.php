<?php
/**
 * Classes for SlippyMap extension
 *
 * @file
 * @ingroup Extensions
 */

class SlippyMap {

	/* Fields */

	/**
	 * Our parser instance, passed from above
	 *
	 * @var object
	 */
	protected $parser;

	/**
	 * List of arguments that we use, parsed in this order.
	 */
	protected $argsList = array(
		/* Find out ASAP what mode we're in when parsing arguments */
		'mode',
		'layer',

		'lat',
		'lon',
		'zoom',

		'width',
		'height',

		'marker'
	);

	/**
	 * List of arguments that must be supplied
	 */
	protected $argsRequired = array(
		'lat',
		'lon'
	);

	/**
	 * An array of error messages that apply to our arguments as
	 * extracted from extractOptions.
	 *
	 * Here because we want to announce all problems with the
     * extension usage at once to the user instead of playing the fix
     * one parameter error at a time game.
	 *
	 * @var array
	 */
	protected $argsError = array();

	/* Functions */

	/**
	 * Constructor
	 *
	 * @param object $parser Parser instance
	 */
	public function __construct( $parser ) {
		$this->parser = $parser;
	}

	/**
	 * Extract and validate options from input and argv.
	 *
     * Returns a boolean indicating whether there were any errors
	 * during argument processing.
	 *
	 * @param string $input Parser hook input
	 * @param string $argv Parser hook arguments
	 * @return boolean
	 */
	public function extractOptions( $input, $args ) {
		wfProfileIn( __METHOD__ );

		if ( isset( $input ) ) {
			/* <slippymap> .*? </slippymap> or {{#tag:slippymap}}, not <slippymap/> */

			if ( ! preg_match( '~^ \s* $~x', $input ) ) {
				/**
				 * Only allow whitespace, we may want to do something
				 * with the content being passed to us in the
				 * future
				 */
				$this->argsError[] = wfMsg( 'slippymap_error_tag_content_given', wfMsg( 'slippymap_tagname' ) );
			}
		}

		/* No arguments */
		if ( count( $args ) == 0 ) {
			$this->argsError[] = wfMsg( 'slippymap_error_missing_arguments', wfMSg( 'slippymap_tagname' ) );

		/* Some arguments */
		} else {

			/* Make sure we have lat/lon/zoom */
			foreach ($this->argsRequired as $requiredArg) {
				if ( ! isset( $args[$requiredArg] ) ) {
					$this->argsError[] = wfMsg( 'slippymap_error_missing_attribute_' . $requiredArg );
				}
			}

			/* Keys that the user made up, this is a fatal error since
			 * we want to protect our namespace
			 */
			foreach ( array_keys( $args ) as $user_key ) {
				if ( ! in_array( $user_key, $this->argsList ) )
					$this->argsError[] = wfMsg( 'slippymap_error_unknown_attribute', $user_key );
			}

			/**
			 * Go through the list of options and add them to our
			 * fields if they validate, also adds default values.
			 */
			$this->populateArguments($args);
		}

		if ( count( $this->argsError ) == 0 ) {

			wfProfileOut( __METHOD__ );
			return true;
		} else {
			wfProfileOut( __METHOD__ );
			return false;
		}
	}

	private function populateArguments( $args ) {
		wfProfileIn( __METHOD__ );
		global $wgSlippyMapModes;
		global $wgLang;
		global $wgSlippyMapSizeRestrictions;

		foreach ($this->argsList as $key) {
			$has_val = isset( $args[$key] );
			$val = $has_val ? $args[$key] : null;

			/* mode */
			if ( $key === 'mode' ) {
				if ( ! $has_val ) {
					$modes = array_keys( $wgSlippyMapModes );
					$default_mode = $modes[0];

					$this->mode = $default_mode;
				} else {
					$modes = array_keys( $wgSlippyMapModes );
					if ( ! in_array( $val, $modes ) ) {
						$this->argsError[] = wfMsg(
							'slippymap_error_invalid_attribute_' . $key . '_value_not_a_mode',
							$val,
							$wgLang->listToText( array_map( array( &$this, 'addHtmlTT' ), $modes ) )
						);
						wfProfileOut( __METHOD__ );
						return null;
					} else {
						$this->mode = $val;
					}
				}
			}

			/* layer */
			if ( $key === 'layer' ) {
				if ( ! $has_val ) {
					$this->layer = $wgSlippyMapModes[$this->mode]['layers'][0];
				} else {
					$layers = $wgSlippyMapModes[$this->mode]['layers'];
					if ( ! in_array( $val, $layers ) ) {
						$this->argsError[] = wfMsg(
							'slippymap_error_invalid_attribute_' . $key . '_value_not_a_layer',
							$val,
							$wgLang->listToText( array_map( array( &$this, 'addHtmlTT' ), $layers ) )
						);
					} else {
						$this->layer = $val;
					}
				}
			}

			/* lat */
			if ( $key === 'lat' && $has_val ) {
				if ( ! preg_match( '~^ -? [0-9]{1,3} (?: \\. [0-9]{1,20} )? $~x', $val ) ) {
					$this->argsError[] = wfMsg( 'slippymap_error_invalid_attribute_' . $key . '_value_nan', $val );
				} else {
					if ( $val > 90 || $val < -90 ) {
						$this->argsError[] = wfMsg( 'slippymap_error_invalid_attribute_' . $key . '_value_out_of_range', $val );
					} else {
						$this->lat = $val;
					}
				}
			}

			/* lon */
			if ( $key === 'lon' && $has_val ) {
				if ( ! preg_match( '~^ -? [0-9]{1,3} (?: \\. [0-9]{1,20} )? $~x', $val ) ) {
					$this->argsError[] = wfMsg( 'slippymap_error_invalid_attribute_' . $key . '_value_nan', $val );
				} else {
					if ( $val > 180 || $val < -180 ) {
						$this->argsError[] = wfMsg( 'slippymap_error_invalid_attribute_' . $key . '_value_out_of_range', $val );
					} else {
						$this->lon = $val;
					}
				}
			}

			/* zoom */
			if ( $key === 'zoom' ) {
				if ( ! $has_val ) {
					$this->zoom = $wgSlippyMapModes[$this->mode]['defaultZoomLevel'];
				} else {
					if ( ! preg_match( '~^ [0-9]{1,2} $~x', $val ) ) {
						$this->argsError[] = wfMsg( 'slippymap_error_invalid_attribute_' . $key . '_value_nan', $val );
					} else {
						/* TODO: Make configurable depending on layer settings */
						$min_zoom = 0;
						$max_zoom = 18;

						/* Note: I'm not calling $wgLang->formatNum( $val ) here on purpose */
						if ( ( $val > $max_zoom || $val < $min_zoom ) ) {
							$this->argsError[] = wfMsg( 'slippymap_error_invalid_attribute_' . $key . '_value_out_of_range', $val, $min_zoom, $max_zoom );
						} else {
							$this->zoom = $val;
						}
					}
				}
			}

			/* width / height */
			if ( $key === 'width' || $key == 'height' ) {
				if ( ! $has_val ) {
					$thumbsize = self::getUserThumbSize();

					if ( $key === 'width' ) {
						$this->width  = $thumbsize;
					} elseif ( $key === 'height' ) {
						$this->height = $thumbsize * .72;
					}

					if ( substr( $this->$key, -2 ) == 'px' )
						$this->$key = (int) substr( $this->$key, 0, -2 );
				} else {
					if ( ! preg_match( '~^ [0-9]{1,20} $~x', $val ) ) {
						$this->argsError[] = wfMsg( 'slippymap_error_invalid_attribute_' . $key . '_value_nan', $val );
					} else {
						list ($min_width, $max_width)   = $wgSlippyMapSizeRestrictions['width'];
						list ($min_height, $max_height) = $wgSlippyMapSizeRestrictions['height'];

						if ( $key == 'width' && ( $val > $max_width || $val < $min_width ) ) {
							$this->argsError[] = wfMsg(
								'slippymap_error_invalid_attribute_' . $key . '_value_out_of_range',
								$val,
								$min_width,
								$max_width
							);
						} elseif ( $key == 'height' && ( $val > $max_height || $val < $min_height ) ) {
							$this->argsError[] = wfMsg(
								'slippymap_error_invalid_attribute_' . $key . '_value_out_of_range',
								$val,
								$min_width,
								$max_width
							);
						} else {
							$this->$key = $val;
						}
					}
				}
			}

			/* marker */
			if ( $key === 'marker' ) {
				if ( ! $has_val ) {
					$this->marker = 0;
				} else {
					if ( ! preg_match( '~^ (?: 0 | 1 ) $~x', $val ) ) {
						$this->argsError[] = wfMsg(
							'slippymap_error_invalid_attribute_' . $key . '_value_not_a_marker',
							$val,
							$wgLang->listToText( array_map( array( &$this, 'addHtmlTT' ), array( 0, 1 ) ) )
						);
					} else {
						$this->marker = $val;
					}
				}
			}
		}

		wfProfileOut( __METHOD__ );
	}

	private static function getUserThumbSize() {
		global $wgUser, $wgOut, $wgThumbLimits;

		return $wgThumbLimits[$wgUser->getOption( 'thumbsize' )];
	}

	/**
	 * Callback function for array_map to add <tt> to array elements.
	 */
	private static function addHtmlTT( $str ) {
		return "<tt>$str</tt>";
	}

	/**
	 * Return HTML output for the parser tag, hopefully a rendered map
	 * but if we've had any errors return an error message instead.
	 *
	 * @param int id
	 */
	public function render( $id ) {
		global $wgOut, $wgJsMimeType;
		global $wgSlippyMapModes;

		$mapcode = <<<EOT

			<script type="{$wgJsMimeType}">slippymaps.push(new slippymap_map($id, {
				mode: '{$this->mode}',
				layer: '{$this->layer}',
				lat: {$this->lat},
				lon: {$this->lon},
				zoom: {$this->zoom},
				width: {$this->width},
				height: {$this->height},
				marker: {$this->marker}
			}));</script>

			<!-- mapframe -->
			<div class="mapframe" style="width:{$this->width}px">
EOT;

		$static_rendering = $wgSlippyMapModes[$this->mode]['static_rendering'];
		if ( isset( $static_rendering ) ) {
			$mapcode .= self::getStaticMap( $id, $static_rendering );
		} else {
			$mapcode .= self::getDynamicMap( $id );
		}

		$mapcode .= <<<EOT

		<!-- /mapframe -->
		</div>
EOT;

		return $mapcode;
	}


	/**
	 * This generates dynamic map code
	 *
	 * @return string: containing dynamic map html code
	 */
	protected function getDynamicMap( $id ) {
		global $wgJsMimeType;
		$mapcode = <<<EOT
				<!-- map div -->
				<div id="map{$id}" class="map" style="width:{$this->width}px; height:{$this->height}px;">
					<script type="{$wgJsMimeType}">slippymaps[{$id}].init();</script>
				<!-- /map div -->
				</div>
EOT;
		return $mapcode;
	}

	/**
	 * This generates static map code
	 *
	 * @return string: containing static map html code
	 */
	protected function getStaticMap( $id, $static_rendering ) {
		$staticType				= $static_rendering['type'];
		$staticOptions			= $static_rendering['options'];

		$static = new $staticType($this->lat, $this->lon, $this->zoom, $this->width, $this->height, $staticOptions);
		$rendering_url = $static->getUrl();

		$clickToActivate = wfMsgHtml('slippymap_clicktoactivate');
		$mapcode = <<<EOT

				<!-- map div -->
				<div id="map{$id}" class="map" style="width:{$this->width}px; height:{$this->height}px;">
					<!-- Static preview -->
					<img
						id="mapPreview{$id}"
						class="mapPreview"
						src="{$rendering_url}"
						onclick="slippymaps[{$id}].init();"
						width="{$this->width}"
						height="{$this->height}"
						alt="Slippy Map"
						title="{$clickToActivate}"/>
				<!-- /map div -->
				</div>
EOT;

		return $mapcode;
	}

	/* /AIDS */

	/**
	 * Reads $this->argsError and returns HTML explaining what the
	 * user did wrong.
	 */
	public function renderErrors() {
		return $this->parser->recursiveTagParse( $this->errorHtml() );
	}

	protected function errorHtml() {
		if ( count( $this->argsError ) == 1 ) {
			return
				Xml::tags(
					'strong',
					array( 'class' => 'error' ),
					wfMsg( 'slippymap_error',
						   wfMsg( 'slippymap_extname' ),
						   $this->argsError[0]
					)
				);
		} else {
			$li = '';
			foreach ($this->argsError as $error) {
				$li .= Xml::tags(
					'li',
					array( 'class' => 'error' ),
					$error
				);
			}
			return
				Xml::tags(
					'strong',
					array( 'class' => 'error' ),
					wfMsgNoTrans( 'slippymap_errors', wfMsgNoTrans( 'slippymap_extname' ) )
					.
					Xml::tags(
						'ul',
						null,
						$li
					)
				);
		}
	}
}
