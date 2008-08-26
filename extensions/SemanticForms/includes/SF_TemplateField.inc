<?php
/**
 * Defines a class, SFTemplateField, that represents a field in a template,
 * including any possible semantic aspects it may have. Used in both creating
 * templates and displaying user-created forms
 *
 * @author Yaron Koren
 */

class SFTemplateField {
	var $field_name;
	var $label;
	var $semantic_field;
	var $semantic_field_call;
	var $is_relation;
	var $field_type;
	var $possible_values;
	var $is_list;

	function newWithValues($name, $label) {
		$f = new SFTemplateField();
		$f->field_name = str_replace('\\', '', $name);
		$f->label = str_replace('\\', '', $label);
		return $f;
	}

	function setTypeAndPossibleValues() {
		$proptitle = Title::newFromText($this->semantic_field, SMW_NS_PROPERTY);
		if ($proptitle === NULL)
			return;
		$store = smwfGetStore();
		$types = $store->getSpecialValues($proptitle, SMW_SP_HAS_TYPE);
		// TODO - need handling for the case of more than one type
		if (count($types) > 0)
			$this->field_type = $types[0]->getWikiValue();

		// this returns an array of objects
		$SMW_values = smwfGetStore()->getSpecialValues($proptitle, SMW_SP_POSSIBLE_VALUE);
		foreach ($SMW_values as $value) {
			$this->possible_values[] = $value->getXSDValue();
		}
		// HACK - if there were any possible values, set the field
		// type to be 'enumeration', regardless of what the actual type is
		if (count($this->possible_values) > 0) {
			$this->field_type = 'enumeration';
		}
	}

	// setSemanticData() - called when template is parsed during the creation
	// of a form
	function setSemanticData($semantic_field, $is_relation, $is_list) {
		$this->semantic_field = str_replace('\\', '', $semantic_field);
		$this->is_relation = $is_relation;
		$this->possible_values = array();
		$this->is_list = $is_list;
		// set field type and possible values, if any
		$this->setTypeAndPossibleValues();
	}
}

function createTemplateText($template_name, $template_fields, $category, $aggregating_property, $aggregating_label, $template_format) {
  $text = "<noinclude>\n";
  $text .= wfMsgForContent('sf_template_docu', $template_name) . "\n";
  $text .= "<pre>\n";
  $text .= "{{" . $template_name . "\n";
  foreach ($template_fields as $field) {
    $text .= "|" . $field->field_name . "=\n";
  }
  $text .= "}}\n";
  $text .= "</pre>\n";
  $text .= wfMsgForContent('sf_template_docufooter') . "\n";
  $text .=<<<END
</noinclude><includeonly>

END;
  // topmost part depends on format
  if ($template_format == 'infobox') {
    // CSS style can't be used, unfortunately, since most MediaWiki setups
    // don't have an 'infobox' or comparable CSS class
    $text .=<<<END
{| style="width: 30em; font-size: 90%; border: 1px solid #aaaaaa; background-color: #f9f9f9; color: black; margin-bottom: 0.5em; margin-left: 1em; padding: 0.2em; float: right; clear: right; text-align:left;"
! style="text-align: center; background-color:#ccccff;" colspan="2" |<big>{{PAGENAME}}</big>
|-

END;
  } else {
    $text .= '{| border="0" cellpadding="4" cellspacing="4"' . "\n";
  }

  foreach ($template_fields as $i => $field) {
    if ($i > 0) {
      $text .= "|-\n";
    }
    $text .= "! " . $field->label . "\n";
    if ($field->semantic_field_call == null || $field->semantic_field_call == '') {
      $text .= "| {{{" . $field->field_name . "|}}}\n";
    // if this field is meant to contain a list, add on an 'arraymap' function,
    // that will call this semantic markup tag on every element in the list
    } elseif ($field->is_list) {
      // find a string that's not in the semantic field call, to be used as
      // the variable
      $var = "x"; // default - use this even if all the attempts fail
      if (strstr($field->semantic_field_call, $var)) {
        $var_options = array('y', 'z', 'xx', 'yy', 'zz', 'aa', 'bb', 'cc');
        foreach ($var_options as $option) {
          if (! strstr($field->semantic_field_call, $option)) {
            $var = $option;
            break;
          }
        }
      }
      $text .= "| {{#arraymap:{{{" . $field->field_name . "|}}}|,|$var|[[" . $field->semantic_field_call . "$var]]}}\n";
    } else {
      $text .= "| [[" . $field->semantic_field_call . "{{{" . $field->field_name . "|}}}]]\n";
    }
  }

  // add a row with an inline query to this table, for aggregation, if
  // a property was specified
  if ($aggregating_property != '') {
    if (count($template_fields) > 0) {
      $text .= "|-\n";
    }
    $text .=<<<END
! $aggregating_label
| 
END;
    // make the actual inline query an #ask function, if that's supported
    // by this version of SMW; otherwise use the old <ask> tag
    // HACK - to find this out, create a new parser and call SMW's 'register'
    // function on it
    $parser = new Parser();
    $dummy_text = "";
    $dummy_state = null;
    smwfRegisterInlineQueries($parser, $dummy_text, $dummy_state);
    if (in_array("ask", $parser->getFunctionHooks())) {
      $text .= "{{#ask:format=\"list\"|[[$aggregating_property{{SUBJECTPAGENAME}}]]}}\n";
    } else {
      $text .= "<ask format=\"list\">[[$aggregating_property{{SUBJECTPAGENAME}}]]</ask>\n";
    }
  }
  $text .= "|}\n";
  if ($category != '') {
    global $wgContLang;
    $namespace_labels = $wgContLang->getNamespaces();
    $category_namespace = $namespace_labels[NS_CATEGORY];
    $text .= "\n[[$category_namespace:$category]]\n";

  }
  $text .= "</includeonly>\n";

  return $text;
}

?>
