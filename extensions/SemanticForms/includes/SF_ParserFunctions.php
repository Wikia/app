<?php
/**
 * Parser functions for Semantic Forms.
 *
 * Four parser functions are defined: 'forminput', 'formlink', 'arraymap'
 * and 'arraymaptemplate'.
 *
 * 'forminput' is called as:
 *
 * {{#forminput:form=|size=|default value=|button text=|query string=
 * |autocomplete on category=|autocomplete on namespace=}}
 *
 * This function returns HTML representing a form to let the user enter the
 * name of a page to be added or edited using a Semantic Forms form. All
 * arguments are optional. 'form' is the name of the SF form to be used;
 * if it is left empty, a dropdown will appear, letting the user chose among
 * all existing forms. 'size' represents the size of the text input (default
 * is 25), and 'default value' is the starting value of the input.
 * 'button text' is the text that will appear on the "submit" button, and
 * 'query string' is the set of values that you want passed in through the
 * query string to the form. Finally, you can can specify that the user will
 * get autocompletion using the values from a category or namespace of your
 * choice, using 'autocomplete on category' or 'autocomplete on namespace'
 * (you can only use one). To autcomplete on all pages in the main (blank)
 * namespace, specify "autocomplete on namespace=main".
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
 * {{#formlink:form=|link text=|link type=|query string=}}
 *
 * This function returns HTML representing a link to a form; given that
 * no page name is entered by the the user, the form must be one that
 * creates an automatic page name, or else it will display an error
 * message when the user clicks on the link.
 *
 * The first two arguments are mandatory: 'form' is the name of the SF
 * form, and 'link text' is the text of the link. 'link type' is the type of
 * the link: if set to 'button', the link will be a button; if set to
 * 'post button', the link will be a button that uses the 'POST' method to
 * send other values to the form; if set to anything else or not called, it
 * will be a standard hyperlink. 'query string' is the text to be added to
 * the generated URL's query string (or, in the case of 'post button' to
 * be sent as hidden inputs).
 *
 * Example: to create a link to add data with a form called
 * 'User' within a namespace also called 'User', and to have the form
 * preload with the page called 'UserStub', you could call the following:
 *
 * {{#formlink:form=User|link text=Add a user
 * |query string=namespace=User&preload=UserStub}}
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
 * @author Yaron Koren
 * @author Sergey Chernyshev
 * @author Daniel Friesen
 * @author Barry Welch
 */

class SFParserFunctions {

	// static variable to guarantee that Javascript for autocompletion
	// only gets added to the page once
	static $num_autocompletion_inputs = 0;

	static function registerFunctions( &$parser ) {
		$parser->setFunctionHook( 'forminput', array( 'SFParserFunctions', 'renderFormInput' ) );
		$parser->setFunctionHook( 'formlink', array( 'SFParserFunctions', 'renderFormLink' ) );
		if ( defined( get_class( $parser ) . '::SFH_OBJECT_ARGS' ) ) {
			$parser->setFunctionHook( 'arraymap', array( 'SFParserFunctions', 'renderArrayMapObj' ), SFH_OBJECT_ARGS );
			$parser->setFunctionHook( 'arraymaptemplate', array( 'SFParserFunctions', 'renderArrayMapTemplateObj' ), SFH_OBJECT_ARGS );
		} else {
			$parser->setFunctionHook( 'arraymap', array( 'SFParserFunctions', 'renderArrayMap' ) );
			$parser->setFunctionHook( 'arraymaptemplate', array( 'SFParserFunctions', 'renderArrayMapTemplate' ) );
		}
		return true;
	}

	// FIXME: Can be removed when new style magic words are used (introduced in r52503)
	static function languageGetMagic( &$magicWords, $langCode = "en" ) {
		switch ( $langCode ) {
		default:
			$magicWords['forminput'] = array ( 0, 'forminput' );
			$magicWords['formlink']	= array ( 0, 'formlink' );
			$magicWords['arraymap']	= array ( 0, 'arraymap' );
			$magicWords['arraymaptemplate'] = array ( 0, 'arraymaptemplate' );
		}
		return true;
	}

