<?php
/**
 * UI Class for DataCenter extension
 *
 * @file
 * @ingroup Extensions
 */

class DataCenterCss {

	/* Static Functions */

	public static function toAttributes( array $attributes ) {
		$cssOutput = '';
		foreach( $attributes as $name => $value ) {
			if ( !is_int( $name ) ) {
				$cssOutput = $name . ':' . $value . ';';
			}
		}
		return $cssOutput;
	}
}

class DataCenterJs {

	/* Static Functions */

	public static function chain( $functions, $end = true ) {
		$jsFunctions = array();
		foreach( $functions as $name => $arguments ) {
			if ( is_int( $name ) ) {
				$jsFunctions[] = sprintf( '%s()', $arguments );
			} elseif ( is_array( $arguments ) ) {
				$jsFunctions[] = sprintf(
					'%s(%s)', $name, implode( ',', $arguments )
				);
			} else {
				$jsFunctions[] = sprintf( '%s(%s)', $name, $arguments );
			}
		}
		return implode( '.', $jsFunctions ) . ( $end ? ';' : '' );
	}

	/**
	 * Escapes a JavaScript string to make it safe to use anywhere
	 * @param $string String: String to escape
	 */
	public static function escape( $string ) {
		return Xml::escapeJSString( $string );
	}

	/**
	 * Converts a PHP value to a javascript object
	 * @param	value			Associative Array to convert
	 */
	public static function toObject( $values ) {
		// Arrays
		if ( is_array( $values ) ) {
			$jsValues = array();
			foreach( $values as $key => $value ) {
				if ( is_array( $value ) ) {
					$jsValues[] = $key . ':' . self::toObject( $value );
				} else {
					$jsValues[] = $key . ':' . self::toScalar( $value );
				}
			}
			return '{' . implode( ',', $jsValues ) . '}';
		}
		return 'null';
	}

	/**
	 * Converts a PHP value to a javascript array
	 * @param	value			Array or Scalar to convert
	 */
	public static function toArray( $values ) {
		// Arrays
		if ( is_array( $values ) ) {
			$jsValues = array();
			foreach( $values as $value ) {
				$jsValues[] = self::toScalar( $value );
			}
			return '[' . implode( ',', $jsValues ) . ']';
		}
		// Scalars
		if ( is_scalar( $values ) ) {
			return '[' . self::toScalar( $values ) . ']';
		}
		return 'null';
	}

	/**
	 * Converts a PHP value to a javascript value
	 * @param	value			Array or Scalar to convert, if value is string
	 * 							it will be escaped and surrounded by quotes
	 * 							unless it is already surrounded by ' quotes,
	 * 							in which case the ' quotes will be removed and
	 * 							the value will be used as a statement
	 */
	public static function toScalar( $value ) {
		// Arrays
		if ( is_array( $value ) ) {
			return "'" . self::escape( implode( $value ) ) . "'";
		}
		// Scalars
		if ( is_scalar( $value ) ) {
			// Numbers
			if ( is_numeric( $value ) ) {
				return $value;
			}
			// Strings
			if ( is_string( $value ) ) {
				// Checks if string is surrouded with ' quotes
				if (
					substr( $value, 0, 1 ) == "'" &&
					substr( $value, -1, 1 ) == "'"
				) {
					// Formats as statement
					return trim( $value, "'" );
				} else {
					// Formats as string
					return "'" . self::escape( $value ) . "'";
				}
			}
			// Booleans
			if ( is_bool( $value ) ) {
				return $value ? 'true' : 'false';
			}
			// Nulls
			if ( is_null( $value ) ) {
				return 'null';
			}
		}
		return 'null';
	}

	/**
	 * Builds an annonomous javascript function declaration
	 * @param $arguments Array: array of argument names to accept
	 * @param $body String: code for body
	 */
	public static function buildFunction( $arguments, $body ) {
		if ( is_array( $arguments ) ) {
			return sprintf(
				'function(%s){%s}', implode( ',', $arguments ), $body
			);
		} elseif ( $arguments !== null ) {
			return sprintf( 'function(%s){%s}', $arguments, $body );
		} else {
			return sprintf( 'function(){%s}', $body );
		}
	}

