<?php
/**
 *
 * @file
 * @ingroup SF
 */

/**
 * This class is distinct from SFTemplateField in that it represents a template
 * field defined in a form definition - it contains an SFTemplateField object
 * within it (the $template_field variable), along with the other properties
 * for that field that are set within the form.
 * @ingroup SF
 */
class SFFormField {
	public $template_field;
	private $mInputType;
	private $mIsMandatory;
	private $mIsHidden;
	private $mIsRestricted;
	private $mPossibleValues;
	private $mIsList;
	// The following fields are not set by the form-creation page
	// (though they could be).
	private $mDefaultValue;
	private $mPreloadPage;
	private $mHoldsTemplate;
	private $mIsUploadable;
	private $mFieldArgs;
	private $mDescriptionArgs;
	private $mLabel;
	// somewhat of a hack - these two fields are for a field in a specific
	// representation of a form, not the form definition; ideally these
	// should be contained in a third 'field' class, called something like
	// SFFormInstanceField, which holds these fields plus an instance of
	// SFFormField. Too much work?
	private $mInputName;
	private $mIsDisabled;

	static function create( $template_field ) {
		$f = new SFFormField();
		$f->template_field = $template_field;
		$f->mInputType = null;
		$f->mIsMandatory = false;
		$f->mIsHidden = false;
		$f->mIsRestricted = false;
		$f->mIsUploadable = false;
		$f->mPossibleValues = null;
		$f->mFieldArgs = array();
		$f->mDescriptionArgs = array();
		return $f;
	}

	public function getTemplateField() {
		return $this->template_field;
	}

	public function setTemplateField( $templateField ) {
		$this->template_field = $templateField;
	}

	public function getInputType() {
		return $this->mInputType;
	}

	public function setInputType( $inputType ) {
		$this->mInputType = $inputType;
	}

	public function hasFieldArg( $key ) {
		return array_key_exists( $key, $this->mFieldArgs );
	}

	public function getFieldArgs() {
		return $this->mFieldArgs;
	}

	public function getFieldArg( $key ) {
		return $this->mFieldArgs[$key];
	}

	public function setFieldArg( $key, $value ) {
		$this->mFieldArgs[$key] = $value;
	}

	public function getDefaultValue() {
		return $this->mDefaultValue;
	}

	public function isMandatory() {
		return $this->mIsMandatory;
	}

	public function setIsMandatory( $isMandatory ) {
		$this->mIsMandatory = $isMandatory;
	}

	public function isHidden() {
		return $this->mIsHidden;
	}

	public function setIsHidden( $isHidden ) {
		$this->mIsHidden = $isHidden;
	}

	public function isRestricted() {
		return $this->mIsRestricted;
	}

	public function setIsRestricted( $isRestricted ) {
		$this->mIsRestricted = $isRestricted;
	}

	public function holdsTemplate() {
		return $this->mHoldsTemplate;
	}

	public function isList() {
		return $this->mIsList;
	}

	public function getPossibleValues() {
		if ( $this->mPossibleValues != null ) {
			return $this->mPossibleValues;
		} else {
			return $this->template_field->getPossibleValues();
		}
	}

	public function getInputName() {
		return $this->mInputName;
	}

	public function getLabel() {
		return $this->mLabel;
	}

	public function isDisabled() {
		return $this->mIsDisabled;
	}

	public function setDescriptionArg( $key, $value ) {
		$this->mDescriptionArgs[$key] = $value;
	}

