<?php
/**
 * Handles the creation and running of a user-created form.
 *
 * @author Yaron Koren
 * @author Jeffrey Stuckman
 * @author Matt Williamson
 */

class SFFormInputs {

  function createAutocompleteValuesArray($field_name, $autocomplete_field_type) {
    $names_array = array();
    // the query depends on whether this field is a relation (property of type
    // Page), attribute (property of any other type), category or namespace
    if ($autocomplete_field_type == 'relation' || $autocomplete_field_type == 'attribute' || $autocomplete_field_type == 'property') {
      $smw_version = SMW_VERSION;
      if (version_compare(SMW_VERSION, '1.2', '>=' ) ||
          substr($smw_version, 0, 3) == '1.2') { // temporary hack
        $names_array = sffGetAllPagesForProperty_1_2($field_name);
      } else {
        $is_relation = ($autocomplete_field_type == 'relation');
        $names_array = sffGetAllPagesForProperty_orig($is_relation, $field_name);
      }
    } elseif ($autocomplete_field_type == 'category') {
      $names_array = sffGetAllPagesForCategory($field_name, 10);
    } else { // i.e., $autocomplete_field_type == 'namespace'
      // switch back to blank for main namespace
      if ($field_name == "main")
        $field_name = "";
      $names_array = sffGetAllPagesForNamespace($field_name);
    }
    return $names_array;
  }

  function uploadLinkHTML($input_id, $delimiter = null) {
    $upload_window_page = SpecialPage::getPage('UploadWindow');
    $query_string = "sfInputID=$input_id";
    if ($delimiter != null)
      $query_string .= "&sfDelimiter=$delimiter";
    $upload_window_url = $upload_window_page->getTitle()->getFullURL($query_string);
    $upload_label = wfMsg('upload');
    $text = " <a href=\"$upload_window_url\" title=\"$upload_label\" rel=\"iframe\" rev=\"width:550 height:380\">$upload_label</a>";
    return $text;
  }

  function textEntryHTML($cur_value, $input_name, $is_mandatory, $is_disabled, $other_args) {
    // if it's an autocomplete, call the with-autocomplete function instead
    // we test to make sure that autocompletion hasn't been disabled, and
    // that either the property is a relation (i.e. it's of type Page) or
    // autocompletion has been specified in the form
    $autocompletion_disabled = (array_key_exists('autocomplete on', $other_args) && $other_args['autocomplete on'] == "") ||
      (array_key_exists('no autocomplete', $other_args) && $other_args['no autocomplete'] == true);
    if (! $autocompletion_disabled) {
      if ((array_key_exists('is_relation', $other_args) && $other_args['is_relation'] == true) ||
          array_key_exists('autocomplete', $other_args) ||
          array_key_exists('autocomplete on property', $other_args) ||
          array_key_exists('autocomplete on category', $other_args) ||
          array_key_exists('autocomplete on', $other_args) ||
          array_key_exists('autocomplete on namespace', $other_args) ||
          array_key_exists('remote autocompletion', $other_args)) {
        return SFFormInputs::textInputWithAutocompleteHTML($cur_value, $input_name, $is_mandatory, $is_disabled, $other_args);
      }
    }

    // if there are possible values specified, call the dropdown function
    if (array_key_exists('possible_values', $other_args) && $other_args['possible_values'] != null)
      return SFFormInputs::dropdownHTML($cur_value, $input_name, $is_mandatory, $is_disabled, $other_args);

    global $sfgTabIndex, $sfgFieldNum, $sfgJSValidationCalls;

    $className = ($is_mandatory) ? "createboxInput mandatoryField" : "createboxInput";
    if (array_key_exists('class', $other_args))
      $className .= " " . $other_args['class'];
    $input_id = "input_$sfgFieldNum";
    $info_id = "info_$sfgFieldNum";
    // set size based on pre-set size, or field type - if field type is set,
    // possibly add validation too
    if (array_key_exists('size', $other_args)) {
      $size = $other_args['size'];
    } elseif (array_key_exists('field_type', $other_args)) {
      $validation_type_str = "";
      if ($other_args['field_type'] == 'integer') {
        $size = 10;
        $validation_type_str = 'integer';
      } elseif ($other_args['field_type'] == 'float') {
        $size = 10;
        $validation_type_str = 'float';
      } elseif ($other_args['field_type'] == 'URL') {
        $size = 100;
        $validation_type_str = 'URL';
      } elseif ($other_args['field_type'] == 'email') {
        $size = 45;
        $validation_type_str = 'email';
      } else {
        $size = 35;
      }
      if ($validation_type_str != '') {
        if ($other_args['part_of_multiple']) {
          $sfgJSValidationCalls[] = "validate_type_of_multiple_fields($sfgFieldNum, '$validation_type_str')";
        } else {
          $sfgJSValidationCalls[] = "validate_field_type('$input_id', '$validation_type_str', '$info_id')";
        }
      }
    } else {
      $size = 35;
    }

    $text =<<<END
		<input id="$input_id" tabindex="$sfgTabIndex" class="$className" name="$input_name" type="text"
        value="$cur_value" size="$size"
END;
    if ($is_disabled)
      $text .= " disabled";
    if (array_key_exists('maxlength', $other_args))
      $text .= ' maxlength="' . $other_args['maxlength'] . '"';
    $text .=<<<END
/>
	<span id="$info_id" class="errorMessage"></span>

END;
    if (array_key_exists('is_uploadable', $other_args) && $other_args['is_uploadable'] == true) {
      if (array_key_exists('is_list', $other_args) && $other_args['is_list'] == true) {
        if (array_key_exists('delimiter', $other_args)) {
          $delimiter = $other_args['delimiter'];
        } else {
          $delimiter = ",";
        }
      } else {
        $delimiter = null;
      }
      $text .= SFFormInputs::uploadLinkHTML($input_id, $delimiter);
    }
    return array($text, null);
  }