	/**
	 * Builds an annonomous javascript function declaration
	 * @param $prototype String
	 * @param $arguments Array: array of argument names to accept
	 */
	public static function buildInstance( $prototype, $arguments = array() ) {
		if ( !is_array( $arguments ) ) {
			$arguments = array( $arguments );
		}
		return sprintf(
			'new %s(%s)', $prototype, implode( ',', $arguments )
		);
	}

	/**
	 * Creates code to call a javascript function
	 * @param	function		String of name of function
	 * @param	arguments		Array of argument values to pass
	 */
	public static function callFunction(
		$function,
		$arguments = array(),
		$end = true
	) {
		if ( !is_array( $arguments ) ) {
			$arguments = array( $arguments );
		}
		return sprintf(
			'%s(%s)', $function, implode( ',', $arguments )
		) . ( $end ? ';' : '' );
	}

	public static function declareVar( $name, $value = 'null', $end = true ) {
		return sprintf( 'var %s=%s', $name, $value ) . ( $end ? ';' : '' );
	}

	public static function declareVars( array $vars, $end = true ) {
		$jsOutput = '';
		foreach( $vars as $name => $value ) {
			if ( is_int( $name ) ) {
				$name = $value;
				$value = 'null';
			}
			$jsOutput .= sprintf(
				'var %s=%s', $name, $value
			) . ( $end ? ';' : '' );
		}
		return $jsOutput;
	}

	public static function declareInstance(
		$name,
		$prototype,
		$arguments = array(),
		$end = true
	) {
		if ( !is_array( $arguments ) ) {
			$arguments = array( $arguments );
		}
		return sprintf(
			'%s=new %s(%s)',
			$name,
			$prototype,
			implode( ',', $arguments )
		) . ( $end ? ';' : '' );
	}

	/**
	 * Builds JavaScript effect
	 * @param	options			Array of effect parameters containing...
	 * 			script			JavaScript to run, with sprintf syntax for
	 * 							including fields in the order listed
	 * 			field			Singular form of fields
	 * 			fields			Array of fields to supply to sprintf function
	 * 							providing a way to get field information,
	 * 							accessable to javascript in order given
	 *
	 * Example:
	 * 		array(
	 * 			'script' => 'alert( 'Row ID: ' + %d )',
	 * 			'field' =>  'id'
	 * 		)
	 * @param	row				DataCenterDBRow object from which to extract
	 * 							fields from
	 */
	public static function buildEffect( $script, $fields = null ) {
		// Checks for...
		if (
			// Required types
			( is_array( $fields ) ) &&
			// Required values
			( $script !== null )
		) {
			// Loops over each field
			foreach ( $fields as $field => $value ) {
				// Replaces reference with value
				$script = str_replace( '{' . $field . '}', $value, $script );
			}
			// Returns processed script
			return $script;
		} else {
			// Returns unprocessed script
			return $script;
		}
	}
}

class DataCenterXml {

	/* Private Static Members */

	/**
	 * Cached value of the DataCenter special page full URL
	 */
	private static $urlBase;

	/* Static Functions */

	/**
	 * Builds an XML string for a complete table tag
	 * @param	attributes		Optional Array of XML attributes
	 * @param	content...		Any number of Strings of XML content
	 */
	public static function table() {
		$arguments = func_get_args();
		$attributes = array(
			'cellpadding' => 0, 'cellspacing' => 0, 'border' => 0,
		);
		if ( count( $arguments ) > 0 && is_array( $arguments[0] ) ) {
			$attributes = array_merge( $attributes, $arguments[0] );
			array_shift( $arguments );
		}
		if ( count( $arguments ) > 0 ) {
			return self::tag( 'table', $attributes, implode( $arguments ) );
		}
		return null;
	}

	/**
	 * Builds an XML string for a complete table row tag
	 * @param	attributes		Optional Array of XML attributes
	 * @param	content...		Any number of Strings of XML content
	 */
	public static function row() {
		$arguments = func_get_args();
		$attributes = array();
		if ( count( $arguments ) > 0 && is_array( $arguments[0] ) ) {
			$attributes = array_merge( $attributes, $arguments[0] );
			array_shift( $arguments );
		}
		if ( count( $arguments ) > 0 ) {
			return self::tag( 'tr', $attributes, implode( $arguments ) );
		}
		return null;
	}