	static function newFromFormFieldTag( $tag_components, $template, $template_in_form, $form_is_disabled ) {
		global $wgParser, $wgUser;

		$f = new SFFormField();
		$f->mFieldArgs = array();

		$field_name = trim( $tag_components[1] );
		$template_name = $template_in_form->getTemplateName();

		// See if this field matches one of the fields defined for this
		// template - if it does, use all available information about
		// that field; if it doesn't, either include it in the form or
		// not, depending on whether the template has a 'strict'
		// setting in the form definition.
		$template_field = $template->getFieldNamed( $field_name );

		if ( $template_field != null ) {
			$f->template_field = $template_field;
		} else {
			if ( $template_in_form->strictParsing() ) {
				$f->template_field = new SFTemplateField();
				$f->mIsList = false;
				return $f;
			}
			$f->template_field = SFTemplateField::create( $field_name, null );
		}

		$semantic_property = null;
		$cargo_table = $cargo_field = null;
		$show_on_select = array();
		$fullFieldName = $template_name . '[' . $field_name . ']';
		// Cycle through the other components.
		for ( $i = 2; $i < count( $tag_components ); $i++ ) {
			$component = trim( $tag_components[$i] );

			if ( $component == 'mandatory' ) {
				$f->mIsMandatory = true;
			} elseif ( $component == 'hidden' ) {
				$f->mIsHidden = true;
			} elseif ( $component == 'restricted' ) {
				$f->mIsRestricted = ( ! $wgUser || ! $wgUser->isAllowed( 'editrestrictedfields' ) );
			} elseif ( $component == 'list' ) {
				$f->mIsList = true;
			} elseif ( $component == 'unique' ) {
				$f->mFieldArgs['unique'] = true;
			} elseif ( $component == 'edittools' ) { // free text only
				$f->mFieldArgs['edittools'] = true;
			}

			$sub_components = array_map( 'trim', explode( '=', $component, 2 ) );

			if ( count( $sub_components ) == 1 ) {
				// add handling for single-value params, for custom input types
				$f->mFieldArgs[$sub_components[0]] = true;

				if ( $component == 'holds template' ) {
					$f->mIsHidden = true;
					$f->mHoldsTemplate = true;
				}
			} elseif ( count( $sub_components ) == 2 ) {
				// First, set each value as its own entry in $this->mFieldArgs.
				$f->mFieldArgs[$sub_components[0]] = $sub_components[1];

				// Then, do all special handling.
				if ( $sub_components[0] == 'input type' ) {
					$f->mInputType = $sub_components[1];
				} elseif ( $sub_components[0] == 'default' ) {
					// We call recursivePreprocess() here,
					// and not the more standard
					// recursiveTagParse(), so that
					// wikitext in the value, and bare URLs,
					// will not get turned into HTML.
					$f->mDefaultValue = $wgParser->recursivePreprocess( $sub_components[1] );
				} elseif ( $sub_components[0] == 'preload' ) {
					$f->mPreloadPage = $sub_components[1];
				} elseif ( $sub_components[0] == 'label' ) {
					$f->mLabel = $sub_components[1];
				} elseif ( $sub_components[0] == 'show on select' ) {
					// html_entity_decode() is needed to turn '&gt;' to '>'
					$vals = explode( ';', html_entity_decode( $sub_components[1] ) );
					foreach ( $vals as $val ) {
						$val = trim( $val );
						if ( empty( $val ) ) {
							continue;
						}
						$option_div_pair = explode( '=>', $val, 2 );
						if ( count( $option_div_pair ) > 1 ) {
							$option = $option_div_pair[0];
							$div_id = $option_div_pair[1];
							if ( array_key_exists( $div_id, $show_on_select ) ) {
								$show_on_select[$div_id][] = $option;
							} else {
								$show_on_select[$div_id] = array( $option );
							}
						} else {
							$show_on_select[$val] = array();
						}
					}
				} elseif ( $sub_components[0] == 'values' ) {
					// Handle this one only after
					// 'delimiter' has also been set.
					$values = $wgParser->recursiveTagParse( $sub_components[1] );
				} elseif ( $sub_components[0] == 'values from property' ) {
					$propertyName = $sub_components[1];
					$f->mPossibleValues = SFValuesUtils::getAllValuesForProperty( $propertyName );
				} elseif ( $sub_components[0] == 'values from query' ) {
					$pages = SFValuesUtils::getAllPagesForQuery( $sub_components[1] );
					foreach ( $pages as $page ) {
						$page_name_for_values = $page->getDbKey();
						$f->mPossibleValues[] = $page_name_for_values;
					}
				} elseif ( $sub_components[0] == 'values from category' ) {
					$category_name = ucfirst( $sub_components[1] );
					$f->mPossibleValues = SFValuesUtils::getAllPagesForCategory( $category_name, 10 );
				} elseif ( $sub_components[0] == 'values from concept' ) {
					$f->mPossibleValues = SFValuesUtils::getAllPagesForConcept( $sub_components[1] );
				} elseif ( $sub_components[0] == 'values from namespace' ) {
					$f->mPossibleValues = SFValuesUtils::getAllPagesForNamespace( $sub_components[1] );
				} elseif ( $sub_components[0] == 'values dependent on' ) {
					global $sfgDependentFields;
					$sfgDependentFields[] = array( $sub_components[1], $fullFieldName );
				} elseif ( $sub_components[0] == 'unique for category' ) {
					$f->mFieldArgs['unique'] = true;
					$f->mFieldArgs['unique_for_category'] = $sub_components[1];
				} elseif ( $sub_components[0] == 'unique for namespace' ) {
					$f->mFieldArgs['unique'] = true;
					$f->mFieldArgs['unique_for_namespace'] = $sub_components[1];
				} elseif ( $sub_components[0] == 'unique for concept' ) {
					$f->mFieldArgs['unique'] = true;
					$f->mFieldArgs['unique_for_concept'] = $sub_components[1];
				} elseif ( $sub_components[0] == 'property' ) {
					$semantic_property = $sub_components[1];
				} elseif ( $sub_components[0] == 'cargo table' ) {
					$cargo_table = $sub_components[1];
				} elseif ( $sub_components[0] == 'cargo field' ) {
					$cargo_field = $sub_components[1];
				} elseif ( $sub_components[0] == 'default filename' ) {
					global $wgTitle;
					$page_name = $wgTitle->getText();
					if ( $wgTitle->isSpecialPage() ) {
						// If it's of the form
						// Special:FormEdit/form/target,
						// get just the target.
						$pageNameComponents = explode( '/', $page_name, 3 );
						if ( count( $pageNameComponents ) == 3 ) {
							$page_name = $pageNameComponents[2];
						}
					}
					$default_filename = str_replace( '<page name>', $page_name, $sub_components[1] );
					// Parse value, so default filename can
					// include parser functions.
					$default_filename = $wgParser->recursiveTagParse( $default_filename );
					$f->mFieldArgs['default filename'] = $default_filename;
				} elseif ( $sub_components[0] == 'restricted' ) {
					$f->mIsRestricted = !array_intersect(
						$wgUser->getEffectiveGroups(), array_map( 'trim', explode( ',', $sub_components[1] ) )
					);
				}
			}
		} // end for


		if ( !array_key_exists( 'delimiter', $f->mFieldArgs ) ) {
			$f->mFieldArgs['delimiter'] = ",";
		}
		$delimiter = $f->mFieldArgs['delimiter'];

		// If the 'values' parameter was set, separate it based on the
		// 'delimiter' parameter, if any.
		if ( ! empty( $values ) ) {
			// Remove whitespaces, and un-escape characters
			$valuesArray = array_map( 'trim', explode( $delimiter, $values ) );
			$f->mPossibleValues = array_map( 'htmlspecialchars_decode', $valuesArray );
		}

		// If we're using Cargo, there's no equivalent for "values from
		// property" - instead, we just always get the values if a 
		// field and table have been specified.
		if ( is_null( $f->mPossibleValues ) && defined( 'CARGO_VERSION' ) && $cargo_table != null && $cargo_field != null ) {
			// We only want the non-null values. Ideally this could
			// be done by calling getValuesForCargoField() with
			// an "IS NOT NULL" clause, but unfortunately that fails
			// for array/list fields.
			// Instead of getting involved with all that, we'll just
			// remove the null/blank values afterward.
			$cargoValues = SFValuesUtils::getAllValuesForCargoField( $cargo_table, $cargo_field );
			$f->mPossibleValues = array_filter( $cargoValues, 'strlen' );
		}

		if ( !is_null( $f->mPossibleValues ) ) {
			if ( array_key_exists( 'mapping template', $f->mFieldArgs ) ) {
				$f->setValuesWithMappingTemplate();
			} elseif ( array_key_exists( 'mapping property', $f->mFieldArgs ) ) {
				$f->setValuesWithMappingProperty();
			} elseif ( array_key_exists( 'mapping cargo table', $f->mFieldArgs ) &&
				array_key_exists( 'mapping cargo field', $f->mFieldArgs ) ) {
				$f->setValuesWithMappingCargoField();
			}
		}
		if ( $template_in_form->allowsMultiple() ) {
			$f->mFieldArgs['part_of_multiple'] = true;
		}
		if ( count( $show_on_select ) > 0 ) {
			$f->mFieldArgs['show on select'] = $show_on_select;
		}

		// Disable this field if either the whole form is disabled, or
		// it's a restricted field and user doesn't have sysop privileges.
		$f->mIsDisabled = ( $form_is_disabled || $f->mIsRestricted );

		// Do some data storage specific to the Semantic MediaWiki and
		// Cargo extensions.
		if ( defined( 'SMW_VERSION' ) ) {
			// If a property was set in the form definition,
			// overwrite whatever is set in the template field -
			// this is somewhat of a hack, since parameters set in
			// the form definition are meant to go into the
			// SFFormField object, not the SFTemplateField object
			// it contains;
			// it seemed like too much work, though, to create an
			// SFFormField::setSemanticProperty() function just for
			// this call.
			if ( !is_null( $semantic_property ) ) {
				$f->template_field->setSemanticProperty( $semantic_property );
			} else {
				$semantic_property = $f->template_field->getSemanticProperty();
			}
			if ( !is_null( $semantic_property ) ) {
				global $sfgFieldProperties;
				$sfgFieldProperties[$fullFieldName] = $semantic_property;
			}
		}
		if ( defined( 'CARGO_VERSION' ) ) {
			if ( $cargo_table != null && $cargo_field != null ) {
				$f->template_field->setCargoFieldData( $cargo_table, $cargo_field );
			}
			$fullCargoField = $f->template_field->getFullCargoField();
			if ( !is_null( $fullCargoField ) ) {
				global $sfgCargoFields;
				$sfgCargoFields[$fullFieldName] = $fullCargoField;
			}
		}

		if ( $template_name == null || $template_name === '' ) {
			$f->mInputName = $field_name;
		} elseif ( $template_in_form->allowsMultiple() ) {
			// 'num' will get replaced by an actual index, either in PHP
			// or in Javascript, later on
			$f->mInputName = $template_name . '[num][' . $field_name . ']';
			$f->setFieldArg( 'origName', $fullFieldName );
		} else {
			$f->mInputName = $fullFieldName;
		}

		return $f;
	}

