<?php
/**
 * Three classes - SFForm, SFTemplateInForm, and SFFormTemplateField - that
 * represent the components of a user-defined form, and handle the creation
 * of a form definition file.
 *
 * @author Yaron Koren
 */

class SFForm {
  var $form_name;
  var $templates;

  function create($form_name, $templates) {
    $form = new SFForm();
    $form->form_name = ucfirst(str_replace('_', ' ', $form_name));
    $form->templates = $templates;
    return $form;
  }

  function creationHTML() {
    $text = "";
    foreach ($this->templates as $i => $ft) {
      $text .= $ft->creationHTML($i);
    }
    return $text;
  }

  function createMarkup() {
    $title = Title::makeTitle( SF_NS_FORM, $this->form_name );
    $ad = SpecialPage::getPage('AddPage');
    $add_data_url = sffTitleURLString($ad->getTitle()) . "/" . $title->getPartialURL();
    $form_description = wfMsgForContent('sf_form_docu', $this->form_name, $add_data_url);
    $form_input = "{{#forminput:" . $this->form_name . "}}\n";
    $text =<<<END
<noinclude>
$form_description

$form_input
</noinclude><includeonly>

END;
    foreach ($this->templates as $template) {
      $text .= $template->createMarkup() . "\n";
    }
    $free_text_label = wfMsgForContent('sf_form_freetextlabel');
    $text .=<<<END
'''$free_text_label:'''

{{{field|free text}}}


{{{standard input|summary}}}

{{{standard input|minor edit}}} {{{standard input|watch}}}

{{{standard input|save}}} {{{standard input|preview}}} {{{standard input|changes}}} {{{standard input|cancel}}}
</includeonly>

END;

    return $text;
  }

}

class SFTemplateInForm {
  var $template_name;
  var $label;
  var $allow_multiple;
  var $max_allowed;
  var $fields;

  function getAllFields() {
    $template_fields = array();
    $field_names_array = array();

    // Get the fields of the template, both semantic and otherwise, by parsing
    // the text of the template.
    // The way this works is that fields are found and then stored in an
    // array based on their location in the template text, so that they
    // can be returned in the order in which they appear in the template, even
    // though they were found in a different order.
    // Some fields can be found more than once (especially if they're part
    // of an "#if" statement, so they're only recorded the first time they're
    // found. Also, every field gets replaced with a string of x's after
    // being found, so it doesn't interfere with future parsing.
    $template_title = Title::newFromText($this->template_name, NS_TEMPLATE);
    $template_article = new Article($template_title);
    $template_text = $template_article->getContent();
    // ignore 'noinclude' sections and 'includeonly' tags
    $template_text = StringUtils::delimiterReplace('<noinclude>', '</noinclude>', '', $template_text);
    $template_text = strtr($template_text, array('<includeonly>' => '', '</includeonly>' => ''));

    // first, look for "arraymap" parser function calls that map a
    // relation or attribute onto a list
    if (preg_match_all('/{{#arraymap:{{{([^|}]*:?[^|}]*)[^\[]*\[\[([^:=]*:?[^:=]*)(:[:=])/mis', $template_text, $matches)) {
      // this is a two-dimensional array; we need the last three of the four
      // sub-arrays; we also have to remove redundant values
      foreach ($matches[1] as $i => $field_name) {
        $is_relation = false;
        $semantic_field_name = $matches[2][$i];
        $full_field_text = $matches[0][$i];
        if (! in_array($field_name, $field_names_array)) {
          $template_field = SFTemplateField::newWithValues($field_name, ucfirst($field_name));
          $template_field->setSemanticData($semantic_field_name, $is_relation, true);
          $cur_pos = stripos($template_text, $full_field_text);
          $template_fields[$cur_pos] = $template_field;
          $field_names_array[] = $field_name;
          $replacement = str_repeat("x", strlen($full_field_text));
          $template_text = str_replace($full_field_text, $replacement, $template_text);
        }
      }
    }

    // second, look for normal relation/attribute calls
    if (preg_match_all('/\[\[([^:=]*:*?[^:=]*)(:[:=]){{{([^\]\|}]*).*?\]\]/mis', $template_text, $matches)) {
      // this is a two-dimensional array; we need the last three of the four
      // sub-arrays; we also have to remove redundant values
      foreach ($matches[1] as $i => $semantic_field_name) {
        $is_relation = false;
        $field_name = $matches[3][$i];
        $full_field_text = $matches[0][$i];
        if (! in_array($field_name, $field_names_array)) {
          $template_field = SFTemplateField::newWithValues($field_name, ucfirst($field_name));
          $template_field->setSemanticData($semantic_field_name, $is_relation, false);
          $cur_pos = stripos($template_text, $full_field_text);
          $template_fields[$cur_pos] = $template_field;
          $field_names_array[] = $field_name;
          $replacement = str_repeat("x", strlen($full_field_text));
          $template_text = str_replace($full_field_text, $replacement, $template_text);
        }
      }
    }

    // finally, get any non-semantic fields defined
    if (preg_match_all('/{{{([^|}]*)/mis', $template_text, $matches)) {
      foreach ($matches[1] as $i => $field_name) {
        $full_field_text = $matches[0][$i];
        if (($full_field_text != '') && (! in_array($field_name, $field_names_array))) {
          $cur_pos = stripos($template_text, $full_field_text);
          $template_fields[$cur_pos] = SFTemplateField::newWithValues($field_name, ucfirst($field_name));
          $field_names_array[] = $field_name;
        }
      }
    }
    ksort($template_fields);
    return $template_fields;
  }

