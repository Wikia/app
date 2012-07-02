<?php
/**
 * Class for handling the parser functions for External Data
 */
 
class EDParserFunctions {
 
	/**
	 * Render the #get_external_data parser function
	 * @deprecated
	 */
	static function doGetExternalData( &$parser ) {
		global $wgTitle, $edgCurPageName, $edgValues;

		// if we're handling multiple pages, reset $edgValues
		// when we move from one page to another
		$cur_page_name = $wgTitle->getText();
		if ( ! isset( $edgCurPageName ) || $edgCurPageName != $cur_page_name ) {
			$edgValues = array();
			$edgCurPageName = $cur_page_name;
		}

		$params = func_get_args();
		array_shift( $params ); // we already know the $parser ...
		$url = array_shift( $params );
		$url = str_replace( ' ', '%20', $url ); // do some minor URL-encoding
		// if the URL isn't allowed (based on a whitelist), exit
		if ( ! EDUtils::isURLAllowed( $url ) ) {
			return;
		}

		$format = strtolower( array_shift( $params ) ); // make case-insensitive
		$external_values = EDUtils::getDataFromURL( $url, $format );
		if ( count( $external_values ) == 0 ) {
			return;
		}

		// Get set of filters and set of mappings, determining each
		// one by whether there's a double or single equals sign,
		// respectively.
		$filters = array();
		$mappings = array();
		foreach ( $params as $param ) {
			if ( strpos( $param, '==' ) ) {
				list( $external_var, $value ) = explode( '==', $param );
				// set to all lowercase to avoid casing issues
				$external_var = strtolower( $external_var );
				$filters[$external_var] = $value;
			} elseif ( strpos( $param, '=' ) ) {
				list( $local_var, $external_var ) = explode( '=', $param );
				// set to all lowercase to avoid casing issues
				$external_var = strtolower( $external_var );
				$mappings[$local_var] = $external_var;
			} else {
				// if the parameter contains no equals signs,
				// do nothing
			}
		}
		self::setGlobalValuesArray( $external_values, $filters, $mappings );
	}

	/**
	 * A helper function, since it's called by both doGetExternalData()
	 * and doGetWebData() - the former is deprecated.
	 */
	static public function setGlobalValuesArray( $external_values, $filters, $mappings ) {
		global $edgValues;

		foreach ( $filters as $filter_var => $filter_value ) {
			// Find the entry of $external_values that matches
			// the filter variable; if none exists, just ignore
			// the filter.
			if ( array_key_exists( $filter_var, $external_values ) ) {
				if ( is_array( $external_values[$filter_var] ) ) {
					$column_values = $external_values[$filter_var];
					foreach ( $column_values as $i => $single_value ) {
						// if a value doesn't match
						// the filter value, remove
						// the value from this row for
						// all columns
						if ( trim( $single_value ) != trim( $filter_value ) ) {
							foreach ( $external_values as $external_var => $external_value ) {
								unset( $external_values[$external_var][$i] );
							}
						}
					}
				} else {
					// if we have only one row of values,
					// and the filter doesn't match, just
					// keep the results array blank and
					// return
					if ( $external_values[$filter_var] != $filter_value ) {
						return;
					}
				}
			}
		}
		// for each external variable name specified in the function
		// call, get its value or values (if any exist), and attach it
		// or them to the local variable name
		foreach ( $mappings as $local_var => $external_var ) {
			if ( array_key_exists( $external_var, $external_values ) ) {
				if ( is_array( $external_values[$external_var] ) )
					// array_values() restores regular
					// 1, 2, 3 indexes to array, after unset()
					// in filtering may have removed some
					$edgValues[$local_var] = array_values( $external_values[$external_var] );
				else
					$edgValues[$local_var][] = $external_values[$external_var];
			}
		}
	}

