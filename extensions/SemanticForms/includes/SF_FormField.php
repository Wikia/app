<?php
/**
 *
 * @file
 * @ingroup SF
 */

/**
 * This class is distinct from SFTemplateField in that it represents a template
 * field defined in a form definition - it contains a SFTemplateField object
 * within it (the $template_field variable), along with the other properties
 * for that field that are set within the form
 * @ingroup SF
 */
class SFFormField {
	private $mNum;
	public $template_field;
	private $mInputType;
	private $mIsMandatory;
	private $mIsHidden;
	private $mIsRestricted;
	private $mPossibleValues;
	private $mIsList;
	// the following fields are not set by the form-creation page
	// (though they could be)
	private $mIsUploadable;
	private $mFieldArgs;
	private $mDescriptionArgs;
	// somewhat of a hack - these two fields are for a field in a specific
	// representation of a form, not the form definition; ideally these
	// should be contained in a third 'field' class, called something like
	// SFFormInstanceField, that holds these fields plus an instance of
	// SFFormField. Too much work?
	private $mInputName;
	private $mIsDisabled;

	static function create( $num, $template_field ) {
		$f = new SFFormField();
		$f->mNum = $num;
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

	static function createFromDefinition( $fieldName, $inputName, $isMandatory, $isHidden, $isUploadable, $possibleValues, $isDisabled, $isList, $inputType, $fieldArgs, $allFields, $strictParsing ) {
		// See if this field matches one of the fields defined for this
		// template - if it is, use all available information about
		// that field; if it's not, either include it in the form or
		// not, depending on whether the template has a 'strict'
		// setting in the form definition.
		$the_field = null;
		foreach ( $allFields as $cur_field ) {
			if ( $fieldName == $cur_field->getFieldName() ) {
				$the_field = $cur_field;
				break;
			}
		}
		if ( $the_field == null ) {
			if ( $strictParsing ) {
				$dummy_ff = new SFFormField();
				$dummy_ff->template_field = new SFTemplateField();
				$dummy_ff->mIsList = false;
				return $dummy_ff;
			}
			$the_field = new SFTemplateField();
		}

		// create an SFFormField object, containing this field as well
		// as settings from the form definition file
		$f = new SFFormField();
		$f->template_field = $the_field;
		$f->mIsMandatory = $isMandatory;
		$f->mIsHidden = $isHidden;
		$f->mIsUploadable = $isUploadable;
		$f->mPossibleValues = $possibleValues;
		$f->mInputType = $inputType;
		$f->mFieldArgs = $fieldArgs;
		$f->mInputName = $inputName;
		$f->mIsDisabled = $isDisabled;
		$f->mIsList = $isList;
		$f->mAllFields = $allFields;
		return $f;
	}

	public function getTemplateField() {
		return $this->template_field;
	}

	public function getInputType() {
		return $this->mInputType;
	}

	public function isMandatory() {
		return $this->mIsMandatory;
	}

	public function isHidden() {
		return $this->mIsHidden;
	}

	public function isList() {
		return $this->mIsList;
	}

	public function getInputName() {
		return $this->mInputName;
	}

	public function isDisabled() {
		return $this->mIsDisabled;
	}

	public function setTemplateField( $templateField ) {
		$this->template_field = $templateField;
	}

	public function setInputType( $inputType ) {
		$this->mInputType = $inputType;
	}

	public function setIsMandatory( $isMandatory ) {
		$this->mIsMandatory = $isMandatory;
	}

	public function setIsHidden( $isHidden ) {
		$this->mIsHidden = $isHidden;
	}

	public function setIsRestricted( $isRestricted ) {
		$this->mIsRestricted = $isRestricted;
	}

	public function setFieldArg( $key, $value ) {
		$this->mFieldArgs[$key] = $value;
	}

	public function setDescriptionArg( $key, $value ) {
		$this->mDescriptionArgs[$key] = $value;
	}

	function inputTypeDropdownHTML( $field_form_text, $default_input_type, $possible_input_types, $cur_input_type ) {
		if ( !is_null( $default_input_type ) ) {
			array_unshift( $possible_input_types, $default_input_type );
		}
		// create the dropdown HTML for a list of possible input types
		$dropdownHTML = "";
		foreach ( $possible_input_types as $i => $input_type ) {
			if ( $i == 0 ) {
				$dropdownHTML .= "	<option value=\".$input_type\">$input_type " .
					wfMessage( 'sf_createform_inputtypedefault' )->escaped() . "</option>\n";
			} else {
				$selected_str = ( $cur_input_type == $input_type ) ? "selected" : "";
				$dropdownHTML .= "	<option value=\"$input_type\" $selected_str>$input_type</option>\n";
			}
		}
		$hidden_text = wfMessage( 'sf_createform_hidden' )->escaped();
		$selected_str = ( $cur_input_type == 'hidden' ) ? "selected" : "";
		// @todo FIXME: Contains hard coded parentheses.
		$dropdownHTML .= "	<option value=\"hidden\" $selected_str>($hidden_text)</option>\n";
		$text = "\t" . Html::rawElement( 'select',
			array(
				'class' => 'inputTypeSelector',
				'name' => 'input_type_' . $field_form_text,
				'formfieldid' => $field_form_text
			), $dropdownHTML ) . "\n";
		return $text;
	}

	function creationHTML( $template_num ) {
		$field_form_text = $template_num . "_" . $this->mNum;
		$template_field = $this->template_field;
		$text = Html::element( 'h3', null, wfMessage( 'sf_createform_field' )->text() . " '" . $template_field->getFieldName() ) . "\n";
		// TODO - remove this probably-unnecessary check?
		if ( $template_field->getSemanticProperty() == "" ) {
			// Print nothing if there's no semantic property.
		} elseif ( $template_field->getPropertyType() == "" ) {
			$prop_link_text = SFUtils::linkText( SMW_NS_PROPERTY, $template_field->getSemanticProperty() );
			$text .= Html::element( 'p', null, wfMessage( 'sf_createform_fieldpropunknowntype', $prop_link_text )->parseAsBlock() ) . "\n";
		} else {
			if ( $template_field->isList() ) {
				$propDisplayMsg = 'sf_createform_fieldproplist';
			} else {
				$propDisplayMsg = 'sf_createform_fieldprop';
			}
			$prop_link_text = SFUtils::linkText( SMW_NS_PROPERTY, $template_field->getSemanticProperty() );

			// Get the display label for this property type.
			global $smwgContLang;
			$propertyTypeStr = '';
			if ( $smwgContLang != null ) {
				$datatypeLabels = $smwgContLang->getDatatypeLabels();
				$datatypeLabels['enumeration'] = 'enumeration';

				$propTypeID = $template_field->getPropertyType();

				// Special handling for SMW 1.9
				if ( $propTypeID == '_str' && !array_key_exists( '_str', $datatypeLabels ) ) {
					$propTypeID = '_txt';
				}
				$propertyTypeStr = $datatypeLabels[$propTypeID];
			}
			$text .= Html::rawElement( 'p', null, wfMessage( $propDisplayMsg, $prop_link_text, $propertyTypeStr )->parse() ) . "\n";
		}
		// If it's not a semantic field - don't add any text.
		$form_label_text = wfMessage( 'sf_createform_formlabel' )->text();
		$form_label_input = Html::input(
			'label_' . $field_form_text,
			$template_field->getLabel(),
			'text',
			array( 'size' => 20 )
		);
		$input_type_text = wfMessage( 'sf_createform_inputtype' )->escaped();
		$text .= <<<END
	<div class="formField">
	<p>$form_label_text $form_label_input
	&#160; $input_type_text

END;
		global $sfgFormPrinter;
		if ( !is_null( $template_field->getPropertyType() ) ) {
			$default_input_type = $sfgFormPrinter->getDefaultInputTypeSMW( $template_field->isList(), $template_field->getPropertyType() );
			$possible_input_types = $sfgFormPrinter->getPossibleInputTypesSMW( $template_field->isList(), $template_field->getPropertyType() );
		} elseif ( !is_null( $template_field->getFieldType() ) ) {
			$default_input_type = $sfgFormPrinter->getDefaultInputTypeCargo( $template_field->isList(), $template_field->getFieldType() );
			$possible_input_types = $sfgFormPrinter->getPossibleInputTypesCargo( $template_field->isList(), $template_field->getFieldType() );
		} else {
			$default_input_type = null;
			$possible_input_types = $sfgFormPrinter->getAllInputTypes();
		}
		$text .= $this->inputTypeDropdownHTML( $field_form_text, $default_input_type, $possible_input_types, $template_field->getInputType() );

		if ( !is_null( $template_field->getInputType() ) ) {
			$cur_input_type = $template_field->getInputType();
		} elseif ( !is_null( $default_input_type ) ) {
			$cur_input_type = $default_input_type;
		} else {
			$cur_input_type = $possible_input_types[0];
		}

		global $wgRequest;
		$paramValues = array();
		foreach ( $wgRequest->getValues() as $key => $value ) {
			if ( ( $pos = strpos( $key, '_' . $field_form_text ) ) != false ) {
				$paramName = substr( $key, 0, $pos );
				// Spaces got replaced by underlines in the
				// query.
				$paramName = str_replace( '_', ' ', $paramName );
				$paramValues[$paramName] = $value;
			}
		}

		$other_param_text = wfMessage( 'sf_createform_otherparameters' )->escaped();
		$text .= "<fieldset class=\"sfCollapsibleFieldset\"><legend>$other_param_text</legend>\n";
		$text .= Html::rawElement( 'div', array( 'class' => 'otherInputParams' ),
			SFCreateForm::showInputTypeOptions( $cur_input_type, $field_form_text, $paramValues ) ) . "\n";
		$text .= "</fieldset>\n";
		$text .= <<<END
	</p>
	</div>
	<hr>

END;
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
		// TODO - why is there an input type field in both the form
		// field and the template field? One of them should probably
		// be removed.
		if ( $this->mIsHidden ) {
			$text .= "|hidden";
		} elseif ( !is_null( $this->getInputType() ) ) {
			$text .= "|input type=" . $this->getInputType();
		} elseif ( $this->template_field->getInputType() != '' ) {
			$text .= "|input type=" . $this->template_field->getInputType();
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
			if ( $this->template_field->getPropertyType() == '_wpg' || array_key_exists( 'autocomplete', $other_args ) || array_key_exists( 'remote autocompletion', $other_args ) ) {
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
