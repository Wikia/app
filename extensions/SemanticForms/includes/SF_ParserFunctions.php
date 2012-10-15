<?php
/**
 * Parser functions for Semantic Forms.
 *
 * @file
 * @ingroup SF
 * The following parser functions are defined: 'forminput', 'formlink',
 * 'queryformlink', 'arraymap', 'arraymaptemplate' and 'autoedit'.
 *
 * 'forminput' is called as:
 *
 * {{#forminput:form=|size=|default value=|button text=|query string=
 * |autocomplete on category=|autocomplete on namespace=
 * |remote autocompletion|...additional query string values...}}
 *
 * This function returns HTML representing a form to let the user enter the
 * name of a page to be added or edited using a Semantic Forms form. All
 * arguments are optional. 'form' is the name of the SF form to be used;
 * if it is left empty, a dropdown will appear, letting the user chose among
 * all existing forms. 'size' represents the size of the text input (default
 * is 25), and 'default value' is the starting value of the input.
 * 'button text' is the text that will appear on the "submit" button, and
 * 'query string' is the set of values that you want passed in through the
 * query string to the form. (Query string values can also be passed in
 * directly as parameters.) Finally, you can can specify that the user will
 * get autocompletion using the values from a category or namespace of your
 * choice, using 'autocomplete on category' or 'autocomplete on namespace'
 * (you can only use one). To autcomplete on all pages in the main (blank)
 * namespace, specify "autocomplete on namespace=main".
 *
 * If the "remote autocompletion" parameter is added, autocompletion
 * is done via an external URL, which can allow autocompletion on a much
 * larger set of values.
 *
 * Example: to create an input to add or edit a page with a form called
 * 'User' within a namespace also called 'User', and to have the form
 * preload with the page called 'UserStub', you could call the following:
 *
 * {{#forminput:form=User|button text=Add or edit user
 * |query string=namespace=User&preload=UserStub}}
 *
 *
 * 'formlink' is called as:
 *
 * {{#formlink:form=|link text=|link type=|tooltip=|query string=|target=
 * |popup|...additional query string values...}}
 *
 * This function returns HTML representing a link to a form; given that
 * no page name is entered by the the user, the form must be one that
 * creates an automatic page name, or else it will display an error
 * message when the user clicks on the link.
 *
 * The first two arguments are mandatory:
 * 'form' is the name of the SF form, and 'link text' is the text of the link.
 * 'link type' is the type of the link: if set to 'button', the link will be
 * a button; if set to 'post button', the link will be a button that uses the
 * 'POST' method to send other values to the form; if set to anything else or
 * not called, it will be a standard hyperlink.
 * 'tooltip' sets a hovering tooltip text, if it's an actual link.
 * 'query string' is the text to be added to the generated URL's query string
 * (or, in the case of 'post button', to be sent as hidden inputs).
 * 'target' is an optional value, setting the name of the page to be
 * edited by the form.
 *
 * Example: to create a link to add data with a form called
 * 'User' within a namespace also called 'User', and to have the form
 * preload with the page called 'UserStub', you could call the following:
 *
 * {{#formlink:form=User|link text=Add a user
 * |query string=namespace=User&preload=UserStub}}
 *
 * 
 * 'queryformlink' links to Special:RunQuery, instead of Special:FormEdit.
 * It is called in the exact same way as 'formlink', though the
 * 'target' parameter should not be specified, and 'link text' is now optional,
 * since it has a default value of 'Run query' (in whatever language the
 * wiki is in).
 *
 *
 * 'arraymap' is called as:
 *
 * {{#arraymap:value|delimiter|var|formula|new_delimiter}}
 *
 * This function applies the same transformation to every section of a
 * delimited string; each such section, as dictated by the 'delimiter'
 * value, is given the same transformation that the 'var' string is
 * given in 'formula'. Finally, the transformed strings are joined
 * together using the 'new_delimiter' string. Both 'delimiter' and
 * 'new_delimiter' default to commas.
 *
 * Example: to take a semicolon-delimited list, and place the attribute
 * 'Has color' around each element in the list, you could call the
 * following:
 *
 * {{#arraymap:blue;red;yellow|;|x|[[Has color::x]]|;}}
 *
 *
 * 'arraymaptemplate' is called as:
 *
 * {{#arraymaptemplate:value|template|delimiter|new_delimiter}}
 *
 * This function makes the same template call for every section of a
 * delimited string; each such section, as dictated by the 'delimiter'
 * value, is passed as a first parameter to the template specified.
 * Finally, the transformed strings are joined together using the
 * 'new_delimiter' string. Both 'delimiter' and 'new_delimiter'
 * default to commas.
 *
 * Example: to take a semicolon-delimited list, and call a template
 * named 'Beautify' on each element in the list, you could call the
 * following:
 *
 * {{#arraymaptemplate:blue;red;yellow|Beautify|;|;}}
 *
 *
 * 'autoedit' is called as:
 *
 * {{#autoedit:form=|target=|link text=|link type=|query string=|reload}}
 *
 * This function creates a link or button that, when clicked on,
 * automatically modifies the specified page according to the values in the
 * 'query string' variable.
 *
 * The parameters of #autoedit are called in the same format as those
 * of #formlink. The one addition, 'reload', will, if added, cause the page
 * to reload after the user clicks the button or link.
 *
 * @author Yaron Koren
 * @author Sergey Chernyshev
 * @author Daniel Friesen
 * @author Barry Welch
 * @author Christoph Burgmer
 * @author Stephan Gambke
 * @author MWJames
 */

