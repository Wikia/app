<?php
/**
 * Static functions for Semantic Forms, for use by the Page Schemas
 * extension.
 *
 * @author Yaron Koren
 * @author Ankit Garg
 * @file
 * @ingroup SF
 */

class SFPageSchemas extends PSExtensionHandler {
	public static function registerClass() {
		global $wgPageSchemasHandlerClasses;
		$wgPageSchemasHandlerClasses[] = 'SFPageSchemas';
		return true;
	}

	/**
	 * Creates an object to hold form-wide information, based on an XML
	 * object from the Page Schemas extension.
	 */
	public static function createPageSchemasObject( $tagName, $xml ) {
		$sfarray = array();
		if ( $tagName == "semanticforms_Form" ) {
			foreach ( $xml->children() as $tag => $child ) {
				if ( $tag == $tagName ) {
					$formName = (string)$child->attributes()->name;
					$sfarray['name'] = $formName;
					foreach ( $child->children() as $tag => $formelem ) {
						$sfarray[$tag] = (string)$formelem;
					}
					return $sfarray;
				}
			}
		}
		if ( $tagName == "semanticforms_TemplateDetails" ) {
			foreach ( $xml->children() as $tag => $child ) {
				if ( $tag == $tagName ) {
					foreach ( $child->children() as $tag => $formelem ) {
						$sfarray[$tag] = (string)$formelem;
					}
					return $sfarray;
				}
			}
		}
		if ( $tagName == "semanticforms_FormInput" ) {
			foreach ( $xml->children() as $tag => $child ) {
				if ( $tag == $tagName ) {
					foreach ( $child->children() as $prop ) {
						if ( $prop->getName() == 'InputType' ) {
							$sfarray[$prop->getName()] = (string)$prop;
						} else {
							$sfarray[(string)$prop->attributes()->name] = (string)$prop;
						}
					}
					return $sfarray;
				}
			}
		}
		return null;
	}

	/**
	 * Creates Page Schemas XML for form-wide information.
	 */
	public static function createSchemaXMLFromForm() {
		global $wgRequest;

		$formName = null;
		$xml = '';
		foreach ( $wgRequest->getValues() as $var => $val ) {
			if ( $var == 'sf_form_name' ) {
				$formName = $val;
			} elseif ( $var == 'sf_page_name_formula' ) {
				if ( !empty( $val ) ) {
					$xml .= '<PageNameFormula>' . $val . '</PageNameFormula>';
				}
			} elseif ( $var == 'sf_create_title' ) {
				if ( !empty( $val ) ) {
					$xml .= '<CreateTitle>' . $val . '</CreateTitle>';
				}
			} elseif ( $var == 'sf_edit_title' ) {
				if ( !empty( $val ) ) {
					$xml .= '<EditTitle>' . $val . '</EditTitle>';
				}
			}
		}
		$xml = '<semanticforms_Form name="' . $formName . '" >' . $xml;
		$xml .= '</semanticforms_Form>';
		return $xml;
	}

	/**
	 * Creates Page Schemas XML from form information on templates.
	 */
	public static function createTemplateXMLFromForm() {
		global $wgRequest;

		$xmlPerTemplate = array();
		$templateNum = -1;
		foreach ( $wgRequest->getValues() as $var => $val ) {
			if ( substr( $var, 0, 18 ) == 'sf_template_label_' ) {
				$templateNum = substr( $var, 18 );
				$xml = '<semanticforms_TemplateDetails>';
				if ( !empty( $val ) ) {
					$xml .= "<Label>$val</Label>";
				}
			} elseif ( substr( $var, 0, 23 ) == 'sf_template_addanother_' ) {
				if ( !empty( $val ) ) {
					$xml .= "<AddAnotherText>$val</AddAnotherText>";
				}
				$xml .= '</semanticforms_TemplateDetails>';
				$xmlPerTemplate[$templateNum] = $xml;
			}
		}
		return $xmlPerTemplate;
	}