	/**
	 * Builds an XML string for a complete table cell tag
	 * @param	attributes		Optional Array of XML attributes
	 * @param	content			String of XML content
	 */
	public static function cell() {
		$arguments = func_get_args();
		$attributes = array();
		if ( count( $arguments ) > 0 && is_array( $arguments[0] ) ) {
			$attributes = array_merge( $attributes, $arguments[0] );
			array_shift( $arguments );
		}
		if ( count( $arguments ) > 0 ) {
			return self::tag( 'td', $attributes, $arguments[0] );
		} else {
			return self::tag( 'td', $attributes );
		}
	}

	/**
	 * Builds an XML string for a complete table heading cell tag
	 * @param	attributes		Optional Array of XML attributes
	 * @param	content			String of XML content
	 */
	public static function headingCell() {
		$arguments = func_get_args();
		$attributes = array();
		if ( count( $arguments ) > 0 && is_array( $arguments[0] ) ) {
			$attributes = array_merge( $attributes, $arguments[0] );
			array_shift( $arguments );
		}
		if ( count( $arguments ) > 0 ) {
			return self::tag( 'th', $attributes, $arguments[0] );
		} else {
			return self::tag( 'th', $attributes );
		}
	}

	/**
	 * Builds an XML string for a complete div
	 * @param	attributes		Array of XML attributes
	 * @param	content
	 */
	public static function div() {
		$arguments = func_get_args();
		$attributes = array();
		if ( count( $arguments ) > 0 && is_array( $arguments[0] ) ) {
			$attributes = array_merge( $attributes, $arguments[0] );
			array_shift( $arguments );
		}
		if ( count( $arguments ) > 0 ) {
			return self::tag( 'div', $attributes, $arguments[0] );
		} else {
			return self::tag( 'div', $attributes );
		}
	}

	/**
	 * Builds an XML string for a complete span
	 * @param	attributes		Array of XML attributes
	 * @param	content
	 */
	public static function span() {
		$arguments = func_get_args();
		$attributes = array();
		if ( count( $arguments ) > 0 && is_array( $arguments[0] ) ) {
			$attributes = array_merge( $attributes, $arguments[0] );
			array_shift( $arguments );
		}
		if ( count( $arguments ) > 0 ) {
			return self::tag( 'span', $attributes, $arguments[0] );
		} else {
			return self::tag( 'span', $attributes );
		}
	}

	/**
	 * Builds an XML string for a complete input
	 * @param $attributes Array: XML attributes
	 */
	public static function input( array $attributes = array() ) {
		return self::tag( 'div', $attributes );
	}

	/**
	 * Builds an XML string for a complete tag
	 * @param	tag				Name of tag
	 * @param	attributes		Array of XML attributes
	 * @param	contents		Array of Strings or String of XML or null to
	 * 							make tag self-closing
	 */
	public static function tag(
		$tag,
		array $attributes = array(),
		$contents = null
	) {
		if ( is_array( $contents ) && count( $contents ) > 1 ) {
			return Xml::tags( $tag, $attributes, implode( $contents ) );
		} else {
			return Xml::tags(
				$tag, $attributes, $contents, ( $contents !== null )
			);
		}
	}

	/**
	 * Builds an XML string for a tag opening
	 * @param $tag String: name of tag
	 * @param $attributes Array: XML attributes
	 */
	public static function open( $tag, array $attributes = array() ) {
		return Xml::openElement( $tag, $attributes );
	}

	/**
	 * Builds an XML string for a tag closing
	 * @param $tag String: name of tag
	 */
	public static function close( $tag ) {
		return Xml::closeElement( $tag );
	}

	/**
	 * Builds an XML string for clearing floating
	 */
	public static function clearFloating() {
		return Xml::element( 'div', array( 'style' => 'clear:both' ), ' ' );
	}