	function getCurrentValue( $template_instance_query_values, $form_submitted, $source_is_page, $all_instances_printed ) {
		// Get the value from the request, if
		// it's there, and if it's not an array.
		$cur_value = null;
		$field_name = $this->template_field->getFieldName();
		$delimiter = $this->mFieldArgs['delimiter'];
		$escaped_field_name = str_replace( "'", "\'", $field_name );
		if ( isset( $template_instance_query_values ) &&
			$template_instance_query_values != null &&
			is_array( $template_instance_query_values ) ) {

			// If the field name contains an apostrophe, the array
			// sometimes has the apostrophe escaped, and sometimes
			// not. For now, just check for both versions.
			// @TODO - figure this out.
			$field_query_val = null;
			if ( array_key_exists( $escaped_field_name, $template_instance_query_values ) ) {
				$field_query_val = $template_instance_query_values[$escaped_field_name];
			} elseif ( array_key_exists( $field_name, $template_instance_query_values ) ) {
				$field_query_val = $template_instance_query_values[$field_name];
			}

			if ( $form_submitted && $field_query_val != '' ) {
				$map_field = false;
				if ( array_key_exists( 'map_field', $template_instance_query_values ) &&
					array_key_exists( $field_name, $template_instance_query_values['map_field'] ) ) {
					$map_field = true;
				}
				if ( is_array( $field_query_val ) ) {
					$cur_values = array();
					if ( $map_field && !is_null( $this->mPossibleValues ) ) {
						$cur_values = array();
						foreach ( $field_query_val as $key => $val ) {
							$val = trim( $val );
							if ( $key === 'is_list' ) {
								$cur_values[$key] = $val;
							} else {
								$cur_values[] = $this->labelToValue( $val );
							}
						}
					} else {
						foreach ( $field_query_val as $key => $val ) {
							$cur_values[$key] = $val;
						}
					}
					return SFFormPrinter::getStringFromPassedInArray( $cur_values, $delimiter );
				} else {
					$field_query_val = trim( $field_query_val );
					if ( $map_field && !is_null( $this->mPossibleValues ) ) {
						// this should be replaced with an input type neutral way of
						// figuring out if this scalar input type is a list
						if ( $this->mInputType == "tokens" ) {
							$this->mIsList = true;
						}
						if ( $this->mIsList ) {
							$cur_values = array_map( 'trim', explode( $delimiter, $field_query_val ) );
							foreach ( $cur_values as $key => $val ) {
								$cur_values[$key] = $this->labelToValue( $val );
							}
							return implode( $delimiter, $cur_values );
						}
						return $this->labelToValue( $field_query_val );
					}
					return $field_query_val;
				}
			}
			if ( !$form_submitted && $field_query_val != '' ) {
				if ( is_array( $field_query_val ) ) {
					return SFFormPrinter::getStringFromPassedInArray( $field_query_val, $delimiter );
				}
				return $field_query_val;
			}
		}

		if ( !empty( $cur_value ) ) {
			return $cur_value;
		}

		// Default values in new instances of multiple-instance
		// templates should always be set, even for existing pages.
		$part_of_multiple = array_key_exists( 'part_of_multiple', $this->mFieldArgs );
		$printing_starter_instance = $part_of_multiple && $all_instances_printed;
		if ( ( !$source_is_page || $printing_starter_instance ) && !$form_submitted ) {
			if ( !is_null( $this->mDefaultValue ) ) {
				// Set to the default value specified in the form, if it's there.
				return $this->mDefaultValue;
			} elseif ( $this->mPreloadPage ) {
				return SFFormUtils::getPreloadedText( $this->mPreloadPage );
			}
		}

		// We're still here...
		return null;
	}