	/**
	 * Creates Page Schemas XML for form fields.
	 */
	public static function createFieldXMLFromForm() {
		global $wgRequest;

		$xmlPerField = array();
		$fieldNum = -1;
		foreach ( $wgRequest->getValues() as $var => $val ) {
			if ( substr( $var, 0, 14 ) == 'sf_input_type_' ) {
				$fieldNum = substr( $var, 14 );
				$xml = '<semanticforms_FormInput>';
				if ( !empty( $val ) ) {
					$xml .= '<InputType>' . $val . '</InputType>';
				}
			} elseif ( substr( $var, 0, 14 ) == 'sf_key_values_' ) {
				if ( $val !== '' ) {
					// replace the comma substitution character that has no chance of
					// being included in the values list - namely, the ASCII beep
					$listSeparator = ',';
					$key_values_str = str_replace( "\\$listSeparator", "\a", $val );
					$key_values_array = explode( $listSeparator, $key_values_str );
					foreach ( $key_values_array as $value ) {
						// replace beep back with comma, trim
						$value = str_replace( "\a", $listSeparator, trim( $value ) );
						$param_value = explode( "=", $value, 2 );
						if ( count( $param_value ) == 2 && $param_value[1] != null ) {
							// Handles <Parameter name="size">20</Parameter>
							$xml .= '<Parameter name="' . $param_value[0] . '">' . $param_value[1] . '</Parameter>';
						} else {
							// Handles <Parameter name="mandatory" />
							$xml .= '<Parameter name="' . $param_value[0] . '"/>';
						}
					}
				}
				$xml .= '</semanticforms_FormInput>';
				$xmlPerField[$fieldNum] = $xml;
			}
		}
		return $xmlPerField;
	}

	public static function getDisplayColor() {
		return '#CF9';
	}

	public static function getSchemaDisplayString() {
		return 'Form';
	}

	public static function getSchemaEditingHTML( $pageSchemaObj ) {
		$form_array = array();
		$hasExistingValues = false;
		if ( !is_null( $pageSchemaObj ) ) {
			$form_array = $pageSchemaObj->getObject( 'semanticforms_Form' );
			if ( !is_null( $form_array ) ) {
				$hasExistingValues = true;
			}
		}

		// Get all the values from the page schema.
		$formName = PageSchemas::getValueFromObject( $form_array, 'name' );
		$pageNameFormula = PageSchemas::getValueFromObject( $form_array, 'PageNameFormula' );
		$createTitle = PageSchemas::getValueFromObject( $form_array, 'CreateTitle' );
		$editTitle = PageSchemas::getValueFromObject( $form_array, 'EditTitle' );

		$text = "\t<p>" . wfMsg( 'ps-namelabel' ) . ' ' . Html::input( 'sf_form_name', $formName, 'text', array( 'size' => 15 ) ) . "</p>\n";
		// The checkbox isn't actually a field in the page schema -
		// we set it based on whether or not a page formula has been
		// specified.
		$twoStepProcessAttrs = array( 'id' => 'sf-two-step-process' );
		if ( is_null( $pageNameFormula ) ) {
			$twoStepProcessAttrs['checked'] = true;
		}
		$text .= '<p>' . Html::input( 'sf_two_step_process', null, 'checkbox', $twoStepProcessAttrs );
		$text .= ' Users must enter the page name before getting to the form (default)';
		$text .= "</p>\n";
		$text .= "\t<p id=\"sf-page-name-formula\">" . wfMsg( 'sf-pageschemas-pagenameformula' ) . ' ' . Html::input( 'sf_page_name_formula', $pageNameFormula, 'text', array( 'size' => 30 ) ) . "</p>\n";
		$text .= "\t<p>" . wfMsg( 'sf-pageschemas-createtitle' ) . ' ' . Html::input( 'sf_create_title', $createTitle, 'text', array( 'size' => 25 ) ) . "</p>\n";
		$text .= "\t<p id=\"sf-edit-title\">" . wfMsg( 'sf-pageschemas-edittitle' ) . ' ' . Html::input( 'sf_edit_title', $editTitle, 'text', array( 'size' => 25 ) ) . "</p>\n";

		// Separately, add Javascript for getting the checkbox to
		// hide certain fields.
		$jsText = <<<END
<script type="text/javascript">
jQuery.fn.toggleFormDataDisplay = function() {
	if (jQuery(this).is(":checked")) {
		jQuery('#sf-page-name-formula').css('display', 'none');
		jQuery('#sf-edit-title').css('display', 'block');
	} else {
		jQuery('#sf-page-name-formula').css('display', 'block');
		jQuery('#sf-edit-title').css('display', 'none');
	}
}
jQuery('#sf-two-step-process').toggleFormDataDisplay();
jQuery('#sf-two-step-process').click( function() {
	jQuery(this).toggleFormDataDisplay();
} );
</script>

END;
		global $wgOut;
		$wgOut->addScript( $jsText );

		return array( $text, $hasExistingValues );
	}

