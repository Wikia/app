<?php
/**
 * A special page holding a form that allows the user to create a semantic
 * property.
 *
 * @author Yaron Koren
 * @author Sanyam Goyal
 * @file
 * @ingroup SF
 */

/**
 * @ingroup SFSpecialPages
 */
class SFCreateClass extends SpecialPage {
	/**
	 * Constructor
	 */
	public function __construct() {
		parent::__construct( 'CreateClass', 'createclass' );
	}

	public function doesWrites() {
		return true;
	}

	function createAllPages() {
		$out = $this->getOutput();
		$req = $this->getRequest();
		$user = $this->getUser();

		$template_name = trim( $req->getVal( "template_name" ) );
		$template_multiple = $req->getBool( "template_multiple" );
		// If this is a multiple-instance template, there
		// shouldn't be a corresponding form or category.
		if ( $template_multiple ) {
			$form_name = null;
			$category_name = null;
		} else {
			$form_name = trim( $req->getVal( "form_name" ) );
			$category_name = trim( $req->getVal( "category_name" ) );
		}
		if ( $template_name === '' || ( !$template_multiple && ( $form_name === '' || $category_name === '' ) ) ) {
			$out->addWikiMsg( 'sf_createclass_missingvalues' );
			return;
		}
		$fields = array();
		$jobs = array();
		// Cycle through all the rows passed in.
		for ( $i = 1; $req->getVal( "field_name_$i" ) != ''; $i++ ) {
			// Go through the query values, setting the appropriate
			// local variables.
			$field_name = trim( $req->getVal( "field_name_$i" ) );
			$property_name = trim( $req->getVal( "property_name_$i" ) );
			$property_type = $req->getVal( "property_type_$i" );
			$allowed_values = $req->getVal( "allowed_values_$i" );
			$is_list = $req->getCheck( "is_list_$i" );
			// Create an SFTemplateField object based on these
			// values, and add it to the $fields array.
			$field = SFTemplateField::create( $field_name, $field_name, $property_name, $is_list );

			if ( defined( 'CARGO_VERSION' ) ) {
				$field->setFieldType( $property_type );
				// Hopefully it's safe to use a Cargo
				// utility method here.
				$possibleValues = CargoUtils::smartSplit( ',', $allowed_values );
				$field->setPossibleValues( $possibleValues );
			}

			$fields[] = $field;

			// Create the property, and make a job for it.
			if ( defined( 'SMW_VERSION' ) && !empty( $property_name ) ) {
				$full_text = SFCreateProperty::createPropertyText( $property_type, '', $allowed_values );
				$property_title = Title::makeTitleSafe( SMW_NS_PROPERTY, $property_name );
				$params = array();
				$params['user_id'] = $user->getId();
				$params['page_text'] = $full_text;
				$params['edit_summary'] = wfMessage( 'sf_createproperty_editsummary', $property_type)->inContentLanguage()->text();
				$jobs[] = new SFCreatePageJob( $property_title, $params );
			}
		}

		// Also create the "connecting property", if there is one.
		$connectingProperty = trim( $req->getVal('connecting_property') );
		if ( defined( 'SMW_VERSION' ) && $connectingProperty != '' ) {
			global $smwgContLang;
			$datatypeLabels = $smwgContLang->getDatatypeLabels();
			$property_type = $datatypeLabels['_wpg'];
			$full_text = SFCreateProperty::createPropertyText( $property_type, '', $allowed_values );
			$property_title = Title::makeTitleSafe( SMW_NS_PROPERTY, $connectingProperty );
			$params = array();
			$params['user_id'] = $user->getId();
			$params['page_text'] = $full_text;
			$params['edit_summary'] = wfMessage( 'sf_createproperty_editsummary', $property_type)->inContentLanguage()->text();
			$jobs[] = new SFCreatePageJob( $property_title, $params );
		}

		// Create the template, and save it (might as well save
		// one page, instead of just creating jobs for all of them).
		$template_format = $req->getVal( "template_format" );
		$sfTemplate = new SFTemplate( $template_name, $fields );
		if ( defined( 'CARGO_VERSION' ) ) {
			$sfTemplate->mCargoTable = trim( $req->getVal( "cargo_table" ) );
		}
		if ( defined( 'SMW_VERSION' ) && $template_multiple ) {
			$sfTemplate->setConnectingProperty( $connectingProperty );
		} else {
			$sfTemplate->setCategoryName( $category_name );
		}
		$sfTemplate->setFormat( $template_format );
		$full_text = $sfTemplate->createText();

		$template_title = Title::makeTitleSafe( NS_TEMPLATE, $template_name );
		$edit_summary = '';
		if ( method_exists( 'WikiPage', 'doEditContent' ) ) {
			// MW 1.21+
			$template_page = new WikiPage( $template_title );
			$content = new WikitextContent( $full_text );
			$template_page->doEditContent( $content, $edit_summary );
		} else {
			// MW <= 1.20
			$template_article = new Article( $template_title );
			$template_article->doEdit( $full_text, $edit_summary );
		}

		// Create the form, and make a job for it.
		if ( $form_name != '' ) {
			$form_template = SFTemplateInForm::create( $template_name, '', false );
			$form_items = array();
			$form_items[] = array( 'type' => 'template',
							'name' => $form_template->getTemplateName(),
							'item' => $form_template );
			$form = SFForm::create( $form_name, $form_items );
			$full_text = $form->createMarkup();
			$form_title = Title::makeTitleSafe( SF_NS_FORM, $form_name );
			$params = array();
			$params['user_id'] = $user->getId();
			$params['page_text'] = $full_text;
			$jobs[] = new SFCreatePageJob( $form_title, $params );
		}

		// Create the category, and make a job for it.
		if ( $category_name != '' ) {
			$full_text = SFCreateCategory::createCategoryText( $form_name, $category_name, '' );
			$category_title = Title::makeTitleSafe( NS_CATEGORY, $category_name );
			$params = array();
			$params['user_id'] = $user->getId();
			$params['page_text'] = $full_text;
			$jobs[] = new SFCreatePageJob( $category_title, $params );
		}

		if ( class_exists( 'JobQueueGroup' ) ) {
			JobQueueGroup::singleton()->push( $jobs );
		} else {
			// MW <= 1.20
			Job::batchInsert( $jobs );
		}

		$out->addWikiMsg( 'sf_createclass_success' );
	}