	/**
	 * Builds an XML string for a stand-alone block of javascript
	 * @param	script			String of raw text to use as script contents or
	 * 							Array of attributes such as src
	 */
	public static function script( $script ) {
		if ( is_array( $script ) ) {
			return Xml::element(
				'script',
				array_merge(
					$script,
					array(
						'type' => 'text/javascript', 'language' => 'javascript'
					)
				),
				'//'
			);
		} else {
			return Xml::tags(
				'script',
				array( 'type' => 'text/javascript', 'language' => 'javascript' ),
				$script
			);
		}
	}

	/**
	 * Builds a URL from link parameters
	 * @param	parameters		Array of link parameters containing...
	 * 			page			String of page name
	 * 			type			String of type name
	 * 			action			String of action name
	 * 			id				Scalar of ID of row
	 * 			parameter		Scalar parameter or Array of parameters
	 */
	public static function url( array $parameters ) {
		global $wgTitle;
		// Gets the base url
		if ( !self::$urlBase ) {
			self::$urlBase = $wgTitle->getFullUrl();
		}
		$parameters = array_merge(
			array(
				'page' => null,
				'type' => null,
				'id' => null,
				'action' => null,
				'parameter' => null,
				'limit' => null,
				'offset' => null,
			),
			$parameters
		);
		$url = self::$urlBase;
		// Checks if the page is set now
		if ( $parameters['page'] !== null  ) {
			// Adds page to url
			$url .= '/' . $parameters['page'];
			if ( $parameters['type'] !== null  ) {
				// Adds type to url
				$url .= ':' . $parameters['type'];
				// Checks if object id was given
				if ( $parameters['id'] !== null  ) {
					// Adds id to url
					$url .= ':' . $parameters['id'];
				}
			}
			// Checks if action was given
			if ( $parameters['action'] !== null  ) {
				// Adds action to url
				$url .= '/' . $parameters['action'];
				// Checks if parameter was given
				if ( $parameters['parameter'] !== null ) {
					if ( is_array( $parameters['parameter'] ) ) { // Adds parameter to url
						$url .= ':' . implode( ',', $parameters['parameter'] );
					} else {
						// Adds parameter to url
						$url .= ':' . $parameters['parameter'];
					}
				}
			} elseif ( $parameters['limit'] !== null  ) {
				$url .= '/';
			}
			if ( $parameters['limit'] !== null  ) {
				$url .= '/' . $parameters['limit'];
				if ( $parameters['offset'] !== null  ) {
					$url .= ':' . $parameters['offset'];
				}
			}
		}
		// Returns url
		return $url;
	}

	/**
	 * Builds an XML string for an icon
	 * @param	name			Name of icon
	 * @param	enabled			Boolean of enabled state
	 * @param	contents		Array of Strings or String of XML or null to
	 * 							make tag self-closing
	 */
	public static function icon(
		$name,
		$enabled = true,
		array $options = array()
	) {
		global $wgScriptPath;
		return Xml::element(
			'img',
			array_merge(
				$options,
				array(
					'src' => $wgScriptPath .
						'/extensions/DataCenter/Resources/Icons/' . $name .
						( !$enabled ? '-disabled' : '' ) . '.png',
					'border' => 0
				)
			)
		);
	}

	/**
	 * Builds an XML string for a link
	 * @param $label String: raw text to use as label
	 * @param $parameters Array: link parameters for self::url
	 */
	public static function link( $label = null, array $parameters ) {
		return Xml::element(
			'a', array( 'href' => self::url( $parameters ) ), $label
		);
	}