	public static function getTemplateEditingHTML( $psTemplate ) {
		$hasExistingValues = false;
		$templateLabel = null;
		$addAnotherText = null;
		if ( !is_null( $psTemplate ) ) {
			$form_array = $psTemplate->getObject( 'semanticforms_TemplateDetails' );
			if ( !is_null( $form_array ) ) {
				$hasExistingValues = true;
				$templateLabel = PageSchemas::getValueFromObject( $form_array, 'Label' );
				$addAnotherText = PageSchemas::getValueFromObject( $form_array, 'AddAnotherText' );
			}
		}

		$text = "\t<p>" . "The following fields are useful if there can be multiple instances of this template." . "</p>\n";
		$text .= "\t<p>" . 'Label:' . ' ' . Html::input( 'sf_template_label_num', $templateLabel, 'text', array( 'size' => 15 ) ) . "</p>\n";
		$text .= "\t<p>" . 'Text of button to add another instance (default is "Add another"):' . ' ' . Html::input( 'sf_template_addanother_num', $addAnotherText, 'text', array( 'size' => 25 ) ) . "</p>\n";

		return array( $text, $hasExistingValues );
	}

	/**
	 * Returns the HTML for inputs to define a single form field,
	 * within the Page Schemas 'edit schema' page.
	 */
	public static function getFieldEditingHTML( $psField ) {
		$fieldValues = array();
		$hasExistingValues = false;
		$inputType = null;
		if ( !is_null( $psField ) ) {
			$fieldValues = $psField->getObject( 'semanticforms_FormInput' );
			if ( !is_null( $fieldValues ) ) {
				$hasExistingValues = true;
				$inputType = PageSchemas::getValueFromObject( $fieldValues, 'InputType' );
			} else {
				$fieldValues = array();
			}
		}

		global $sfgFormPrinter;
		$possibleInputTypes = $sfgFormPrinter->getAllInputTypes();
		$inputTypeDropdownHTML = Html::element( 'option', null, null );
		foreach ( $possibleInputTypes as $possibleInputType ) {
			$inputTypeOptionAttrs = array();
			if ( $possibleInputType == $inputType ) {
				$inputTypeOptionAttrs['selected'] = true;
			}
			$inputTypeDropdownHTML .= Html::element( 'option', $inputTypeOptionAttrs, $possibleInputType ) . "\n";
		}
		$inputTypeDropdown = Html::rawElement( 'select', array( 'name' => 'sf_input_type_num' ), $inputTypeDropdownHTML );
		$text = '<p>' . wfMsg( 'sf-pageschemas-inputtype' ) . ' ' . $inputTypeDropdown . '</p>';

		$text .= "\t" . '<p>Enter parameter names and their values as key=value pairs, separated by commas (if a value contains a comma, replace it with "\,"). For example: size=20, mandatory</p>' . "\n";
		$paramValues = array();
		foreach ( $fieldValues as $param => $value ) {
			if ( !empty( $param ) && $param != 'InputType' ) {
				if ( !empty( $value ) ) {
					$paramValues[] = $param . '=' . $value;
				} else {
					$paramValues[] = $param;
				}
			}
		}
		$param_value_str = implode( ', ', $paramValues );
		$inputParamsAttrs = array( 'size' => 80 );
		$inputParamsInput = Html::input( 'sf_key_values_num', $param_value_str, 'text', $inputParamsAttrs );
		$text .= "\t<p>$inputParamsInput</p>\n";
		return array( $text, $hasExistingValues );
	}

	public static function getFormName( $pageSchemaObj ) {
		$mainFormInfo = self::getMainFormInfo( $pageSchemaObj );
		if ( is_null( $mainFormInfo ) || !array_key_exists( 'name', $mainFormInfo ) ) {
			return null;
		}
		return $mainFormInfo['name'];
	}

	public static function getMainFormInfo( $pageSchemaObj ) {
		// return $pageSchemaObj->getObject( 'semanticforms_Form' );
		// We don't just call getObject() here, because sometimes, for
		// some reason, this gets called before SF registers itself
		// with Page Schemas, which means that getObject() would return
		// null. Instead, we directly call the code that would have
		// been called.
		$xml = $pageSchemaObj->getXML();
		foreach ( $xml->children() as $tag => $child ) {
			if ( $tag == "semanticforms_Form" ) {
				$sfarray = array();
				$formName = (string)$child->attributes()->name;
				$sfarray['name'] = $formName;
				foreach ( $child->children() as $tag => $formelem ) {
					$sfarray[$tag] = (string)$formelem;
				}
				return $sfarray;
			}
		}
		return array();
	}