	/**
	 * Helper function to get an array of labels from an array of values
	 * given a mapping template.
	 */
	function setValuesWithMappingTemplate() {
		global $wgParser;

		$labels = array();
		$templateName = $this->mFieldArgs['mapping template'];
		$title = Title::makeTitleSafe( NS_TEMPLATE, $templateName );
		$templateExists = $title->exists();
		foreach ( $this->mPossibleValues as $value ) {
			if ( $templateExists ) {
				$label = trim( $wgParser->recursiveTagParse( '{{' . $templateName .
					'|' . $value . '}}' ) );
				if ( $label == '' ) {
					$labels[$value] = $value;
				} else {
					$labels[$value] = $label;
				}
			} else {
				$labels[$value] = $value;
			}
		}
		$this->mPossibleValues = $this->disambiguateLabels( $labels );
	}

	/**
	 * Helper function to get an array of labels from an array of values
	 * given a mapping property.
	 */
	function setValuesWithMappingProperty() {
		// Error-handling.
		if ( !is_array( $this->mPossibleValues ) ) {
			$this->mPossibleValues = array();
			return;
		}

		$store = SFUtils::getSMWStore();
		if ( $store == null ) {
			return;
		}

		$propertyName = $this->mFieldArgs['mapping property'];
		$labels = array();
		foreach ( $this->mPossibleValues as $value ) {
			$labels[$value] = $value;
			$subject = Title::newFromText( $value );
			if ( $subject != null ) {
				$vals = SFValuesUtils::getSMWPropertyValues( $store, $subject, $propertyName );
				if ( count( $vals ) > 0 ) {
					$labels[$value] = trim( $vals[0] );
				}
			}
		}
		$this->mPossibleValues = $this->disambiguateLabels( $labels );
	}