class SFParserFunctions {

	// static variable to guarantee that Javascript for autocompletion
	// only gets added to the page once
	static $num_autocompletion_inputs = 0;

	static function registerFunctions( &$parser ) {

		global $wgOut;

		$parser->setFunctionHook( 'forminput', array( 'SFParserFunctions', 'renderFormInput' ) );
		$parser->setFunctionHook( 'formlink', array( 'SFParserFunctions', 'renderFormLink' ) );
		$parser->setFunctionHook( 'queryformlink', array( 'SFParserFunctions', 'renderQueryFormLink' ) );
		if ( defined( get_class( $parser ) . '::SFH_OBJECT_ARGS' ) ) {
			$parser->setFunctionHook( 'arraymap', array( 'SFParserFunctions', 'renderArrayMapObj' ), SFH_OBJECT_ARGS );
			$parser->setFunctionHook( 'arraymaptemplate', array( 'SFParserFunctions', 'renderArrayMapTemplateObj' ), SFH_OBJECT_ARGS );
		} else {
			$parser->setFunctionHook( 'arraymap', array( 'SFParserFunctions', 'renderArrayMap' ) );
			$parser->setFunctionHook( 'arraymaptemplate', array( 'SFParserFunctions', 'renderArrayMapTemplate' ) );
		}

		$parser->setFunctionHook( 'autoedit', array( 'SFParserFunctions', 'renderAutoEdit' ) );

		// load jQuery on MW 1.16
		if ( is_callable( array( $wgOut, 'includeJQuery' ) ) ) {
			$wgOut->includeJQuery();
		}

		return true;
	}

	static function renderFormLink ( &$parser ) {
		$params = func_get_args();
		array_shift( $params ); // We don't need the parser.
		
		// hack to remove newline from beginning of output, thanks to
		// http://jimbojw.com/wiki/index.php?title=Raw_HTML_Output_from_a_MediaWiki_Parser_Function
		return $parser->insertStripItem( SFUtils::createFormLink( $parser, 'FormEdit', $params ), $parser->mStripState );
	}

	static function renderQueryFormLink ( &$parser ) {
		$params = func_get_args();
		array_shift( $params ); // We don't need the parser.
		// If it's a popup, make this just a static display of
		// results, with no 'additiona query' form, since at the
		// moment additional queries can't be handled anyway.
		if ( in_array( 'popup', $params ) ) {
			$params[] = 'wpRunQuery=true';
			$params[] = 'additionalquery=false';
		}
		
		// hack to remove newline from beginning of output, thanks to
		// http://jimbojw.com/wiki/index.php?title=Raw_HTML_Output_from_a_MediaWiki_Parser_Function
		return $parser->insertStripItem( SFUtils::createFormLink( $parser, 'RunQuery', $params ), $parser->mStripState );
	}

