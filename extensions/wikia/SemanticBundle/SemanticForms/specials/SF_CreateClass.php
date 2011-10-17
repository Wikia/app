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
		SFUtils::loadMessages();
	}

	static function addJavascript( $numStartingRows ) {
		global $wgOut;

		SFUtils::addJavascriptAndCSS();

		$jsText =<<<END
<script>
var rowNum = $numStartingRows;
function createClassAddRow() {
	rowNum++;
	newRow = jQuery('#starterRow').clone().css('display', '');
	newHTML = newRow.html().replace(/starter/g, rowNum);
	newRow.html(newHTML);
	jQuery('#mainTable').append(newRow);
}

</script>

END;
		$wgOut->addScript( $jsText );
	}

	function execute( $query ) {
		global $wgOut, $wgRequest, $wgUser, $sfgScriptPath;
		global $wgLang, $smwgContLang;

		# Check permissions
		if ( !$wgUser->isAllowed( 'createclass' ) ) {
			$this->displayRestrictionError();
			return;
		}

		$this->setHeaders();
		$wgOut->addExtensionStyle( $sfgScriptPath . "/skins/SemanticForms.css" );
		$numStartingRows = 10;
		self::addJavascript( $numStartingRows );

		$property_name_error_str = '';
		$save_page = $wgRequest->getCheck( 'save' );
		if ( $save_page ) {
			$template_name = trim( $wgRequest->getVal( "template_name" ) );
			$form_name = trim( $wgRequest->getVal( "form_name" ) );
			$category_name = trim( $wgRequest->getVal( "category_name" ) );
			if ( $template_name == '' | $form_name == '' || $category_name == '' ) {
				$wgOut->addWikiMsg( 'sf_createclass_missingvalues' );
				return;
			}
			$fields = array();
			$jobs = array();
			// cycle through all the rows passed in
			for ( $i = 1; $wgRequest->getCheck( "property_name_$i" ); $i++ ) {
				// go through the query values, setting the appropriate local variables
				$property_name = trim( $wgRequest->getVal( "property_name_$i" ) );
				if ( empty( $property_name ) ) continue;
				$field_name = trim( $wgRequest->getVal( "field_name_$i" ) );
				if ( $field_name === '' )
					$field_name = $property_name;
				$property_type = $wgRequest->getVal( "property_type_$i" );
				$allowed_values = $wgRequest->getVal( "allowed_values_$i" );
				$is_list = $wgRequest->getCheck( "is_list_$i" );
				// create an SFTemplateField based on these
				// values, and add it to the $fields array
				$field = SFTemplateField::create( $field_name, $field_name, $property_name, $is_list );
				$fields[] = $field;

				// create the property, and make a job for it
				$full_text = SFCreateProperty::createPropertyText( $property_type, '', $allowed_values );
				$property_title = Title::makeTitleSafe( SMW_NS_PROPERTY, $property_name );
				$params = array();
				$params['user_id'] = $wgUser->getId();
				$params['page_text'] = $full_text;
				$jobs[] = new SFCreatePageJob( $property_title, $params );
			}

			// create the template, and save it
			$full_text = SFTemplateField::createTemplateText( $template_name, $fields, null, $category_name, null, null, null );
			$template_title = Title::makeTitleSafe( NS_TEMPLATE, $template_name );
			$template_article = new Article( $template_title, 0 );
			$edit_summary = '';
			$template_article->doEdit( $full_text, $edit_summary );

			// create the form, and make a job for it
			$form_template = SFTemplateInForm::create( $template_name, '', false );
			$form_templates = array( $form_template );
			$form = SFForm::create( $form_name, $form_templates );
			$full_text = $form->createMarkup();
			$form_title = Title::makeTitleSafe( SF_NS_FORM, $form_name );
			$params = array();
			$params['user_id'] = $wgUser->getId();
			$params['page_text'] = $full_text;
			$jobs[] = new SFCreatePageJob( $form_title, $params );

			// create the category, and make a job for it
			$full_text = SFCreateCategory::createCategoryText( $form_name, $category_name, '' );
			$category_title = Title::makeTitleSafe( NS_CATEGORY, $category_name );
			$params = array();
			$params['user_id'] = $wgUser->getId();
			$params['page_text'] = $full_text;
			$jobs[] = new SFCreatePageJob( $category_title, $params );
			Job::batchInsert( $jobs );

			$wgOut->addWikiMsg( 'sf_createclass_success' );
			return;
		}

		$datatype_labels = $smwgContLang->getDatatypeLabels();

		// make links to all the other 'Create...' pages, in order to
		// link to them at the top of the page
		$sk = $wgUser->getSkin();
		$creation_links = array();
		$creation_links[] = SFUtils::linkForSpecialPage( $sk, 'CreateProperty' );
		$creation_links[] = SFUtils::linkForSpecialPage( $sk, 'CreateTemplate' );
		$creation_links[] = SFUtils::linkForSpecialPage( $sk, 'CreateForm' );
		$creation_links[] = SFUtils::linkForSpecialPage( $sk, 'CreateCategory' );
		$create_class_docu = wfMsg( 'sf_createclass_docu', $wgLang->listToText( $creation_links ) );
		$leave_field_blank = wfMsg( 'sf_createclass_leavefieldblank' );
		$form_name_label = wfMsg( 'sf_createclass_nameinput' );
		$template_name_label = wfMsg( 'sf_createtemplate_namelabel' );
		$category_name_label = wfMsg( 'sf_createcategory_name' );
		$property_name_label = wfMsg( 'sf_createproperty_propname' );
		$field_name_label = wfMsg( 'sf_createtemplate_fieldname' );
		$type_label = wfMsg( 'sf_createproperty_proptype' );
		$allowed_values_label = wfMsg( 'sf_createclass_allowedvalues' );
		$list_of_values_label = wfMsg( 'sf_createclass_listofvalues' );

		$text = <<<END
<form action="" method="post">
	<p>$create_class_docu</p>
	<p>$leave_field_blank</p>
	<p>$template_name_label <input type="text" size="30" name="template_name"></p>
	<p>$form_name_label <input type="text" size="30" name="form_name"></p>
	<p>$category_name_label <input type="text" size="30" name="category_name"></p>
	<div>
		<table id="mainTable">
		<tr>
			<th colspan="2">$property_name_label</th>
			<th>$field_name_label</th>
			<th>$type_label</th>
			<th>$allowed_values_label</th>
			<th>$list_of_values_label</th>
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
		<tr $rowString>
			<td>$n.</td>
			<td><input type="text" size="25" name="property_name_$n" /></td>
			<td><input type="text" size="25" name="field_name_$n" /></td>
			<td>
			<select name="property_type_$n">

END;
			$optionsStr ="";
			foreach ( $datatype_labels as $label ) {
				$text .= "				<option>$label</option>\n";
				$optionsStr .= $label . ",";
			}
			$text .= <<<END
			</select>
			</td>
			<td><input type="text" size="25" name="allowed_values_$n" /></td>
			<td><input type="checkbox" name="is_list_$n" /></td>

END;
		}
		$text .= <<<END
		</tr>
		</table>
	</div>

END;
		$add_another_button = Xml::element( 'input',
			array(
				'type' => 'button',
				'value' => wfMsg( 'sf_formedit_addanother' ),
				'onclick' => "createClassAddRow()"
			)
		);
		$text .= Xml::tags( 'p', null, $add_another_button ) . "\n";
		// Set 'title' as hidden field, in case there's no URL niceness
		$cc = $this->getTitle();
		$text .= SFFormUtils::hiddenFieldHTML( 'title', SFUtils::titleURLString( $cc ) );
		$text .= Xml::element( 'input',
			array(
				'type' => 'submit',
				'name' => 'save',
				'value' => wfMsg( 'sf_createclass_create' )
			)
		);
		$text .= "</form>\n";
		$wgOut->addHTML( $text );
	}
}