	/**
	 * Builds an array of XML Attributes for javascript onclick linking
	 * @param	options			Mixed Array of link parameters, each
	 * 							containing...
	 * 			link			Array of link parameters for DataCenterUI::url
	 * 			field			Singular form of fields
	 * 			fields			List of from => to pairs of fields from row to
	 * 							inject into link, with the special from fields of
	 * 							'#type' and '#category' also made available
	 * Example:
	 * 		array(
	 * 			'link' => array(
	 * 				'page' => 'assets',
	 * 				'action' => 'view',
	 *			),
	 *			'fields' => array(
	 *				'#type' => 'type',
	 *				'id' => 'id',
	 *			)
	 * 		)
	 * @param	row				DataCenterDBRow object from which to extract
	 * 							field/fields from
	 */
	public static function buildLink( $options, $row = null ) {
		// Checks if row was given
		if ( isset( $options['page'] ) && $row instanceof DataCenterDBRow ) {
			// Transforms options based on row
			$fields = array_merge(
				$row->get(),
				array(
					'type' => $row->getType(),
					'category' => $row->getCategory(),
				)
			);
			// Loops over each field
			foreach ( $fields as $key => $value ) {
				// Loops over each option
				foreach ( $options as $option => $reference ) {
					if ( is_array( $options[$option] ) ) {
						for ( $i = 0; $i < count( $options[$option] ); $i++ ) {
							// Checks if value is reference to row field
							if ( '#' . $key == $options[$option][$i] ) {
								// Replaces reference with value
								$options[$option][$i] = $value;
							}
						}
					} else {
						// Checks if value is reference to row field
						if ( '#' . $key == $reference ) {
							// Replaces reference with value
							$options[$option] = $value;
						}
					}
				}
			}
		}
		// Builds javascript for linking
		$jsURL = DataCenterJs::escape(
			DataCenterXml::url( $options )
		);
		// Returns XML attributes for link
		return array( 'onclick' => "window.location='{$jsURL}'" );
	}

	/**
	 * Builds an array of XML Attributes for javascript effects
	 * @param	options			Array of Arrays of effect parameters, each
	 * 							containing...
	 * 			event			Name of inline XML event
	 * 			script			JavaScript to run, with sprintf syntax for
	 * 							including fields in the order listed
	 * 			field			Singular form of fields
	 * 			fields			Array of fields to supply to sprintf function
	 * 							providing a way to get field information,
	 * 							accessable to javascript in order given
	 * Example:
	 *		array(
	 * 			array(
	 * 				'event' => 'onmouseover',
	 * 				'script' => 'alert( 'Row ID: ' + %d )',
	 * 				'field' =>  'id'
	 * 			)
	 * 		)
	 * @param	row				DataCenterDBRow object from which to extract
	 * 							field/fields from
	 */
	public static function buildEffects( array $options, $fields ) {
		if ( $fields instanceof DataCenterDBRow ) {
			$fields = $fields->get();
		}
		// Checks for required types
		if ( ( is_array( $fields ) ) ) {
			$effects = array();
			// Loops over each effect
			foreach ( $options as $effect ) {
				if ( isset( $effect['event'], $effect['script'] ) ) {
					// Builds effect
					$effects[$effect['event']] = DataCenterJs::buildEffect(
						$effect['script'], $fields
					);
				}
			}
			// Returns XML attributes for effects
			return $effects;
		} else {
			return array();
		}
	}
}

abstract class DataCenterRenderable {

	/* Abstract Static Function */

	/**
	 * Abstract function for rendering the input
	 * @param $parameters Array: array of parameters
	 */
	public static function render( array $parameters ) {}

	/* Protected Static Functions */

	/**
	 * Builds XML string of begining of input
	 * @param $class String: CSS class name of widget
	 */
	protected static function begin( $class ) {
		return DataCenterXml::open( 'div', array( 'class' => $class ) );
	}

	/**
	 * Builds XML string of ending of input
	 */
	protected static function end() {
		return DataCenterXml::close( 'div' );
	}
}

abstract class DataCenterInput extends DataCenterRenderable {
	// Input-related functions to be defined...
}

abstract class DataCenterLayout extends DataCenterRenderable {
	// Layout-related functions to be defined...
}

abstract class DataCenterWidget extends DataCenterRenderable {

	/* Static Functions */

