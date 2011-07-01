<?php
/**
 * Helper functions to display the various inputs of a user-generated form
 *
 * @author Yaron Koren
 * @author Jeffrey Stuckman
 * @author Matt Williamson
 * @author Patrick Nagel
 * @author Sanyam Goyal
 * @file
 * @ingroup SF
 */

/**
 * Parent class for all form input classes.
 * @ingroup SFFormInput
 */
class SFFormInput {
	/**
	 * Returns the set of SMW property types for which this input is
	 * meant to be the default one - ideally, no more than one input
	 * should declare itself the default for any specific type.
	 */
	public static function getDefaultPropTypes() {
		return array();
	}

	/**
	 * Returns the set of SMW property types which this input can
	 * handle, but for which it isn't the default input.
	 */
	public static function getOtherPropTypesHandled() {
		return array();
	}

	/**
	 * Like getDefaultPropTypes(), but for a field which holds a
	 * list of values instead of just one.
	 */
	public static function getDefaultPropTypeLists() {
		return array();
	}

	/**
	 * Like getOtherPropTypesHandled(), but for a field which holds a
	 * list of values instead of just one.
	 */
	public static function getOtherPropTypeListsHandled() {
		return array();
	}

	/**
	 * Returns the set of parameters for this form input.
	 */
	public static function getParameters() {
		$params = array();
		$params[] = array( 'name' => 'mandatory', 'type' => 'boolean', 'description' => wfMsg( 'sf_forminputs_mandatory' ) );
		$params[] = array( 'name' => 'restricted', 'type' => 'boolean', 'description' => wfMsg( 'sf_forminputs_restricted' ) );
		$params[] = array( 'name' => 'class', 'type' => 'string', 'description' => wfMsg( 'sf_forminputs_class' ) );
		$params[] = array( 'name' => 'property', 'type' => 'string', 'description' => wfMsg( 'sf_forminputs_property' ) );
		$params[] = array( 'name' => 'default', 'type' => 'string', 'description' => wfMsg( 'sf_forminputs_default' ) );
		return $params;
	}

	/**
	 * Returns the name and parameters for the initialization Javascript
	 * function for this input type, if any.
	 *
	 * This function is not used yet.
	 */
	public static function getInitJSFunction() {
		return null;
	}

	/**
	 * Returns the name and parameters for the validation Javascript
	 * functions for this input type, if any.
	 *
	 * This function is not used yet.
	 */
	public static function getValidationJSFunctions() {
		return array();
	}
}

/**
 * The base class for every form input that holds a pre-set enumeration
 * of values.
 * @ingroup SFFormInput
 */
class SFEnumInput extends SFFormInput {
	public static function getOtherPropTypesHandled() {
		return array( 'enumeration', '_boo' );
	}

	public static function getValuesParameters() {
		$params = array();
		$params[] = array( 'name' => 'values', 'type' => 'string', 'description' => wfMsg( 'sf_forminputs_values' ) );
		$params[] = array( 'name' => 'values from property', 'type' => 'string', 'description' => wfMsg( 'sf_forminputs_valuesfromproperty' ) );
		$params[] = array( 'name' => 'values from category', 'type' => 'string', 'description' => wfMsg( 'sf_forminputs_valuesfromcategory' ) );
		$params[] = array( 'name' => 'values from namespace', 'type' => 'string', 'description' => wfMsg( 'sf_forminputs_valuesfromnamespace' ) );
		$params[] = array( 'name' => 'values from concept', 'type' => 'string', 'description' => wfMsg( 'sf_forminputs_valuesfromconcept' ) );
		return $params;
	}

	public static function getParameters() {
		$params = parent::getParameters();
		$params = array_merge( $params, self::getValuesParameters() );
		$params[] = array( 'name' => 'show on select', 'type' => 'string', 'description' => wfMsg( 'sf_forminputs_showonselect' ) );
		return $params;
	}
}

/**
 * The base class for every form input that holds a list of elements, each
 * one from a pre-set enumeration of values.
 * @ingroup SFFormInput
 */
class SFMultiEnumInput extends SFEnumInput {
	public static function getOtherPropTypesHandled() {
		return array();
	}

	public static function getOtherPropTypeListsHandled() {
		return array( 'enumeration' );
	}

	public static function getParameters() {
		$params = parent::getParameters();
		$params[] = array( 'name' => 'delimiter', 'type' => 'string', 'description' => wfMsg( 'sf_forminputs_delimiter' ) );
		return $params;
	}
}

/**
 * @ingroup SFFormInput
 */
class SFTextInput extends SFFormInput {
	public static function getName() {
		return 'text';
	}

	public static function getDefaultPropTypes() {
		return array(
			'_str' => array( 'field_type' => 'string' ),
			'_num' => array( 'field_type' => 'number' ),
			'_uri' => array( 'field_type' => 'URL' ),
			'_ema' => array( 'field_type' => 'email' )
		);
	}

	public static function getOtherPropTypesHandled() {
		return array( '_wpg', '_geo' );
	}

	public static function getDefaultPropTypeLists() {
		return array(
			'_str' => array( 'field_type' => 'string', 'is_list' => 'true', 'size' => '100' ),
			'_num' => array( 'field_type' => 'number', 'is_list' => 'true', 'size' => '100' ),
			'_uri' => array( 'field_type' => 'URL', 'is_list' => 'true' ),
			'_ema' => array( 'field_type' => 'email', 'is_list' => 'true' )
		);
	}

	public static function getOtherPropTypeListsHandled() {
		return array( '_wpg' );
	}

	public static function uploadLinkHTML( $input_id, $delimiter = null, $default_filename = null ) {
		$upload_window_page = SpecialPage::getPage( 'UploadWindow' );
		$query_string = "sfInputID=$input_id";
		if ( $delimiter != null )
			$query_string .= "&sfDelimiter=$delimiter";
		if ( $default_filename != null )
			$query_string .= "&wpDestFile=$default_filename";
		$upload_window_url = $upload_window_page->getTitle()->getFullURL( $query_string );
		$upload_label = wfMsg( 'upload' );
		// window needs to be bigger for MediaWiki version 1.16+
		if ( class_exists( 'HTMLForm' ) )
			$style = "width:650 height:500";
		else
			$style = '';

		$linkAttrs = array(
			'href' => $upload_window_url,
			'class' => 'sfFancyBox',
			'title' => $upload_label,
			'rev' => $style
		);
		$text = "\t" . Xml::element( 'a', $linkAttrs, $upload_label ) . "\n";
		return $text;
	}

