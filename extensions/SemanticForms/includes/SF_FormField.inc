<?php
/*
 * This class is distinct from SFTemplateField in that it represents a
 * template field defined in a form - it contains a SFTemplateField object
 * within it (the $template_field variable), along with the other properties
 * for that field that are set within the form
 */
class SFFormField {
	var $num;
	var $template_field;
	var $input_type;
	var $is_mandatory;
	var $is_hidden;
	var $is_restricted;
	var $possible_values;
	// the following fields are not set by the form-creation page
	// (though they could be)
	var $is_uploadable;
	var $field_args;
	var $autocomplete_source;
	var $autocomplete_field_type;
	var $no_autocomplete;
	var $part_of_multiple;
	// somewhat of a hack - these two fields are for a field in a specific
	// representation of a form, not the form definition; ideally these
	// should be contained in a third 'field' class, called something like
	// SFFormInstanceField, that holds these fields plus an instance of
	// SFFormField. Too much work?
	var $input_name;
	var $is_disabled;

	static function create($num, $template_field) {
		$f = new SFFormField();
		$f->num = $num;
		$f->template_field = $template_field;
		$f->input_type = "";
		$f->is_mandatory = false;
		$f->is_hidden = false;
		$f->is_restricted = false;
		$f->is_uploadable = false;
		$f->possible_values = null;
		return $f;
	}

	static function createFromDefinition($field_name, $input_name, $is_mandatory, $is_hidden, $is_uploadable, $possible_values, $is_disabled, $is_list, $input_type, $field_args, $all_fields, $strict_parsing) {
		// see if this field matches one of the fields defined for this
		// template - if it is, use all available information about
		// that field; if it's not, either include it in the form or
		// not, depending on whether the template has a 'strict'
		// setting in the form definition
		$the_field = null;
		foreach ($all_fields as $cur_field) {
			if ($field_name == $cur_field->field_name) {
				$the_field = $cur_field;
				break;
			}
		}
		if ($the_field == null) {
			if ($strict_parsing) {
				$dummy_ff = new SFFormField();
				$dummy_ff->template_field = new SFTemplateField();
				$dummy_ff->is_list = false;
				$dummy_ff->field_args = array();
				return $dummy_ff;
			}
			$the_field = new SFTemplateField();
		}

		// create an SFFormField object, containing this field as well
		// as settings from the form definition file
		$f = new SFFormField();
		$f->template_field = $the_field;
		$f->is_mandatory = $is_mandatory;
		$f->is_hidden = $is_hidden;
		$f->is_uploadable = $is_uploadable;
		$f->possible_values = $possible_values;
		$f->input_type = $input_type;
		$f->field_args = $field_args;
		$f->input_name = $input_name;
		$f->is_disabled = $is_disabled;
		$f->is_list = $is_list;
		return $f;
	}

	/**
	 * Get the set of possible form input types for either a specific
	 * SMW property type or a list of such types
	 */
	function possibleInputTypes($semantic_type, $is_list) {
		// first, get the list of field types, to determine which one this is
		global $smwgContLang;
		$datatypeLabels =  $smwgContLang->getDatatypeLabels();
		$string_type = $datatypeLabels['_str'];
		$text_type = $datatypeLabels['_txt'];
		// type introduced in SMW 1.2
		$code_type = array_key_exists('_cod', $datatypeLabels) ? $datatypeLabels['_cod'] : 'code';
		$url_type = $datatypeLabels['_uri'];
		$email_type = $datatypeLabels['_ema'];
		$number_type = $datatypeLabels['_num'];
		$bool_type = $datatypeLabels['_boo'];
		$date_type = $datatypeLabels['_dat'];
		$enum_type = 'enumeration'; // not a real type
		$page_type = $datatypeLabels['_wpg'];

		// then, return the array of possible input types, depending on
		// the field type and whether this field will contain multiple
		// values
		if ($semantic_type == $string_type ||
			$semantic_type == $number_type ||
			$semantic_type == $url_type ||
			$semantic_type == $email_type) {
			if ($is_list) {
				return array('text', 'textarea', 'categories');
			} else {
				return array('text', 'category');
			}
		} elseif ($semantic_type == $text_type || $semantic_type == $code_type) {
			return array('textarea');
		} elseif ($semantic_type == $bool_type) {
			return array('checkbox');
		} elseif ($semantic_type == $date_type) {
			return array('date', 'datetime', 'datetime with timezone', 'year');
		} elseif ($semantic_type == $enum_type) {
			if ($is_list) {
				return array('checkboxes', 'listbox');
			} else {
				return array('dropdown', 'radiobutton');
			}
		} elseif ($semantic_type == $page_type) {
			if ($is_list) {
				return array('text', 'textarea');
			} else {
				return array('text');
			}
		} else { // blank or an unknown type
			return array('text', 'textarea', 'checkbox', 'date', 'datetime', 'datetime with timezone', 'category', 'categories');
		}
	}

	function inputTypeDropdownHTML($dropdown_name, $possible_input_types, $cur_input_type) {
		// create the dropdown HTML for a list of possible input types
		$text = "	<select name=\"$dropdown_name\">\n";
		foreach ($possible_input_types as $i => $input_type) {
			if ($i == 0) {
				$text .= "	<option value=\"\">$input_type " .
				wfMsg('sf_createform_inputtypedefault') . "</option>\n";
			} else {
				$selected_str = ($cur_input_type == $input_type) ? "selected" : "";
				$text .= "	<option value=\"$input_type\" $selected_str>$input_type</option>\n";
			}
		}
		$text .= "	</select>\n";
		return $text;
	}