  function dropdownHTML($cur_value, $input_name, $is_mandatory, $is_disabled, $other_args) {
    global $sfgTabIndex, $sfgFieldNum;

    $className = ($is_mandatory) ? "mandatoryField" : "createboxInput";
    if (array_key_exists('class', $other_args))
      $className .= " " . $other_args['class'];
    $input_id = "input_$sfgFieldNum";
    $info_id = "info_$sfgFieldNum";
    $disabled_text = ($is_disabled) ? "disabled" : "";
    $text =<<<END
	<select id="$input_id" tabindex="$sfgTabIndex" name="$input_name" class="$className" $disabled_text>

END;
    // add a blank value at the beginning if it's a non-mandatory field
    if (! $is_mandatory)
      $text .= "  <option value=\"\"></option>\n";
    if (($possible_values = $other_args['possible_values']) == null)
      $possible_values = array(); 
    foreach ($possible_values as $possible_value) {
      $text .= "  <option value=\"$possible_value\"";
      if ($possible_value == $cur_value) {$text .= " selected=\"selected\""; }
      $text .= ">$possible_value</option>\n";
    }
    $text .=<<<END
	</select>
	<span id="$info_id" class="errorMessage"></span>

END;
    return array($text, null);
  }

  /*
   * getValuesArray() - helper function to get an array of values out of
   * what may be either an array or a delimited string
   */
  function getValuesArray($value, $delimiter) {
    if (is_array($value)) {
      return $value;
    } else {
      // remove extra spaces
      return array_map('trim', explode($delimiter, $value));
    }
  }

  function listboxHTML($cur_value, $input_name, $is_mandatory, $is_disabled, $other_args) {
    global $sfgTabIndex, $sfgFieldNum;

    $className = ($is_mandatory) ? "mandatoryField" : "createboxInput";
    if (array_key_exists('class', $other_args))
      $className .= " " . $other_args['class'];
    $input_id = "input_$sfgFieldNum";
    $info_id = "info_$sfgFieldNum";
    $hidden_input_name = $input_name . "[is_list]";
    $input_name .= "[]"; // needed so that this input will send an array
    $disabled_text = ($is_disabled) ? "disabled" : "";
    // get list delimiter - default is comma
    if (array_key_exists('delimiter', $other_args)) {
      $delimiter = $other_args['delimiter'];
    } else {
       $delimiter = ",";
    }
    $cur_values = SFFormInputs::getValuesArray($cur_value, $delimiter);

    $text =<<<END
	<select id="$input_id" tabindex="$sfgTabIndex" name="$input_name" class="$className" multiple $disabled_text>

END;
    if (($possible_values = $other_args['possible_values']) == null)
      $possible_values = array(); 
    foreach ($possible_values as $possible_value) {
      $text .= "  <option value=\"$possible_value\"";
      if (in_array($possible_value, $cur_values)) {$text .= " selected"; }
      $text .= ">$possible_value</option>\n";
    }
    $text .=<<<END
	</select>
	<span id="$info_id" class="errorMessage"></span>
	<input type="hidden" name="$hidden_input_name" value="1" />

END;
    return array($text, null);
  }