	public static function getHTML( $cur_value, $input_name, $is_mandatory, $is_disabled, $other_args ) {
		global $sfgTabIndex, $sfgFieldNum;

		// For backward compatibility with pre-SF-2.1 forms
		if ( array_key_exists( 'autocomplete field type', $other_args ) &&
			! array_key_exists( 'no autocomplete', $other_args ) ) {
			return SFTextWithAutocompleteInput::getHTML( $cur_value, $input_name, $is_mandatory, $is_disabled, $other_args );
		}

		$className = "createboxInput";
		if ( $is_mandatory ) {
			$className .= " mandatoryField";
		}
		if ( array_key_exists( 'class', $other_args ) ) {
			$className .= " " . $other_args['class'];
		}
		$input_id = "input_$sfgFieldNum";
		// Set size based on pre-set size, or field type - if field
		// type is set, possibly add validation too.
		$size = 35;
		$inputType = '';
		if ( array_key_exists( 'field_type', $other_args ) ) {
			if ( $other_args['field_type'] == 'number' ) {
				$size = 10;
				$inputType = 'number';
			} elseif ( $other_args['field_type'] == 'URL' ) {
				$size = 100;
				$inputType = 'URL';
			} elseif ( $other_args['field_type'] == 'email' ) {
				$size = 45;
				$inputType = 'email';
			}
		}
		if ( array_key_exists( 'size', $other_args ) ) {
			$size = $other_args['size'];
		}

		$inputAttrs = array(
			'type' => 'text',
			'id' => $input_id,
			'tabindex' => $sfgTabIndex,
			'class' => $className,
			'name' => $input_name,
			'value' => $cur_value,
			'size' => $size
		);
		if ( $is_disabled ) {
			$inputAttrs['disabled'] = 'disabled';
		}
		if ( array_key_exists( 'maxlength', $other_args ) ) {
			$inputAttrs['maxlength'] = $other_args['maxlength'];
		}
		$text = Xml::element( 'input', $inputAttrs );

		if ( array_key_exists( 'is_uploadable', $other_args ) && $other_args['is_uploadable'] == true ) {
			if ( array_key_exists( 'is_list', $other_args ) && $other_args['is_list'] == true ) {
				if ( array_key_exists( 'delimiter', $other_args ) ) {
					$delimiter = $other_args['delimiter'];
				} else {
					$delimiter = ",";
				}
			} else {
				$delimiter = null;
			}
			if ( array_key_exists( 'default filename', $other_args ) ) {
				$default_filename = $other_args['default filename'];
			} else {
				$default_filename = "";
			}
			$text .= self::uploadLinkHTML( $input_id, $delimiter, $default_filename );
		}
		$spanClass = "inputSpan";
		if ( $inputType != '' ) {
			$spanClass .= " {$inputType}Input";
		}
		if ( $is_mandatory ) { $spanClass .= " mandatoryFieldSpan"; }
		$text = Xml::tags( 'span', array( 'class' => $spanClass ), $text );
		return $text;
	}

	public static function getParameters() {
		$params = parent::getParameters();
		$params[] = array( 'name' => 'size', 'type' => 'int', 'description' => wfMsg( 'sf_forminputs_size' ) );
		$params[] = array( 'name' => 'maxlength', 'type' => 'int', 'description' => wfMsg( 'sf_forminputs_maxlength' ) );
		$params[] = array( 'name' => 'uploadable', 'type' => 'boolean', 'description' => wfMsg( 'sf_forminputs_uploadable' ) );
		$params[] = array( 'name' => 'default filename', 'type' => 'string', 'description' => wfMsg( 'sf_forminputs_defaultfilename' ) );
		return $params;
	}
}

/**
 * @ingroup SFFormInput
 */
class SFTextAreaInput extends SFFormInput {
	public static function getName() {
		return 'textarea';
	}

	public static function getDefaultPropTypes() {
		return array( '_txt' => array(), '_cod' => array() );
	}

	public static function getOtherPropTypesHandled() {
		return array( '_wpg', '_str' );
	}

	public static function getOtherPropTypeListsHandled() {
		return array( '_wpg', '_str' );
	}

	public static function getHTML( $cur_value, $input_name, $is_mandatory, $is_disabled, $other_args ) {
		global $sfgTabIndex, $sfgFieldNum;

		$className = ( $is_mandatory ) ? "mandatoryField" : "createboxInput";
		if ( array_key_exists( 'class', $other_args ) ) {
			$className .= " " . $other_args['class'];
		}
		// Use a special ID for the free text field, for FCK's needs.
		$input_id = $input_name == "free_text" ? "free_text" : "input_$sfgFieldNum";

		if ( array_key_exists( 'rows', $other_args ) ) {
			$rows = $other_args['rows'];
		} else {
			$rows = 5;
		}

		if ( array_key_exists( 'autogrow', $other_args ) ) {
			$className .= ' autoGrow';
		}

		$textarea_attrs = array(
			'tabindex' => $sfgTabIndex,
			'id' => $input_id,
			'name' => $input_name,
			'rows' => $rows,
			'class' => $className,
		);

		if ( array_key_exists( 'cols', $other_args ) ) {
			$textarea_attrs['cols'] = $other_args['cols'];
		} else {
			$textarea_attrs['style'] = "width: 100%";
		}

		if ( $is_disabled ) {
			$textarea_attrs['disabled'] = 'disabled';
		}
		if ( array_key_exists( 'maxlength', $other_args ) ) {
			$maxlength = $other_args['maxlength'];
			// For every actual character pressed (i.e., excluding
			// things like the Shift key), reduce the string to its
			// allowed length if it's exceeded that.
			// This JS code is complicated so that it'll work
			// correctly in IE - IE moves the cursor to the end
			// whenever this.value is reset, so we'll make sure to
			// do that only when we need to.
			$maxLengthJSCheck = "if (window.event && window.event.keyCode < 48 && window.event.keyCode != 13) return; if (this.value.length > $maxlength) { this.value = this.value.substring(0, $maxlength); }";
			$textarea_attrs['onKeyDown'] = $maxLengthJSCheck;
			$textarea_attrs['onKeyUp'] = $maxLengthJSCheck;
		}
		$text = Xml::element( 'textarea', $textarea_attrs, $cur_value, false );
		$spanClass = "inputSpan";
		if ( $is_mandatory ) { $spanClass .= " mandatoryFieldSpan"; }
		$text = Xml::tags( 'span', array( 'class' => $spanClass ), $text );
		return $text;
	}

	public static function getParameters() {
		$params = parent::getParameters();
		$params[] = array( 'name' => 'preload', 'type' => 'string', 'description' => wfMsg( 'sf_forminputs_preload' ) );
		$params[] = array( 'name' => 'rows', 'type' => 'int', 'description' => wfMsg( 'sf_forminputs_rows' ) );
		$params[] = array( 'name' => 'cols', 'type' => 'int', 'description' => wfMsg( 'sf_forminputs_cols' ) );
		$params[] = array( 'name' => 'maxlength', 'type' => 'int', 'description' => wfMsg( 'sf_forminputs_maxlength' ) );
		$params[] = array( 'name' => 'autogrow', 'type' => 'boolean', 'description' => wfMsg( 'sf_forminputs_autogrow' ) );
		return $params;
	}
}

/**
 * @ingroup SFFormInput
 */
class SFCheckboxInput extends SFFormInput {
	public static function getName() {
		return 'checkbox';
	}

	public static function getDefaultPropTypes() {
		return array( '_boo' => array() );
	}

	public static function getHTML( $cur_value, $input_name, $is_mandatory, $is_disabled, $other_args ) {
		global $sfgTabIndex, $sfgFieldNum, $sfgShowOnSelect;

		$className = ( $is_mandatory ) ? "mandatoryField" : "createboxInput";
		if ( array_key_exists( 'class', $other_args ) )
			$className .= " " . $other_args['class'];
		$input_id = "input_$sfgFieldNum";
		$disabled_text = ( $is_disabled ) ? "disabled" : "";
		if ( array_key_exists( 'show on select', $other_args ) ) {
			$className .= " sfShowIfCheckedCheckbox";
			$div_id = key( $other_args['show on select'] );
			$sfgShowOnSelect[$input_id] = $div_id;
		}

		// Can show up here either as an array or a string, depending on
		// whether it came from user input or a wiki page
		if ( is_array( $cur_value ) ) {
			$checked_str = ( array_key_exists( 'value', $cur_value ) && $cur_value['value'] == 'on' ) ? ' checked="checked"' : "";
		} else {
			// Default to false - no need to check if it matches
			// a 'false' word.
			$vlc = strtolower( trim( $cur_value ) );
			// Manually load SMW's message values, if they weren't
			// loaded before.
			global $wgVersion;
			if ( version_compare( $wgVersion, '1.16', '<' ) ) {
				wfLoadExtensionMessages( 'SemanticMediaWiki' );
			}
			if ( in_array( $vlc, explode( ',', wfMsgForContent( 'smw_true_words' ) ), TRUE ) ) {
				$checked_str = ' checked="checked"';
			} else {
				$checked_str = "";
			}
		}
		$text = <<<END
	<input name="{$input_name}[is_checkbox]" type="hidden" value="true" />
	<input id="$input_id" name="{$input_name}[value]" type="checkbox" class="$className" tabindex="$sfgTabIndex" $checked_str $disabled_text/>

END;
		return $text;
	}

