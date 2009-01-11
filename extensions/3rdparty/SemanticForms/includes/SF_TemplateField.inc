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
	var $semantic_property;
	var $is_relation;
	var $field_type;
	var $possible_values;
	var $is_list;

	static function newWithValues($name, $label) {
		$f = new SFTemplateField();
		$f->field_name = trim(str_replace('\\', '', $name));
		$f->label = trim(str_replace('\\', '', $label));
		return $f;
	}

	function setTypeAndPossibleValues() {
		$proptitle = Title::newFromText($this->semantic_field, SMW_NS_PROPERTY);
		if ($proptitle === NULL)
			return;
		$store = smwfGetStore();
		if (class_exists('SMWPropertyValue')) {
			$types = $store->getPropertyValues($proptitle, SMWPropertyValue::makeUserProperty("Has type"));
			// this returns an array of objects
			$allowed_values = $store->getPropertyValues($proptitle, SMWPropertyValue::makeUserProperty("Allows value"));
		} else {
			$types = $store->getSpecialValues($proptitle, SMW_SP_HAS_TYPE);
			// this returns an array of objects
			$allowed_values = $store->getSpecialValues($proptitle, SMW_SP_POSSIBLE_VALUE);
		}
		// TODO - need handling for the case of more than one type
		if (count($types) > 0)
			$this->field_type = $types[0]->getWikiValue();

		foreach ($allowed_values as $value) {
			// HTML-unencode each value
			$this->possible_values[] = html_entity_decode($value->getXSDValue());
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

	function createTemplateText($template_name, $template_fields, $category, $aggregating_property, $aggregating_label, $template_format) {
		$text = "<noinclude>\n";
		$text .= wfMsgForContent('sf_template_docu', $template_name) . "\n";
		$text .= "<pre>\n";
		$text .= "{{" . $template_name;
		if (count($template_fields) > 0) { $text .= "\n"; }
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
			// CSS style can't be used, unfortunately, since most MediaWiki
			// setups don't have an 'infobox' or comparable CSS class
			$text .=<<<END
{| style="width: 30em; font-size: 90%; border: 1px solid #aaaaaa; background-color: #f9f9f9; color: black; margin-bottom: 0.5em; margin-left: 1em; padding: 0.2em; float: right; clear: right; text-align:left;"
! style="text-align: center; background-color:#ccccff;" colspan="2" |<big>{{PAGENAME}}</big>
|-

END;
		} else {
			$text .= '{| class="wikitable"' . "\n";
		}

		foreach ($template_fields as $i => $field) {
			if ($i > 0) {
				$text .= "|-\n";
			}
			$text .= "! " . $field->label . "\n";
			if ($field->semantic_property == null || $field->semantic_property == '') {
				$text .= "| {{{" . $field->field_name . "|}}}\n";
				// if this field is meant to contain a list,
				// add on an 'arraymap' function, that will
				// call this semantic markup tag on every
				// element in the list
			} elseif ($field->is_list) {
				// find a string that's not in the semantic
				// field call, to be used as the variable
				$var = "x"; // default - use this if all the attempts fail
				if (strstr($field->semantic_property, $var)) {
					$var_options = array('y', 'z', 'xx', 'yy', 'zz', 'aa', 'bb', 'cc');
					foreach ($var_options as $option) {
						if (! strstr($field->semantic_property, $option)) {
							$var = $option;
							break;
						}
					}
				}
				$text .= "| {{#arraymap:{{{" . $field->field_name . "|}}}|,|$var|[[" . $field->semantic_property . "::$var]]}}\n";
			} else {
				$text .= "| [[" . $field->semantic_property . "::{{{" . $field->field_name . "|}}}]]\n";
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
| {{#ask:[[$aggregating_property::{{SUBJECTPAGENAME}}]]|format=list}}

END;
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
}