	public static function getFormFieldInfo( $psTemplate, $template_fields ) {
		$form_fields = array();
		$fieldsInfo = $psTemplate->getFields();
		foreach ( $fieldsInfo as $i => $psField ) {
			$fieldFormArray = $psField->getObject( 'semanticforms_FormInput' );
			if ( !is_null( $fieldFormArray ) ) {
				$formField = SFFormField::create( $i, $template_fields[$i] );
				foreach ( $fieldFormArray as $var => $val ) {
					if ( $var == 'InputType' ) {
						$formField->setInputType( $val );
					} elseif ( $var == 'mandatory' ) {
						$formField->setIsMandatory( true );
					} elseif ( $var == 'hidden' ) {
						$formField->setIsHidden( true );
					} elseif ( $var == 'restricted' ) {
						$formField->setIsRestricted( true );
					} else {
						$formField->setFieldArg( $var, $val );
					}
				}
				$form_fields[] = $formField;
			}
		}
		return $form_fields;
	}

	/**
	 * Return the list of pages that Semantic Forms could generate from
	 * the current Page Schemas schema.
	 */
	public static function getPagesToGenerate( $pageSchemaObj ) {
		$psTemplates = $pageSchemaObj->getTemplates();
		foreach ( $psTemplates as $psTemplate ) {
			$title = Title::makeTitleSafe( NS_TEMPLATE, $psTemplate->getName() );
			$genPageList[] = $title;
		}
		$form_name = self::getFormName( $pageSchemaObj );
		if ( $form_name == null ) {
			return array();
		}
		$title = Title::makeTitleSafe( SF_NS_FORM, $form_name );
		$genPageList[] = $title;
		return $genPageList;
	}

	/**
	 * Returns an array of SFTemplateField objects, representing the fields
	 * of a template, based on the contents of a <PageSchema> tag.
	 */
	public static function getFieldsFromTemplateSchema( $psTemplate ) {
		$psFields = $psTemplate->getFields();
		$templateFields = array();
		foreach ( $psFields as $psField ) {
			$prop_array = $psField->getObject( 'semanticmediawiki_Property' );
			$propertyName = PageSchemas::getValueFromObject( $prop_array, 'name' );
			if ( $psField->getLabel() === '' ) {
				$fieldLabel = $psField->getName();
			} else {
				$fieldLabel = $psField->getLabel();
			}
			$templateField = SFTemplateField::create(
				$psField->getName(),
				$fieldLabel,
				$propertyName,
				$psField->isList(),
				$psField->getDelimiter(),
				$psField->getDisplay()
			);
			$templateFields[] = $templateField;
		}
		return $templateFields;
	}

	/**
	 * Creates a form page, when called from the 'generatepages' page
	 * of Page Schemas.
	 */
	public static function generateForm( $formName, $formTitle,
		$formTemplates, $formDataFromSchema, $categoryName ) {
		global $wgUser;

		$form = SFForm::create( $formName, $formTemplates );
		$form->setAssociatedCategory( $categoryName );
		if ( array_key_exists( 'PageNameFormula', $formDataFromSchema ) ) {
			$form->setPageNameFormula( $formDataFromSchema['PageNameFormula'] );
		}
		if ( array_key_exists( 'CreateTitle', $formDataFromSchema ) ) {
			$form->setCreateTitle( $formDataFromSchema['CreateTitle'] );
		}
		if ( array_key_exists( 'EditTitle', $formDataFromSchema ) ) {
			$form->setEditTitle( $formDataFromSchema['EditTitle'] );
		}
		$formContents = $form->createMarkup();
		$params = array();
		$params['user_id'] = $wgUser->getId();
		$params['page_text'] = $formContents;
		$job = new PSCreatePageJob( $formTitle, $params );
		Job::batchInsert( array( $job ) );
	}