	static function renderFormLink ( &$parser ) {
		$params = func_get_args();
		array_shift( $params ); // don't need the parser
		// set defaults
		$inFormName = $inLinkStr = $inLinkType = $inQueryStr = '';
		// assign params - support unlabelled params, for backwards compatibility
		foreach ( $params as $i => $param ) {
			$elements = explode( '=', $param, 2 );
			$param_name = null;
			$value = $param;
			if ( count( $elements ) > 1 ) {
				$param_name = $elements[0];
				$value = $elements[1];
			}
			if ( $param_name == 'form' )
				$inFormName = $value;
			elseif ( $param_name == 'link text' )
				$inLinkStr = $value;
			elseif ( $param_name == 'link type' )
				$inLinkType = $value;
			elseif ( $param_name == 'query string' )
				$inQueryStr = $value;
			elseif ( $i == 0 )
				$inFormName = $param;
			elseif ( $i == 1 )
				$inLinkStr = $param;
			elseif ( $i == 2 )
				$inLinkType = $param;
			elseif ( $i == 3 )
				$inQueryStr = $param;
		}

		$ad = SpecialPage::getPage( 'FormEdit' );
		$link_url = $ad->getTitle()->getLocalURL() . "/$inFormName";
		$link_url = str_replace( ' ', '_', $link_url );
		if ( $inQueryStr != '' ) {
			// special handling for 'post button' - query string
			// has to be turned into hidden inputs
			if ( $inLinkType == 'post button' ) {
				$hidden_inputs = "";
				$query_components = explode( '&', $inQueryStr );
				foreach ( $query_components as $query_component ) {
					$query_component = urldecode( $query_component );
					$var_and_val = explode( '=', $query_component );
					if ( count( $var_and_val ) == 2 ) {
						$hidden_inputs .= '<input type="hidden" name="' . $var_and_val[0] . '" value="' . $var_and_val[1] . '" /> ';
					}
				}
			} else {
				$link_url .= ( strstr( $link_url, '?' ) ) ? '&' : '?';
				// URL-encode any spaces or plus-signs in the query string
				$inQueryStr = str_replace( array( ' ', '+' ),
					array( '%20', '%2B' ),
					$inQueryStr );
				$link_url .= $inQueryStr;
			}
		}
		if ( $inLinkType == 'button' ) {
			$link_url = html_entity_decode( $link_url, ENT_QUOTES );
			$link_url = str_replace( "'", "\'", $link_url );
			$str = "<form><input type=\"button\" value=\"$inLinkStr\" onclick=\"window.location.href='$link_url'\"></form>";
		} elseif ( $inLinkType == 'post button' ) {
			$str = "<form action=\"$link_url\" method=\"post\"><input type=\"submit\" value=\"$inLinkStr\">$hidden_inputs</form>";
		} else {
			$str = "<a href=\"$link_url\">$inLinkStr</a>";
		}
		// hack to remove newline from beginning of output, thanks to
		// http://jimbojw.com/wiki/index.php?title=Raw_HTML_Output_from_a_MediaWiki_Parser_Function
		return $parser->insertStripItem( $str, $parser->mStripState );
	}

