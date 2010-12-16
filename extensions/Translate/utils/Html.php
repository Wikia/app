<?php

/**
 * HTML builder class which wraps around Html::rawElement().
 * Most of the functions are dual purpose. With no value (or null value) they
 * return the current value of asked property. If the value is not null, it
 * replaces the current value and the object itself is returned. This allows
 * chaining calls. Noted as chain-accessor in the comments. Example:
 * <code>$tag = new HtmlTag( 'div' ); $div = $div->content( 'foo' )->style( 'color', 'red' );</code>
 * Note: relies on implicit toString conversion (PHP >= 5.2)
 */
class HtmlTag {
	public $tag = 'div';
	public $content = '';
	public $params = array();
	public $style = array();
	/** Throw exceptions on invalid input. Set to false to degrade them to warnings */
	public $strict = true;

	/**
	 * Constructs a html tag. See the notes about handling contentless tags in
	 * HTML class.
	 * @param $tag string  Optional. The name of the tag, if null defaults to div.
	 * @param $content string  Optional. The contents of the tag, if null defaults to empty string.
	 * @param $params array  Optional. The html parameters for this tag, if null defaults to no tags.
	 */
	public function __construct( $tag = null, $content = null, $params = null ) {
		$this->tag( $tag );
		$this->content( $content );
		$this->params( $params );
	}

	/**
	 * Sets tag type. Chain-accessor.
	 * @param $value Mixed  Optional. Null to view and string to set the tag.
	 * @return Mixed  The tag name or self;
	 */
	public function tag( $value = null ) {
		if ( $value === null ) return $this->tag;

		$this->tag = (string) $this->assert( 'is_string', $value );
		return $this;
	}

	/**
	 * Sets the tag content. Chain-accessor.
	 * @param $value Mixed  Optional. Null to view and string to set the content.
	 * @return Mixed  The content as a string or self.
	 */
	public function content( $value = null ) {
		if ( $value === null ) return $this->content;

		if ( $value instanceof HtmlTag || $value instanceof RawHtml || $value instanceof TagContainer  ) {
			$this->content = $value;
		} else {
			$this->content = (string) $this->assert( 'is_string', $value );
		}

		return $this;
	}

	/**
	 * Sets all parameters. Chain-accessor.
	 * @param $value Mixed  Optional. Null to view and array to set the values.
	 * @return Array  The paramater array.
	 */
	public function params( $value = null ) {
		if ( $value === null ) return $this->params;

		$this->params = (array) $this->assert( 'is_array', $value );
		return $this;
	}

	/**
	 * Sets or unsets a parameter. Chain-accessor.
	 * @param $name String  The name of the parameter.
	 * @param $value Mixed  Optional. False to unset, null to view and string to set the value.
	 * @return Mixed  The value of the parameter or null if not set.
	 */
	public function param( $name, $value = null ) {
		$name = (string) $this->assert( 'is_string', $name );
		if ( $value === null ) {
			return isset( $this->params[$name] ) ? $this->params[$name] : null;
		}

		if ( $value === false ) {
			unset( $this->params[$name] );
		} else {
			$this->params[$name] = $this->assert( 'is_string', $value );
		}
		return $this;
	}

	/**
	 * Sets or unsets one CSS style parameter. Chain-accessor. These will be
	 * appended to style paramerer set in tag parameters.
	 * @param $name String  The name of the parameter.
	 * @param $value Mixed  Optional. False to unset, null to view and string to set the value.
	 * @return Mixed  The value of the parameter or null if not set.
	 */
	public function style( $name, $value = null ) {
		$name = (string) $this->assert( 'is_string', $name );
		if ( $value === null ) {
			return isset( $this->style[$name] ) ? $this->style[$name] : null;
		}

		if ( $value === false ) {
			unset( $this->style[$name] );
		} else {
			$this->style[$name] = $this->assert( 'is_string', $value );
		}
		return $this;
	}

	/**
	 * Shortcut for param( name = id ). Chain-accessor.
	 */
	public function id( $value = null ) {
		return $this->param( 'id', $value );
	}

	/**
	 * Returns the html output. Use this when you don't want to use
	 * implicit string conversion.
	 * @return string  html
	 */
	public function html() {
		// Collapse styles
		$params = $this->params;
		$style = $this->collapseStyles();
		if ( $style ) $params['style'] = $style;

		if ( is_object( $this->content ) ) {
			return Html::rawElement( $this->tag, $params, $this->content );
		} else {
			return Html::element( $this->tag, $params, $this->content );
		}
	}

	/**
	 * Wrapper for html method, for implicit conversion to string.
	 * @return string  html
	 */
	public function __toString() {
		return $this->html();
	}

	/**
	 * Constructs the value for style parameter.
	 * @return string  The value for style parameter.
	 */
	public function collapseStyles() {
		$style = '';

		if ( isset( $this->params['style'] ) ) {
			$style = trim( $this->params['style'] );
			$style = rtrim( $style, ';' ) . ";";
		}

		foreach ( $this->style as $name => $val ) {
			$style .= "$name: $val;";
		}

		if ( $style !== '' ) return $style;
		return false;
	}

	/**
	 * Simple type checker for input. Simple types are silently converted to string for convenience.
	 * @param $function string  Function to use as type checker, for example is_string.
	 * @param $value Mixed  The value to to check.
	 * @param $result Mixed  The value to compare to the result of the check.
	 * @return The value given.
	 */
	protected function assert( $function, $value, $result = true ) {
		if ( $function === 'is_string' ) {
			if ( is_int( $value ) || is_float( $value ) ) $value = (string) $value;
		}

		$real_result = call_user_func( $function, $value );
		if ( $real_result === $result ) return $value;
		$msg =  __METHOD__ . ":expecting $function to be $result";
		if ( $this->strict ) {
				throw new MWException( $msg );
		} else {
			wfWarn( $msg );
			return $value;
		}
	}

}

/**
 * Class for passing data to HtmlTag. Useful when you already
 * have piece of html.
 */
class RawHtml {
	/** Contents */
	public $data = '';

	public function __construct( $data ) {
		$this->data = $data;
	}

	public function __toString() {
		return $this->data;
	}
}

/**
 * Wrapper class which implements array properties. Useful for adding multiple
 * tags inside as contents of another tag. Items must be pre-escaped!
 */
class TagContainer implements ArrayAccess {
	public $tags = array();

	public function __construct( $tags = array() ) {
		$this->tags = $tags;
	}

	public function __toString() {
		$output = '';
		foreach ( $this->tags as $tag )
			$output .= $tag . "\n";
		return $output;
	}

	// ArrayAccess
	public function offsetSet( $offset, $value ) {
		if ( $offset === null ) {
			$this->tags[] = $value;
		} else {
			$this->tags[$offset] = $value;
		}
	}
	public function offsetExists( $offset ) {
		return isset( $this->tags[$offset] );
	}
	public function offsetUnset( $offset ) {
		unset( $this->tags[$offset] );
	}
	public function offsetGet( $offset ) {
		return isset( $this->tags[$offset] ) ? $this->tags[$offset] : null;
	}
}