	function creationHTML($template_num) {
		$field_form_text = $template_num . "_" . $this->num;
		$template_field = $this->template_field;
		$text = '<h3>' . wfMsg('sf_createform_field') . " '" . $template_field->field_name . "'</h3>\n";
		$prop_link_text = SFUtils::linkText(SMW_NS_PROPERTY, $template_field->semantic_property);
		// TODO - remove this probably-unnecessary check?
		if ($template_field->semantic_property == "") {
			// print nothing if there's no semantic field
		} elseif ($template_field->field_type == "") {
			$text .= '<p>' . wfMsg('sf_createform_fieldpropunknowntype', $prop_link_text) . "</p>\n";
		} elseif ($template_field->is_list) {
			$text .= '<p>' . wfMsg('sf_createform_fieldproplist', $prop_link_text,
				SFUtils::linkText(SMW_NS_TYPE, $template_field->field_type)) . "</p>\n";
		} else {
			$text .= '<p>' . wfMsg('sf_createform_fieldprop', $prop_link_text,
				SFUtils::linkText(SMW_NS_TYPE, $template_field->field_type)) . "</p>\n";
		}
		// if it's not a semantic field - don't add any text
		$form_label_text = wfMsg('sf_createform_formlabel');
		$field_label = $template_field->label;
		$input_type_text = wfMsg('sf_createform_inputtype');
		$text .=<<<END
	<p>$form_label_text <input type="text" name="label_$field_form_text" size=20 value="$field_label" />
	&nbsp; $input_type_text

END;
		$possible_input_types = $this->possibleInputTypes($template_field->field_type, $template_field->is_list);
		if (count($possible_input_types) > 1) {
			$text .= $this->inputTypeDropdownHTML("input_type_$field_form_text", $possible_input_types, $template_field->input_type);
		} else {
			$text .= $possible_input_types[0];
		}
		$mandatory_checked_str = ($this->is_mandatory) ? "checked" : "";
		$mandatory_text = wfMsg('sf_createform_mandatory');
		$hidden_checked_str = ($this->is_hidden) ? "checked" : "";
		$hidden_text = wfMsg('sf_createform_hidden');
		$restricted_checked_str = ($this->is_restricted) ? "checked" : "";
		$restricted_text = wfMsg('sf_createform_restricted');
		$text .=<<<END
	</p>
	<p>
	<input type="checkbox" name="mandatory_$field_form_text" value="mandatory" $mandatory_checked_str /> $mandatory_text
	<input type="checkbox" name="hidden_$field_form_text" value="hidden" $hidden_checked_str /> $hidden_text
	<input type="checkbox" name="restricted_$field_form_text" value="restricted" $restricted_checked_str /> $restricted_text</p>
	<hr>

END;
		return $text;
	}

	// for now, HTML of an individual field depends on whether or not it's
	// part of multiple-instance template; this may change if handling of
	// such templates in form definitions gets more sophisticated
	function createMarkup($part_of_multiple, $is_last_field_in_template) {
		$text = "";
		if ($this->template_field->label != "") {
			if ($part_of_multiple) {
				$text .= "'''" . $this->template_field->label .  ":''' ";
			} else {
				$text .= "! " . $this->template_field->label . ":\n";
			}
		}
		if (! $part_of_multiple) { $text .= "| "; }
		$text .= "{{{field|" . $this->template_field->field_name;
		if (isset($this->template_field->input_type) &&
			$this->template_field->input_type != null) {
			$text .= "|input type=" . $this->template_field->input_type;
		}
		if ($this->is_mandatory) {
			$text .= "|mandatory";
		} elseif ($this->is_hidden) {
			$text .= "|hidden";
		} elseif ($this->is_restricted) {
			$text .= "|restricted";
		}
		$text .= "}}}\n";
		if ($part_of_multiple) {
			$text .= "\n";
		} elseif (! $is_last_field_in_template) {
			$text .= "|-\n";
		}
		return $text;
	}

	/*
	 * Since Semantic Forms uses a hook system for the functions that
	 * create HTML inputs, most arguments are contained in the "$other_args"
	 * array - create this array, using the attributes of this form
	 * field and the template field it corresponds to, if any
	 */
	function getArgumentsForInputCall($default_args = null) {
		// start with the arguments array already defined
		$other_args = $this->field_args;
		// a value defined for the form field should always supersede
		// the coresponding value for the template field
		if ($this->possible_values != null)
			$other_args['possible_values'] = $this->possible_values;
		else {
			$other_args['possible_values'] = $this->template_field->possible_values;
			$other_args['value_labels'] = $this->template_field->value_labels;
		}
		$other_args['is_list'] = ($this->is_list || $this->template_field->is_list);
		if ($this->template_field->semantic_property != '' && ! array_key_exists('semantic_property', $other_args))
			$other_args['semantic_property'] = $this->template_field->semantic_property;
		// if autocompletion hasn't already been hardcoded in the form,
		// and it's a property of type page, or a property of another
		// type with 'autocomplete' specified, set the necessary
		// parameters
		if (! array_key_exists('autocompletion source', $other_args)) {
			if ($this->template_field->propertyIsOfType('_wpg')) {
				$other_args['autocompletion source'] = $this->template_field->semantic_property;
				$other_args['autocomplete field type'] = 'relation';
			} elseif (array_key_exists('autocomplete', $other_args) || array_key_exists('remote autocompletion', $other_args)) {
				$other_args['autocompletion source'] = $this->template_field->semantic_property;
				$other_args['autocomplete field type'] = 'attribute';
			}
		}
		// now merge in the default values set by SFFormPrinter, if
		// there were any - put the default values first, so that if
		// there's a conflict they'll be overridden
		if ($default_args != null)
			$other_args = array_merge($default_args, $other_args);
		return $other_args;
	}
}