	static function renderFormInput ( &$parser ) {

		$params = func_get_args();
		array_shift( $params ); // don't need the parser
		// set defaults
		$inFormName = $inValue = $inButtonStr = $inQueryStr = '';
		$inQueryArr = array();
		$positionalParameters = false;
		$inAutocompletionSource = '';
		$inRemoteAutocompletion = false;
		$inSize = 25;
		$classStr = "";
		// assign params - support unlabelled params, for backwards compatibility
		foreach ( $params as $i => $param ) {
			$elements = explode( '=', $param, 2 );

			// set param_name and value
			if ( count( $elements ) > 1 && !$positionalParameters ) {
				$param_name = trim( $elements[0] );

				// parse (and sanitize) parameter values
				$value = trim( $parser->recursiveTagParse( $elements[1] ) );
			} else {
				$param_name = null;

				// parse (and sanitize) parameter values
				$value = trim( $parser->recursiveTagParse( $param ) );
			}

			if ( $param_name == 'form' )
				$inFormName = $value;
			elseif ( $param_name == 'size' )
				$inSize = $value;
			elseif ( $param_name == 'default value' )
				$inValue = $value;
			elseif ( $param_name == 'button text' )
				$inButtonStr = $value;
			elseif ( $param_name == 'query string' ) {
				// Change HTML-encoded ampersands directly to
				// URL-encoded ampersands, so that the string
				// doesn't get split up on the '&'.
				$inQueryStr = str_replace( '&amp;', '%26', $value );
				
				parse_str($inQueryStr, $arr);
				$inQueryArr = SFUtils::array_merge_recursive_distinct( $inQueryArr, $arr );
			} elseif ( $param_name == 'autocomplete on category' ) {
				$inAutocompletionSource = $value;
				$autocompletion_type = 'category';
			} elseif ( $param_name == 'autocomplete on namespace' ) {
				$inAutocompletionSource = $value;
				$autocompletion_type = 'namespace';
			} elseif ( $param_name == 'remote autocompletion' ) {
				$inRemoteAutocompletion = true;
			} elseif ( $param_name == null && $value == 'popup' ) {
				SFUtils::loadScriptsForPopupForm( $parser );
				$classStr = 'popupforminput';
			} elseif ( $param_name !== null && !$positionalParameters ) {

				$value = urlencode($value);
				parse_str("$param_name=$value", $arr);
				$inQueryArr = SFUtils::array_merge_recursive_distinct( $inQueryArr, $arr );
				
			} elseif ( $i == 0 ) {
				$inFormName = $value;
				$positionalParameters = true;
			} elseif ( $i == 1 ) {
				$inSize = $value;
			} elseif ( $i == 2 ) {
				$inValue = $value;
			} elseif ( $i == 3 ) {
				$inButtonStr = $value;
			} elseif ( $i == 4 ) {
				// Change HTML-encoded ampersands directly to
				// URL-encoded ampersands, so that the string
				// doesn't get split up on the '&'.
				$inQueryStr = str_replace( '&amp;', '%26', $value );
				
				parse_str($inQueryStr, $arr);
				$inQueryArr = SFUtils::array_merge_recursive_distinct( $inQueryArr, $arr );
			}
		}

		$fs = SFUtils::getSpecialPage( 'FormStart' );

		$fs_url = $fs->getTitle()->getLocalURL();
		$str = <<<END
			<form name="createbox" action="$fs_url" method="get" class="$classStr">
			<p>

END;
		$formInputAttrs = array( 'size' => $inSize );

		// Now apply the necessary settings and Javascript, depending
		// on whether or not there's autocompletion (and whether the
		// autocompletion is local or remote).
		$input_num = 1;
		if ( empty( $inAutocompletionSource ) ) {
			$formInputAttrs['class'] = 'formInput';
		} else {
			self::$num_autocompletion_inputs++;
			$input_num = self::$num_autocompletion_inputs;
			// place the necessary Javascript on the page, and
			// disable the cache (so the Javascript will show up) -
			// if there's more than one autocompleted #forminput
			// on the page, we only need to do this the first time
			if ( $input_num == 1 ) {
				$parser->disableCache();
				SFUtils::addJavascriptAndCSS();
			}

			$inputID = 'input_' . $input_num;
			$formInputAttrs['id'] = $inputID;
			$formInputAttrs['class'] = 'autocompleteInput createboxInput formInput';
			if ( $inRemoteAutocompletion ) {
				$formInputAttrs['autocompletesettings'] = $inAutocompletionSource;
				$formInputAttrs['autocompletedatatype'] = $autocompletion_type;
			} else {
				$autocompletion_values = SFUtils::getAutocompleteValues( $inAutocompletionSource, $autocompletion_type );
				global $sfgAutocompleteValues;
				$sfgAutocompleteValues[$inputID] = $autocompletion_values;
				$formInputAttrs['autocompletesettings'] = $inputID;
			}
		}

		$str .= "\t" . Html::input( 'page_name', $inValue, 'text', $formInputAttrs ) . "\n";

		// if the form start URL looks like "index.php?title=Special:FormStart"
		// (i.e., it's in the default URL style), add in the title as a
		// hidden value
		if ( ( $pos = strpos( $fs_url, "title=" ) ) > - 1 ) {
			$str .= Html::hidden( "title", urldecode( substr( $fs_url, $pos + 6 ) ) );
		}
		if ( $inFormName == '' ) {
			$str .= SFUtils::formDropdownHTML();
		} else {
			$str .= Html::hidden( "form", $inFormName );
		}

		// Recreate the passed-in query string as a set of hidden variables.
		if ( !empty( $inQueryArr ) ) {
			// query string has to be turned into hidden inputs.

			$query_components = explode( '&', http_build_query( $inQueryArr, '', '&' ) );

			foreach ( $query_components as $query_component ) {
				$var_and_val = explode( '=', $query_component, 2 );
				if ( count( $var_and_val ) == 2 ) {
					$str .= Html::hidden( urldecode( $var_and_val[0] ), urldecode( $var_and_val[1] ) );
				}
			}
		}

		$button_str = ( $inButtonStr != '' ) ? $inButtonStr : wfMsg( 'sf_formstart_createoredit' );
		$str .= <<<END
			<input type="submit" value="$button_str" /></p>
			</form>

END;
		if ( ! empty( $inAutocompletionSource ) ) {
			$str .= "\t\t\t" .
				Html::element( 'div',
					array(
						'class' => 'page_name_auto_complete',
						'id' => "div_$input_num",
					),
					// it has to be <div></div>, not
					// <div />, to work properly - stick
					// in a space as the content
					' '
				) . "\n";
		}

		// hack to remove newline from beginning of output, thanks to
		// http://jimbojw.com/wiki/index.php?title=Raw_HTML_Output_from_a_MediaWiki_Parser_Function
		return $parser->insertStripItem( $str, $parser->mStripState );
	}