	/**
	 * Helper function to get an array of labels from an array of values
	 * given a mapping Cargo table/field.
	 */
	function setValuesWithMappingCargoField() {
		$labels = array();
		foreach ( $this->mPossibleValues as $value ) {
			$labels[$value] = $value;
			$vals = SFValuesUtils::getValuesForCargoField(
				$this->mFieldArgs['mapping cargo table'],
				$this->mFieldArgs['mapping cargo field'],
				'_pageName="' . $value . '"'
			);
			if ( count( $vals ) > 0 ) {
				$labels[$value] = trim( $vals[0] );
			}
		}
		$this->mPossibleValues = $this->disambiguateLabels( $labels );
	}


	function disambiguateLabels( $labels ) {
		asort( $labels );
		if ( count( $labels ) == count( array_unique( $labels ) ) ) {
			return $labels;
		}
		$fixed_labels = array();
		foreach ( $labels as $value => $label ) {
			$fixed_labels[$value] = $labels[$value];
		}
		$counts = array_count_values( $fixed_labels );
		foreach ( $counts as $current_label => $count ) {
			if ( $count > 1 ) {
				$matching_keys = array_keys( $labels, $current_label );
				foreach ( $matching_keys as $key ) {
					$fixed_labels[$key] .= ' (' . $key . ')';
				}
			}
		}
		if ( count( $fixed_labels ) == count( array_unique( $fixed_labels ) ) ) {
			return $fixed_labels;
		}
		foreach ( $labels as $value => $label ) {
			$labels[$value] .= ' (' . $value . ')';
		}
		return $labels;
	}