	function execute( $query ) {
		global $wgLang, $smwgContLang;

		$out = $this->getOutput();
		$req = $this->getRequest();

		// Check permissions.
		if ( !$this->getUser()->isAllowed( 'createclass' ) ) {
			$this->displayRestrictionError();
			return;
		}

		$this->setHeaders();

		$numStartingRows = 5;
		$out->addJsConfigVars( '$numStartingRows', $numStartingRows );
		$out->addModules( array( 'ext.semanticforms.SF_CreateClass' ) );

		$createAll = $req->getCheck( 'createAll' );
		if ( $createAll ) {
			// Guard against cross-site request forgeries (CSRF).
			$validToken = $this->getUser()->matchEditToken( $req->getVal( 'csrf' ), 'CreateClass' );
			if ( !$validToken ) {
				$text = "This appears to be a cross-site request forgery; canceling save.";
				$out->addHTML( $text );
				return;
			}

			$this->createAllPages();
			return;
		}

		$specialBGColor = '#eeffcc';
		if ( defined( 'SMW_VERSION' ) ) {
			$possibleTypes = $smwgContLang->getDatatypeLabels();
		} elseif ( defined( 'CARGO_VERSION' ) ) {
			global $wgCargoFieldTypes;
			$possibleTypes = $wgCargoFieldTypes;
			$specialBGColor = '';
		} else {
			$possibleTypes = array();
		}

		// Make links to all the other 'Create...' pages, in order to
		// link to them at the top of the page.
		$creation_links = array();
		if ( defined( 'SMW_VERSION' ) ) {
			$creation_links[] = SFUtils::linkForSpecialPage( 'CreateProperty' );
		}
		$creation_links[] = SFUtils::linkForSpecialPage( 'CreateTemplate' );
		$creation_links[] = SFUtils::linkForSpecialPage( 'CreateForm' );
		$creation_links[] = SFUtils::linkForSpecialPage( 'CreateCategory' );

		$text = '<form action="" method="post">' . "\n";
		$text .= "\t" . Html::rawElement( 'p', null,
				wfMessage( 'sf_createclass_docu' )
					->rawParams( $wgLang->listToText( $creation_links ) )
					->escaped() ) . "\n";
		$templateNameLabel = wfMessage( 'sf_createtemplate_namelabel' )->escaped();
		$templateNameInput = Html::input( 'template_name', null, 'text', array( 'size' => 30 ) );
		$text .= "\t" . Html::rawElement( 'p', null, $templateNameLabel . ' ' . $templateNameInput ) . "\n";
		$templateInfo = SFCreateTemplate::printTemplateStyleInput( 'template_format' );
		$templateInfo .= Html::rawElement( 'p', null,
			Html::element( 'input', array(
				'type' => 'checkbox',
				'name' => 'template_multiple',
				'id' => 'template_multiple',
				'class' => "disableFormAndCategoryInputs",
			) ) . ' ' . wfMessage( 'sf_createtemplate_multipleinstance' )->escaped() ) . "\n";
		// Either #set_internal or #subobject will be added to the
		// template, depending on whether Semantic Internal Objects is
		// installed.
		global $smwgDefaultStore;
		if ( defined( 'SIO_VERSION' ) || $smwgDefaultStore == "SMWSQLStore3" ) {
			$templateInfo .= Html::rawElement( 'div',
				array (
					'id' => 'connecting_property_div',
					'style' => 'display: none;',
				),
				wfMessage( 'sf_createtemplate_connectingproperty' )->escaped() . "\n" .
				Html::element( 'input', array(
					'type' => 'text',
					'name' => 'connecting_property',
				) ) ) . "\n";
		}
		$text .= Html::rawElement( 'blockquote', null, $templateInfo );

		$form_name_label = wfMessage( 'sf_createclass_nameinput' )->text();
		$text .= "\t" . Html::rawElement( 'p', null, Html::element( 'label', array( 'for' => 'form_name' ), $form_name_label ) . ' ' . Html::element( 'input', array( 'size' => '30', 'name' => 'form_name', 'id' => 'form_name' ), null ) ) . "\n";
		$category_name_label = wfMessage( 'sf_createcategory_name' )->text();
		$text .= "\t" . Html::rawElement( 'p', null, Html::element( 'label', array( 'for' => 'category_name' ), $category_name_label ) . ' ' . Html::element( 'input', array( 'size' => '30', 'name' => 'category_name', 'id' => 'category_name' ), null ) ) . "\n";
		if ( defined( 'CARGO_VERSION' ) && !defined( 'SMW_VERSION' ) ) {
			$cargo_table_label = wfMessage( 'sf_createtemplate_cargotablelabel' )->escaped();
			$text .= "\t" . Html::rawElement( 'p', null, Html::element( 'label', array( 'for' => 'cargo_table' ), $cargo_table_label ) . ' ' . Html::element( 'input', array( 'size' => '30', 'name' => 'cargo_table', 'id' => 'cargo_table' ), null ) ) . "\n";
		}
		$text .= "\t" . Html::element( 'br', null, null ) . "\n";
		$text .= <<<END
	<div>
		<table id="mainTable" style="border-collapse: collapse;">

END;
		if ( defined( 'SMW_VERSION' ) ) {
			$property_label = wfMessage( 'smw_pp_type' )->escaped();
			$text .= <<<END
		<tr>
			<th colspan="3" />
			<th colspan="3" style="background: #ddeebb; padding: 4px;">$property_label</th>
		</tr>

END;
		}

		$field_name_label = wfMessage( 'sf_createtemplate_fieldname' )->escaped();
		$list_of_values_label = wfMessage( 'sf_createclass_listofvalues' )->escaped();
		$text .= <<<END
		<tr>
			<th colspan="2">$field_name_label</th>
			<th style="padding: 4px;">$list_of_values_label</th>

END;
		if ( defined( 'SMW_VERSION' ) ) {
			$property_name_label = wfMessage( 'sf_createproperty_propname' )->escaped();
			$text .= <<<END
			<th style="background: $specialBGColor; padding: 4px;">$property_name_label</th>

END;
		}

		$type_label = wfMessage( 'sf_createproperty_proptype' )->escaped();
		$allowed_values_label = wfMessage( 'sf_createclass_allowedvalues' )->escaped();
		$text .= <<<END
			<th style="background: $specialBGColor; padding: 4px;">$type_label</th>
			<th style="background: $specialBGColor; padding: 4px;">$allowed_values_label</th>
		</tr>

END;
		// Make one more row than what we're displaying - use the
		// last row as a "starter row", to be cloned when the
		// "Add another" button is pressed.
		for ( $i = 1; $i <= $numStartingRows + 1; $i++ ) {
			if ( $i == $numStartingRows + 1 ) {
				$rowString = 'id="starterRow" style="display: none"';
				$n = 'starter';
			} else {
				$rowString = '';
				$n = $i;
			}
			$text .= <<<END
		<tr $rowString style="margin: 4px;">
			<td>$n.</td>
			<td><input type="text" size="25" name="field_name_$n" /></td>
			<td style="text-align: center;"><input type="checkbox" name="is_list_$n" /></td>

END;
		if ( defined( 'SMW_VERSION' ) ) {
			$text .= <<<END
			<td style="background: $specialBGColor; padding: 4px;"><input type="text" size="25" name="property_name_$n" /></td>

END;
		}
		$text .= <<<END
			<td style="background: $specialBGColor; padding: 4px;">

END;
			$typeDropdownBody = '';
			foreach ( $possibleTypes as $typeName ) {
				$typeDropdownBody .= "\t\t\t\t<option>$typeName</option>\n";
			}
			$text .= "\t\t\t\t" . Html::rawElement( 'select', array( 'name' => "property_type_$n" ), $typeDropdownBody ) . "\n";
			$text .= <<<END
			</td>
			<td style="background: $specialBGColor; padding: 4px;"><input type="text" size="25" name="allowed_values_$n" /></td>

END;
		}
		$text .= <<<END
		</tr>
		</table>
	</div>

END;
		$add_another_button = Html::element( 'input',
			array(
				'type' => 'button',
				'value' => wfMessage( 'sf_formedit_addanother' )->text(),
				'class' => "createClassAddRow"
			)
		);
		$text .= Html::rawElement( 'p', null, $add_another_button ) . "\n";
		// Set 'title' as hidden field, in case there's no URL niceness
		$cc = $this->getTitle();
		$text .= Html::hidden( 'title', SFUtils::titleURLString( $cc ) );

		$text .= "\t" . Html::hidden( 'csrf', $this->getUser()->getEditToken( 'CreateClass' ) ) . "\n";

		$text .= Html::element( 'input',
			array(
				'type' => 'submit',
				'name' => 'createAll',
				'value' => wfMessage( 'sf_createclass_create' )->text()
			)
		);
		$text .= "</form>\n";
		$out->addHTML( $text );
	}

	protected function getGroupName() {
		return 'sf_group';
	}
}