	public static function buildPaging( $page, $num ) {
		$range = array( 'limit' => 10, 'offset' => 0 );
		if ( isset( $page['limit'] ) && $page['limit'] !== null ) {
			$range['limit'] = $page['limit'];
		}
		if ( isset( $page['offset'] ) && $page['offset'] !== null ) {
			$range['offset'] = $page['offset'];
		}
		$icons = array(
			'first' => array(
				'name' => 'Navigation/First',
				'enabled' => true,
 			),
			'previous' => array(
				'name' => 'Navigation/Previous',
				'enabled' => true,
 			),
			'last' => array(
				'name' => 'Navigation/Last',
				'enabled' => true,
 			),
			'next' => array(
				'name' => 'Navigation/Next',
				'enabled' => true,
 			),
		);
		if ( $num < $range['limit'] ) {
			$range['offset'] = 0;
		}
		if ( $range['offset'] == 0 ) {
			$icons['first']['enabled'] = false;
			$icons['previous']['enabled'] = false;
		}
		if ( $range['offset'] + $range['limit'] >= $num ) {
			$icons['next']['enabled'] = false;
			$icons['last']['enabled'] = false;
		}
		$xmlOutput = DataCenterXml::open(
			'div', array( 'class' => 'paging', 'align' => 'center' )
		);
		foreach ( $icons as $icon => $options ) {
			$attributes = array(
				'class' => 'icon' . ( !$options['enabled'] ? '-disabled' : '' )
			);
			$attributes['class'] .= ' ' . $icon;
			$iconRange = array( 'limit' => $range['limit']  );
			if ( $options['enabled'] ) {
				switch ( $icon ) {
					case 'first':
						$iconRange['offset'] = 0;
						break;
					case 'previous':
						$iconRange['offset'] = max(
							$range['offset'] - $range['limit'], 0
						);
						break;
					case 'next':
						$iconRange['offset'] = min(
							$range['offset'] + $range['limit'], $num - 1
						);
						break;
					case 'last':
						$iconRange['offset'] = $num - $range['limit'];
						break;
				}
				$attributes = array_merge(
					$attributes, DataCenterXml::buildLink(
						array_merge( $page, $iconRange )
					)
				);
			}
			$xmlOutput .= DataCenterXml::icon(
				$options['name'], $options['enabled'], $attributes
			);
		}
		$xmlOutput .= DataCenterXml::div(
			array( 'class' => 'label' ),
			DataCenterUI::message( 'label', 'range', $num )
		);
		$xmlOutput .= DataCenterXml::close( 'div' );
		return $xmlOutput;
	}

}

class DataCenterUI {

	/* Private Static Members */

	/**
	 * Widgets, inputs and layouts are rendered by passing a type, parameters,
	 * and in the case of layouts contents. These array are used to verify the
	 * widget, input or layout is available and also as a lookup table to
	 * determine the corrosponding class to call the render function in.
	 */
	private static $widgets = array(
		'actions' => 'DataCenterWidgetActions',
		'body' => 'DataCenterWidgetBody',
		'details' => 'DataCenterWidgetDetails',
		'export' => 'DataCenterWidgetExport',
		'fieldlinks' => 'DataCenterWidgetFieldLinks',
		'form' => 'DataCenterWidgetForm',
		'gallery' => 'DataCenterWidgetGallery',
		'heading' => 'DataCenterWidgetHeading',
		'history' => 'DataCenterWidgetHistory',
		'map' => 'DataCenterWidgetMap',
		'model' => 'DataCenterWidgetModel',
		'plan' => 'DataCenterWidgetPlan',
		'search' => 'DataCenterWidgetSearch',
		'searchresults' => 'DataCenterWidgetSearchResults',
		'space' => 'DataCenterWidgetSpace',
		'table' => 'DataCenterWidgetTable',
	);
	private static $inputs = array(
		'boolean' => 'DataCenterInputBoolean',
		'button' => 'DataCenterInputButton',
		'list' => 'DataCenterInputList',
		'number' => 'DataCenterInputNumber',
		'position' => 'DataCenterInputPosition',
		'string' => 'DataCenterInputString',
		'tense' => 'DataCenterInputTense',
		'text' => 'DataCenterInputText',
	);
	private static $layouts = array(
		'columns' => 'DataCenterLayoutColumns',
		'rows' => 'DataCenterLayoutRows',
		'tabs' => 'DataCenterLayoutTabs',
	);