	/**
	 * Map a label back to a value.
	 */
	function labelToValue( $label ) {
		$value = array_search( $label, $this->mPossibleValues );
		if ( $value === false ) {
			return $label;
		} else {
			return $value;
		}
	}

	/**
	 * Map a template field value into labels.
	 */
	public function valueStringToLabels( $valueString, $delimiter ) {
		if ( !is_null( $delimiter ) ) {
			$values = array_map( 'trim', explode( $delimiter, $valueString ) );
		} else {
			$values = array( $valueString );
		}
		$labels = array();
		foreach ( $values as $value ) {
			if ( $value != '' ) {
				if ( array_key_exists( $value, $this->mPossibleValues ) ) {
					$labels[] = $this->mPossibleValues[$value];
				} else {
					$labels[] = $value;
				}
			}
		}
		if ( count( $labels ) > 1 ) {
			return $labels;
		} else {
			return $labels[0];
		}
	}

	public function additionalHTMLForInput( $cur_value, $field_name, $template_name ) {
		$text = '';

		// Add a field just after the hidden field, within the HTML, to
		// locate where the multiple-templates HTML, stored in
		// $multipleTemplateString, should be inserted.
		if ( $this->mHoldsTemplate ) {
			$text .= SFFormPrinter::makePlaceholderInFormHTML( SFFormPrinter::placeholderFormat( $template_name, $field_name ) );
		}

		// If this field is disabled, add a hidden field holding
		// the value of this field, because disabled inputs for some
		// reason don't submit their value.
		if ( $this->mIsDisabled ) {
			if ( $field_name == 'free text' || $field_name == '<freetext>' ) {
				$text .= Html::hidden( 'sf_free_text', '!free_text!' );
			} else {
				if ( is_array( $cur_value ) ) {
					$delimiter = $this->mFieldArgs['delimiter'];
					$text .= Html::hidden( $this->mInputName, implode( $delimiter, $cur_value ) );
				} else {
					$text .= Html::hidden( $this->mInputName, $cur_value );
				}
			}
		}

		if ( $this->hasFieldArg( 'mapping template' ) ||
			$this->hasFieldArg( 'mapping property' ) ||
			( $this->hasFieldArg( 'mapping cargo table' ) &&
			$this->hasFieldArg( 'mapping cargo field' ) ) ) {
			if ( $this->hasFieldArg( 'part_of_multiple' ) ) {
				$text .= Html::hidden( $template_name . '[num][map_field][' . $field_name . ']', 'true' );
			} else {
				$text .= Html::hidden( $template_name . '[map_field][' . $field_name . ']', 'true' );
			}
		}

		if ( $this->hasFieldArg( 'unique' ) ) {
			global $sfgFieldNum;

			$semantic_property = $this->template_field->getSemanticProperty();
			if ( $semantic_property != null ) {
				$text .= Html::hidden( 'input_' . $sfgFieldNum . '_unique_property', $semantic_property );
			}
			$fullCargoField = $this->template_field->getFullCargoField();
			if ( $fullCargoField != null ) {
				// It's inefficient to get these values via
				// text parsing, but oh well.
				list( $cargo_table, $cargo_field ) = explode( '|', $fullCargoField, 2 );
				$text .= Html::hidden( 'input_' . $sfgFieldNum . '_unique_cargo_table', $cargo_table );
				$text .= Html::hidden( 'input_' . $sfgFieldNum . '_unique_cargo_field', $cargo_field );
			}
			if ( $this->hasFieldArg( 'unique_for_category' ) ) {
				$text .= Html::hidden( 'input_' . $sfgFieldNum . '_unique_for_category', $this->getFieldArg( 'unique_for_category' ) );
			}
			if ( $this->hasFieldArg( 'unique_for_namespace' ) ) {
				$text .= Html::hidden( 'input_' . $sfgFieldNum . '_unique_for_namespace', $this->getFieldArg( 'unique_for_namespace' ) );
			}
			if ( $this->hasFieldArg( 'unique_for_concept' ) ) {
				$text .= Html::hidden( 'input_' . $sfgFieldNum . '_unique_for_concept', $this->getFieldArg( 'unique_for_concept' ) );
			}
		}
		return $text;
	}