	public static function getParameters() {
		// Remove the 'mandatory' option - it doesn't make sense for
		// checkboxes.
		$params = array();
		foreach( parent::getParameters() as $param ) {
			if ( $param['name'] != 'mandatory' ) {
				$params[] = $param;
			}
		}
		return $params;
	}
}

/**
 * @ingroup SFFormInput
 */
class SFDropdownInput extends SFEnumInput {
	public static function getName() {
		return 'dropdown';
	}

	public static function getDefaultPropTypes() {
		return array(
			'enumeration' => array()
		);
	}

	public static function getOtherPropTypesHandled() {
		return array( '_boo' );
	}

	public static function getHTML( $cur_value, $input_name, $is_mandatory, $is_disabled, $other_args ) {
		global $sfgTabIndex, $sfgFieldNum, $sfgShowOnSelect;

		$className = ( $is_mandatory ) ? "mandatoryField" : "createboxInput";
		if ( array_key_exists( 'class', $other_args ) ) {
			$className .= " " . $other_args['class'];
		}
		$input_id = "input_$sfgFieldNum";
		if ( array_key_exists( 'show on select', $other_args ) ) {
			$className .= " sfShowIfSelected";
			foreach ( $other_args['show on select'] as $div_id => $options ) {
				if ( array_key_exists( $input_id, $sfgShowOnSelect ) ) {
					$sfgShowOnSelect[$input_id][] = array( $options, $div_id );
				} else {
					$sfgShowOnSelect[$input_id] = array( array( $options, $div_id ) );
				}
			}
		}
		$innerDropdown = "";
		// Add a blank value at the beginning, unless this is a
		// mandatory field and there's a current value in place
		// (either through a default value or because we're editing
		// an existing page).
		if ( ! $is_mandatory || $cur_value == '' ) {
			$innerDropdown .= "	<option value=\"\"></option>\n";
		}
		if ( ( $possible_values = $other_args['possible_values'] ) == null ) {
			// If it's a Boolean property, display 'Yes' and 'No'
			// as the values.
			if ( array_key_exists( 'property_type', $other_args ) && $other_args['property_type'] == '_boo' ) {
				$possible_values = array(
					SFUtils::getWordForYesOrNo( true ),
					SFUtils::getWordForYesOrNo( false ),
				);
			} else {
				$possible_values = array();
			}
		}
		foreach ( $possible_values as $possible_value ) {
			$optionAttrs = array( 'value' => $possible_value );
			if ( $possible_value == $cur_value ) {
				$optionAttrs['selected'] = "selected";
			}
			if ( array_key_exists( 'value_labels', $other_args ) && is_array( $other_args['value_labels'] ) && array_key_exists( $possible_value, $other_args['value_labels'] ) ) {
				$label = $other_args['value_labels'][$possible_value];
			} else {
				$label = $possible_value;
			}
			$innerDropdown .= Xml::element( 'option', $optionAttrs, $label );
		}
		$selectAttrs = array(
			'id' => $input_id,
			'tabindex' => $sfgTabIndex,
			'name' => $input_name,
			'class' => $className
		);
		if ( $is_disabled ) {
			$selectAttrs['disabled'] = 'disabled';
		}
		$text = Xml::tags( 'select', $selectAttrs, $innerDropdown );
		$spanClass = "inputSpan";
		if ( $is_mandatory ) { $spanClass .= " mandatoryFieldSpan"; }
		$text = Xml::tags( 'span', array( 'class' => $spanClass ), $text );
		return $text;
	}
}

/**
 * @ingroup SFFormInput
 */
class SFRadioButtonInput extends SFEnumInput {
	public static function getName() {
		return 'radiobutton';
	}

	public static function getHTML( $cur_value, $input_name, $is_mandatory, $is_disabled, $other_args ) {
		global $sfgTabIndex, $sfgFieldNum, $sfgShowOnSelect;

		if ( ( $possible_values = $other_args['possible_values'] ) == null ) {
			// If it's a Boolean property, display 'Yes' and 'No'
			// as the values.
			if ( $other_args['property_type'] == '_boo' ) {
				$possible_values = array(
					SFUtils::getWordForYesOrNo( true ),
					SFUtils::getWordForYesOrNo( false ),
				);
			} else {
				$possible_values = array();
			}
		}

		// Add a "None" value at the beginning, unless this is a
		// mandatory field and there's a current value in place (either
		// through a default value or because we're editing an existing
		// page).
		if ( ! $is_mandatory || $cur_value == '' ) {
			array_unshift( $possible_values, '' );
		}

		// Set $cur_value to be one of the allowed options, if it isn't
		// already - that makes it easier to automatically have one of
		// the radiobuttons be checked at the beginning.
		if ( ! in_array( $cur_value, $possible_values ) ) {
			if ( in_array( '', $possible_values ) )
				$cur_value = '';
			else
				$cur_value = $possible_values[0];
		}

		$text = '';
		foreach ( $possible_values as $i => $possible_value ) {
			$sfgTabIndex++;
			$sfgFieldNum++;
			$input_id = "input_$sfgFieldNum";

			$radiobutton_attrs = array(
				'type' => 'radio',
				'id' => $input_id,
				'tabindex' => $sfgTabIndex,
				'name' => $input_name,
				'value' => $possible_value,
			);
			if ( $cur_value == $possible_value ) {
				$radiobutton_attrs['checked'] = 'checked';
			}
			if ( $is_disabled ) {
				$radiobutton_attrs['disabled'] = 'disabled';
			}
			if ( $possible_value == '' ) // blank/"None" value
				$label = wfMsg( 'sf_formedit_none' );
			elseif ( array_key_exists( 'value_labels', $other_args ) && is_array( $other_args['value_labels'] ) && array_key_exists( $possible_value, $other_args['value_labels'] ) )
				$label = htmlspecialchars( $other_args['value_labels'][$possible_value] );
			else
				$label = $possible_value;

			$text .= "\t" . Xml::element ( 'input', $radiobutton_attrs ) . " $label\n";
		}

		$spanClass = "radioButtonSpan";
		if ( array_key_exists( 'class', $other_args ) ) {
			$spanClass .= " " . $other_args['class'];
		}
		if ( $is_mandatory ) {
			$spanClass .= " mandatoryFieldSpan";
		}

		$spanID = "span_$sfgFieldNum";

		// Do the 'show on select' handling.
		if ( array_key_exists( 'show on select', $other_args ) ) {
			$spanClass .= " sfShowIfChecked";
			foreach ( $other_args['show on select'] as $div_id => $options ) {
				if ( array_key_exists( $spanID, $sfgShowOnSelect ) ) {
					$sfgShowOnSelect[$spanID][] = array( $options, $div_id );
				} else {
					$sfgShowOnSelect[$spanID] = array( array( $options, $div_id ) );
				}
			}
		}
		$spanAttrs = array(
			'id' => $spanID,
			'class' => $spanClass
		);
		$text = Xml::tags( 'span', $spanAttrs, $text );

		return $text;
	}
}

/**
 * @ingroup SFFormInput
 */
class SFListBoxInput extends SFMultiEnumInput {
	public static function getName() {
		return 'listbox';
	}