  function create($name, $label, $allow_multiple, $max_allowed = null) {
    $tif = new SFTemplateInForm();
    $tif->template_name = str_replace('_', ' ', $name);
    $tif->fields = array();
    $fields = $tif->getAllFields();
    $field_num = 0;
    foreach ($fields as $field) {
      $tif->fields[] = SFFormTemplateField::create($field_num++, $field);
    }
    $tif->label = $label;
    $tif->allow_multiple = $allow_multiple;
    $tif->max_allowed = $max_allowed;
    return $tif;
  }

  function creationHTML($template_num) {
    $checked_str = ($this->allow_multiple) ? "checked" : "";
    $template_str = wfMsg('sf_createform_template');
    $template_label_input = wfMsg('sf_createform_templatelabelinput');
    $allow_multiple_text = wfMsg('sf_createform_allowmultiple');
    $text =<<<END
	<input type="hidden" name="template_$template_num" value="$this->template_name">
	<div class="templateForm">
	<h2>$template_str '$this->template_name'</h2>
	<p>$template_label_input <input size=25 name="label_$template_num" value="$this->label"></p>
	<p><input type="checkbox" name="allow_multiple_$template_num" $checked_str> $allow_multiple_text</p>
	<hr>

END;
    foreach ($this->fields as $field) {
      $text .= $field->creationHTML($template_num);
    }
    $text .= '	<p><input type="submit" name="del_' . $template_num .
      '" value="' . wfMsg('sf_createform_removetemplate') . '"></p>' . "\n";
    $text .= "	</div>\n";
    return $text;
  }

  function createMarkup() {
    $text = "";
    $text .= "{{{for template|" . $this->template_name;
    if ($this->allow_multiple) 
      $text .= "|multiple";
    if ($this->label != '')
      $text .= "|label=" . $this->label;
    $text .= "}}}\n";
    // for now, HTML for templates differs for multiple-instance templates;
    // this may change if handling of form definitions gets more sophisticated
    if (! $this->allow_multiple) { $text .= "{| class=\"formtable\"\n"; }
    foreach ($this->fields as $i => $field) {
      $is_last_field = ($i == count($this->fields) - 1);
      $text .= $field->createMarkup($this->allow_multiple, $is_last_field);
    }
    if (! $this->allow_multiple) { $text .= "|}\n"; }
    $text .= "{{{end template}}}\n";
    return $text;
  }
}

/*
 * This class is distinct from SFTemplateField in that it represents a
 * template field defined in a form - it contains a SFTemplateField object
 * within it (the $template_field variable), along with the other properties
 * for that field that are set within the form
 */
class SFFormTemplateField {
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
  var $autocomplete_category;
  var $no_autocomplete;
  var $part_of_multiple;
  // somewhat of a hack - these two fields are for a field in a specific
  // representation of a form, not the form definition; ideally these
  // should be contained in a third 'field' class, called something like
  // SFFormInstanceField, that holds these fields plus an instance of
  // SFFormTemplateField. Too much work?
  var $input_name;
  var $is_disabled;