	// for now, HTML of an individual field depends on whether or not it's
	// part of multiple-instance template; this may change if handling of
	// such templates in form definitions gets more sophisticated
	function createMarkup( $part_of_multiple, $is_last_field_in_template ) {
		$text = "";
		$descPlaceholder = "";
		$textBeforeField = "";

		if ( array_key_exists( "Description", $this->mDescriptionArgs ) ) {
			$fieldDesc = $this->mDescriptionArgs['Description'];
			if ( $fieldDesc != '' ) {
				if ( isset( $this->mDescriptionArgs['DescriptionTooltipMode'] ) ) {
					// The wikitext we use for tooltips
					// depends on which other extensions
					// are installed.
					if ( defined( 'SMW_VERSION' ) ) {
						// Semantic MediaWiki
						$descPlaceholder = " {{#info:$fieldDesc}}";
					} elseif ( class_exists( 'SimpleTooltipParserFunction' ) ) {
						// SimpleTooltip
						$descPlaceholder = " {{#tip-info:$fieldDesc}}";
					} else {
						// Don't make it a tooltip.
						$descPlaceholder = '<br><p class="sfFieldDescription" style="font-size:0.7em; color:gray;">' . $fieldDesc . '</p>';
					}
				} else {
					$descPlaceholder = '<br><p class="sfFieldDescription" style="font-size:0.7em; color:gray;">' . $fieldDesc . '</p>';
				}
			}
		}

		if ( array_key_exists( "TextBeforeField", $this->mDescriptionArgs ) ) {
			$textBeforeField = $this->mDescriptionArgs['TextBeforeField'];
		}

		$fieldLabel = $this->template_field->getLabel();
		if ( $textBeforeField != '' ) {
			$fieldLabel = $textBeforeField . ' ' . $fieldLabel;
		}

		if ( $part_of_multiple ) {
			$text .= "'''$fieldLabel:''' $descPlaceholder";
		} else {
			$text .= "! $fieldLabel: $descPlaceholder\n";
		}

		if ( ! $part_of_multiple ) { $text .= "| "; }
		$text .= "{{{field|" . $this->template_field->getFieldName();
		if ( $this->mIsHidden ) {
			$text .= "|hidden";
		} elseif ( !is_null( $this->getInputType() ) ) {
			$text .= "|input type=" . $this->getInputType();
		}
		foreach ( $this->mFieldArgs as $arg => $value ) {
			if ( $value === true ) {
				$text .= "|$arg";
			} elseif ( $arg === 'uploadable' ) {
				// Are there similar value-less arguments
				// that need to be handled here?
				$text .= "|$arg";
			} else {
				$text .= "|$arg=$value";
			}
		}
		if ( $this->mIsMandatory ) {
			$text .= "|mandatory";
		} elseif ( $this->mIsRestricted ) {
			$text .= "|restricted";
		}
		$text .= "}}}\n";
		if ( $part_of_multiple ) {
			$text .= "\n";
		} elseif ( ! $is_last_field_in_template ) {
			$text .= "|-\n";
		}
		return $text;
	}