	public static function getHTML( $cur_value, $input_name, $is_mandatory, $is_disabled, $other_args ) {
		global $sfgTabIndex, $sfgFieldNum, $sfgShowOnSelect;

		$className = ( $is_mandatory ) ? "mandatoryField" : "createboxInput";
		if ( array_key_exists( 'class', $other_args ) ) {
			$className .= " " . $other_args['class'];
		}
		$input_id = "input_$sfgFieldNum";
		// get list delimiter - default is comma
		if ( array_key_exists( 'delimiter', $other_args ) ) {
			$delimiter = $other_args['delimiter'];
		} else {
			 $delimiter = ",";
		}
		$cur_values = SFUtils::getValuesArray( $cur_value, $delimiter );
		$className .= " sfShowIfSelected";

		if ( ( $possible_values = $other_args['possible_values'] ) == null ) {
			$possible_values = array();
		}
		$optionsText = "";
		foreach ( $possible_values as $possible_value ) {
			if ( array_key_exists( 'value_labels', $other_args ) && is_array( $other_args['value_labels'] ) && array_key_exists( $possible_value, $other_args['value_labels'] ) ) {
				$optionLabel = $other_args['value_labels'][$possible_value];
			} else {
				$optionLabel = $possible_value;
			}
			$optionAttrs = array( 'value' => $possible_value );
			if ( in_array( $possible_value, $cur_values ) ) {
				$optionAttrs['selected'] = 'selected';
			}
			$optionsText .= Xml::element( 'option', $optionAttrs, $optionLabel );
		}
		$selectAttrs = array(
			'id' => $input_id,
			'tabindex' => $sfgTabIndex,
			'name' => $input_name . '[]',
			'class' => $className,
			'multiple' => 'multiple'
		);
		if ( array_key_exists( 'size', $other_args ) ) {
			$selectAttrs['size'] = $other_args['size'];
		}
		if ( $is_disabled ) {
			$selectAttrs['disabled'] = 'disabled';
		}
		$text = Xml::tags( 'select', $selectAttrs, $optionsText );
		$text .= "\t" . Html::Hidden( $input_name . '[is_list]', 1 ) . "\n";
		if ( $is_mandatory ) {
			$text = Xml::tags( 'span', array( 'class' => 'inputSpan mandatoryFieldSpan' ), $text );
		}

		if ( array_key_exists( 'show on select', $other_args ) ) {
			foreach ( $other_args['show on select'] as $div_id => $options ) {
				if ( array_key_exists( $input_id, $sfgShowOnSelect ) ) {
					$sfgShowOnSelect[$input_id][] = array( $options, $div_id );
				} else {
					$sfgShowOnSelect[$input_id] = array( array( $options, $div_id ) );
				}
			}
		}

		return $text;
	}

	public static function getParameters() {
		$params = parent::getParameters();
		$params[] = array( 'name' => 'size', 'type' => 'int', 'description' => wfMsg( 'sf_forminputs_listboxsize' ) );
		return $params;
	}
}

/**
 * @ingroup SFFormInput
 */
class SFCheckboxesInput extends SFMultiEnumInput {
	public static function getName() {
		return 'checkboxes';
	}

	public static function getDefaultPropTypeLists() {
		return array(
			'enumeration' => array()
		);
	}

	public static function getOtherPropTypeListsHandled() {
		return array();
	}

	public static function getHTML( $cur_value, $input_name, $is_mandatory, $is_disabled, $other_args ) {
		global $sfgTabIndex, $sfgFieldNum, $sfgShowOnSelect;

		$checkbox_class = ( $is_mandatory ) ? "mandatoryField" : "createboxInput";
		$span_class = "checkboxSpan";
		if ( array_key_exists( 'class', $other_args ) )
			$span_class .= " " . $other_args['class'];
		$input_id = "input_$sfgFieldNum";
		// get list delimiter - default is comma
		if ( array_key_exists( 'delimiter', $other_args ) ) {
			$delimiter = $other_args['delimiter'];
		} else {
			$delimiter = ",";
		}
		$cur_values = SFUtils::getValuesArray( $cur_value, $delimiter );

		if ( ( $possible_values = $other_args['possible_values'] ) == null )
			$possible_values = array();
		$text = "";
		foreach ( $possible_values as $key => $possible_value ) {
			$cur_input_name = $input_name . "[" . $key . "]";

			if ( array_key_exists( 'value_labels', $other_args ) && is_array( $other_args['value_labels'] ) && array_key_exists( $possible_value, $other_args['value_labels'] ) )
				$label = $other_args['value_labels'][$possible_value];
			else
				$label = $possible_value;

			$checkbox_attrs = array(
				'type' => 'checkbox',
				'id' => $input_id,
				'tabindex' => $sfgTabIndex,
				'name' => $cur_input_name,
				'value' => $possible_value,
				'class' => $checkbox_class,
			);
			if ( in_array( $possible_value, $cur_values ) ) {
				$checkbox_attrs['checked'] = 'checked';
			}
			if ( $is_disabled ) {
				$checkbox_attrs['disabled'] = 'disabled';
			}
			$checkbox_input = Xml::element( 'input', $checkbox_attrs );

			// Make a span around each checkbox, for CSS purposes.
			$text .= '	' . Xml::tags( 'span',
				array( 'class' => $span_class ),
				$checkbox_input . ' ' . $label
			) . "\n";
			$sfgTabIndex++;
			$sfgFieldNum++;
		}

		$outerSpanID = "span_$sfgFieldNum";
		$outerSpanClass = "checkboxesSpan";
		if ( $is_mandatory ) {
			$outerSpanClass .= " mandatoryFieldSpan";
		}

		if ( array_key_exists( 'show on select', $other_args ) ) {
			$outerSpanClass .= " sfShowIfChecked";
			foreach ( $other_args['show on select'] as $div_id => $options ) {
				if ( array_key_exists( $outerSpanID, $sfgShowOnSelect ) ) {
					$sfgShowOnSelect[$outerSpanID][] = array( $options, $div_id );
				} else {
					$sfgShowOnSelect[$outerSpanID] = array( array( $options, $div_id ) );
				}
			}
		}

		$text .= "\n" . Html::Hidden( $input_name . '[is_list]', 1 ) . "\n";
		$outerSpanAttrs = array( 'id' => $outerSpanID, 'class' => $outerSpanClass );
		$text = "\t" . Xml::tags( 'span', $outerSpanAttrs, $text ) . "\n";

		return $text;
	}
}

/**
 * @ingroup SFFormInput
 */
class SFTextWithAutocompleteInput extends SFTextInput {
	public static function getName() {
		return 'text with autocomplete';
	}

	public static function getDefaultPropTypes() {
		return array(
			'_wpg' => array()
		);
	}

	public static function getOtherPropTypesHandled() {
		return array( '_str' );
	}

	public static function getDefaultPropTypeLists() {
		return array(
			'_wpg' => array( 'is_list' => true, 'size' => 100 )
		);
	}

	public static function getOtherPropTypeListsHandled() {
		return array( '_str' );
	}

	public static function getAutocompletionTypeAndSource( &$field_args ) {
		if ( array_key_exists( 'values from property', $field_args ) ) {
			$autocompletionSource = $field_args['values from property'];
			$propValue = SMWPropertyValue::makeUserProperty( $autocompletionSource );
			if ( $propValue->getPropertyTypeID() == '_wpg' ) {
				$autocompleteFieldType = 'relation';
			} else {
				$autocompleteFieldType = 'attribute';
			}
		} elseif ( array_key_exists( 'values from category', $field_args ) ) {
			$autocompleteFieldType = 'category';
			$autocompletionSource = $field_args['values from category'];
		} elseif ( array_key_exists( 'values from concept', $field_args ) ) {
			$autocompleteFieldType = 'concept';
			$autocompletionSource = $field_args['values from concept'];
		} elseif ( array_key_exists( 'values from namespace', $field_args ) ) {
			$autocompleteFieldType = 'namespace';
			$autocompletionSource = $field_args['values from namespace'];
		} elseif ( array_key_exists( 'values from url', $field_args ) ) {
			$autocompleteFieldType = 'external_url';
			$autocompletionSource = $field_args['values from url'];
			// Autocompletion from URL is always done remotely.
			$field_args['remote autocompletion'] = true;
		} elseif ( array_key_exists( 'values', $field_args ) ) {
			global $sfgFieldNum;
			$autocompleteFieldType = 'values';
			$autocompletionSource = "values-$sfgFieldNum";
		} elseif ( array_key_exists( 'autocomplete field type', $field_args ) ) {
			$autocompleteFieldType = $field_args['autocomplete field type'];
			$autocompletionSource = $field_args['autocompletion source'];
		} elseif ( array_key_exists( 'semantic_property', $field_args ) ) {
			$autocompletionSource = $field_args['semantic_property'];
			$propValue = SMWPropertyValue::makeUserProperty( $autocompletionSource );
			if ( $propValue->getPropertyTypeID() == '_wpg' ) {
				$autocompleteFieldType = 'relation';
			} else {
				$autocompleteFieldType = 'attribute';
			}
		} else {
			$autocompleteFieldType = null;
			$autocompletionSource = null;
		}

		if ( $autocompleteFieldType != 'external_url' ) {
			global $wgContLang;
			$autocompletionSource = $wgContLang->ucfirst( $autocompletionSource );
		}

		return array( $autocompleteFieldType, $autocompletionSource );
	}