  function checkboxesHTML($cur_value, $input_name, $is_mandatory, $is_disabled, $other_args) {
    global $sfgTabIndex, $sfgFieldNum;

    $className = ($is_mandatory) ? "mandatoryField" : "createboxInput";
    if (array_key_exists('class', $other_args))
      $className .= " " . $other_args['class'];
    $input_id = "input_$sfgFieldNum";
    $info_id = "info_$sfgFieldNum";
    $hidden_input_name = $input_name . "[is_list]";
    $disabled_text = ($is_disabled) ? "disabled" : "";
    // get list delimiter - default is comma
    if (array_key_exists('delimiter', $other_args)) {
      $delimiter = $other_args['delimiter'];
    } else {
      $delimiter = ",";
    }
    $cur_values = SFFormInputs::getValuesArray($cur_value, $delimiter);

    if (($possible_values = $other_args['possible_values']) == null)
      $possible_values = array(); 
    $text = "";
    // if it's mandatory, add a span around all the checkboxes, since
    // some browsers don't support formatting of checkboxes
    if ($is_mandatory)
      $text .= '	<span class="mandatoryFieldsSpan">' . "\n";
    foreach ($possible_values as $key => $possible_value) {
      $cur_input_name = $input_name . "[" . $key . "]";
      $checked_text = (in_array($possible_value, $cur_values)) ? 'checked="checked"' : "";
      $text .=<<<END
	<span class="checkboxSpan">
	<input type="checkbox" id="$input_id" tabindex="$sfgTabIndex" name="$cur_input_name" value="$possible_value" class="$className" $checked_text $disabled_text/> $possible_value
	</span>

END;
      $sfgTabIndex++;
    }
    // close span
    if ($is_mandatory)
      $text .= "	</span>";
    $text .=<<<END
	<span id="$info_id" class="errorMessage"></span>
	<input type="hidden" name="$hidden_input_name" value="1" />

END;
    return array($text, null);
  }

