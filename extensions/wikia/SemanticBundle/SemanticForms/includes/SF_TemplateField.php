<?php
/**
 * Defines a class, SFTemplateField, that represents a field in a template,
 * including any possible semantic aspects it may have. Used in both creating
 * templates and displaying user-created forms.
 *
 * @author Yaron Koren
 * @file
 * @ingroup SF
 */

class SFTemplateField {
	private $mFieldName;
	private $mValueLabels;
	private $mLabel;
	private $mSemanticProperty;
	private $mPropertyType;
	private $mPossibleValues;
	private $mIsList;
	private $mDelimiter;
	private $mInputType;

	static function create( $name, $label, $semanticProperty = null, $isList = null, $delimiter = null ) {
		$f = new SFTemplateField();
		$f->mFieldName = trim( str_replace( '\\', '', $name ) );
		$f->mLabel = trim( str_replace( '\\', '', $label ) );
		$f->setSemanticProperty( $semanticProperty );
		$f->mIsList = $isList;
		$f->mDelimiter = $delimiter;
		// Delimiter should default to ','.
		if ( !empty( $isList ) && empty( $delimiter ) ) {
			$f->mDelimiter = ',';
		}
		return $f;
	}

	/**
	 * Create an SFTemplateField object based on the corresponding field
	 * in the template definition (which we first have to find)
	 */
	static function createFromList( $field_name, $all_fields, $strict_parsing ) {
		// See if this field matches one of the fields defined for
		// the template it's part of - if it is, use all available
		// information about that field; if it's not, either create
		// an object for it or not, depending on whether the
		// template has a 'strict' setting in the form definition.
		$the_field = null;
		foreach ( $all_fields as $cur_field ) {
			if ( $field_name == $cur_field->mFieldName ) {
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
		$proptitle = Title::makeTitleSafe( SMW_NS_PROPERTY, $this->mSemanticProperty );
		if ( $proptitle === null ) {
			return;
		}

		$store = smwfGetStore();
		// this returns an array of objects
		$allowed_values = SFUtils::getSMWPropertyValues( $store, $proptitle, "Allows value" );
		$label_formats = SFUtils::getSMWPropertyValues( $store, $proptitle, "Has field label format" );
		if ( class_exists( 'SMWDIProperty' ) ) {
			// SMW 1.6+
			$propValue = SMWDIProperty::newFromUserLabel( $this->mSemanticProperty );
			$this->mPropertyType = $propValue->findPropertyTypeID();
		} else {
			$propValue = SMWPropertyValue::makeUserProperty( $this->mSemanticProperty );
			$this->mPropertyType = $propValue->getPropertyTypeID();
		}

		foreach ( $allowed_values as $allowed_value ) {
			// HTML-unencode each value
			$this->mPossibleValues[] = html_entity_decode( $allowed_value );
			if ( count( $label_formats ) > 0 ) {
				$label_format = $label_formats[0];
				$prop_instance = SMWDataValueFactory::findTypeID( $this->mPropertyType );
				$label_value = SMWDataValueFactory::newTypeIDValue( $prop_instance, $wiki_value );
				$label_value->setOutputFormat( $label_format );
				$this->mValueLabels[$wiki_value] = html_entity_decode( $label_value->getWikiValue() );
			}
		}

		// HACK - if there were any possible values, set the property
		// type to be 'enumeration', regardless of what the actual type is
		if ( count( $this->mPossibleValues ) > 0 ) {
			$this->mPropertyType = 'enumeration';
		}
	}

	/**
	 * Called if a matching property is found for a template field when
	 * a template is parsed during the creation of a form.
	 */
	function setSemanticProperty( $semantic_property ) {
		$this->mSemanticProperty = str_replace( '\\', '', $semantic_property );
		$this->mPossibleValues = array();
		// set field type and possible values, if any
		$this->setTypeAndPossibleValues();
	}

	function getFieldName() {
		return $this->mFieldName;
	}

	function getValueLabels() {
		return $this->mValueLabels;
	}

	function getLabel() {
		return $this->mLabel;
	}

	function getSemanticProperty() {
		return $this->mSemanticProperty;
	}

	function getPropertyType() {
		return $this->mPropertyType;
	}

	function getPossibleValues() {
		return $this->mPossibleValues;
	}

	function isList() {
		return $this->mIsList;
	}

	function getInputType() {
		return $this->mInputType;
	}

	function setTemplateField( $templateField ) {
		$this->mTemplateField = $templateField;
	}

	function setLabel( $label ) {
		$this->mLabel = $label;
	}

	function setInputType( $inputType ) {
		$this->mInputType = $inputType;
	}

	/**
	 * Creates the text of a template, when called from either
	 * Special:CreateTemplate or Special:CreateClass.
	 *
	 * @TODO: There's really no good reason why this method is contained
	 * within this class.
	 */
	public static function createTemplateText( $template_name, $template_fields, $internal_obj_property, $category, $aggregating_property, $aggregating_label, $template_format ) {
		$template_header = wfMsgForContent( 'sf_template_docu', $template_name );
		$text = <<<END
<noinclude>
$template_header
<pre>

END;
		$text .= '{{' . $template_name;
		if ( count( $template_fields ) > 0 ) { $text .= "\n"; }
		foreach ( $template_fields as $field ) {
			$text .= "|" . $field->mFieldName . "=\n";
		}
		$template_footer = wfMsgForContent( 'sf_template_docufooter' );
		$text .= <<<END
}}
</pre>
$template_footer
</noinclude><includeonly>

END;
		// Only add a call to #set_internal if the Semantic Internal
		// Objects extension is also installed.
		if ( !empty( $internal_obj_property) && class_exists( 'SIOInternalObject' ) ) {
			$setInternalText = '{{#set_internal:' . $internal_obj_property;
		} else {
			$setInternalText = null;
		}

 		// Topmost part of table depends on format.
		if ( $template_format == 'infobox' ) {
			// A CSS style can't be used, unfortunately, since most
			// MediaWiki setups don't have an 'infobox' or
			// comparable CSS class.
			$tableText = <<<END
{| style="width: 30em; font-size: 90%; border: 1px solid #aaaaaa; background-color: #f9f9f9; color: black; margin-bottom: 0.5em; margin-left: 1em; padding: 0.2em; float: right; clear: right; text-align:left;"
! style="text-align: center; background-color:#ccccff;" colspan="2" |<big>{{PAGENAME}}</big>
|-

END;
		} else {
			$tableText = '{| class="wikitable"' . "\n";
		}

		foreach ( $template_fields as $i => $field ) {
			if ( $i > 0 ) {
				$tableText .= "|-\n";
			}
			$tableText .= "! " . $field->mLabel . "\n";
			if ( empty( $field->mSemanticProperty ) ) {
				$tableText .= "| {{{" . $field->mFieldName . "|}}}\n";
				// if this field is meant to contain a list,
				// add on an 'arraymap' function, that will
				// call this semantic markup tag on every
				// element in the list
			} elseif ( !is_null( $setInternalText ) ) {
				if ( $field->mIsList ) {
					$setInternalText .= '|' . $field->mSemanticProperty . '#list={{{' . $field->mFieldName . '|}}}';
				} else {
					$setInternalText .= '|' . $field->mSemanticProperty . '={{{' . $field->mFieldName . '|}}}';
				}
			} elseif ( $field->mIsList ) {
				// find a string that's not in the semantic
				// field call, to be used as the variable
				$var = "x"; // default - use this if all the attempts fail
				if ( strstr( $field->mSemanticProperty, $var ) ) {
					$var_options = array( 'y', 'z', 'xx', 'yy', 'zz', 'aa', 'bb', 'cc' );
					foreach ( $var_options as $option ) {
						if ( ! strstr( $field->mSemanticProperty, $option ) ) {
							$var = $option;
							break;
						}
					}
				}
				$tableText .= "| {{#arraymap:{{{" . $field->mFieldName . "|}}}|" . $field->mDelimiter . "|$var|[[" . $field->mSemanticProperty . "::$var]]}}\n";
			} else {
				$tableText .= "| [[" . $field->mSemanticProperty . "::{{{" . $field->mFieldName . "|}}}]]\n";
			}
		}

		// Add a row with an inline query to this table, for
		// aggregation, if a property was specified.
		if ( $aggregating_property != '' ) {
			if ( count( $template_fields ) > 0 ) {
				$tableText .= "|-\n";
			}
			$tableText .= <<<END
! $aggregating_label
| {{#ask:[[$aggregating_property::{{SUBJECTPAGENAME}}]]|format=list}}

END;
		}
		$tableText .= "|}\n";
		if ( !is_null( $setInternalText ) ) {
			$setInternalText .= "}}\n";
			$text .= $setInternalText;
		}

		$text .= $tableText;
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