	public static function setAutocompleteValues( $field_args ) {
		global $sfgAutocompleteValues;

		// Get all autocomplete-related values, plus delimiter value
		// (it's needed also for the 'uploadable' link, if there is one).
		list( $autocompleteFieldType, $autocompletionSource ) =
			self::getAutocompletionTypeAndSource( $field_args );
		$autocompleteSettings = $autocompletionSource;
		$is_list = ( array_key_exists( 'is_list', $field_args ) && $field_args['is_list'] == true );
		if ( $is_list ) {
			$autocompleteSettings .= ",list";
			if ( array_key_exists( 'delimiter', $field_args ) ) {
				$delimiter = $field_args['delimiter'];
				$autocompleteSettings .= "," . $delimiter;
			} else {
				$delimiter = ",";
			}
		} else {
			$delimiter = null;
		}

		$remoteDataType = null;
		if ( array_key_exists( 'remote autocompletion', $field_args ) &&
				$field_args['remote autocompletion'] == true ) {
			$remoteDataType = $autocompleteFieldType;
		} elseif ( $autocompletionSource != '' ) {
			// @TODO - that count() check shouldn't be necessary
			if ( array_key_exists( 'possible_values', $field_args ) &&
			count( $field_args['possible_values'] ) > 0 ) {
				$autocompleteValues = $field_args['possible_values'];
			} elseif ( $autocompleteFieldType == 'values' ) {
				$autocompleteValues = explode( ',', $field_args['values'] );
			} else {
				$autocompleteValues = SFUtils::getAutocompleteValues( $autocompletionSource, $autocompleteFieldType );
			}
			$sfgAutocompleteValues[$autocompleteSettings] = $autocompleteValues;
		}
		return array( $autocompleteSettings, $remoteDataType, $delimiter );
	}

	public static function getHTML( $cur_value, $input_name, $is_mandatory, $is_disabled, $other_args ) {
		// Backwards compatibility, for pre-SF-2.1 forms:
		// if 'no autocomplete' was specified, switch to SFTextInput.
		if ( array_key_exists( 'no autocomplete', $other_args ) &&
				$other_args['no autocomplete'] == true ) {
			unset( $other_args['autocompletion source'] );
			return SFTextInput::getHTML( $cur_value, $input_name, $is_mandatory, $is_disabled, $other_args );
		}

		global $sfgTabIndex, $sfgFieldNum;

		list( $autocompleteSettings, $remoteDataType, $delimiter ) = self::setAutocompleteValues( $other_args );

		$className = ( $is_mandatory ) ? "autocompleteInput mandatoryField" : "autocompleteInput createboxInput";
		if ( array_key_exists( 'class', $other_args ) )
			$className .= " " . $other_args['class'];
		$input_id = "input_" . $sfgFieldNum;

		if ( array_key_exists( 'size', $other_args ) ) {
			$size = $other_args['size'];
		} elseif ( array_key_exists( 'is_list', $other_args ) && $other_args['is_list'] ) {
			$size = "100";
		} else {
			$size = "35";
		}

		$inputAttrs = array(
			'type' => 'text',
			'id' => $input_id,
			'name' => $input_name,
			'value' => $cur_value,
			'size' => $size,
			'class' => $className,
			'tabindex' => $sfgTabIndex,
			'autocompletesettings' => $autocompleteSettings,
		);
		if ( !is_null( $remoteDataType ) ) {
			$inputAttrs['autocompletedatatype'] = $remoteDataType;
		}
		if ( $is_disabled ) {
			$inputAttrs['disabled'] = 'disabled';
		}
		if ( array_key_exists( 'maxlength', $other_args ) ) {
			$inputAttrs['maxlength'] = $other_args['maxlength'];
		}
		$text = "\n\t" . Xml::element( 'input', $inputAttrs ) . "\n";

		if ( array_key_exists( 'is_uploadable', $other_args ) && $other_args['is_uploadable'] == true ) {
			if ( array_key_exists( 'default filename', $other_args ) ) {
				$default_filename = $other_args['default filename'];
			} else {
				$default_filename = "";
			}
			$text .= self::uploadLinkHTML( $input_id, $delimiter, $default_filename );
		}

		$spanClass = "inputSpan";
		if ( $is_mandatory ) { $spanClass .= " mandatoryFieldSpan"; }
		$text = "\n" . Xml::tags( 'span', array( 'class' => $spanClass ), $text );
		
		return $text;
	}

	public static function getAutocompletionParameters() {
		$params = SFEnumInput::getValuesParameters();
		$params[] = array( 'name' => 'values from url', 'type' => 'string', 'description' => wfMsg( 'sf_forminputs_valuesfromurl' ) );
		$params[] = array( 'name' => 'remote autocompletion', 'type' => 'boolean', 'description' => wfMsg( 'sf_forminputs_remoteautocompletion' ) );
		$params[] = array( 'name' => 'list', 'type' => 'boolean', 'description' => wfMsg( 'sf_forminputs_list' ) );
		$params[] = array( 'name' => 'delimiter', 'type' => 'string', 'description' => wfMsg( 'sf_forminputs_delimiter' ) );
		return $params;
	}

	public static function getParameters() {
		$params = parent::getParameters();
		$params = array_merge( $params, self::getAutocompletionParameters() );
		return $params;
	}
}

/**
 * @ingroup SFFormInput
 */
class SFTextAreaWithAutocompleteInput extends SFTextAreaInput {
	public static function getName() {
		return 'textarea with autocomplete';
	}

	public static function getDefaultPropTypes() {
		return array();
	}

	public static function getOtherPropTypesHandled() {
		return array( '_wpg', '_str' );
	}

	public static function getOtherPropTypeListsHandled() {
		return array( '_wpg', '_str' );
	}