  function textInputWithAutocompleteHTML($cur_value, $input_name, $is_mandatory, $is_disabled, $other_args) {
    // if 'no autocomplete' was specified, call the regular text entry instead
    if (array_key_exists('no autocomplete', $other_args) &&
        $other_args['no autocomplete'] == true)
      return SFFormInputs::textEntryHTML($cur_value, $input_name, $is_mandatory, $is_disabled, $other_args);

    global $sfgTabIndex, $sfgFieldNum;

    $className = ($is_mandatory) ? "autocompleteInput mandatoryField" : "autocompleteInput";
    if (array_key_exists('class', $other_args))
      $className .= " " . $other_args['class'];
    $disabled_text = ($is_disabled) ? "disabled" : "";
    if (array_key_exists('autocomplete on property', $other_args)) {
      $autocomplete_field_type = 'property';
      $semantic_field_name = $other_args['autocomplete on property'];
    } elseif (array_key_exists('autocomplete on', $other_args)) { // for backwards-compatibility
      $autocomplete_field_type = 'category';
      $semantic_field_name = $other_args['autocomplete on'];
    } elseif (array_key_exists('autocomplete on category', $other_args)) {
      $autocomplete_field_type = 'category';
      $semantic_field_name = $other_args['autocomplete on category'];
    } elseif (array_key_exists('autocomplete on namespace', $other_args)) {
      $autocomplete_field_type = 'namespace';
      $semantic_field_name = $other_args['autocomplete on namespace'];
      // special handling for "main" (blank) namespace
      if ($semantic_field_name == "")
        $semantic_field_name = "main";
    } elseif (array_key_exists('is_relation', $other_args) ||
              (array_key_exists('field_type', $other_args) && $other_args['field_type'] == 'page')) {
      $autocomplete_field_type = 'relation';
      $semantic_field_name = $other_args['semantic_field_name'];
    } else {
      $autocomplete_field_type = 'attribute';
      if (array_key_exists('semantic_field_name', $other_args))
        $semantic_field_name = $other_args['semantic_field_name'];
      else
        // there's some discrepancy between the form and template calls and
        // the property for this field
        $semantic_field_name = "";
    }
    $input_id = "input_" . $sfgFieldNum;
    $info_id = "info_" . $sfgFieldNum;
    $div_name = "div_" . $sfgFieldNum;
    if (array_key_exists('input_type', $other_args) && $other_args['input_type'] == "textarea") {
      $rows = $other_args['rows'];
      $cols = $other_args['cols'];
      $text =<<<END
	<textarea tabindex="$sfgTabIndex" id="$input_id" name="$input_name" rows="$rows" cols="$cols" class="$className" $disabled_text></textarea>

END;
    } else {
      if (array_key_exists('size', $other_args))
        $size = $other_args['size'];
      else
        $size = "35";

      $text =<<<END
        <input tabindex="$sfgTabIndex" id="$input_id" name="$input_name" type="text"
	value="" size="$size" class="$className"
END;
    if ($is_disabled)
      $text .= " disabled";
    if (array_key_exists('maxlength', $other_args))
      $text .= ' maxlength="' . $other_args['maxlength'] . '"';
    $text .= "/>\n";
    }
    // is_list and delimiter variables - needed later
    $is_list = (array_key_exists('is_list', $other_args) && $other_args['is_list'] == true);
    if ($is_list) {
      if (array_key_exists('delimiter', $other_args)) {
        $delimiter = $other_args['delimiter'];
      } else {
        $delimiter = ",";
      }
    } else {
      $delimiter = null;
    }
    if (array_key_exists('is_uploadable', $other_args) && $other_args['is_uploadable'] == true) {
      $text .= SFFormInputs::uploadLinkHTML($input_id, $delimiter);
    }
    $text .=<<<END
	<span id="$info_id" class="errorMessage"></span>
	<div class="page_name_auto_complete" id="$div_name"></div>
<script type="text/javascript">/* <![CDATA[ */

END;
    $options_str_key = str_replace("'", "\'", $semantic_field_name);
    if ($is_list) {
      $options_str_key .= ",list";
      if ($delimiter != ",") {
        $options_str_key .= "," . $delimiter;
      }
    }
    $javascript_text = "autocompletemappings[$sfgFieldNum] = '$options_str_key';\n";
    if (array_key_exists('remote_autocompletion', $other_args) &&
        $other_args['remote_autocompletion'] == true) {
      $javascript_text .= "autocompletedatatypes['$options_str_key'] = '$autocomplete_field_type';\n";
    } else {
      $autocomplete_values = SFFormInputs::createAutocompleteValuesArray(str_replace(' ', '_', $semantic_field_name), $autocomplete_field_type);
      $autocomplete_string = "[['" . implode("'], ['", $autocomplete_values) . "']]";
      $javascript_text .= "autocompletestrings['$options_str_key'] = $autocomplete_string;\n";
    }
    if ($cur_value) {
      $text .= "document.getElementById('$input_id').value = \"$cur_value\"\n";
    }
    $text .= "/* ]]> */</script>\n";
    return array($text, $javascript_text);
  }

  function textAreaHTML($cur_value, $input_name, $is_mandatory, $is_disabled, $other_args) {
    // set size values
    if (! array_key_exists('rows', $other_args))
      $other_args['rows'] = 5;
    if (! array_key_exists('cols', $other_args))
      $other_args['cols'] = 80;

    // if it's an autocomplete, call the with-autocomplete function instead
    $autocompletion_disabled = array_key_exists('autocomplete on', $other_args) && $other_args['autocomplete on'] == "";
    if (! $autocompletion_disabled) {
      if ((array_key_exists('is_relation', $other_args) && $other_args['is_relation'] == true) ||
          array_key_exists('autocomplete', $other_args) ||
          array_key_exists('autocomplete on', $other_args) ||
          array_key_exists('autocomplete on namespace', $other_args) ||
          array_key_exists('remote autocompletion', $other_args)) {
        $other_args['input_type'] = "textarea";
        return SFFormInputs::textInputWithAutocompleteHTML($cur_value, $input_name, $is_mandatory, $is_disabled, $other_args);
      }
    }

    global $sfgTabIndex, $sfgFieldNum;

    $className = ($is_mandatory) ? "mandatoryField" : "createboxInput";
    if (array_key_exists('class', $other_args))
      $className .= " " . $other_args['class'];
    $input_id = "input_$sfgFieldNum";
    $info_id = "info_$sfgFieldNum";
    $disabled_text = ($is_disabled) ? "disabled" : "";

    $rows = $other_args['rows'];
    $cols = $other_args['cols'];

    $text =<<<END
	<textarea tabindex="$sfgTabIndex" id="$input_id" name="$input_name" rows="$rows" cols="$cols" class="$className" $disabled_text>$cur_value</textarea>
	<span id="$info_id" class="errorMessage"></span>

END;
    return array($text, null);
  }