  function create($num, $template_field) {
    $f = new SFFormTemplateField();
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

  function createFromDefinition($field_name, $input_name, $is_mandatory, $is_hidden, $is_uploadable, $possible_values, $is_disabled, $is_list, $input_type, $field_args, $all_fields, $strict_parsing) {
    // see if this field matches one of the fields defined for this template -
    // if it is, use all available information about that field; if it's not,
    // either include it in the form or not, depending on whether the
    // template has a 'strict' setting in the form definition
    $the_field = null;
    foreach ($all_fields as $cur_field) {
      if ($field_name == $cur_field->field_name) {
        $the_field = $cur_field;
        break;
      }
    }
    if ($the_field == null) {
      if ($strict_parsing)
        return null;
      $the_field = new SFTemplateField();
    }

    // create an SFFormTemplateField object, containing this field as well
    // as settings from the form definition file
    $f = new SFFormTemplateField();
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

  function possibleInputTypes($semantic_field_type, $is_list) {
    // first, get the list of field types, to determine which one this is
    global $smwgContLang;
    $datatypeLabels =  $smwgContLang->getDatatypeLabels();
    $string_type = $datatypeLabels['_str'];
    $text_type = $datatypeLabels['_txt'];
    // type introduced in SMW 1.2
    if (array_key_exists('_cod', $datatypeLabels))
      $code_type = $datatypeLabels['_cod'];
    else
      $code_type = 'code';
    $url_type = $datatypeLabels['_uri'];
    $email_type = $datatypeLabels['_ema'];
    $float_type = $datatypeLabels['_num'];
    $int_type = $datatypeLabels['_num'];
    // some old versions of SMW 1.0 don't support Boolean types
    if (array_key_exists('_boo', $datatypeLabels))
      $bool_type = $datatypeLabels['_boo'];
    else
      $bool_type = 'boolean';
    $date_type = $datatypeLabels['_dat'];
    $enum_type = 'enumeration'; // not a real type in SMW 1.0
    $page_type = $datatypeLabels['_wpg'];

    // then, return the array of possible input types, depending on the
    // field type and whether this field will contain multiple values
    if ($semantic_field_type == $string_type ||
        $semantic_field_type == $float_type ||
        $semantic_field_type == $int_type ||
        $semantic_field_type == $url_type ||
        $semantic_field_type == $email_type) {
      if ($is_list) {
        return array('text', 'textarea');
      } else {
        return array('text');
      }
    } elseif ($semantic_field_type == $text_type || $semantic_field_type == $code_type) {
      return array('textarea');
    } elseif ($semantic_field_type == $bool_type) {
      return array('checkbox');
    } elseif ($semantic_field_type == $date_type) {
      return array('date', 'datetime', 'datetime with timezone');
    } elseif ($semantic_field_type == $enum_type) {
      if ($is_list) {
        return array('checkboxes', 'listbox');
      } else {
        return array('dropdown', 'radiobutton');
      }
    } elseif ($semantic_field_type == $page_type) {
      if ($is_list) {
        return array('text', 'textarea');
      } else {
        return array('text');
      }
    } else { // blank or an unknown type
      return array('text', 'textarea', 'checkbox', 'date', 'datetime', 'datetime with timezone');
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
    $prop_link_text = sffLinkText(SMW_NS_PROPERTY, $template_field->semantic_field);
    // TODO - remove this probably-unnecessary check?
    if ($template_field->semantic_field == "") {
      // print nothing if there's no semantic field
    } elseif ($template_field->field_type == "")
      $text .= '<p>' . wfMsg('sf_createform_fieldpropunknowntype', $prop_link_text) . "</p>\n";
    elseif ($template_field->is_list)
      $text .= '<p>' . wfMsg('sf_createform_fieldproplist', $prop_link_text,
        sffLinkText(SMW_NS_TYPE, $template_field->field_type)) . "</p>\n";
    else
      $text .= '<p>' . wfMsg('sf_createform_fieldprop', $prop_link_text,
        sffLinkText(SMW_NS_TYPE, $template_field->field_type)) . "</p>\n";
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
    if ($this->template_field->input_type != '') {
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
}

?>
