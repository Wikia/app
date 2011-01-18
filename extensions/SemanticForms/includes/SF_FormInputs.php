<?php
/**
 * Helper functions to display the various inputs of a user-generated form
 *
 * @author Yaron Koren
 * @author Jeffrey Stuckman
 * @author Matt Williamson
 * @author Patrick Nagel
 * @author Sanyam Goyal
 */

class SFFormInput {
	public static function getStandardParameters() {
		$params = array();
		$params[] = array( 'name' => 'restricted', 'type' => 'boolean'  );
		$params[] = array( 'name' => 'mandatory', 'type' => 'boolean' );
		return array();
	}

	public static function getParameters() {
		$params = array();
		$params[] = array( 'name' => 'class', 'type' => 'string' );
		$params[] = array( 'name' => 'default', 'type' => 'string' );
		$params[] = array( 'name' => 'preload', 'type' => 'string' );
		return array();
	}
}

class SFEnumInput extends SFFormInput {
	public static function getParameters() {
		$params = parent::getParameters();
		$params[] = array( 'name' => 'show on select', 'type' => 'string' );
		return $params;
	}
}

class SFMultiEnumInput extends SFEnumInput {
	public static function getParameters() {
		$params = parent::getParameters();
		$params[] = array( 'name' => 'delimiter', 'type' => 'string' );
		return $params;
	}
}

