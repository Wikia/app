<?php
/**
 * A special page holding a form that allows the user to create a data-entry
 * form.
 *
 * @author Yaron Koren
 * @file
 * @ingroup SF
 */

/**
 * @ingroup SFSpecialPages
 */
class SFCreateForm extends SpecialPage {

	/**
	 * Constructor
	 */
	function __construct() {
		parent::__construct( 'CreateForm' );
	}

	function execute( $query ) {
		global $wgRequest, $wgOut;

		$this->setHeaders();
		if ( $wgRequest->getCheck( 'showinputtypeoptions' ) ) {
			$wgOut->disable();

			// handle Ajax action
			$inputType = $wgRequest->getVal( 'showinputtypeoptions' );
			$fieldFormText = $wgRequest->getVal( 'formfield' );
			$paramValues = array();
			foreach ( $wgRequest->getArray('params') as $key => $value ) {
				if ( ( $pos = strpos( $key, '_' . $fieldFormText ) ) != false ) {
					$paramName = substr( $key, 0, $pos );
					// Spaces got replaced by underlines in
					// the query.
					$paramName = str_replace( '_', ' ', $paramName );
					$paramValues[$paramName] = $value;
				}
			}
			echo self::showInputTypeOptions( $inputType, $fieldFormText, $paramValues );
		} else {
			$this->doSpecialCreateForm( $query );
		}
	}