  function monthDropdownHTML($cur_month, $input_name, $is_disabled) {
    global $sfgTabIndex, $sfgFieldNum, $wgAmericanDates;

    $disabled_text = ($is_disabled) ? "disabled" : "";
    $text = '	<select tabindex="' . $sfgTabIndex . '" id="input_' . $sfgFieldNum . '_month" name="' . $input_name . "[month]\" $disabled_text>\n";
    $month_names = sffGetMonthNames();
    foreach ($month_names as $i => $name) {
      // pad out month to always be two digits
      $month_value = ($wgAmericanDates == true) ? $name : str_pad($i + 1, 2, "0", STR_PAD_LEFT);
      $text .= "	<option value=\"$month_value\"";
      if ($name == $cur_month || ($i + 1) == $cur_month) {$text .= " selected=\"selected\""; }
      $text .= ">$name</option>\n";
    }
    $text .= "	</select>\n";
    return $text;
  }

  function dateEntryHTML($date, $input_name, $is_mandatory, $is_disabled, $other_args) {
    global $sfgTabIndex, $sfgFieldNum, $sfgJSValidationCalls;

    $input_id = "input_$sfgFieldNum";
    $info_id = "info_$sfgFieldNum";
    // add to validation calls
    if ($other_args['part_of_multiple']) {
      $sfgJSValidationCalls[] = "validate_type_of_multiple_fields($sfgFieldNum, 'date')";
    } else {
      $sfgJSValidationCalls[] = "validate_field_type('$input_id', 'date', '$info_id')";
    }

    if ($date) {
      // can show up here either as an array or a string, depending on
      // whether it came from user input or a wiki page
      if (is_array($date)) {
        $year = $date['year'];
        $month = $date['month'];
        $day = $date['day'];
      } else {
        $actual_date = strtotime($date);
        $year = date("Y", $actual_date);
        $month = date("n", $actual_date);
        $day = date("j", $actual_date);
      }
    } else {
      $cur_date = getdate();
      $year = $cur_date['year'];
      $month = $cur_date['month'];
      $day = null; // no need for day
    }
    $disabled_text = ($is_disabled) ? "disabled" : "";
    $text = SFFormInputs::monthDropdownHTML($month, $input_name, $is_disabled);
    $text .= '  <input tabindex="' . $sfgTabIndex . '" id="' . $input_id . '_day" name="' . $input_name . '[day]" type="text" value="' . $day . '" size="2" ' . $disabled_text . '/>' . "\n";
    $text .= '  <input tabindex="' . $sfgTabIndex . '" id="' . $input_id . '_year" name="' . $input_name . '[year]" type="text" value="' . $year . '" size="4" ' . $disabled_text . '/>' . "\n";
    $text .= "	<span id=\"$info_id\" class=\"errorMessage\"></span>";
    return array($text, null);
  }