	/**
	 * Generate pages (form and templates) specified in the list.
	 */
	public static function generatePages( $pageSchemaObj, $selectedPages ) {
		global $wgUser;

		$psTemplates = $pageSchemaObj->getTemplates();

		$form_templates = array();
		$jobs = array();
		foreach ( $psTemplates as $psTemplate ) {
			// Generate every specified template
			$templateName = $psTemplate->getName();
			$templateTitle = Title::makeTitleSafe( NS_TEMPLATE, $templateName );
			$fullTemplateName = PageSchemas::titleString( $templateTitle );
			$template_fields = self::getFieldsFromTemplateSchema( $psTemplate );
			if ( class_exists( 'SIOPageSchemas' ) ) {
				$internalObjProperty = SIOPageSchemas::getInternalObjectPropertyName( $psTemplate );
			} else {
				$internalObjProperty = null;
			}
			// TODO - actually, the category-setting should be
			// smarter than this: if there's more than one
			// template in the schema, it should probably be only
			// the first non-multiple template that includes the
			// category tag.
			if ( $psTemplate->isMultiple() ) {
				$categoryName = null;
			} else {
				$categoryName = $pageSchemaObj->getCategoryName();
			}
			$templateText = SFTemplateField::createTemplateText( $templateName,
				$template_fields, $internalObjProperty, $categoryName, null, null, null );
			if ( in_array( $fullTemplateName, $selectedPages ) ) {
				$params = array();
				$params['user_id'] = $wgUser->getId();
				$params['page_text'] = $templateText;
				$jobs[] = new PSCreatePageJob( $templateTitle, $params );
			}

			$templateValues = self::getTemplateValues( $psTemplate );
			if ( array_key_exists( 'Label', $templateValues ) ) {
				$templateLabel = $templateValues['Label'];
			} else {
				$templateLabel = null;
			}
			$form_fields = self::getFormFieldInfo( $psTemplate, $template_fields );
			// Create template info for form, for use in generating
			// the form (if it will be generated).
			$form_template = SFTemplateInForm::create(
				$templateName,
				$templateLabel,
				$psTemplate->isMultiple(),
				null,
				$form_fields
			);
			$form_templates[] = $form_template;
		}
		Job::batchInsert( $jobs );

		// Create form, if it's specified.
		$formName = self::getFormName( $pageSchemaObj );
		if ( !empty( $formName ) ) {
			$formInfo = self::getMainFormInfo( $pageSchemaObj );
			$formTitle = Title::makeTitleSafe( SF_NS_FORM, $formName );
			$fullFormName = PageSchemas::titleString( $formTitle );
			if ( in_array( $fullFormName, $selectedPages ) ) {
				self::generateForm( $formName, $formTitle,
					$form_templates, $formInfo, $categoryName );
			}
		}
	}

	public static function getSchemaDisplayValues( $schemaXML ) {
		foreach ( $schemaXML->children() as $tag => $child ) {
			if ( $tag == "semanticforms_Form" ) {
				$formName = $child->attributes()->name;
				$values = array();
				foreach ( $child->children() as $tagName => $prop ) {
					$values[$tagName] = (string)$prop;
				}
				return array( $formName, $values );
			}
		}
		return null;
	}

	public static function getTemplateValues( $psTemplate ) {
		// TODO - fix this.
		$values = array();
		if ( $psTemplate instanceof PSTemplate ) {
			$psTemplate = $psTemplate->getXML();
		}
		foreach ( $psTemplate->children() as $tag => $child ) {
			if ( $tag == "semanticforms_TemplateDetails" ) {
				foreach ( $child->children() as $prop ) {
					$values[$prop->getName()] = (string)$prop;
				}
			}
		}
		return $values;
	}

	public static function getTemplateDisplayString() {
		return 'Details for template in form';
	}

	/**
	 * Displays form details for one template in the Page Schemas XML.
	 */
	public static function getTemplateDisplayValues( $templateXML ) {
		$templateValues = self::getTemplateValues( $templateXML );
		if ( count( $templateValues ) == 0 ) {
			return null;
		}

		$displayValues = array();
		foreach ( $templateValues as $key => $value ) {
			if ( $key == 'Label' ) {
				$propName = 'Label';
			} elseif ( $key == 'AddAnotherText' ) {
				$propName = "'Add another' button";
			}
			$displayValues[$propName] = $value;
		}
		return array( null, $displayValues );
	}

	public static function getFieldDisplayString() {
		return 'Form input';
	}

	/**
	 * Displays data on a single form input in the Page Schemas XML.
	 */
	public static function getFieldDisplayValues( $fieldXML ) {
		foreach ( $fieldXML->children() as $tag => $child ) {
			if ( $tag == "semanticforms_FormInput" ) {
				$inputName = $child->attributes()->name;
				$values = array();
				foreach ( $child->children() as $prop ) {
					if ( $prop->getName() == 'InputType' ) {
						$propName = 'Input type';
					} else {
						$propName = (string)$prop->attributes()->name;
					}
					$values[$propName] = (string)$prop;
				}
				return array( $inputName, $values );
			}
		}
		return null;
	}
}