	static function renderFormInput ( &$parser ) {
		$params = func_get_args();
		array_shift( $params ); // don't need the parser
		// set defaults
		$inFormName = $inValue = $inButtonStr = $inQueryStr = '';
		$inAutocompletionSource = '';
		$inSize = 25;
		// assign params - support unlabelled params, for backwards compatibility
		foreach ( $params as $i => $param ) {
			$elements = explode( '=', $param, 2 );
			$param_name = null;
			$value = $param;
			if ( count( $elements ) > 1 ) {
				$param_name = $elements[0];
				$value = $elements[1];
			}
			if ( $param_name == 'form' )
				$inFormName = $value;
			elseif ( $param_name == 'size' )
				$inSize = $value;
			elseif ( $param_name == 'default value' )
				$inValue = $value;
			elseif ( $param_name == 'button text' )
				$inButtonStr = $value;
			elseif ( $param_name == 'query string' )
				$inQueryStr = $value;
			elseif ( $param_name == 'autocomplete on category' ) {
				$inAutocompletionSource = $value;
				$autocompletion_type = 'category';
			} elseif ( $param_name == 'autocomplete on namespace' ) {
				$inAutocompletionSource = $value;
				$autocompletion_type = 'namespace';
			}
			elseif ( $i == 0 )
				$inFormName = $param;
			elseif ( $i == 1 )
				$inSize = $param;
			elseif ( $i == 2 )
				$inValue = $param;
			elseif ( $i == 3 )
				$inButtonStr = $param;
			elseif ( $i == 4 )
				$inQueryStr = $param;
		}

		$input_num = 1;
		if ( ! empty( $inAutocompletionSource ) ) {
			self::$num_autocompletion_inputs++;
			$input_num = self::$num_autocompletion_inputs;
			// place the necessary Javascript on the page, and
			// disable the cache (so the Javascript will show up) -
			// if there's more than one autocompleted #forminput
			// on the page, we only need to do this the first time
			$autocompletion_javascript = '';
			if ( $input_num == 1 ) {
				$parser->disableCache();
				SFUtils::addJavascriptAndCSS();
				$autocompletion_javascript = SFFormUtils::autocompletionJavascript();
			}
			$autocompletion_str = SFFormInputs::createAutocompleteValuesString( $inAutocompletionSource, $autocompletion_type );
			$javascript_text = <<<END
		<script type="text/javascript"> 
/*<![CDATA[*/ 
$autocompletion_javascript
autocompletemappings[$input_num] = 'input_{$input_num}';
autocompletestrings['input_{$input_num}'] = $autocompletion_str;
 /*]]>*/</script>

END;
			global $wgOut;
			$wgOut->addScript( $javascript_text );
		}

		$fs = SpecialPage::getPage( 'FormStart' );
		$fs_url = $fs->getTitle()->getLocalURL();
		if ( empty( $inAutocompletionSource ) ) {
			$str = <<<END
			<form action="$fs_url" method="get">
			<p><input type="text" name="page_name" size="$inSize" value="$inValue" />

END;
		} else {
			// if there's autocompletion, we need to place it in
			// a table so that the autocompletion <div> won't lead
			// to the button being on a separate line (this can
			// probably be done just with CSS instead, but I don't
			// know how)
			$str = <<<END
			<form name="createbox" action="$fs_url" method="get">
			<table><tr><td><input type="text" name="page_name" id="input_$input_num" size="$inSize" value="$inValue"  class="autocompleteInput createboxInput" />
			<div class="page_name_auto_complete" id="div_$input_num"></div>
			</td>

END;
		}
		// if the add page URL looks like "index.php?title=Special:AddPage"
		// (i.e., it's in the default URL style), add in the title as a
		// hidden value
		if ( ( $pos = strpos( $fs_url, "title=" ) ) > - 1 ) {
			$str .= '			<input type="hidden" name="title" value="' . urldecode( substr( $fs_url, $pos + 6 ) ) . '">' . "\n";
		}
		if ( $inFormName == '' ) {
			$str .= SFUtils::formDropdownHTML();
		} else {
			$str .= '			<input type="hidden" name="form" value="' . $inFormName . '">' . "\n";
			$str .= '			<input type="hidden" name="form2" value="' . $inFormName . '">' . "\n";
		}
		// recreate the passed-in query string as a set of hidden variables
		$query_components = explode( '&', $inQueryStr );
		foreach ( $query_components as $component ) {
			$subcomponents = explode( '=', $component, 2 );
			$key = ( isset( $subcomponents[0] ) ) ? $subcomponents[0] : '';
			$val = ( isset( $subcomponents[1] ) ) ? $subcomponents[1] : '';
			if ( ! empty( $key ) )
				$str .= '			<input type="hidden" name="' . $key . '" value="' . $val . '">' . "\n";
		}
		wfLoadExtensionMessages( 'SemanticForms' );
		$button_str = ( $inButtonStr != '' ) ? $inButtonStr : wfMsg( 'sf_formstart_createoredit' );
		if ( empty( $inAutocompletionSource ) ) {
			$str .= <<<END
			<input type="submit" value="$button_str"></p>
			</form>

END;
		} else {
			$str .= <<<END
			<td><input type="submit" value="$button_str"></td></tr></table>
			</form>

END;
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
		$new_delimiter = str_replace( '\n', "\n", $new_delimiter );
		$values_array = explode( $parser->mStripState->unstripNoWiki( $delimiter ), $value );
		$results = array();
		foreach ( $values_array as $cur_value ) {
			$cur_value = trim( $cur_value );
			// ignore a value if it's null
			if ( '' != $cur_value ) {
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
		$value         = isset( $args[0] ) ? trim( $frame->expand( $args[0] ) ) : '';
		$delimiter     = isset( $args[1] ) ? trim( $frame->expand( $args[1] ) ) : ',';
		$var           = isset( $args[2] ) ? trim( $frame->expand( $args[2], PPFrame::NO_ARGS | PPFrame::NO_TEMPLATES ) ) : 'x';
		$formula       = isset( $args[3] ) ? $args[3] : 'x';
		$new_delimiter = isset( $args[4] ) ? trim( $frame->expand( $args[4] ) ) : ', ';
		# Unstrip some
		$delimiter = $parser->mStripState->unstripNoWiki( $delimiter );
		# let '\n' represent newlines
		$delimiter = str_replace( '\n', "\n", $delimiter );
		$new_delimiter = str_replace( '\n', "\n", $new_delimiter );
	
		$values_array = explode( $delimiter, $value );
		$results_array = array();
		foreach ( $values_array as $old_value ) {
			$old_value = trim( $old_value );
			if ( $old_value == '' ) continue;
			$result_value = $frame->expand( $formula, PPFrame::NO_ARGS | PPFrame::NO_TEMPLATES );
			$result_value  = str_replace( $var, $old_value, $result_value );
			$result_value  = $parser->preprocessToDom( $result_value, $frame->isTemplate() ? Parser::PTD_FOR_INCLUSION : 0 );
			$results_array[] = trim( $frame->expand( $result_value ) );
		}
		return implode( $new_delimiter, $results_array );
	}

	/**
	 * {{#arraymaptemplate:value|template|delimiter|new_delimiter}}
	 */
	static function renderArrayMapTemplate( &$parser, $value = '', $template = '', $delimiter = ',', $new_delimiter = ', ' ) {
		# let '\n' represent newlines
		$delimiter = str_replace( '\n', "\n", $delimiter );
		$new_delimiter = str_replace( '\n', "\n", $new_delimiter );
		$values_array = explode( $parser->mStripState->unstripNoWiki( $delimiter ), $value );
		$results = array();
		$template = trim( $template );
		foreach ( $values_array as $cur_value ) {
			$cur_value = trim( $cur_value );
			// ignore a value if it's null
			if ( '' != $cur_value ) {
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
		$value         = isset( $args[0] ) ? trim( $frame->expand( $args[0] ) ) : '';
		$template      = isset( $args[1] ) ? trim( $frame->expand( $args[1] ) ) : '';
		$delimiter     = isset( $args[2] ) ? trim( $frame->expand( $args[2] ) ) : ',';
		$new_delimiter = isset( $args[3] ) ? trim( $frame->expand( $args[3] ) ) : ', ';
		# Unstrip some
		$delimiter = $parser->mStripState->unstripNoWiki( $delimiter );
		# let '\n' represent newlines
		$delimiter = str_replace( '\n', "\n", $delimiter );
		$new_delimiter = str_replace( '\n', "\n", $new_delimiter );

		$values_array = explode( $delimiter, $value );
		$results_array = array();
		foreach ( $values_array as $old_value ) {
			$old_value = trim( $old_value );
			if ( $old_value == '' ) continue;
			$results_array[] = $parser->replaceVariables(
				implode( '', $frame->virtualBracketedImplode( '{{', '|', '}}',
					$template, '1=' . $old_value ) ), $frame );
		}
		return implode( $new_delimiter, $results_array );
	}

}