	/**
	 * {{#arraymap:value|delimiter|var|formula|new_delimiter}}
	 */
	static function renderArrayMap( &$parser, $value = '', $delimiter = ',', $var = 'x', $formula = 'x', $new_delimiter = ', ' ) {
		// let '\n' represent newlines - chances that anyone will
		// actually need the '\n' literal are small
		$delimiter = str_replace( '\n', "\n", $delimiter );
		$actual_delimiter = $parser->mStripState->unstripNoWiki( $delimiter );
		$new_delimiter = str_replace( '\n', "\n", $new_delimiter );

		if ( $actual_delimiter == '' ) {
			$values_array = preg_split( '/(.)/u', $value, -1, PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE );
		} else {
			$values_array = explode( $actual_delimiter, $value );
		}

		$results = array();
		foreach ( $values_array as $cur_value ) {
			$cur_value = trim( $cur_value );
			// ignore a value if it's null
			if ( $cur_value != '' ) {
				// remove whitespaces
				$results[] = str_replace( $var, $cur_value, $formula );
			}
		}
		return implode( $new_delimiter, $results );
	}

	/**
	 * SFH_OBJ_ARGS
	 * {{#arraymap:value|delimiter|var|formula|new_delimiter}}
	 */
	static function renderArrayMapObj( &$parser, $frame, $args ) {
		# Set variables
		$value = isset( $args[0] ) ? trim( $frame->expand( $args[0] ) ) : '';
		$delimiter = isset( $args[1] ) ? trim( $frame->expand( $args[1] ) ) : ',';
		$var = isset( $args[2] ) ? trim( $frame->expand( $args[2], PPFrame::NO_ARGS | PPFrame::NO_TEMPLATES ) ) : 'x';
		$formula = isset( $args[3] ) ? $args[3] : 'x';
		$new_delimiter = isset( $args[4] ) ? trim( $frame->expand( $args[4] ) ) : ', ';
		# Unstrip some
		$delimiter = $parser->mStripState->unstripNoWiki( $delimiter );
		# let '\n' represent newlines
		$delimiter = str_replace( '\n', "\n", $delimiter );
		$new_delimiter = str_replace( '\n', "\n", $new_delimiter );

		if ( $delimiter == '' ) {
			$values_array = preg_split( '/(.)/u', $value, -1, PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE );
		} else {
			$values_array = explode( $delimiter, $value );
		}

		$results_array = array();
		// add results to the results array only if the old value was
		// non-null, and the new, mapped value is non-null as well.
		foreach ( $values_array as $old_value ) {
			$old_value = trim( $old_value );
			if ( $old_value == '' ) continue;
			$result_value = $frame->expand( $formula, PPFrame::NO_ARGS | PPFrame::NO_TEMPLATES );
			$result_value = str_replace( $var, $old_value, $result_value );
			$result_value = $parser->preprocessToDom( $result_value, $frame->isTemplate() ? Parser::PTD_FOR_INCLUSION : 0 );
			$result_value = trim( $frame->expand( $result_value ) );
			if ( $result_value == '' ) continue;
			$results_array[] = $result_value;
		}
		return implode( $new_delimiter, $results_array );
	}