	/**
	 * After the user interface is initialized, an instance of a page class is
	 * created and rendered. Durring this process both setDestinations,
	 * addScript and addContent get called. The raw data or rendered XML is
	 * stored in output so that it can be composited later by render.
	 */
	private static $output = array(
		'search' => '',
		'menu' => '',
		'content' => '',
		'script' => null,
		'scripts' => array(
			'<!--[if IE]><script type="text/javascript" src="%s/extensions/DataCenter/Resources/Support/excanvas-compressed.js"></script><![endif]-->',
			'/extensions/DataCenter/DataCenter.js',
		)
	);

	/* Static Functions */

	/**
	 * Gets internationalized message
	 * @param	type			String of type of message
	 * @param	name			String of name of message
	 * @param	arguments		String or array of strings of arguments which
	 * 							will be passed to MediaWiki's message parser
	 */
	public static function message( $type, $name = null, $arguments = null ) {
		if ( !$name ) {
			return wfMsg( $type );
		}
		return wfMsgExt(
			"datacenter-ui-{$type}-{$name}",
			array( 'parsemag', 'parseinline' ),
			$arguments
		);
	}

	/**
	 * Formats value using various modes
	 * @param	value			Scalar of value to format
	 * @param	format			String of mode to use, which can be nothing for
	 * 							no formatting or any of the following...
	 * 				date		Localized date and time format from timestamp
	 */
	public static function format( $value, $format ) {
		global $wgLang;
		// Handles format type
		switch ( $format ) {
			case 'date':
				// Uses localized date formatting
				return $wgLang->timeanddate( $value );
				break;
			case 'option':
				return self::message( 'option', $value );
				break;
			case 'type':
				return self::message( 'type', $value );
				break;
			case 'category':
				return self::message( 'category', $value );
				break;
			case 'side':
				return self::message( 'option', $value ? 'back' : 'front' );
				break;
			case 'angle':
				return self::message( 'label', 'degrees-value', $value * 90 );
				break;
			case 'boolean':
				return self::message( 'option', $value ? 'true' : 'false' );
				break;
			default:
				// Performs no formatting
				return $value;
		}
	}

	/**
	 * Renders a final composition from cached output
	 */
	public static function render() {
		global $wgOut, $wgScriptPath;
		// Adds XML head content
		foreach ( self::$output['scripts'] as $url ) {
			if ( strpos( $url, 'http://' ) !== false ) {
				$wgOut->addScript(
					DataCenterXml::script( array( 'src' => $url ) )
				);
			} elseif ( strpos( $url, '<' ) !== false ) {
				$wgOut->addScript( sprintf( $url, $wgScriptPath ) );
			} else {
				$wgOut->addScriptFile( $wgScriptPath . $url );
			}
		}
		$wgOut->addLink(
			array(
				'rel' => 'stylesheet',
				'type' => 'text/css',
				'href' => $wgScriptPath .
					'/extensions/DataCenter/DataCenter.css'
			)
		);
		// Adds XML body content
		$wgOut->addHTML(
			DataCenterXml::div(
				array( 'class' => 'datacenter-ui' ),
				self::$output['menu'] . self::$output['content']
			)
		);
		if ( self::$output['script'] !== null ) {
			$wgOut->addHTML(
				DataCenterXml::script( self::$output['script'] )
			);
		}
	}

	/**
	 * Builds string of XML using widget
	 * @param $name String: name of widget to use
	 * @param $parameters Array: parameters to pass on to widget
	 * @return	String of widget's XML output
	 */
	public static function renderWidget( $name, array $parameters = array() ) {
		if ( isset( self::$widgets[$name] ) ) {
			$function = array( self::$widgets[$name], 'render' );
			if ( is_callable( $function ) ) {
				return call_user_func(
					$function,
					$parameters
				);
			}
		}
		return null;
	}

	/**
	 * Builds string of XML using input
	 * @param $name String: name of input to use
	 * @param $parameters Array: parameters to pass on to input
	 * @return	String of input's XML output
	 */
	public static function renderInput( $name, array $parameters = array() ) {
		if ( isset( self::$inputs[$name] ) ) {
			$function = array( self::$inputs[$name], 'render' );
			if ( is_callable( $function ) ) {
				return call_user_func(
					$function,
					$parameters
				);
			}
		}
		return null;
	}