	/**
	 * Render the #get_web_data parser function
	 */
	static function doGetWebData( &$parser ) {
		global $wgTitle, $edgCurPageName, $edgValues;

		// If we're handling multiple pages, reset $edgValues
		// when we move from one page to another.
		$cur_page_name = $wgTitle->getText();
		if ( ! isset( $edgCurPageName ) || $edgCurPageName != $cur_page_name ) {
			$edgValues = array();
			$edgCurPageName = $cur_page_name;
		}

		$params = func_get_args();
		array_shift( $params ); // we already know the $parser ...
		$args = EDUtils::parseParams( $params ); // parse params into name-value pairs
		if ( array_key_exists( 'url', $args ) ) {
			$url = $args['url'];
		} else {
			return;
		}
		$url = str_replace( ' ', '%20', $url ); // do some minor URL-encoding
		// if the URL isn't allowed (based on a whitelist), exit
		if ( ! EDUtils::isURLAllowed( $url ) ) {
			return;
		}

		if ( array_key_exists( 'format', $args ) ) {
			$format = strtolower( $args['format'] );
		} else {
			$format = '';
		}
		$external_values = EDUtils::getDataFromURL( $url, $format );
		if ( is_string( $external_values ) ) {
			// It's an error message - just display it on the
			// screen.
			return $external_values;
		}
		if ( count( $external_values ) == 0 ) {
			return;
		}

		if ( array_key_exists( 'data', $args ) ) {
			// parse the 'data' arg into mappings
			$mappings = EDUtils::paramToArray( $args['data'], false, true );
		} else {
			return;
		}
		if ( array_key_exists( 'filters', $args ) ) {
			// parse the 'filters' arg
			$filters = EDUtils::paramToArray( $args['filters'], true, false );
		} else {
			$filters = array();
		}

		self::setGlobalValuesArray( $external_values, $filters, $mappings );
	}

 	/**
	 * Render the #get_ldap_data parser function
	 */
	static function doGetLDAPData( &$parser ) {
		global $wgTitle, $edgCurPageName, $edgValues;

		// if we're handling multiple pages, reset $edgValues
		// when we move from one page to another
		$cur_page_name = $wgTitle->getText();
		if ( ! isset( $edgCurPageName ) || $edgCurPageName != $cur_page_name ) {
			$edgValues = array();
			$edgCurPageName = $cur_page_name;
		}

		$params = func_get_args();
		array_shift( $params ); // we already know the $parser ...
		$args = EDUtils::parseParams( $params ); // parse params into name-value pairs
		$mappings = EDUtils::paramToArray( $args['data'] ); // parse the data arg into mappings

		$external_values = EDUtils::getLDAPData( $args['filter'], $args['domain'], array_values( $mappings ) );

		// Build $edgValues
		foreach ( $mappings as $local_var => $external_var ) {
			$edgValues[$local_var][] = $external_values[0][$external_var][0];
		}
		return;
	}

	/**
	 * Render the #get_db_data parser function
	 */
	static function doGetDBData( &$parser ) {
		global $wgTitle, $edgCurPageName, $edgValues;

		// if we're handling multiple pages, reset $edgValues
		// when we move from one page to another
		$cur_page_name = $wgTitle->getText();
		if ( ! isset( $edgCurPageName ) || $edgCurPageName != $cur_page_name ) {
			$edgValues = array();
			$edgCurPageName = $cur_page_name;
		}

		$params = func_get_args();
		array_shift( $params ); // we already know the $parser ...
		$args = EDUtils::parseParams( $params ); // parse params into name-value pairs
		$data = ( array_key_exists( 'data', $args ) ) ? $args['data'] : null;
		$dbID = ( array_key_exists( 'db', $args ) ) ? $args['db'] : null;
		// For backwards-compatibility - 'db' parameter was added
		// in External Data version 1.3.
		if ( is_null( $dbID ) ) {
			$dbID = ( array_key_exists( 'server', $args ) ) ? $args['server'] : null;
		}
		$table = ( array_key_exists( 'from', $args ) ) ? $args['from'] : null;
		$conds = ( array_key_exists( 'where', $args ) ) ? $args['where'] : null;
		$limit = ( array_key_exists( 'limit', $args ) ) ? $args['limit'] : null;
		$orderBy = ( array_key_exists( 'order by', $args ) ) ? $args['order by'] : null;
		$options = array( 'LIMIT' => $limit, 'ORDER BY' => $orderBy );
		$mappings = EDUtils::paramToArray( $data ); // parse the data arg into mappings

		$external_values = EDUtils::getDBData( $dbID, $table, array_values( $mappings ), $conds, $options );
		// handle error cases
		if ( is_null( $external_values ) )
			return;

		// Build $edgValues
		foreach ( $mappings as $local_var => $external_var ) {
			if ( array_key_exists( $external_var, $external_values ) ) {
				foreach ( $external_values[$external_var] as $value ) {
					$edgValues[$local_var][] = $value;
				}
			}
		}
		return;
	}

	/**
	 * Get the specified index of the array for the specified local
	 * variable retrieved by #get_external_data
	 */
	static function getIndexedValue( $var, $i ) {
		global $edgValues;
		if ( array_key_exists( $var, $edgValues ) && count( $edgValues[$var] > $i ) )
			return $edgValues[$var][$i];
		else
			return '';
	}
 