  function dateTimeEntryHTML($datetime, $input_name, $is_mandatory, $is_disabled, $other_args) {
    global $sfgTabIndex;

    $include_timezone = $other_args['include_timezone'];
 
    if ($datetime) {
      // can show up here either as an array or a string, depending on
      // whether it came from user input or a wiki page
      if (is_array($datetime)) {
        if (isset($datetime['hour'])) $hour = $cur_value['hour'];
        if (isset($datetime['minute'])) $minute = $cur_value['minute'];
        if (isset($datetime['second'])) $second = $cur_value['second'];
        if (isset($datetime['ampm24h'])) $ampm24h = $cur_value['ampm24h'];
        if (isset($datetime['timezone'])) $timezone = $cur_value['timezone'];
      } else {
        $actual_date = strtotime($datetime);
        $hour = date("g", $actual_date);
        $minute = date("i", $actual_date);
        $second = date("s", $actual_date);
        $ampm24h = date("A", $actual_date);
        $timezone = date("T", $actual_date);
      }
    } else {
      $cur_date = getdate();
      $hour = null;
      $minute = null;
      $second = "00"; // default at least this value
      $timezone = "";
    }

    list($text, $javascript_text) = SFFormInputs::dateEntryHTML($datetime, $input_name, $is_mandatory, $is_disabled, $other_args);
    $disabled_text = ($is_disabled) ? "disabled" : "";
    $text .= '  &nbsp;<input tabindex="' . $sfgTabIndex . '" name="' . $input_name . '[hour]" type="text" value="' . $hour . '" size="2"/ ' . $disabled_text . '>';
    $sfgTabIndex++;
    $text .= '  :<input tabindex="' . $sfgTabIndex . '" name="' . $input_name . '[minute]" type="text" value="' . $minute . '" size="2"/ ' . $disabled_text . '>';
    $sfgTabIndex++;
    $text .= ':<input tabindex="' . $sfgTabIndex . '" name="' . $input_name . '[second]" type="text" value="' . $second . '" size="2"/ ' . $disabled_text . '>' . "\n";

    $sfgTabIndex++;
    $text .= '   <select tabindex="' . $sfgTabIndex . '" name="' . $input_name . "[ampm24h]\" $disabled_text>\n";
    $ampm24h_options = array('', 'AM', 'PM');
    foreach ($ampm24h_options as $value) {
      $text .= "        <option value=\"$value\"";
      if ($value == $ampm24h) {$text .= " selected=\"selected\""; }
      $text .= ">$value</option>\n";
    }
    $text .= "  </select>\n";

    if ($include_timezone) {
      $sfgTabIndex++;
      $text .= '  <input tabindex="' . $sfgTabIndex . '" name="' . $input_name . '[timezone]" type="text" value="' . $timezone . '" size="2"/ ' . $disabled_text . '>' . "\n";
    }

    return array($text, $javascript_text);
  }

  function radioButtonHTML($cur_value, $input_name, $is_mandatory, $is_disabled, $other_args) {
    global $sfgTabIndex;

    $disabled_text = ($is_disabled) ? "disabled" : "";
    $check_set = false;
    if (! $is_mandatory) {
      $text = '	<input type="radio" tabindex="' . $sfgTabIndex . '" name="' . $input_name . '" value=""';
      if (! $cur_value) {
        $text .= ' checked="checked"';
        $check_set = true;
      }
      $text .= " $disabled_text/> " . wfMsg('sf_editdata_none') . "\n";
    }
    // if it's mandatory, add a span around all the radiobuttons, since
    // some browsers don't support formatting of radiobuttons
    if ($is_mandatory)
      $text = '	<span class="mandatoryFieldsSpan">' . "\n";
    if (($possible_values = $other_args['possible_values']) == null)
      $possible_values = array(); 
    foreach ($possible_values as $i => $possible_value) {
      $text .= '	<input type="radio" tabindex="' . $sfgTabIndex . '" name="' . $input_name . '" value="' . $possible_value . '"';
      if ($cur_value == $possible_value || (! $cur_value && ! $check_set)) {
        $text .= ' checked="checked"';
        $check_set = true;
      }
      $text .= " $disabled_text/> $possible_value\n";
    }
    // close span
    if ($is_mandatory)
      $text .= "	</span>";
    return array($text, null);
  }

  function checkboxHTML($cur_value, $input_name, $is_mandatory, $is_disabled, $other_args) {
    global $sfgTabIndex, $sfgFieldNum;

    $className = ($is_mandatory) ? "mandatoryField" : "createboxInput";
    if (array_key_exists('class', $other_args))
      $className .= " " . $other_args['class'];
    $info_id = "info_$sfgFieldNum";
    $disabled_text = ($is_disabled) ? "disabled" : "";

    // can show up here either as an array or a string, depending on
    // whether it came from user input or a wiki page
    if (is_array($cur_value)) {
      $checked_str = (array_key_exists('value', $cur_value) && $cur_value['value'] == 'on') ? ' checked="checked"' : "";
    } else {
      // default to false - no need to check if it matches a 'false' word
      $vlc = strtolower(trim($cur_value));
      if (in_array($vlc, explode(',', wfMsgForContent('smw_true_words')), TRUE)) {
        $checked_str = ' checked="checked"';
      } else {
        $checked_str = "";
      }
    }
    $text =<<<END
	<input name="{$input_name}[is_checkbox]" type="hidden" value="true" />
	<input id="input_$sfgFieldNum" name="{$input_name}[value]" type="checkbox" class="$className" tabindex="$sfgTabIndex" $checked_str $disabled_text/>
	<span id="$info_id" class="errorMessage"></span>

END;
    return array($text, null);
  }

}

?>