	function doSpecialCreateForm( $query ) {
		global $wgOut, $wgRequest, $sfgScriptPath;
		$db = wfGetDB( DB_SLAVE );

		if ( !is_null( $query ) ) {
			$presetFormName = str_replace( '_', ' ', $query );
			$wgOut->setPageTitle( wfMessage( 'sf-createform-with-name', $presetFormName )->text() );
			$form_name = $presetFormName;
		} else {
			$presetFormName = null;
			$form_name = $wgRequest->getVal( 'form_name' );
		}

		// Create Javascript to populate fields to let the user input
		// parameters for the field, based on the input type selected
		// in the dropdown.
		$url = Skin::makeSpecialUrl( 'CreateForm', "showinputtypeoptions=' + this.val() + '&formfield=' + this.attr('formfieldid') + '" );
		foreach ( $wgRequest->getValues() as $param => $value ) {
			$url .= '&params[' . Xml::escapeJsString( $param ) . ']=' . Xml::escapeJsString( $value );
		}

		$wgOut->addModules( 'ext.semanticforms.collapsible' );
		$section_name_error_str = '<font color="red" id="section_error">' . wfMessage( 'sf_blank_error' )->escaped() . '</font>';

		$wgOut->addScript("<script>
jQuery.fn.displayInputParams = function() {
	inputParamsDiv = this.closest('.formField').find('.otherInputParams');
	jQuery.ajax({
		url: '$url',
		context: document.body,
		success: function(data){
			inputParamsDiv.html(data);
		}
	});
};
jQuery(document).ready(function() {
	jQuery('.inputTypeSelector').change( function() {
		jQuery(this).displayInputParams();
	});
	jQuery('#addsection').click( function(event) {
	if(jQuery('#sectionname').val() == '') {
			event.preventDefault();
			jQuery('#section_error').remove();
			jQuery('<div/>').append('$section_name_error_str').appendTo('#sectionerror');
	}
    });
});
</script>");


		// Get the names of all templates on this site.
		$all_templates = array();
		$res = $db->select(
			'page',
			'page_title',
			array( 'page_namespace' => NS_TEMPLATE, 'page_is_redirect' => 0 ),
			__METHOD__,
			array( 'ORDER BY' => 'page_title' )
		);

		if ( $db->numRows( $res ) > 0 ) {
			while ( $row = $db->fetchRow( $res ) ) {
				$template_name = str_replace( '_', ' ', $row[0] );
				$all_templates[] = $template_name;
			}
		}

		$deleted_template_loc = null;
		$deleted_section_loc = null;
		// To keep the templates and sections
		$form_items = array();

		// Handle inputs.
		foreach ( $wgRequest->getValues() as $var => $val ) {
			# ignore variables that are not of the right form
			if ( strpos( $var, "_" ) != false ) {
				# get the template declarations and work from there
				list ( $action, $id ) = explode( "_", $var, 2 );
				if ( $action == "template" ) {
					// If the button was pressed to remove
					// this template, just don't add it to
					// the array.
					if ( $wgRequest->getVal( "del_$id" ) != null ) {
						$deleted_template_loc = $id;
					} else {
						$form_template = SFTemplateInForm::create( $val,
							$wgRequest->getVal( "label_$id" ),
							$wgRequest->getVal( "allow_multiple_$id" ) );
						$form_items[] = array( 'type' => 'template',
							'name' => $form_template->getTemplateName(),
							'item' => $form_template );
					}
				} elseif ( $action == "section" ) {
					if ( $wgRequest->getVal( "delsection_$id" ) != null ) {
						$deleted_section_loc = $id;
					} else {
						$form_section = SFPageSection::create( $val );
						$form_items[] = array( 'type' => 'section',
							'name' => $form_section->getSectionName(),
							'item' => $form_section );
					}
				}
			}
		}
		if ( $wgRequest->getVal( 'add_field' ) != null ) {
			$form_template = SFTemplateInForm::create( $wgRequest->getVal( 'new_template' ), "", false );
			$template_loc = $wgRequest->getVal( 'before_template' );
			$template_count = 0;
			if ( $template_loc === null ) {
				$new_template_loc = 0;
				$template_loc = 0;
			} else {
				// Count the number of templates before the
				// location of the template to be added
				for ( $i = 0; $i < $template_loc; $i++ ) {
					if ( $form_items[$i]['type'] == 'template' ) {
						$template_count++;
					}
				}
				$new_template_loc = $template_count;
			}
			// @HACK - array_splice() doesn't work for objects, so
			// we have to first insert a stub element into the
			// array, then replace that with the actual object.
			array_splice( $form_items, $template_loc, 0, "stub" );
			$form_items[$template_loc] = array( 'type' => 'template', 'name' => $form_template->getTemplateName(), 'item' => $form_template );
		} else {
			$template_loc = null;
			$new_template_loc = null;
		}

		if ( $wgRequest->getVal( 'add_section' ) != null ) {
			$form_section = SFPageSection::create( $wgRequest->getVal( 'sectionname' ) );
			$section_loc = $wgRequest->getVal( 'before_section' );
			$section_count = 0;
			if ( $section_loc === null ) {
				$new_section_loc = 0;
				$section_loc = 0;
				} else {
					// Count the number of sections before the
					// location of the section to be added
					for ( $i = 0; $i < $section_loc; $i++ ) {
						if ( $form_items[$i]['type'] == 'section' ) {
							$section_count++;
						}
					}
					$new_section_loc = $section_count;
				}
			// The same used hack for templates
			array_splice( $form_items, $section_loc, 0, "stub" );
			$form_items[$section_loc] = array( 'type' => 'section', 'name' => $form_section->getSectionName(), 'item' => $form_section );
		} else {
			$section_loc = null;
			$new_section_loc = null;
		}

		// Now cycle through the templates and fields, modifying each
		// one per the query variables.
		$templates = 0; $sections = 0;
		foreach ( $form_items as $fi ) {
			if ( $fi['type'] == 'template' ) {
				foreach ( $fi['item']->getFields() as $j => $field ) {

					$old_i = SFFormUtils::getChangedIndex( $templates, $new_template_loc, $deleted_template_loc );
					foreach ( $wgRequest->getValues() as $key => $value ) {
						if ( ( $pos = strpos( $key, '_' . $old_i . '_' . $j ) ) != false ) {
							$paramName = substr( $key, 0, $pos );
							// Spaces got replaced by
							// underlines in the query.
							$paramName = str_replace( '_', ' ', $paramName );
						} else {
							continue;
						}

						if ( $paramName == 'label' ) {
							$field->template_field->setLabel( $value );
						} elseif ( $paramName == 'input type' ) {
							$input_type = $wgRequest->getVal( "input_type_" . $old_i . "_" . $j );
							if ( $input_type == 'hidden' ) {
								$field->template_field->setInputType( $input_type );
								$field->setIsHidden( true );
							} elseif ( substr( $input_type, 0, 1 ) == '.' ) {
								// It's the default input type -
								// don't do anything.
							} else {
								$field->template_field->setInputType( $input_type );
							}
						} else {
							if ( ! empty( $value ) ) {
								if ( $value == 'on' ) {
									$value = true;
								}
								$field->setFieldArg( $paramName, $value );
							}
						}
					}
				}
				$templates++;

			} elseif ( $fi['type'] == 'section' ) {
				$section = $fi['item'];
				$old_i = SFFormUtils::getChangedIndex( $sections, $new_section_loc, $deleted_section_loc );
				foreach ( $wgRequest->getValues() as $key => $value ) {
					if ( ( $pos = strpos( $key, '_section_' . $old_i ) ) != false ) {
						$paramName = substr( $key, 0, $pos );
						$paramName = str_replace( '_', ' ', $paramName );
					} else {
						continue;
					}

						if ( !empty( $value ) ) {
							if ( $value == 'on' ) {
								$value = true;
							}
							if ( $paramName == 'level' ) {
								$section->setSectionLevel( $value );
							} elseif ( $paramName == 'hidden' ) {
								$section->setIsHidden( $value );
							} elseif ( $paramName == 'restricted' ) {
								$section->setIsRestricted( $value );
							} elseif ( $paramName == 'mandatory' ) {
								$section->setIsMandatory( $value );
							} else {
								$section->setSectionArgs( $paramName, $value );
							}
						}
				}
				$sections++;
			}

		}

		$form = SFForm::create( $form_name, $form_items );

		// If a submit button was pressed, create the form-definition
		// file, then redirect.
		$save_page = $wgRequest->getCheck( 'wpSave' );
		$preview_page = $wgRequest->getCheck( 'wpPreview' );
		if ( $save_page || $preview_page ) {
			$validToken = $this->getUser()->matchEditToken( $wgRequest->getVal( 'csrf' ), 'CreateForm' );
			if ( !$validToken ) {
				$text = "This appears to be a cross-site request forgery; canceling save.";
				$wgOut->addHTML( $text );
				return;
			}

			// Validate form name.
			if ( $form->getFormName() == "" ) {
				$form_name_error_str = wfMessage( 'sf_blank_error' )->text();
			} else {
				// Redirect to wiki interface.
				$wgOut->setArticleBodyOnly( true );
				$title = Title::makeTitleSafe( SF_NS_FORM, $form->getFormName() );
				$full_text = $form->createMarkup();
				$text = SFUtils::printRedirectForm( $title, $full_text, "", $save_page, $preview_page, false, false, false, null, null );
				$wgOut->addHTML( $text );
				return;
			}
		}

		$text = "\t" . '<form action="" method="post">' . "\n";
		if ( is_null( $presetFormName ) ) {
			// Set 'title' field, in case there's no URL niceness
			$text .= Html::hidden( 'title', $this->getTitle()->getPrefixedText() );
			$text .= "\n\t<p>" . wfMessage( 'sf_createform_nameinput' )->escaped() . ' ' . wfMessage( 'sf_createform_nameinputdesc' )->escaped() . Html::input( 'form_name', $form_name, 'text', array( 'size'=> 25 ) );
			if ( ! empty( $form_name_error_str ) ) {
				$text .= "\t" . Html::element( 'font', array( 'color' => 'red' ), $form_name_error_str );
			}
			$text .= "</p>\n";
		}

		$text .= $form->creationHTML();

		$text .= "<h2> " . wfMessage( 'sf_createform_addelements' )->escaped() . " </h2>";
		$text .= "\t<p>" . wfMessage( 'sf_createform_addtemplate' )->escaped() . "\n";

		$select_body = "";
		foreach ( $all_templates as $template ) {
			$select_body .= "	" . Html::element( 'option', array( 'value' => $template ), $template ) . "\n";
		}
		$text .= "\t" . Html::rawElement( 'select', array( 'name' => 'new_template' ), $select_body ) . "\n";

		// If a template has already been added, show a dropdown letting
		// the user choose where in the list to add a new dropdown.
		$select_body = "";
		foreach ( $form_items as $i => $fi ) {
			if ( $fi['type'] == 'template' ) {
				$option_str = wfMessage( 'sf_createform_template' )->escaped();
			} elseif ( $fi['type'] == 'section' ) {
				$option_str = wfMessage( 'sf_createform_pagesection' )->escaped();
			}
			$option_str .= $fi['name'];
			$select_body .= "\t" . Html::element( 'option', array( 'value' => $i ), $option_str ) . "\n";
		}
		$final_index = count( $form_items );
		$at_end_msg = wfMessage( 'sf_createform_atend' )->escaped();
		$select_body .= "\t" . Html::element( 'option', array( 'value' => $final_index, 'selected' => 'selected' ), $at_end_msg );

		// Selection for before which item this template should be placed
		if ( count( $form_items ) > 0 ) {
			$text .= wfMessage( 'sf_createform_before' )->escaped();
			$text .= Html::rawElement( 'select', array( 'name' => 'before_template' ), $select_body ) . "\n";
		}

		// Disable 'save' and 'preview' buttons if user has not yet
		// added any templates.
		$add_button_text = wfMessage( 'sf_createform_add' )->text();
		$text .= "\t" . Html::input( 'add_field', $add_button_text, 'submit' ) . "\n";

		// The form HTML for page sections
		$text .= "</br></br>" . Html::rawElement( 'span', null, wfMessage( 'sf_createform_addsection' )->text() . ":" ) . "\n";
		$text .= Html::input( 'sectionname', '', 'text', array( 'size' => '30', 'placeholder' => wfMessage( 'sf_createform_sectionname' )->text(), 'id' => 'sectionname' ) ) . "\n";

		// Selection for before which item this section should be placed
		if ( count( $form_items ) > 0 ) {
			$text .= wfMessage( 'sf_createform_before' )->escaped();
			$text .= Html::rawElement( 'select', array( 'name' => 'before_section' ), $select_body ) . "\n";
		}

		$add_section_text = wfMessage( 'sf_createform_addsection' )->text();
		$text .= "\t" . Html::input( 'add_section', $add_section_text, 'submit', array( 'id' => 'addsection' ) );
		$text .= "\n\t" . Html::rawElement( 'div', array( 'id' => 'sectionerror' ) );
		$text .= <<<END
</p>
	<br />

END;

		$text .= "\t" . Html::hidden( 'csrf', $this->getUser()->getEditToken( 'CreateForm' ) ) . "\n";

		$saveAttrs = array( 'id' => 'wpSave' );
		if ( count( $form_items ) == 0 ) {
			$saveAttrs['disabled'] = true;
		}
		$editButtonsText = "\t" . Html::input( 'wpSave', wfMessage( 'savearticle' )->text(), 'submit', $saveAttrs ) . "\n";
		$previewAttrs = array( 'id' => 'wpPreview' );
		if ( count( $form_items ) == 0 ) {
			$previewAttrs['disabled'] = true;
		}
		$editButtonsText .= "\t" . Html::input( 'wpPreview',  wfMessage( 'preview' )->text(), 'submit', $previewAttrs ) . "\n";
		$text .= "\t" . Html::rawElement( 'div', array( 'class' => 'editButtons' ),
			Html::rawElement( 'p', array(), $editButtonsText ) . "\n" ) . "\n";
		// Explanatory message if buttons are disabled because no
		// templates have been added.
		if ( count( $form_items ) == 0 ) {
			$text .= "\t" . Html::element( 'p', null, "(" . wfMessage( 'sf_createform_additembeforesave' )->text() . ")" );
		}
		$text .= <<<END
	</form>

END;

		$wgOut->addExtensionStyle( $sfgScriptPath . "/skins/SemanticForms.css" );
		$wgOut->addHTML( $text );

		//Don't submit the form if enter is pressed on a text input box or a select
		$wgOut->addScript('<script>
		jQuery("input,select").keypress(function(event) { return event.keyCode != 13; });
		</script>');
	}

	/**
	 * Prints an input for a form-field parameter.
	 * Code borrowed from Semantic MediaWiki's
	 * SMWAskPage::addOptionInput().
	 */
	public static function inputTypeParamInput( $type, $paramName, $cur_value, array $param, array $paramValues, $fieldFormText ) {
		if ( $type == 'int' ) {
			return Html::input(
				$paramName . '_' . $fieldFormText,
				$cur_value,
				'text',
				array( 'size' => 6 )
			);
		} elseif ( $type == 'string' ) {
			return Html::input(
				$paramName . '_' . $fieldFormText,
				$cur_value,
				'text',
				array( 'size' => 32 )
			);
		} elseif ( $type == 'text' ) {
			return Html::element( 'textarea', array(
				'name' => $paramName . '_' . $fieldFormText,
				'rows' => 4
			), $cur_value );
		} elseif ( $type == 'enumeration' ) {
			$text = '<select name="p[' . htmlspecialchars( $paramName ) . ']">';
			$text .= "\n	<option value=''></option>\n";

			$parts = array();
			foreach ( $param['values'] as $value ) {
				$parts[] = '<option value="' . htmlspecialchars( $value ) . '"' .
				( $cur_value == $value ? ' selected' : '' ) . '>' .
				htmlspecialchars( $value ) . '</option>';
			}

			$text .= implode( "\n", $parts ) . "\n</select>";
			return $text;
		} elseif ( $type == 'enum-list' ) {
			$cur_values = explode( ',', $cur_value );
			foreach ( $param['values'] as $val ) {
				$text .= '<span style="white-space: nowrap; padding-right: 5px;"><input type="checkbox" name="p[' .
					htmlspecialchars( $paramName ) . '][' . htmlspecialchars( $val ). ']" value="true"' .
					( in_array( $val, $cur_values ) ? ' checked' : '' ) . '/> <tt>' . htmlspecialchars( $val ) . "</tt></span>\n";
			}
			return $text;
		} elseif ( $type == 'boolean' ) {
			$checkboxAttrs = array();
			if ( $cur_value) { $checkboxAttrs['checked'] = true; }
			return Html::input( $paramName . '_' . $fieldFormText, null, 'checkbox', $checkboxAttrs );
		}
	}

	/**
	 * Display a form section showing the options for a given format,
	 * based on the getParameters() value for that format's query printer.
	 *
	 * @param string $format
	 * @param array $paramValues
	 *
	 * @return string
	 */
	public static function showInputTypeOptions( $inputType, $fieldFormText, $paramValues ) {
		global $sfgFormPrinter;
		global $wgParser;

		$text = '';

		// Handle default types, which start with a '.' to differentiate
		// them.
		if ( substr( $inputType, 0, 1) == '.' ) {
			$inputType = substr( $inputType, 1 );
		}

		$inputTypeClass = $sfgFormPrinter->getInputType( $inputType );

		$params = method_exists( $inputTypeClass, 'getParameters' ) ? call_user_func( array( $inputTypeClass, 'getParameters' ) ) : array();

		$i = 0;
		foreach ( $params as $param ) {
			$paramName = $param['name'];
			$type = $param['type'];
			$desc = $wgParser->parse( $param['description'], new Title(), new ParserOptions() )->getText();

			if ( array_key_exists( $paramName, $paramValues ) ) {
				$cur_value = $paramValues[$paramName];
			} elseif ( array_key_exists( 'default', $param ) ) {
				$cur_value = $param['default'];
			} else {
				$cur_value = '';
			}

			// 3 values per row, with alternating colors for rows
			if ( $i % 3 == 0 ) {
				$bgcolor = ( $i % 6 ) == 0 ? '#eee' : 'white';
				$text .= "<div style=\"background: $bgcolor;\">";
			}

			$text .= "<div style=\"width: 30%; padding: 5px; float: left;\">$paramName:\n";

			$text .= self::inputTypeParamInput( $type, $paramName, $cur_value, $param, array(), $fieldFormText );
			$text .= "\n<br />" . Html::rawElement( 'em', null, $desc ) . "\n</div>\n";

			if ( $i % 3 == 2 || $i == count( $params ) - 1 ) {
				$text .= "<div style=\"clear: both\";></div></div>\n";
			}
			++$i;
		}
		return $text;
	}

	/**
	 * Display other parameters for a page section
	 *
	 * @return string
	 */
	public static function showSectionParameters( $section_count, $paramValues ) {
		global $wgParser;

		$text = '';
		$descriptiontext = '';
		$section_text = 'section_' . $section_count;

		$params = SFPageSection::getParameters();
		$i = 0;
		foreach ( $params as $param ) {
			$paramName = $param['name'];
			$type = $param['type'];
			$desc = $wgParser->parse( $param['description'], new Title(), new ParserOptions() )->getText();

			if ( array_key_exists( $paramName, $paramValues ) ) {
				$cur_value = $paramValues[$paramName];
			} elseif ( array_key_exists( 'default', $param ) ) {
				$cur_value = $param['default'];
			} else {
				$cur_value = '';
			}

			// 3 values per row, with alternating colors for rows
			if ( $i % 3 == 0 ) {
				$bgcolor = ( $i % 6 ) == 0 ? '#ecf0f6' : 'white';
				$text .= "<div style=\"background: $bgcolor;\">";
			}

			$text .= "<div style=\"width: 30%; padding: 5px; float: left;\">$paramName:\n";

			$text .= self::inputTypeParamInput( $type, $paramName, $cur_value, $param, array(), $section_text );
			$text .= "\n<br />" . Html::rawElement( 'em', null, $desc ) . "\n</div>\n";
			if ( $i % 3 == 2 || $i == count( $params ) - 1 ) {
				$text .= "<div style=\"clear: both\";></div></div>\n";
			}
			++$i;
		}
		return $text;
	 }
}