	function getArgumentsForInputCallSMW( &$other_args ) {
		if ( $this->template_field->getSemanticProperty() !== '' &&
			! array_key_exists( 'semantic_property', $other_args ) ) {
			$other_args['semantic_property'] = $this->template_field->getSemanticProperty();
			$other_args['property_type'] = $this->template_field->getPropertyType();
		}
		// If autocompletion hasn't already been hardcoded in the form,
		// and it's a property of type page, or a property of another
		// type with 'autocomplete' specified, set the necessary
		// parameters.
		if ( ! array_key_exists( 'autocompletion source', $other_args ) ) {
			if ( $this->template_field->getPropertyType() == '_wpg' ) {
				$other_args['autocompletion source'] = $this->template_field->getSemanticProperty();
				$other_args['autocomplete field type'] = 'property';
			} elseif ( array_key_exists( 'autocomplete', $other_args ) || array_key_exists( 'remote autocompletion', $other_args ) ) {
				$other_args['autocompletion source'] = $this->template_field->getSemanticProperty();
				$other_args['autocomplete field type'] = 'property';
			}
		}
	}

	function getArgumentsForInputCallCargo( &$other_args ) {
		$fullCargoField = $this->template_field->getFullCargoField();
		if ( $fullCargoField !== null &&
			! array_key_exists( 'full_cargo_field', $other_args ) ) {
			$other_args['full_cargo_field'] = $fullCargoField;
		}

		if ( ! array_key_exists( 'autocompletion source', $other_args ) ) {
			if ( $this->template_field->getFieldType() == 'Page' || array_key_exists( 'autocomplete', $other_args ) || array_key_exists( 'remote autocompletion', $other_args ) ) {
				$other_args['autocompletion source'] = $this->template_field->getFullCargoField();
				$other_args['autocomplete field type'] = 'cargo field';
			}
		}
	}

	/**
	 * Since Semantic Forms uses a hook system for the functions that
	 * create HTML inputs, most arguments are contained in the "$other_args"
	 * array - create this array, using the attributes of this form
	 * field and the template field it corresponds to, if any.
	 */
	function getArgumentsForInputCall( $default_args = null ) {
		// start with the arguments array already defined
		$other_args = $this->mFieldArgs;
		// a value defined for the form field should always supersede
		// the coresponding value for the template field
		if ( $this->mPossibleValues != null ) {
			$other_args['possible_values'] = $this->mPossibleValues;
		} else {
			$other_args['possible_values'] = $this->template_field->getPossibleValues();
			$other_args['value_labels'] = $this->template_field->getValueLabels();
		}
		$other_args['is_list'] = ( $this->mIsList || $this->template_field->isList() );

		// Now add some extension-specific arguments to the input call.
		if ( defined( 'CARGO_VERSION' ) ) {
			$this->getArgumentsForInputCallCargo( $other_args );
		}
		if ( defined( 'SMW_VERSION' ) ) {
			$this->getArgumentsForInputCallSMW( $other_args );
		}

		// Now merge in the default values set by SFFormPrinter, if
		// there were any - put the default values first, so that if
		// there's a conflict they'll be overridden.
		if ( $default_args != null ) {
			$other_args = array_merge( $default_args, $other_args );
		}

		global $wgParser;
		foreach ( $other_args as $argname => $argvalue ) {
			if ( is_string( $argvalue ) ) {
				$other_args[$argname] =
					$wgParser->recursiveTagParse( $argvalue );
			}
		}

		return $other_args;
	}
}