	/**
	 * Builds string of XML using layout
	 * @param $name String: name of layout to use
	 * @param $contents Array: array of strings of XML to layout
	 * @return String of layout's XML output
	 */
	public static function renderLayout( $name, array $contents = array() ) {
		if ( isset( self::$layouts[$name] ) ) {
			$function = array( self::$layouts[$name], 'render' );
			if ( is_callable( $function ) ) {
				return call_user_func(
					$function,
					$contents
				);
			}
		}
		return null;
	}

	/**
	 * Appends the scripts list, skipping duplicate entries
	 * @param $url String: fully qualified URL to JavaScript file
	 */
	public static function addScript( $url ) {
		if ( !in_array( $url, self::$output['scripts'] ) ) {
			self::$output['scripts'][] = $url;
		}
	}

	/**
	 * Appends content to the output cache
	 * @param $content String: XML content to append
	 */
	public static function addContent( $content ) {
		self::$output['content'] .= $content;
	}

	/**
	 * Builds and stores menus in output cache
	 * @param	pages			Array of pages for main menu, with keys as page
	 * 							names
	 * @param	controller		DataCenterController of the current page's
	 * 							controller
	 * @param	path			Array of link parameters of current path
	 */
	public static function setDestinations(
		array $pages,
		DataCenterController $controller,
		array $path
	) {
		global $wgUser;
		// Adds main menu
		self::$output['menu'] .= DataCenterXml::open(
			'div', array( 'class' => 'menu' )
		);
		foreach ( $pages as $page => $classes ) {
			if ( $classes['display'] ) {
				$state = ( $page == $path['page'] ? 'current' : 'normal' );
				self::$output['menu'] .= DataCenterXml::div(
					array( 'class' => 'item-' . $state ),
					DataCenterXml::link(
						self::message( 'page', $page ),
						array( 'page' => $page )
					)
				);
			}
		}
		self::$output['menu'] .= DataCenterXml::close( 'div' );
		// Adds search
		self::$output['menu'] .= DataCenterUI::renderWidget(
			'search', array()
		);
		// Adds sub menu
		self::$output['menu'] .= DataCenterXml::open(
			'div', array( 'class' => 'toolbar' )
		);
		// Type tabs
		if ( count( $controller->types ) > 0 ) {
			self::$output['menu'] .= DataCenterXml::div(
				array( 'class' => 'type-label' ),
				self::message( 'label' , 'browse-by' )
			);
			foreach ( $controller->types as $label => $type ) {
				$state = ( $label == $path['type'] ? 'current' : 'normal' );
				self::$output['menu'] .= DataCenterXml::div(
					array( 'class' => 'type-' . $state ),
					DataCenterXml::link(
						self::message( 'type', $label ), $type
					)
				);
			}
		}
		// Trail steps
		$count = 1;
		foreach ( $controller->trail as $label => $step ) {
			$end = ( $count == count( $controller->trail ) ) ? '-end' : '';
			self::$output['menu'] .= DataCenterXml::div(
				array( 'class' => 'breadcrumb' . $end ),
				DataCenterXml::link( $label, $step)
			);
			$count++;
		}
		// Action tabs
		foreach ( $controller->actions as $label => $action ) {
			$state = ( $label == $path['action'] ? 'current' : 'normal' );
			self::$output['menu'] .= DataCenterXml::div(
				array( 'class' => 'action-' . $state ),
				DataCenterXml::link(
					self::message( 'action', $label ),
					$action
				)
			);
		}
		self::$output['menu'] .= DataCenterXml::close( 'div' );
	}

	/**
	 * Checks if widget is available
	 * @param $name String: name of widget to look for
	 * @return Boolean true if exists, false if not
	 */
	public static function isWidget( $name ) {
		return isset( self::$widgets[$name] );
	}

	/**
	 * Checks if input is available
	 * @param $name String: name of input to look for
	 * @return Boolean true if exists, false if not
	 */
	public static function isInput( $name ) {
		return isset( self::$inputs[$name] );
	}

	/**
	 * Checks if layout is available
	 * @param $name String: name of layout to look for
	 * @return Boolean true if exists, false if not
	 */
	public static function isLayout( $name ) {
		return isset( self::$layouts[$name] );
	}
}
