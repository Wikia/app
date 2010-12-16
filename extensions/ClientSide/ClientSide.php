<?php

$wgExtensionCredits['other'][] = array(
	'path' => __FILE__,
	'name' => 'ClientSide',
	'author' => 'Trevor Parscal',
	'url' => 'http://www.mediawiki.org/wiki/Extension:ClientSide',
	'descriptionmsg' => 'clientside-desc',
	'version' => '0.1.1',
);

$wgExtensionMessagesFiles['ClientSide'] =  dirname(__FILE__) . '/ClientSide.i18n.php';

abstract class CsHtml {

	/* Static Functions */

	/**
	 * Builds an HTML string for a complete table tag
	 * @param	attributes		Optional Array of HTML attributes
	 * @param	content...		Any number of Strings of HTML content
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
	 * Builds an HTML string for a complete table row tag
	 * @param	attributes		Optional Array of HTML attributes
	 * @param	content...		Any number of Strings of HTML content
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
	 * Builds an HTML string for a complete table cell tag
	 * @param	attributes		Optional Array of HTML attributes
	 * @param	content			String of HTML content
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
	 * Builds an HTML string for a complete div
	 * @param	attributes		Array of HTML attributes
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
	 * Builds an HTML string for a complete span
	 * @param	attributes		Array of HTML attributes
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
	 * Builds an HTML string for an input
	 * @param	attributes		Array of HTML attributes
	 */
	public static function input(
		array $attributes = array()
	) {
		return self::tag( 'input', $attributes );
	}

	/**
	 * Builds an HTML string for a stand-alone block of javascript
	 * @param	script			String of raw text to use as script contents or
	 * 							Array of attributes such as src
	 */
	public static function script(
		$script
	) {
		global $wgJsMimeType;
		if ( is_array( $script ) ) {
			return Xml::element(
				'script',
				array_merge(
					$script,
					array(
						'type' => $wgJsMimeType, 'language' => 'javascript'
					)
				),
				'//'
			);
		} else {
			return Xml::tags(
				'script',
				array( 'type' => $wgJsMimeType, 'language' => 'javascript' ),
				$script
			);
		}
	}

	/**
	 * Builds an HTML string for a complete tag
	 * @param	tag				Name of tag
	 * @param	attributes		Array of HTML attributes
	 * @param	contents		Array of Strings or String of HTML or null to
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
	 * Builds an HTML string for a tag opening
	 * @param	tag				Name of tag
	 * @param	attributes		Array of HTML attributes
	 */
	public static function open(
		$tag,
		array $attributes = array()
	) {
		return Xml::openElement( $tag, $attributes );
	}

	/**
	 * Builds an HTML string for a tag closing
	 * @param	tag				Name of tag
	 */
	public static function close(
		$tag
	) {
		return Xml::closeElement( $tag );
	}

	/**
	 * Sanitizes a string to be used as an HTML ID
	 * @param	id				String to sanitize
	 */
	public static function toId(
		$id
	) {
		return  preg_replace(
			'`\ +`', ' ', preg_replace( '`[^a-z0-9\_]`i', '', $id )
		);
	}
}

abstract class CsCss {

	/* Static Functions */

	public static function toAttributes(
		array $attributes
	) {
		$cssOutput = '';
		foreach( $attributes as $name => $value ) {
			if ( !is_int( $name ) ) {
				$cssOutput .= $name . ':' . $value . ';';
			}
		}
		return $cssOutput;
	}
}

abstract class CsJs {

	/* Static Functions */

	public static function chain(
		$functions,
		$end = true
	) {
		$jsFunctions = array();
		foreach( $functions as $name => $arguments ) {
			if ( is_int( $name ) ) {
				$jsFunctions[] = sprintf( '%s()', $arguments );
			} else if ( is_array( $arguments ) ) {
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
	 * Escapes a javascript string to make it safe to use anywhere
	 * @param	string			String to escape
	 */
	public static function escape(
		$string
	) {
		return Xml::escapeJSString( $string );
	}

	/**
	 * Converts a PHP value to a javascript object
	 * @param	value			Associative Array to convert
	 */
	public static function toObject(
		$values
	) {
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
	public static function toArray(
		$values
	) {
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
	public static function toScalar(
		$value
	) {
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

	/**
	 * Builds an annonomous javascript function declaration
	 * @param	arguments		Array of argument names to accept
	 * @param	body			String of code for body
	 */
	public static function buildFunction(
		$arguments,
		$body
	) {
		if ( is_array( $arguments ) ) {
			return sprintf(
				'function(%s){%s}', implode( ',', $arguments ), $body
			);
		} else if ( $arguments !== null ) {
			return sprintf( 'function(%s){%s}', $arguments, $body );
		} else {
			return sprintf( 'function(){%s}', $body );
		}
	}

	/**
	 * Builds an annonomous javascript function declaration
	 * @param	arguments		Array of argument names to accept
	 * @param	body			String of code for body
	 */
	public static function buildInstance(
		$prototype,
		$arguments = array()
	) {
		if ( !is_array( $arguments ) ) {
			$arguments = array( $arguments );
		}
		return sprintf(
			'new %s(%s)', $prototype, implode( ',', $arguments )
		);
	}

	public static function declareVar(
		$name,
		$value = 'null',
		$end = true
	) {
		return sprintf( 'var %s=%s', $name, $value ) . ( $end ? ';' : '' );
	}

	public static function declareVars(
		array $vars,
		$end = true
	) {
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
}