	public static function getHTML( $cur_value, $input_name, $is_mandatory, $is_disabled, $other_args ) {
		// If 'no autocomplete' was specified, print a regular
		// textarea instead.
		if ( array_key_exists( 'no autocomplete', $other_args ) &&
				$other_args['no autocomplete'] == true ) {
			unset( $other_args['autocompletion source'] );
			return SFTextAreaInput::getHTML( $cur_value, $input_name, $is_mandatory, $is_disabled, $other_args );
		}

		global $sfgTabIndex, $sfgFieldNum;

		list( $autocompleteSettings, $remoteDataType, $delimiter ) = SFTextWithAutocompleteInput::setAutocompleteValues( $other_args );

		$className = ( $is_mandatory ) ? "autocompleteInput mandatoryField" : "autocompleteInput createboxInput";
		if ( array_key_exists( 'class', $other_args ) )
			$className .= " " . $other_args['class'];
		$input_id = "input_" . $sfgFieldNum;

		if ( array_key_exists( 'rows', $other_args ) ) {
			$rows = $other_args['rows'];
		} else {
			$rows = 5;
		}
		if ( array_key_exists( 'cols', $other_args ) ) {
			$cols = $other_args['cols'];
		} else {
			$cols = 80;
		}
		$text = "";
		if ( array_key_exists( 'autogrow', $other_args ) ) {
			$className .= ' autoGrow';
		}

		$textarea_attrs = array(
			'tabindex' => $sfgTabIndex,
			'id' => $input_id,
			'name' => $input_name,
			'rows' => $rows,
			'cols' => $cols,
			'class' => $className,
			'autocompletesettings' => $autocompleteSettings,
		);
		if ( !is_null( $remoteDataType ) ) {
			$textarea_attrs['autocompletedatatype'] = $remoteDataType;
		}
		if ( $is_disabled ) {
			$textarea_attrs['disabled'] = 'disabled';
		}
		if ( array_key_exists( 'maxlength', $other_args ) ) {
			$maxlength = $other_args['maxlength'];
			// For every actual character pressed (i.e., excluding
			// things like the Shift key), reduce the string to
			// its allowed length if it's exceeded that.
			// This JS code is complicated so that it'll work
			// correctly in IE - IE moves the cursor to the end
			// whenever this.value is reset, so we'll make sure
			// to do that only when we need to.
			$maxLengthJSCheck = "if (window.event && window.event.keyCode < 48 && window.event.keyCode != 13) return; if (this.value.length > $maxlength) { this.value = this.value.substring(0, $maxlength); }";
			$textarea_attrs['onKeyDown'] = $maxLengthJSCheck;
			$textarea_attrs['onKeyUp'] = $maxLengthJSCheck;
		}
		$textarea_input = Xml::element('textarea', $textarea_attrs, $cur_value, false);
		$text .= $textarea_input;

		if ( array_key_exists( 'is_uploadable', $other_args ) && $other_args['is_uploadable'] == true ) {
			if ( array_key_exists( 'default filename', $other_args ) ) {
				$default_filename = $other_args['default filename'];
			} else {
				$default_filename = "";
			}
			$text .= self::uploadLinkHTML( $input_id, $delimiter, $default_filename );
		}

		$spanClass = "inputSpan";
		if ( $is_mandatory ) { $spanClass .= " mandatoryFieldSpan"; }
		$text = "\n" . Xml::tags( 'span', array( 'class' => $spanClass ), $text );
		
		return $text;
	}

	public static function getParameters() {
		$params = parent::getParameters();
		$params = array_merge( $params, SFTextWithAutocompleteInput::getAutocompletionParameters() );
		return $params;
	}
}

/**
 * @ingroup SFFormInput
 */
class SFComboBoxInput extends SFFormInput {
	public static function getName() {
		return 'combobox';
	}

	public static function getOtherPropTypesHandled() {
		return array( '_wpg', '_str' );
	}

	public static function getHTML( $cur_value, $input_name, $is_mandatory, $is_disabled, $other_args ) {
		// For backward compatibility with pre-SF-2.1 forms
		if ( array_key_exists( 'no autocomplete', $other_args ) &&
				$other_args['no autocomplete'] == true ) {
			unset( $other_args['autocompletion source'] );
			return SFTextInput::getHTML( $cur_value, $input_name, $is_mandatory, $is_disabled, $other_args );
		}

		global $sfgTabIndex, $sfgFieldNum;

		$className = "sfComboBox";
		if ( $is_mandatory ) {
			$className .= " mandatoryField";
		}
		if ( array_key_exists( 'class', $other_args ) ) {
			$className .= " " . $other_args['class'];
		}
		$disabled_text = ( $is_disabled ) ? "disabled" : "";

		if ( array_key_exists( 'size', $other_args ) ) {
			$size = $other_args['size'];
		} else {
			$size = "35";
		}
		// There's no direct correspondence between the 'size='
		// attribute for text inputs and the number of pixels, but
		// multiplying by 6 seems to be about right for the major
		// browsers.
		$pixel_width = $size * 6 . "px";
 
		list( $autocompleteFieldType, $autocompletionSource ) =
			SFTextWithAutocompleteInput::getAutocompletionTypeAndSource( $other_args );
		$values = SFUtils::getAutocompleteValues($autocompletionSource, $autocompleteFieldType );
		$autocompletionSource = str_replace( "'", "\'", $autocompletionSource );

		$optionsText = Xml::element( 'option', array( 'value' => $cur_value ), null, false ) . "\n";
		foreach ( $values as $value ) {
			$optionsText .= Xml::element( 'option', array( 'value' => $value ), $value ) . "\n";
		}

		$selectAttrs = array(
			'id' => "input_$sfgFieldNum",
			'name' => $input_name,
			'class' => $className,
			'tabindex' => $sfgTabIndex,
			'autocompletesettings' => $autocompletionSource,
			'comboboxwidth' => $pixel_width,
		);
		if ( array_key_exists( 'existing values only', $other_args ) ) {
			$selectAttrs['existingvaluesonly'] = 'true';
		}
		$selectText = Xml::tags( 'select', $selectAttrs, $optionsText );

		$divClass = "ui-widget";
		if ($is_mandatory) { $divClass .= " mandatory"; }
		$text = Xml::tags( 'div', array( 'class' => $divClass ), $selectText );
		return $text;
	}

	public static function getParameters() {
		$params = parent::getParameters();
		$params[] = array( 'name' => 'size', 'type' => 'int', 'description' => wfMsg( 'sf_forminputs_size' ) );
		$params = array_merge( $params, SFEnumInput::getValuesParameters() );
		$params[] = array( 'name' => 'existing values only', 'type' => 'boolean', 'description' => wfMsg( 'sf_forminputs_existingvaluesonly' ) );
		return $params;
	}
}

/**
 * @ingroup SFFormInput
 */
class SFDateInput extends SFFormInput {
	public static function getName() {
		return 'date';
	}

	public static function getDefaultPropTypes() {
		return array( '_dat' => array() );
	}

	public static function monthDropdownHTML( $cur_month, $input_name, $is_disabled ) {
		global $sfgTabIndex, $wgAmericanDates;

		$optionsText = "";
		$month_names = SFFormUtils::getMonthNames();
		foreach ( $month_names as $i => $name ) {
			// pad out month to always be two digits
			$month_value = ( $wgAmericanDates == true ) ? $name : str_pad( $i + 1, 2, "0", STR_PAD_LEFT );
			$optionAttrs = array ( 'value' => $month_value );
			if ( $name == $cur_month || ( $i + 1 ) == $cur_month ) {
				$optionAttrs['selected'] = 'selected';
			}
			$optionsText .= Xml::element( 'option', $optionAttrs, $name );
		}
		$selectAttrs = array(
			'class' => 'monthInput',
			'name' => $input_name . '[month]',
			'tabindex' => $sfgTabIndex
		);
		if ( $is_disabled ) {
			$selectAttrs['disabled'] = 'disabled';
		}
		$text = Xml::tags( 'select', $selectAttrs, $optionsText );
		return $text;
	}