class SFTextInput extends SFFormInput {
  static function uploadLinkHTML( $input_id, $delimiter = null, $default_filename = null ) {
    global $wgOut, $sfgScriptPath;

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

  static function getText( $cur_value, $input_name, $is_mandatory, $is_disabled, $other_args ) {
    // if it's an autocomplete, call the with-autocomplete function instead
    if ( array_key_exists( 'autocompletion source', $other_args ) ) {
        return SFTextWithAutocompleteInput::getText( $cur_value, $input_name, $is_mandatory, $is_disabled, $other_args );
    }

    // if there are possible values specified, call the dropdown function
    if ( array_key_exists( 'possible_values', $other_args ) && $other_args['possible_values'] != null )
      return SFDropdownInput::getText( $cur_value, $input_name, $is_mandatory, $is_disabled, $other_args );

    global $sfgTabIndex, $sfgFieldNum;

    $className = "createboxInput";
    if ( $is_mandatory ) {
      $className .= " mandatoryField";
    }
    if ( array_key_exists( 'class', $other_args ) ) {
      $className .= " " . $other_args['class'];
    }
    $input_id = "input_$sfgFieldNum";
    // set size based on pre-set size, or field type - if field type is set,
    // possibly add validation too
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
		$params[] = array( 'name' => 'size', 'type' => 'int' );
		$params[] = array( 'name' => 'maxlength', 'type' => 'int' );
		$params[] = array( 'name' => 'uploadable', 'type' => 'boolean' );
		$params[] = array( 'name' => 'default filename', 'type' => 'string' );
		return $params;
	}
}

class SFDropdownInput extends SFEnumInput {
  static function getText( $cur_value, $input_name, $is_mandatory, $is_disabled, $other_args ) {
    global $sfgTabIndex, $sfgFieldNum, $sfgShowOnSelect;

    $className = ( $is_mandatory ) ? "mandatoryField" : "createboxInput";
    if ( array_key_exists( 'class', $other_args ) )
      $className .= " " . $other_args['class'];
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
    // add a blank value at the beginning, unless this is a mandatory field
    // and there's a current value in place (either through a default value
    // or because we're editing an existing page)
    if ( ! $is_mandatory || $cur_value == '' ) {
      $innerDropdown .= "  <option value=\"\"></option>\n";
    }
    if ( ( $possible_values = $other_args['possible_values'] ) == null )
      $possible_values = array();
    foreach ( $possible_values as $possible_value ) {
      $optionAttrs = array( 'value' => $possible_value );
      if ( $possible_value == $cur_value ) {
        $optionAttrs['selected'] = "selected";
      }
      if ( array_key_exists( 'value_labels', $other_args ) && is_array( $other_args['value_labels'] ) && array_key_exists( $possible_value, $other_args['value_labels'] ) )
        $label = $other_args['value_labels'][$possible_value];
      else
        $label = $possible_value;
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

class SFListBoxInput extends SFMultiEnumInput {
  static function getText( $cur_value, $input_name, $is_mandatory, $is_disabled, $other_args ) {
    global $sfgTabIndex, $sfgFieldNum, $sfgShowOnSelect;

    $className = ( $is_mandatory ) ? "mandatoryField" : "createboxInput";
    if ( array_key_exists( 'class', $other_args ) )
      $className .= " " . $other_args['class'];
    $input_id = "input_$sfgFieldNum";
    // get list delimiter - default is comma
    if ( array_key_exists( 'delimiter', $other_args ) ) {
      $delimiter = $other_args['delimiter'];
    } else {
       $delimiter = ",";
    }
    $cur_values = SFUtils::getValuesArray( $cur_value, $delimiter );
    $className .= " sfShowIfSelected";

    if ( ( $possible_values = $other_args['possible_values'] ) == null )
      $possible_values = array();
    $optionsText = "";
    foreach ( $possible_values as $possible_value ) {
      if ( array_key_exists( 'value_labels', $other_args ) && is_array( $other_args['value_labels'] ) && array_key_exists( $possible_value, $other_args['value_labels'] ) )
        $optionLabel = $other_args['value_labels'][$possible_value];
      else
        $optionLabel = $possible_value;
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
    $text .= "\t" . Xml::hidden( $input_name . '[is_list]', 1 ) . "\n";
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
}

class SFCheckboxesInput extends SFMultiEnumInput {
  static function getText( $cur_value, $input_name, $is_mandatory, $is_disabled, $other_args ) {
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

    $text .= "\n" . Xml::hidden( $input_name . '[is_list]', 1 ) . "\n";
    $outerSpanAttrs = array( 'id' => $outerSpanID, 'class' => $outerSpanClass );
    $text = "\t" . Xml::tags( 'span', $outerSpanAttrs, $text ) . "\n";

    return $text;
  }
}

class SFComboBoxInput extends SFFormInput {
  static function getText( $cur_value, $input_name, $is_mandatory, $is_disabled, $other_args ) {
    if ( array_key_exists( 'no autocomplete', $other_args ) &&
        $other_args['no autocomplete'] == true ) {
      unset( $other_args['autocompletion source'] );
      return SFTextInput::getText( $cur_value, $input_name, $is_mandatory, $is_disabled, $other_args );
    }
    // if a set of values was specified, print a dropdown instead
    if ( array_key_exists( 'possible_values', $other_args ) && $other_args['possible_values'] != null )
      return SFDropdownInput::getText( $cur_value, $input_name, $is_mandatory, $is_disabled, $other_args );

    global $sfgTabIndex, $sfgFieldNum, $wgOut, $sfgScriptPath, $wgJsMimeType;
    global $smwgScriptPath, $smwgJqUIAutoIncluded;

    $autocomplete_field_type = "";
    $autocompletion_source = "";

    $className = "sfComboBox";
    if ( $is_mandatory ) {
      $className .= " mandatoryField";
    }
    if ( array_key_exists( 'class', $other_args ) ) {
      $className .= " " . $other_args['class'];
    }
    $disabled_text = ( $is_disabled ) ? "disabled" : "";
    if ( array_key_exists( 'autocomplete field type', $other_args ) ) {
      $autocomplete_field_type = $other_args['autocomplete field type'];
      $autocompletion_source = $other_args['autocompletion source'];
      if ( $autocomplete_field_type != 'external_url' ) {
        global $wgContLang;
        $autocompletion_source = $wgContLang->ucfirst( $autocompletion_source );
      }
    }
    if ( array_key_exists( 'size', $other_args ) )
      $size = $other_args['size'];
    else
      $size = "35";

    $input_id = "input_" . $sfgFieldNum;
 
    $values = SFUtils::getAutocompleteValues($autocompletion_source, $autocomplete_field_type );
    $autocompletion_source = str_replace( "'", "\'", $autocompletion_source );

    $divClass = "ui-widget";
    if ($is_mandatory) { $divClass .= " mandatory"; }
    $text =<<<END
<div class="$divClass">
	<select id="input_$sfgFieldNum" name="$input_name" class="$className" tabindex="$sfgTabIndex" autocompletesettings="$autocompletion_source">
		<option value="$cur_value"></option>

END;
    foreach ($values as $value) {
      $text .= "		<option value=\"$value\">$value</option>\n";
    }
    $text .= <<<END
	</select>
</div>
END;
    // there's no direct correspondence between the 'size=' attribute for
    // text inputs and the number of pixels, but multiplying by 6 seems to
    // be about right for the major browsers
    $pixel_width = $size * 6;
    $combobox_css =<<<END
<style type="text/css">
input#input_$sfgFieldNum { width: {$pixel_width}px; }
</style>
END;
    $wgOut->addScript($combobox_css);
    return $text;
  }
}

class SFTextWithAutocompleteInput extends SFTextInput {
  static function getText( $cur_value, $input_name, $is_mandatory, $is_disabled, $other_args ) {
    // if 'no autocomplete' was specified, print a regular text entry instead
    if ( array_key_exists( 'no autocomplete', $other_args ) &&
        $other_args['no autocomplete'] == true ) {
      unset( $other_args['autocompletion source'] );
      return SFTextInput::getText( $cur_value, $input_name, $is_mandatory, $is_disabled, $other_args );
    }
    // if a set of values was specified, print a dropdown instead
    if ( array_key_exists( 'possible_values', $other_args ) && $other_args['possible_values'] != null )
      return SFDropdownInput::getText( $cur_value, $input_name, $is_mandatory, $is_disabled, $other_args );

    global $sfgTabIndex, $sfgFieldNum, $sfgScriptPath, $wgJsMimeType, $smwgScriptPath, $smwgJqUIAutoIncluded;
    global $sfgAutocompleteValues;

    $className = ( $is_mandatory ) ? "autocompleteInput mandatoryField" : "autocompleteInput createboxInput";
    if ( array_key_exists( 'class', $other_args ) )
      $className .= " " . $other_args['class'];
    if ( array_key_exists( 'autocomplete field type', $other_args ) ) {
      $autocomplete_field_type = $other_args['autocomplete field type'];
      $autocompletion_source = $other_args['autocompletion source'];
      if ( $autocomplete_field_type != 'external_url' ) {
        global $wgContLang;
        $autocompletion_source = $wgContLang->ucfirst( $autocompletion_source );
      }
    }
    $input_id = "input_" . $sfgFieldNum;

    // Get all autocomplete-related values, plus delimiter value (it's needed
    // also for the 'uploadable' link, if there is one).
    $autocompleteSettings = $autocompletion_source;
    $is_list = ( array_key_exists( 'is_list', $other_args ) && $other_args['is_list'] == true );
    if ( $is_list ) {
      $autocompleteSettings .= ",list";
      if ( array_key_exists( 'delimiter', $other_args ) ) {
        $delimiter = $other_args['delimiter'];
        $autocompleteSettings .= "," . $delimiter;
      } else {
        $delimiter = ",";
      }
    } else {
      $delimiter = null;
    }

    $remoteDataType = null;
    if ( array_key_exists( 'remote autocompletion', $other_args ) &&
        $other_args['remote autocompletion'] == true ) {
      $remoteDataType = $autocomplete_field_type;
    } elseif ( $autocompletion_source != '' ) {
      $autocomplete_values = SFUtils::getAutocompleteValues( $autocompletion_source, $autocomplete_field_type );
      $sfgAutocompleteValues[$autocompleteSettings] = $autocomplete_values;
    }

    if ( array_key_exists( 'input_type', $other_args ) && $other_args['input_type'] == "textarea" ) {
       
      $rows = $other_args['rows'];
      $cols = $other_args['cols'];
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
        // For every actual character pressed (i.e., excluding things like the
        // Shift key), reduce the string to its allowed length if it's exceeded
        // that.
        // This JS code is complicated so that it'll work correctly in IE - IE
        // moves the cursor to the end whenever this.value is reset, so we'll
        // make sure to do that only when we need to.
        $maxLengthJSCheck = "if (window.event && window.event.keyCode < 48 && window.event.keyCode != 13) return; if (this.value.length > $maxlength) { this.value = this.value.substring(0, $maxlength); }";
        $textarea_attrs['onKeyDown'] = $maxLengthJSCheck;
        $textarea_attrs['onKeyUp'] = $maxLengthJSCheck;
      }
      $textarea_input = Xml::element('textarea', $textarea_attrs, $cur_value, false);
      $text .= $textarea_input;
    } else {
      if ( array_key_exists( 'size', $other_args ) )
        $size = $other_args['size'];
      else
        $size = "35";

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
        $text .= ' maxlength="' . $other_args['maxlength'] . '"';
      }
      $text = "\n\t" . Xml::element( 'input', $inputAttrs ) . "\n";
    }
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
		$params = array();
		$params[] = array( 'name' => 'maxlength', 'type' => 'int' );
		$params[] = array( 'name' => 'list', 'type' => 'boolean' );
		$params[] = array( 'name' => 'remote autocompletion', 'type' => 'boolean' );
		return array();
	}
}

class SFTextAreaInput extends SFFormInput {
  static function getText( $cur_value, $input_name, $is_mandatory, $is_disabled, $other_args ) {
    // set size values
      
    if ( ! array_key_exists( 'rows', $other_args ) )
      $other_args['rows'] = 5;
    if ( ! array_key_exists( 'cols', $other_args ) )
      $other_args['cols'] = 80;

    // if it's an autocomplete, call the with-autocomplete function instead
    if ( array_key_exists( 'autocompletion source', $other_args ) ) {
        $other_args['input_type'] = "textarea";
        return SFTextWithAutocompleteInput::getText( $cur_value, $input_name, $is_mandatory, $is_disabled, $other_args );
    }

    global $sfgTabIndex, $sfgFieldNum, $smwgScriptPath, $sfgScriptPath;

    $className = ( $is_mandatory ) ? "mandatoryField" : "createboxInput";
    if ( array_key_exists( 'class', $other_args ) )
      $className .= " " . $other_args['class'];
    // use a special ID for the free text field, for FCK's needs
    $input_id = $input_name == "free_text" ? "free_text" : "input_$sfgFieldNum";

    $rows = $other_args['rows'];
    $cols = $other_args['cols'];

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
    );
    if ( $is_disabled ) {
      $textarea_attrs['disabled'] = 'disabled';
    }
    if ( array_key_exists( 'maxlength', $other_args ) ) {
      $maxlength = $other_args['maxlength'];
      // For every actual character pressed (i.e., excluding things like the
      // Shift key), reduce the string to its allowed length if it's exceeded
      // that.
      // This JS code is complicated so that it'll work correctly in IE - IE
      // moves the cursor to the end whenever this.value is reset, so we'll
      // make sure to do that only when we need to.
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
		$params[] = array( 'name' => 'rows', 'type' => 'int' );
		$params[] = array( 'name' => 'cols', 'type' => 'int' );
		$params[] = array( 'name' => 'autogrow', 'type' => 'boolean' );
		return $params;
	}
}

class SFDateInput extends SFFormInput {
  static function monthDropdownHTML( $cur_month, $input_name, $is_disabled ) {
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

  static function getMainHTML( $date, $input_name, $is_mandatory, $is_disabled, $other_args ) {
    global $sfgTabIndex, $sfgFieldNum, $wgAmericanDates;

    $input_id = "input_$sfgFieldNum";

    if ( $date ) {
      // can show up here either as an array or a string, depending on
      // whether it came from user input or a wiki page
      if ( is_array( $date ) ) {
        $year = $date['year'];
        $month = $date['month'];
        $day = $date['day'];
      } else {
        // handle 'default=now'
        if ( $date == 'now' ) $date = date( 'Y/m/d' );
        $actual_date = new SMWTimeValue( '_dat' );
        $actual_date->setUserValue( $date );
        $year = $actual_date->getYear();
        // TODO - the code to convert from negative to BC notation should
        // be in SMW itself
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
    $dayInput = '  <input tabindex="' . $sfgTabIndex . '" class="dayInput" name="' . $input_name . '[day]" type="text" value="' . $day . '" size="2" ' . $disabled_text . '/>';
    if ( $wgAmericanDates ) {
      $text .= "$monthInput\n$dayInput\n";
    } else {
      $text .= "$dayInput\n$monthInput\n";
    }
    $text .= '  <input tabindex="' . $sfgTabIndex . '" class="yearInput" name="' . $input_name . '[year]" type="text" value="' . $year . '" size="4" ' . $disabled_text . '/>' . "\n";
    return $text;
  }
  
  static function getText( $date, $input_name, $is_mandatory, $is_disabled, $other_args ) {
    $text = self::getMainHTML( $date, $input_name, $is_mandatory, $is_disabled, $other_args );
    $spanClass = "dateInput";
    if ( $is_mandatory ) { $spanClass .= " mandatoryFieldSpan"; }
    $text = Xml::tags( 'span', array( 'class' => $spanClass ), $text );
    return $text;
  }
}

class SFDateTimeInput extends SFDateInput {
  static function getText( $datetime, $input_name, $is_mandatory, $is_disabled, $other_args ) {
    global $sfgTabIndex, $sfg24HourTime;

    $include_timezone = $other_args['include_timezone'];
 
    if ( $datetime ) {
      // can show up here either as an array or a string, depending on
      // whether it came from user input or a wiki page
      if ( is_array( $datetime ) ) {
        if ( isset( $datetime['hour'] ) ) $hour = $datetime['hour'];
        if ( isset( $datetime['minute'] ) ) $minute = $datetime['minute'];
        if ( isset( $datetime['second'] ) ) $second = $datetime['second'];
        if ( ! $sfg24HourTime ) {
          if ( isset( $datetime['ampm24h'] ) ) $ampm24h = $datetime['ampm24h'];
        }
        if ( isset( $datetime['timezone'] ) ) $timezone = $datetime['timezone'];
      } else {
        // TODO - this should change to use SMW's own date-handling class,
        // just like dateEntryHTML() does
        $actual_date = strtotime( $datetime );
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
    $text .= '  &#160;<input tabindex="' . $sfgTabIndex . '" name="' . $input_name . '[hour]" type="text" value="' . $hour . '" size="2"/ ' . $disabled_text . '>';
    $sfgTabIndex++;
    $text .= '  :<input tabindex="' . $sfgTabIndex . '" name="' . $input_name . '[minute]" type="text" value="' . $minute . '" size="2"/ ' . $disabled_text . '>';
    $sfgTabIndex++;
    $text .= ':<input tabindex="' . $sfgTabIndex . '" name="' . $input_name . '[second]" type="text" value="' . $second . '" size="2"/ ' . $disabled_text . '>' . "\n";

    if ( ! $sfg24HourTime ) {
      $sfgTabIndex++;
      $text .= '   <select tabindex="' . $sfgTabIndex . '" name="' . $input_name . "[ampm24h]\" $disabled_text>\n";
      $ampm24h_options = array( '', 'AM', 'PM' );
      foreach ( $ampm24h_options as $value ) {
        $text .= "        <option value=\"$value\"";
        if ( $value == $ampm24h ) { $text .= " selected=\"selected\""; }
        $text .= ">$value</option>\n";
      }
      $text .= "  </select>\n";
    }

    if ( $include_timezone ) {
      $sfgTabIndex++;
      $text .= '  <input tabindex="' . $sfgTabIndex . '" name="' . $input_name . '[timezone]" type="text" value="' . $timezone . '" size="2"/ ' . $disabled_text . '>' . "\n";
    }

    return $text;
  }
}

class SFRadioButtonInput extends SFEnumInput {
  static function getText( $cur_value, $input_name, $is_mandatory, $is_disabled, $other_args ) {
    global $sfgTabIndex, $sfgFieldNum, $sfgShowOnSelect;

    if ( ( $possible_values = $other_args['possible_values'] ) == null )
      $possible_values = array();

    // Add a "None" value at the beginning, unless this is a mandatory
    // field and there's a current value in place (either through a
    // default value or because we're editing an existing page).
    if ( ! $is_mandatory || $cur_value == '' ) {
      array_unshift( $possible_values, '' );
    }

    // Set $cur_value to be one of the allowed options, if it isn't already -
    // that makes it easier to automatically have one of the radiobuttons
    // be checked at the beginning.
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

class SFCheckboxInput extends SFFormInput {
  static function getText( $cur_value, $input_name, $is_mandatory, $is_disabled, $other_args ) {
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

    // can show up here either as an array or a string, depending on
    // whether it came from user input or a wiki page
    if ( is_array( $cur_value ) ) {
      $checked_str = ( array_key_exists( 'value', $cur_value ) && $cur_value['value'] == 'on' ) ? ' checked="checked"' : "";
    } else {
      // default to false - no need to check if it matches a 'false' word
      $vlc = strtolower( trim( $cur_value ) );
      // manually load SMW's message values, if they weren't loaded before
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
}

class SFCategoryInput extends SFFormInput {
  static function getText( $cur_value, $input_name, $is_mandatory, $is_disabled, $other_args ) {
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

    // start with an initial "None" value, unless this is a mandatory field
    // and there's a current value in place (either through a default value
    // or because we're editing an existing page)
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
    $tree = efCategoryTreeParserHook( $top_category, array( 'mode' => 'categories', 'depth' => 10 ) );

    // CategoryTree HTML-escapes all values
    $cur_value = htmlentities( $cur_value );
    // capitalize the first letter, if first letters always get capitalized
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
    $text .= $tree . '</div>';

    $spanClass = "radioButtonSpan";
    if ( $is_mandatory) { $spanClass .= " mandatoryFieldSpan"; }
    $text = Xml::tags( 'span', array( 'class' => $spanClass ), $text );

    return $text;
  }
}

class SFCategoriesInput {
  static function getText( $cur_value, $input_name, $is_mandatory, $is_disabled, $other_args ) {
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
    $tree = efCategoryTreeParserHook( $top_category, array( 'mode' => 'categories', 'depth' => 10 ) );
    // some string that will hopefully never show up in a category, template
    // or field name
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
      // CategoryTree HTML-escapes all values
      $value = htmlentities( $value );
      // capitalize the first letter, if first letters always get capitalized
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
    $text = '<div style="overflow: auto; padding: 5px; border: 1px #aaaaaa solid; max-height: ' . $height . 'px; width: ' . $width . 'px;">' . $tree . '</div>';

    $text .= "\t" . Xml::hidden( $input_name . '[is_list]', 1 ) . "\n";
    $spanClass = "checkboxesSpan";
    if ( $is_mandatory) { $spanClass .= " mandatoryFieldSpan"; }
    $text = "\n" . Xml::tags( 'span', array( 'class' => $spanClass ), $text ) . "\n";

    return $text;
  }
}
