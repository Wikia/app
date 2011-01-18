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
	var $value_labels;
	var $label;
	var $semantic_property;
	var $field_type;
	var $possible_values;
	var $is_list;
	var $input_type;

	static function create( $name, $label ) {
		$f = new SFTemplateField();
		$f->field_name = trim( str_replace( '\\', '', $name ) );
		$f->label = trim( str_replace( '\\', '', $label ) );
		return $f;
	}

	/**
	 * Create an SFTemplateField object based on the corresponding field
	 * in the template definition (which we first have to find)
	 */
	static function createFromList( $field_name, $all_fields, $strict_parsing ) {
		// see if this field matches one of the fields defined for
		// the template it's part of - if it is, use all available
		// information about that field; if it's not, either create
		// an object for it or not, depending on whether the
		// template has a 'strict' setting in the form definition
		$the_field = null;
		foreach ( $all_fields as $cur_field ) {
			if ( $field_name == $cur_field->field_name ) {
				$the_field = $cur_field;
				break;
			}
		}
		if ( $the_field == null ) {
			if ( $strict_parsing ) {
				return null;
			}
			$the_field = new SFTemplateField();
		}
		return $the_field;
	}

	function setTypeAndPossibleValues() {
		$proptitle = Title::makeTitleSafe( SMW_NS_PROPERTY, $this->semantic_property );
		if ( $proptitle === NULL )
			return;
		$store = smwfGetStore();
		$types = $store->getPropertyValues( $proptitle, SMWPropertyValue::makeUserProperty( "Has type" ) );
		// this returns an array of objects
		$allowed_values = $store->getPropertyValues( $proptitle, SMWPropertyValue::makeUserProperty( "Allows value" ) );
		$label_formats = $store->getPropertyValues( $proptitle, SMWPropertyValue::makeUserProperty( "Has field label format" ) );
		// TODO - need handling for the case of more than one type
		if ( count( $types ) > 0 )
			$this->field_type = $types[0]->getWikiValue();

		foreach ( $allowed_values as $value ) {
			// HTML-unencode each value
			$wiki_value = html_entity_decode( $value->getWikiValue() );
			$this->possible_values[] = $wiki_value;
			if ( count( $label_formats ) > 0 ) {
				$label_format = $label_formats[0]->getWikiValue();
				$prop_instance = SMWDataValueFactory::findTypeID( $this->field_type );
				$label_value = SMWDataValueFactory::newTypeIDValue( $prop_instance, $wiki_value );
				$label_value->setOutputFormat( $label_format );
				$this->value_labels[$wiki_value] = html_entity_decode( $label_value->getWikiValue() );
			}
		}

		// HACK - if there were any possible values, set the field
		// type to be 'enumeration', regardless of what the actual type is
		if ( count( $this->possible_values ) > 0 ) {
			$this->field_type = 'enumeration';
		}
	}

	/**
	 * Called when template is parsed during the creation of a form
	 */
	function setSemanticProperty( $semantic_property ) {
		$this->semantic_property = str_replace( '\\', '', $semantic_property );
		$this->possible_values = array();
		// set field type and possible values, if any
		$this->setTypeAndPossibleValues();
	}

	/**
	 * Returns whether the semantic property represented by this field
	 * has the passed-in type constant (e.g., '_str', '_wpg')
	 */
	function propertyIsOfType( $type_constant ) {
                global $smwgContLang;
                $datatypeLabels =  $smwgContLang->getDatatypeLabels();
                $page_type = $datatypeLabels[$type_constant];
		return ( $this->field_type == $page_type );
	}

	function createTemplateText( $template_name, $template_fields, $category, $aggregating_property, $aggregating_label, $template_format ) {
		$template_header = wfMsgForContent( 'sf_template_docu', $template_name );
		$text = <<<END
<noinclude>
$template_header
<pre>

END;
		$text .= '{{' . $template_name;
		if ( count( $template_fields ) > 0 ) { $text .= "\n"; }
		foreach ( $template_fields as $field ) {
			$text .= "|" . $field->field_name . "=\n";
		}
		$template_footer = wfMsgForContent( 'sf_template_docufooter' );
		$text .= <<<END
}}
</pre>
$template_footer
</noinclude><includeonly>

END;
  		// topmost part depends on format
		if ( $template_format == 'infobox' ) {
			// CSS style can't be used, unfortunately, since most MediaWiki
			// setups don't have an 'infobox' or comparable CSS class
			$text .= <<<END
{| style="width: 30em; font-size: 90%; border: 1px solid #aaaaaa; background-color: #f9f9f9; color: black; margin-bottom: 0.5em; margin-left: 1em; padding: 0.2em; float: right; clear: right; text-align:left;"
! style="text-align: center; background-color:#ccccff;" colspan="2" |<big>{{PAGENAME}}</big>
|-

END;
		} else {
			$text .= '{| class="wikitable"' . "\n";
		}

		foreach ( $template_fields as $i => $field ) {
			if ( $i > 0 ) {
				$text .= "|-\n";
			}
			$text .= "! " . $field->label . "\n";
			if ( $field->semantic_property == null || $field->semantic_property == '' ) {
				$text .= "| {{{" . $field->field_name . "|}}}\n";
				// if this field is meant to contain a list,
				// add on an 'arraymap' function, that will
				// call this semantic markup tag on every
				// element in the list
			} elseif ( $field->is_list ) {
				// find a string that's not in the semantic
				// field call, to be used as the variable
				$var = "x"; // default - use this if all the attempts fail
				if ( strstr( $field->semantic_property, $var ) ) {
					$var_options = array( 'y', 'z', 'xx', 'yy', 'zz', 'aa', 'bb', 'cc' );
					foreach ( $var_options as $option ) {
						if ( ! strstr( $field->semantic_property, $option ) ) {
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
		if ( $aggregating_property != '' ) {
			if ( count( $template_fields ) > 0 ) {
				$text .= "|-\n";
			}
			$text .= <<<END
! $aggregating_label
| {{#ask:[[$aggregating_property::{{SUBJECTPAGENAME}}]]|format=list}}

END;
		}
		$text .= "|}\n";
		if ( $category != '' ) {
			global $wgContLang;
			$namespace_labels = $wgContLang->getNamespaces();
			$category_namespace = $namespace_labels[NS_CATEGORY];
			$text .= "\n[[$category_namespace:$category]]\n";
		}
		$text .= "</includeonly>\n";

		return $text;
	}
}