	public static function getMainHTML( $date, $input_name, $is_mandatory, $is_disabled, $other_args ) {
		global $sfgTabIndex, $sfgFieldNum, $wgAmericanDates;

		$input_id = "input_$sfgFieldNum";

		if ( $date ) {
			// Can show up here either as an array or a string,
			// depending on whether it came from user input or a
			// wiki page.
			if ( is_array( $date ) ) {
				$year = $date['year'];
				$month = $date['month'];
				$day = $date['day'];
			} else {
				// handle 'default=now'
				if ( $date == 'now' ) {
					global $wgLocaltimezone;
					if ( isset( $wgLocaltimezone ) ) {
						$serverTimezone = date_default_timezone_get();
						date_default_timezone_set( $wgLocaltimezone );
					}
					$date = date( 'Y/m/d' );
					if ( isset( $wgLocaltimezone ) ) {
						date_default_timezone_set( $serverTimezone );
					}
				}
				$actual_date = new SMWTimeValue( '_dat' );
				$actual_date->setUserValue( $date );
				$year = $actual_date->getYear();
				// TODO - the code to convert from negative to
				// BC notation should be in SMW itself.
				if ( $year < 0 ) { $year = ( $year * - 1 + 1 ) . " BC"; }
				$month = $actual_date->getMonth();
				$day = $actual_date->getDay();
			}
		} else {
			$cur_date = getdate();
			$year = $cur_date['year'];
			$month = $cur_date['month'];
			$day = null; // no need for day
		}
		$text = "";
		$disabled_text = ( $is_disabled ) ? "disabled" : "";
		$monthInput = self::monthDropdownHTML( $month, $input_name, $is_disabled );
		$dayInput = '	<input tabindex="' . $sfgTabIndex . '" class="dayInput" name="' . $input_name . '[day]" type="text" value="' . $day . '" size="2" ' . $disabled_text . '/>';
		if ( $wgAmericanDates ) {
			$text .= "$monthInput\n$dayInput\n";
		} else {
			$text .= "$dayInput\n$monthInput\n";
		}
		$text .= '	<input tabindex="' . $sfgTabIndex . '" class="yearInput" name="' . $input_name . '[year]" type="text" value="' . $year . '" size="4" ' . $disabled_text . '/>' . "\n";
		return $text;
	}
	
	public static function getHTML( $date, $input_name, $is_mandatory, $is_disabled, $other_args ) {
		$text = self::getMainHTML( $date, $input_name, $is_mandatory, $is_disabled, $other_args );
		$spanClass = "dateInput";
		if ( $is_mandatory ) { $spanClass .= " mandatoryFieldSpan"; }
		$text = Xml::tags( 'span', array( 'class' => $spanClass ), $text );
		return $text;
	}
}

/**
 * @ingroup SFFormInput
 */
class SFDateTimeInput extends SFDateInput {
	public static function getName() {
		return 'datetime';
	}

	public static function getDefaultPropTypes() {
		return array();
	}

	public static function getOtherPropTypesHandled() {
		return array( '_dat' );
	}

	public static function getHTML( $datetime, $input_name, $is_mandatory, $is_disabled, $other_args ) {
		global $sfgTabIndex, $sfg24HourTime;

		$include_timezone = array_key_exists( 'include timezone', $other_args );
 
		if ( $datetime ) {
			// Can show up here either as an array or a string,
			// depending on whether it came from user input or a
			// wiki page.
			if ( is_array( $datetime ) ) {
				if ( isset( $datetime['hour'] ) ) $hour = $datetime['hour'];
				if ( isset( $datetime['minute'] ) ) $minute = $datetime['minute'];
				if ( isset( $datetime['second'] ) ) $second = $datetime['second'];
				if ( ! $sfg24HourTime ) {
					if ( isset( $datetime['ampm24h'] ) ) $ampm24h = $datetime['ampm24h'];
				}
				if ( isset( $datetime['timezone'] ) ) $timezone = $datetime['timezone'];
			} else {
				// TODO - this should change to use SMW's own
				// date-handling class, just like
				// dateEntryHTML() does.

				// Handle 'default=now'.
				if ( $datetime == 'now' ) {
					global $wgLocaltimezone;
					if ( isset( $wgLocaltimezone ) ) {
						$serverTimezone = date_default_timezone_get();
						date_default_timezone_set( $wgLocaltimezone );
					}
					$actual_date = time();
				} else {
					$actual_date = strtotime( $datetime );
				}
				if ( $sfg24HourTime ) {
					$hour = date( "G", $actual_date );
				} else {
					$hour = date( "g", $actual_date );
				}
				$minute = date( "i", $actual_date );
				$second = date( "s", $actual_date );
				if ( ! $sfg24HourTime ) {
					$ampm24h = date( "A", $actual_date );
				}
				$timezone = date( "T", $actual_date );
				// Restore back to the server's timezone.
				if ( $datetime == 'now' ) {
					if ( isset( $wgLocaltimezone ) ) {
						date_default_timezone_set( $serverTimezone );
					}
				}
			}
		} else {
			$cur_date = getdate();
			$hour = null;
			$minute = null;
			$second = "00"; // default at least this value
			$ampm24h = "";
			$timezone = "";
		}

		$text = parent::getMainHTML( $datetime, $input_name, $is_mandatory, $is_disabled, $other_args );
		$disabled_text = ( $is_disabled ) ? "disabled" : "";
		$text .= '	&#160;<input tabindex="' . $sfgTabIndex . '" name="' . $input_name . '[hour]" type="text" value="' . $hour . '" size="2"/ ' . $disabled_text . '>';
		$sfgTabIndex++;
		$text .= '	:<input tabindex="' . $sfgTabIndex . '" name="' . $input_name . '[minute]" type="text" value="' . $minute . '" size="2"/ ' . $disabled_text . '>';
		$sfgTabIndex++;
		$text .= ':<input tabindex="' . $sfgTabIndex . '" name="' . $input_name . '[second]" type="text" value="' . $second . '" size="2"/ ' . $disabled_text . '>' . "\n";

		if ( ! $sfg24HourTime ) {
			$sfgTabIndex++;
			$text .= '	 <select tabindex="' . $sfgTabIndex . '" name="' . $input_name . "[ampm24h]\" $disabled_text>\n";
			$ampm24h_options = array( '', 'AM', 'PM' );
			foreach ( $ampm24h_options as $value ) {
				$text .= "				<option value=\"$value\"";
				if ( $value == $ampm24h ) { $text .= " selected=\"selected\""; }
				$text .= ">$value</option>\n";
			}
			$text .= "	</select>\n";
		}

		if ( $include_timezone ) {
			$sfgTabIndex++;
			$text .= '	<input tabindex="' . $sfgTabIndex . '" name="' . $input_name . '[timezone]" type="text" value="' . $timezone . '" size="3"/ ' . $disabled_text . '>' . "\n";
		}

		return $text;
	}

	public static function getParameters() {
		$params = parent::getParameters();
		$params[] = array( 'name' => 'include timezone', 'type' => 'boolean', 'description' => wfMsg( 'sf_forminputs_includetimezone' ) );
		return $params;
	}
}

/**
 * @ingroup SFFormInput
 */
class SFYearInput extends SFTextInput {
	public static function getName() {
		return 'year';
	}

	public static function getDefaultPropTypes() {
		return array();
	}

	public static function getOtherPropTypesHandled() {
		return array( '_dat' );
	}

	public static function getDefaultPropTypeLists() {
		return array();
	}

	public static function getOtherPropTypeListsHandled() {
		return array();
	}

	public static function getHTML( $cur_value, $input_name, $is_mandatory, $is_disabled, $other_args ) {
		$other_args['size'] = 4;
		return parent::getHTML( $cur_value, $input_name, $is_mandatory, $is_disabled, $other_args );
	}

	public static function getParameters() {
		$params = array();
		$params[] = array( 'name' => 'mandatory', 'type' => 'boolean', 'description' => wfMsg( 'sf_forminputs_mandatory' ) );
		$params[] = array( 'name' => 'restricted', 'type' => 'boolean', 'description' => wfMsg( 'sf_forminputs_restricted' ) );
		$params[] = array( 'name' => 'class', 'type' => 'string', 'description' => wfMsg( 'sf_forminputs_class' ) );
		$params[] = array( 'name' => 'default', 'type' => 'string', 'description' => wfMsg( 'sf_forminputs_default' ) );
		$params[] = array( 'name' => 'size', 'type' => 'int', 'description' => wfMsg( 'sf_forminputs_size' ) );
		return $params;
	}
}

/**
 * @ingroup SFFormInput
 */
class SFCategoryInput extends SFFormInput {
	public static function getName() {
		return 'category';
	}

	public static function getOtherPropTypesHandled() {
		return array( '_wpg' );
	}