	/**
	 * {{#arraymaptemplate:value|template|delimiter|new_delimiter}}
	 */
	static function renderArrayMapTemplate( &$parser, $value = '', $template = '', $delimiter = ',', $new_delimiter = ', ' ) {
		# let '\n' represent newlines
		$delimiter = str_replace( '\n', "\n", $delimiter );
		$actual_delimiter = $parser->mStripState->unstripNoWiki( $delimiter );
		$new_delimiter = str_replace( '\n', "\n", $new_delimiter );

		if ( $actual_delimiter == '' ) {
			$values_array = preg_split( '/(.)/u', $value, -1, PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE );
		} else {
			$values_array = explode( $actual_delimiter, $value );
		}

		$results = array();
		$template = trim( $template );

		foreach ( $values_array as $cur_value ) {
			$cur_value = trim( $cur_value );
			// ignore a value if it's null
			if ( $cur_value != '' ) {
				// remove whitespaces
				$results[] = '{{' . $template . '|' . $cur_value . '}}';
			}
		}

		return array( implode( $new_delimiter, $results ), 'noparse' => false, 'isHTML' => false );
	}

	/**
	 * SFH_OBJ_ARGS
	 * {{#arraymaptemplate:value|template|delimiter|new_delimiter}}
	 */
	static function renderArrayMapTemplateObj( &$parser, $frame, $args ) {
		# Set variables
		$value = isset( $args[0] ) ? trim( $frame->expand( $args[0] ) ) : '';
		$template = isset( $args[1] ) ? trim( $frame->expand( $args[1] ) ) : '';
		$delimiter = isset( $args[2] ) ? trim( $frame->expand( $args[2] ) ) : ',';
		$new_delimiter = isset( $args[3] ) ? trim( $frame->expand( $args[3] ) ) : ', ';
		# Unstrip some
		$delimiter = $parser->mStripState->unstripNoWiki( $delimiter );
		# let '\n' represent newlines
		$delimiter = str_replace( '\n', "\n", $delimiter );
		$new_delimiter = str_replace( '\n', "\n", $new_delimiter );

		if ( $delimiter == '' ) {
			$values_array = preg_split( '/(.)/u', $value, -1, PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE );
		} else {
			$values_array = explode( $delimiter, $value );
		}

		$results_array = array();
		foreach ( $values_array as $old_value ) {
			$old_value = trim( $old_value );
			if ( $old_value == '' ) continue;
			$bracketed_value = $frame->virtualBracketedImplode( '{{', '|', '}}',
				$template, '1=' . $old_value );
			// special handling if preprocessor class is set to
			// 'Preprocessor_Hash'
			if ( $bracketed_value instanceof PPNode_Hash_Array ) {
				$bracketed_value = $bracketed_value->value;
			}
			$results_array[] = $parser->replaceVariables(
				implode( '', $bracketed_value ), $frame );
		}
		return implode( $new_delimiter, $results_array );
	}


