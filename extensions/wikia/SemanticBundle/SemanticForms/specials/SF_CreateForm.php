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
		SFUtils::loadMessages();
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
			$this->doSpecialCreateForm();
		}
	}

	function doSpecialCreateForm() {
		global $wgOut, $wgRequest, $wgUser, $sfgScriptPath;
		$db = wfGetDB( DB_SLAVE );

		SFUtils::loadMessages();

		// Create Javascript to populate fields to let the user input
		// parameters for the field, based on the input type selected
		// in the dropdown.
		$skin = $wgUser->getSkin();
		$url = $skin->makeSpecialUrl( 'CreateForm', "showinputtypeoptions=' + this.val() + '&formfield=' + this.attr('formfieldid') + '" );
		foreach ( $wgRequest->getValues() as $param => $value ) {
			$url .= '&params[' . Xml::escapeJsString( $param ) . ']=' . Xml::escapeJsString( $value );
		}

		// Only add 'collapsible' ability if the ResourceLoader exists,
		// i.e. for MW 1.17 - adding backwards compatibility doesn't
		// seem worth it for this relatively minor piece of
		// functionality.
		if ( method_exists( $wgOut, 'addModules' ) ) {
			$wgOut->addModules( 'ext.semanticforms.collapsible' );
		}

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
});
</script>");


		// Get the names of all templates on this site.
		$all_templates = array();
		$res = $db->select(
			'page',
			'page_title',
			array( 'page_namespace' => NS_TEMPLATE, 'page_is_redirect' => 0 ),
			array( 'ORDER BY' => 'page_title' ) 
		);
	
		if ( $db->numRows( $res ) > 0 ) {
			while ( $row = $db->fetchRow( $res ) ) {
				$template_name = str_replace( '_', ' ', $row[0] );
				$all_templates[] = $template_name;
			}
		}

		$form_templates = array();
		$i = 1;
		$deleted_template_loc = null;

		# handle inputs
		$form_name = $wgRequest->getVal( 'form_name' );
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
						$form_templates[] = $form_template;
					}
				}
			}
		}
		if ( $wgRequest->getVal( 'add_field' ) != null ) {
			$form_template = SFTemplateInForm::create( $wgRequest->getVal( 'new_template' ), "", false );
			$new_template_loc = $wgRequest->getVal( 'before_template' );
			if ( $new_template_loc === null ) { $new_template_loc = 0; }
			// @HACK - array_splice() doesn't work for objects, so
			// we have to first insert a stub element into the
			// array, then replace that with the actual object.
			array_splice( $form_templates, $new_template_loc, 0, "stub" );
			$form_templates[$new_template_loc] = $form_template;
		} else {
			$new_template_loc = null;
		}

		// Now cycle through the templates and fields, modifying each
		// one per the query variables.
		foreach ( $form_templates as $i => $ft ) {
			foreach ( $ft->getFields() as $j => $field ) {
				// handle the change in indexing if a new template was
				// inserted before the end, or one was deleted
				$old_i = $i;
				if ( $new_template_loc != null ) {
					if ( $i > $new_template_loc ) {
						$old_i = $i - 1;
					} elseif ( $i == $new_template_loc ) {
						// it's the new template; it shouldn't
						// get any query-string data
						$old_i = - 1;
					}
				} elseif ( $deleted_template_loc != null ) {
					if ( $i >= $deleted_template_loc ) {
						$old_i = $i + 1;
					}
				}
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
		}
		$form = SFForm::create( $form_name, $form_templates );

		// If a submit button was pressed, create the form-definition
		// file, then redirect.
		$save_page = $wgRequest->getCheck( 'wpSave' );
		$preview_page = $wgRequest->getCheck( 'wpPreview' );
		if ( $save_page || $preview_page ) {
			// Validate form name
			if ( $form->getFormName() == "" ) {
				$form_name_error_str = wfMsg( 'sf_blank_error' );
			} else {
				// Redirect to wiki interface
				$wgOut->setArticleBodyOnly( true );
				$title = Title::makeTitleSafe( SF_NS_FORM, $form->getFormName() );
				$full_text = $form->createMarkup();
				$text = SFUtils::printRedirectForm( $title, $full_text, "", $save_page, $preview_page, false, false, false, null, null );
				$wgOut->addHTML( $text );
				return;
			}
		}

		$text = "\t" . '<form action="" method="post">' . "\n";
		// Set 'title' field, in case there's no URL niceness
		$text .= SFFormUtils::hiddenFieldHTML( 'title', $this->getTitle()->getPrefixedText() );
		$text .= "\t<p>" . wfMsg( 'sf_createform_nameinput' ) . ' ' . wfMsg( 'sf_createform_nameinputdesc' ) . ' <input size=25 name="form_name" value="' . $form_name . '" />';
		if ( ! empty( $form_name_error_str ) )
			$text .= "\t" . Xml::element( 'font', array( 'color' => 'red' ), $form_name_error_str );
		$text .= "</p>\n";

		$text .= $form->creationHTML();

		$text .= "\t<p>" . wfMsg( 'sf_createform_addtemplate' ) . "\n";

		$select_body = "";
		foreach ( $all_templates as $template ) {
			$select_body .= "	" . Xml::element( 'option', array( 'value' => $template ), $template ) . "\n";
		}
		$text .= "\t" . Xml::tags( 'select', array( 'name' => 'new_template' ), $select_body ) . "\n";
		// If a template has already been added, show a dropdown letting
		// the user choose where in the list to add a new dropdown.
		if ( count( $form_templates ) > 0 ) {
			$before_template_msg = wfMsg( 'sf_createform_beforetemplate' );
			$text .= $before_template_msg;
			$select_body = "";
			foreach ( $form_templates as $i => $ft ) {
				$select_body .= "\t" . Xml::element( 'option', array( 'value' => $i ), $ft->getTemplateName() ) . "\n";
			}
			$final_index = count( $form_templates );
			$at_end_msg = wfMsg( 'sf_createform_atend' );
			$select_body .= "\t" . Xml::element( 'option', array( 'value' => $final_index, 'selected' => 'selected' ), $at_end_msg );
			$text .= Xml::tags( 'select', array( 'name' => 'before_template' ), $select_body ) . "\n";
		}

		// Disable 'save' and 'preview' buttons if user has not yet
		// added any templates.
		$disabled_text = ( count( $form_templates ) == 0 ) ? "disabled" : "";
		$add_button_text = wfMsg( 'sf_createform_add' );
		$sk = $wgUser->getSkin();
		$create_template_link = SFUtils::linkForSpecialPage( $sk, 'CreateTemplate' );
		$text .= "\t" . Xml::element( 'input', array( 'type' => 'submit', 'name' => 'add_field', 'value' => $add_button_text ) );
		$text .= <<<END
</p>
	<br />

END;
		$saveAttrs = array( 'type' => 'submit', 'id' => 'wpSave', 'name' => 'wpSave', 'value' => wfMsg( 'savearticle' ) );
		if ( count( $form_templates ) == 0 ) { $saveAttrs['disabled'] = 'disabled'; }
		$editButtonsText = "\t" . Xml::element( 'input', $saveAttrs ) . "\n";
		$previewAttrs = array( 'type' => 'submit', 'id' => 'wpPreview', 'name' => 'wpPreview', 'value' => wfMsg( 'preview' ) );
		if ( count( $form_templates ) == 0 ) { $previewAttrs['disabled'] = 'disabled'; }
		$editButtonsText .= "\t" . Xml::element( 'input', $previewAttrs ) . "\n";
		$text .= "\t" . Xml::tags( 'div', array( 'class' => 'editButtons' ),
			Xml::tags( 'p', array(), $editButtonsText ) . "\n" ) . "\n";
		// Explanatory message if buttons are disabled because no
		// templates have been added.
		if ( count( $form_templates ) == 0 ) {
			$text .= "\t" . Xml::element( 'p', null, "(" . wfMsg( 'sf_createtemplate_addtemplatebeforesave' ) . ")" );
		}
		$text .= <<<END
	</form>
	<hr /><br />

END;
		$text .= "\t" . Xml::tags( 'p', null, $create_template_link . '.' );

		$wgOut->addExtensionStyle( $sfgScriptPath . "/skins/SemanticForms.css" );
		$wgOut->addHTML( $text );
	}

	/**
	 * Prints an input for a form-field parameter.
	 * Code borrowed heavily from Semantic MediaWiki's
	 * SMWAskPage::addOptionInput().
	 */
	public static function inputTypeParamInput( $type, $paramName, $cur_value, array $param, array $paramValues, $fieldFormText ) {
		if ( $type == 'int' ) {
			return Xml::element( 'input', array(
				'type' => 'text',
				'name' => $paramName . '_' . $fieldFormText,
				'value' => $cur_value,
				'size' => 6
			) );
		} elseif ( $type == 'string' ) {
			return Xml::element( 'input', array(
				'type' => 'text',
				'name' => $paramName . '_' . $fieldFormText,
				'value' => $cur_value,
				'size' => 32 
			) ); 
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
			$checkboxAttrs = array(
				'type' => 'checkbox',
				'name' => $paramName . '_' . $fieldFormText
			);
			if ( $cur_value) { $checkboxAttrs['checked'] = 'checked'; }
			return Xml::element( 'input', $checkboxAttrs );
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

		$text = '';

		// Handle default types, which start with a '.' to differentiate
		// them.
		if ( substr( $inputType, 0, 1) == '.' ) {
			$inputType = substr( $inputType, 1 );
		}

		$inputTypeClass = $sfgFormPrinter->getInputType( $inputType );

		$params = method_exists( $inputTypeClass, 'getParameters' ) ? call_user_func( array( $inputTypeClass, 'getParameters' ) ) : array();

		foreach ( $params as $i => $param ) {
			$paramName = $param['name'];
			$type = $param['type'];
			$desc = $param['description'];

			$cur_value = ( array_key_exists( $paramName, $paramValues ) ) ? $paramValues[$paramName] : '';

			// 3 values per row, with alternating colors for rows
			if ( $i % 3 == 0 ) {
				$bgcolor = ( $i % 6 ) == 0 ? '#eee' : 'white';
				$text .= "<div style=\"background: $bgcolor;\">";
			}

			$text .= "<div style=\"width: 30%; padding: 5px; float: left;\">$paramName:\n";

			$text .= self::inputTypeParamInput( $type, $paramName, $cur_value, $param, array(), $fieldFormText );
			$text .= "\n<br />" . Xml::element( 'em', null, $desc ) . "\n</div>\n";

			if ( $i % 3 == 2 || $i == count( $params ) - 1 ) {
				$text .= "<div style=\"clear: both\";></div></div>\n";
			}
		}
		return $text;
	}
}