	public static function getHTML( $cur_value, $input_name, $is_mandatory, $is_disabled, $other_args ) {
		// escape if CategoryTree extension isn't included
		if ( ! function_exists( 'efCategoryTreeParserHook' ) )
			return null;

		global $sfgTabIndex, $sfgFieldNum;

		$className = ( $is_mandatory ) ? "mandatoryField" : "createboxInput";
		if ( array_key_exists( 'class', $other_args ) )
			$className .= " " . $other_args['class'];
		if ( array_key_exists( 'top category', $other_args ) ) {
			$top_category = $other_args['top category'];
		} else {
			// escape - we can't do anything
			return null;
		}
		$hideroot = array_key_exists( 'hideroot', $other_args );
		if ( array_key_exists( 'height', $other_args ) ) {
			$height = $other_args['height'];
		} else {
			$height = "100";
		}
		if ( array_key_exists( 'width', $other_args ) ) {
			$width = $other_args['width'];
		} else {
			$width = "500";
		}

		$text = '<div style="overflow: auto; padding: 5px; border: 1px #aaaaaa solid; max-height: ' . $height . 'px; width: ' . $width . 'px;">';

		// Start with an initial "None" value, unless this is a
		// mandatory field and there's a current value in place
		// (either through a default value or because we're editing
		// an existing page)
		if ( ! $is_mandatory || $cur_value == '' ) {
			$text .= '	<input type="radio" tabindex="' . $sfgTabIndex . '" name="' . $input_name . '" value=""';
			if ( ! $cur_value ) {
				$text .= ' checked="checked"';
			}
			$disabled_text = ( $is_disabled ) ? "disabled" : "";
			$text .= " $disabled_text/> <em>" . wfMsg( 'sf_formedit_none' ) . "</em>\n";
		}

		global $wgCategoryTreeMaxDepth;
		$wgCategoryTreeMaxDepth = 10;
		$tree = efCategoryTreeParserHook( $top_category, array( 'mode' => 'categories', 'depth' => 10, 'hideroot' => $hideroot ) );

		// Capitalize the first letter, if first letters always get
		// capitalized.
		global $wgCapitalLinks;
		if ( $wgCapitalLinks ) {
			global $wgContLang;
			$cur_value = $wgContLang->ucfirst( $cur_value );
		}

		$tree = preg_replace( '/(<a class="CategoryTreeLabel.*>)(.*)(<\/a>)/', '<input tabindex="' . $sfgTabIndex . '" name="' . $input_name . '" value="$2" type="radio"> $1$2$3', $tree );
		$tree = str_replace( "value=\"$cur_value\"", "value=\"$cur_value\" checked=\"checked\"", $tree );
		// if it's disabled, set all to disabled
		if ( $is_disabled ) {
			$tree = str_replace( 'type="radio"', 'type="radio" disabled', $tree );
		}

		// Get rid of all the 'no subcategories' messages.
		$tree = str_replace( '<div class="CategoryTreeChildren" style="display:block"><i class="CategoryTreeNotice">' . wfMsg( 'categorytree-no-subcategories' ) . '</i></div>', '', $tree );

		$text .= $tree . '</div>';

		$spanClass = "radioButtonSpan";
		if ( $is_mandatory) { $spanClass .= " mandatoryFieldSpan"; }
		$text = Xml::tags( 'span', array( 'class' => $spanClass ), $text );

		return $text;
	}

	public static function getParameters() {
		$params = parent::getParameters();
		$params[] = array( 'name' => 'top category', 'type' => 'string', 'description' => wfMsg( 'sf_forminputs_topcategory' ) );
		$params[] = array( 'name' => 'hideroot', 'type' => 'boolean', 'description' => wfMsg( 'sf_forminputs_hideroot' ) );
		$params[] = array( 'name' => 'height', 'type' => 'int', 'description' => wfMsg( 'sf_forminputs_height' ) );
		$params[] = array( 'name' => 'width', 'type' => 'int', 'description' => wfMsg( 'sf_forminputs_width' ) );
		return $params;
	}
}

/**
 * @ingroup SFFormInput
 */
class SFCategoriesInput extends SFCategoryInput {
	public static function getName() {
		return 'categories';
	}

	public static function getOtherPropTypeListsHandled() {
		return array( '_wpg' );
	}

	public static function getHTML( $cur_value, $input_name, $is_mandatory, $is_disabled, $other_args ) {
		// escape if CategoryTree extension isn't included
		if ( ! function_exists( 'efCategoryTreeParserHook' ) )
			return null;

		global $sfgTabIndex, $sfgFieldNum, $wgCapitalLinks;

		$className = ( $is_mandatory ) ? "mandatoryField" : "createboxInput";
		if ( array_key_exists( 'class', $other_args ) )
			$className .= " " . $other_args['class'];
		$input_id = "input_$sfgFieldNum";
		$info_id = "info_$sfgFieldNum";
		// get list delimiter - default is comma
		if ( array_key_exists( 'delimiter', $other_args ) ) {
			$delimiter = $other_args['delimiter'];
		} else {
			$delimiter = ",";
		}
		$cur_values = SFUtils::getValuesArray( $cur_value, $delimiter );
		if ( array_key_exists( 'top category', $other_args ) ) {
			$top_category = $other_args['top category'];
		} else {
			// escape - we can't do anything
			return null;
		}
		$hideroot = array_key_exists( 'hideroot', $other_args );
		if ( array_key_exists( 'height', $other_args ) ) {
			$height = $other_args['height'];
		} else {
			$height = "100";
		}
		if ( array_key_exists( 'width', $other_args ) ) {
			$width = $other_args['width'];
		} else {
			$width = "500";
		}

		global $wgCategoryTreeMaxDepth;
		$wgCategoryTreeMaxDepth = 10;
		$tree = efCategoryTreeParserHook( $top_category, array( 'mode' => 'categories', 'depth' => 10, 'hideroot' => $hideroot ) );
		// Some string that will hopefully never show up in a category,
		// template or field name.
		$dummy_str = 'REPLACE THIS STRING!';
		$tree = preg_replace( '/(<a class="CategoryTreeLabel.*>)(.*)(<\/a>)/', '<input id="' . $input_id . '" tabindex="' . $sfgTabIndex . '" name="' . $input_name . '[' . $dummy_str . ']" value="$2" type="checkbox"> $1$2$3', $tree );
		// replace values one at a time, by an incrementing index -
		// inspired by http://bugs.php.net/bug.php?id=11457
		$i = 0;
		while ( ( $a = strpos( $tree, $dummy_str ) ) > 0 ) {
			$tree = substr( $tree, 0, $a ) . $i++ . substr( $tree, $a + strlen( $dummy_str ) );
		}
		// set all checkboxes matching $cur_values to checked
		foreach ( $cur_values as $value ) {
			// Capitalize the first letter, if first letters
			// always get capitalized.
			if ( $wgCapitalLinks ) {
				global $wgContLang;
				$value = $wgContLang->ucfirst( $value );
			}

			$tree = str_replace( "value=\"$value\"", "value=\"$value\" checked=\"checked\"", $tree );
		}
		// if it's disabled, set all to disabled
		if ( $is_disabled ) {
			$tree = str_replace( 'type="checkbox"', 'type="checkbox" disabled', $tree );
		}

		// Get rid of all the 'no subcategories' messages.
		$tree = str_replace( '<div class="CategoryTreeChildren" style="display:block"><i class="CategoryTreeNotice">' . wfMsg( 'categorytree-no-subcategories' ) . '</i></div>', '', $tree );

		$text = '<div style="overflow: auto; padding: 5px; border: 1px #aaaaaa solid; max-height: ' . $height . 'px; width: ' . $width . 'px;">' . $tree . '</div>';

		$text .= "\t" . Html::Hidden( $input_name . '[is_list]', 1 ) . "\n";
		$spanClass = "checkboxesSpan";
		if ( $is_mandatory) { $spanClass .= " mandatoryFieldSpan"; }
		$text = "\n" . Xml::tags( 'span', array( 'class' => $spanClass ), $text ) . "\n";

		return $text;
	}
}