	static function renderAutoEdit( &$parser ) {
		global $wgTitle;

		// set defaults
		$formcontent = '';
		$linkString = null;
		$linkType = 'span';
		$summary = null;
		$classString = 'autoedit-trigger';
		$inQueryArr = array();

		// parse parameters
		$params = func_get_args();
		array_shift( $params ); // don't need the parser

		foreach ( $params as $param ) {

			$elements = explode( '=', $param, 2 );

			$key = trim( $elements[ 0 ] );
			$value = ( count( $elements ) > 1 ) ? trim( $elements[ 1 ] ) : '';

			switch ( $key ) {
				case 'link text':
					$linkString = $parser->recursiveTagParse( $value );
					break;
				case 'link type':
					$linkType = $parser->recursiveTagParse( $value );
					break;
				case 'reload':
					$classString .= ' reload';
					break;
				case 'summary':
					$summary = $parser->recursiveTagParse( $value );
					break;
				case 'query string' :

					// Change HTML-encoded ampersands directly to
					// URL-encoded ampersands, so that the string
					// doesn't get split up on the '&'.
					$inQueryStr = str_replace( '&amp;', '%26', $value );

					parse_str( $inQueryStr, $arr );
					$inQueryArr = SFUtils::array_merge_recursive_distinct( $inQueryArr, $arr );
					break;

				case 'ok text':
				case 'error text':
					// do not parse ok text or error text yet. Will be parsed on api call
					$arr = array( $key => $value );
					$inQueryArr = SFUtils::array_merge_recursive_distinct( $inQueryArr, $arr );
					break;
				
				default :

					$value = $parser->recursiveTagParse( $value );
					$arr = array( $key => $value );
					$inQueryArr = SFUtils::array_merge_recursive_distinct( $inQueryArr, $arr );
			}
		}

		// query string has to be turned into hidden inputs.
		if ( !empty( $inQueryArr ) ) {

			$query_components = explode( '&', http_build_query( $inQueryArr, '', '&' ) );

			foreach ( $query_components as $query_component ) {
				$var_and_val = explode( '=', $query_component, 2 );
				if ( count( $var_and_val ) == 2 ) {
					$formcontent .= Html::hidden( urldecode( $var_and_val[0] ), urldecode( $var_and_val[1] ) );
				}
			}
		}

		if ( $linkString == null ) return null;

		if ( $linkType == 'button' ) {
			$linkElement = Html::rawElement( 'button', array( 'class' => $classString ), $linkString );
		} elseif ( $linkType == 'link' ) {
			$linkElement = Html::rawElement( 'a', array( 'class' => $classString, 'href' => "#" ), $linkString );
		} else {
			$linkElement = Html::rawElement( 'span', array( 'class' => $classString ), $linkString );
		}

		if ( $summary == null ) {
			$summary = wfMsg( 'sf_autoedit_summary', "[[$wgTitle]]" );
		}

		$formcontent .= Html::hidden( 'wpSummary', $summary );

		$form = Html::rawElement( 'form', array( 'class' => 'autoedit-data' ), $formcontent );

		// ensure loading of jQuery and style sheets
		self::loadScriptsForAutoEdit( $parser );

		$output = Html::rawElement( 'div', array( 'class' => 'autoedit' ),
				$linkElement .
				Html::rawElement( 'span', array( 'class' => "autoedit-result" ), null ) .
				$form
		);

		// return output HTML
		return $parser->insertStripItem( $output, $parser->mStripState );
	}

	/**
	 * Load scripts and style files for AutoEdit
	 */
	private static function loadScriptsForAutoEdit ( &$parser ) {
		global $sfgScriptPath;

		if ( defined( 'MW_SUPPORTS_RESOURCE_MODULES' ) ) {
			$parser->getOutput()->addModules( 'ext.semanticforms.autoedit' );
		} else {

			static $loaded = false;

			// load JavaScript and CSS files only once
			if ( !$loaded ) {

				// load extensions JavaScript
				$parser->getOutput()->addHeadItem(
					'<script type="text/javascript" src="' . $sfgScriptPath
					. '/libs/SF_autoedit.js"></script> ' . "\n",
					'sf_autoedit_script'
				);

				// load extensions style sheet
				$parser->getOutput()->addHeadItem(
					'<link rel="stylesheet" href="' . $sfgScriptPath
					. '/skins/SF_autoedit.css"/> ' . "\n",
					'sf_autoedit_style'
				);

				$loaded = true;
			}
		}

		return true;
	}

}