	/**
	 * Render the #external_value parser function
	 */
	static function doExternalValue( &$parser, $local_var = '' ) {
		global $edgValues;
		if ( ! array_key_exists( $local_var, $edgValues ) )
			return '';
		elseif ( is_array( $edgValues[$local_var] ) )
			return $edgValues[$local_var][0];
		else
			return $edgValues[$local_var];
	}
 
	/**
	 * Render the #for_external_table parser function
	 */
	static function doForExternalTable( &$parser, $expression = '' ) {
		global $edgValues;

		// get the variables used in this expression, get the number
		// of values for each, and loop through 
		$matches = array();
		preg_match_all( '/{{{([^}]*)}}}/', $expression, $matches );
		$variables = $matches[1];
		$num_loops = 0;
		foreach ( $variables as $variable ) {
			// ignore the presence of '.urlencode' - it's a command,
			// not part of the actual variable name
			$variable = str_replace( '.urlencode', '', $variable );
			if ( array_key_exists( $variable, $edgValues ) ) {
				$num_loops = max( $num_loops, count( $edgValues[$variable] ) );
			}
		}
		$text = "";
		for ( $i = 0; $i < $num_loops; $i++ ) {
			$cur_expression = $expression;
			foreach ( $variables as $variable ) {
				// if variable name ends with a ".urlencode",
				// that's a command - URL-encode the value of
				// the actual variable
				$loc_of_urlencode = strrpos( $variable, '.urlencode' );
				if ( ( $loc_of_urlencode > 0 ) && ( $loc_of_urlencode == strlen( $variable ) - strlen( '.urlencode' ) ) ) {
					$real_var = str_replace( '.urlencode', '', $variable );
					$value = urlencode( self::getIndexedValue( $real_var , $i ) );
				} else {
					$value = self::getIndexedValue( $variable , $i );
				}
				$cur_expression = str_replace( '{{{' . $variable . '}}}', $value, $cur_expression );
			}
			$text .= $cur_expression;
		}
		return $text;
	}
 
	/**
	 * Render the #store_external_table parser function
	 */
	static function doStoreExternalTable( &$parser ) {
		if ( ! class_exists( 'SIOHandler' ) ) {
			return 'Semantic Internal Objects is not installed';
		}
		global $edgValues;

		$params = func_get_args();
		array_shift( $params ); // we already know the $parser...

		// get the variables used in this expression, get the number
		// of values for each, and loop through 
		$expression = implode( '|', $params );
		$matches = array();
		preg_match_all( '/{{{([^}]*)}}}/', $expression, $matches );
		$variables = $matches[1];
		$num_loops = 0;
		foreach ( $variables as $variable ) {
			// ignore the presence of '.urlencode' - it's a command,
			// not part of the actual variable name
			$variable = str_replace( '.urlencode', '', $variable );
			if ( array_key_exists( $variable, $edgValues ) ) {
				$num_loops = max( $num_loops, count( $edgValues[$variable] ) );
			}
		}
		$text = "";
		for ( $i = 0; $i < $num_loops; $i++ ) {
			// re-get $params
			$params = func_get_args();
			array_shift( $params );
			foreach ( $params as $j => $param ) {
				foreach ( $variables as $variable ) {
					// if variable name ends with a ".urlencode",
					// that's a command - URL-encode the value of
					// the actual variable
					if ( strrpos( $variable, '.urlencode' ) == strlen( $variable ) - strlen( '.urlencode' ) ) {
						$real_var = str_replace( '.urlencode', '', $variable );
						$value = urlencode( self::getIndexedValue( $real_var , $i ) );
					} else {
						$value = self::getIndexedValue( $variable , $i );
					}
					$params[$j] = str_replace( '{{{' . $variable . '}}}', $value, $params[$j] );
				}
			}
			// Add $parser to the beginning of the $params array,
			// and pass the whole thing in as arguments to
			// doSetInternal, to mimic a call to #set_internal.
			array_unshift( $params, $parser );
			// As of PHP 5.3.1, call_user_func_array() requires that
			// the function params be references. Workaround via
			// http://stackoverflow.com/questions/2045875/pass-by-reference-problem-with-php-5-3-1
			$refParams = array();
			foreach ( $params as $key => $value ) {
				$refParams[$key] = &$params[$key];
			}
			call_user_func_array( array( 'SIOHandler', 'doSetInternal' ), $refParams );
		}
		return null;
	}

	/**
	 * Render the #clear_external_data parser function
	 */
	static function doClearExternalData( &$parser ) {
		global $edgValues;
		$edgValues = array();
	}
}
