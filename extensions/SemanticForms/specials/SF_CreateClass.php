<?php
/**
 * A special page holding a form that allows the user to create a semantic
 * property.
 *
 * @author Yaron Koren
 * @author Sanyam Goyal
 */

if ( !defined( 'MEDIAWIKI' ) ) die();

class SFCreateClass extends SpecialPage {

	/**
	 * Constructor
	 */
	public function __construct() {
		parent::__construct( 'CreateClass', 'createclass' );
		SFUtils::loadMessages();
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

		$create_button_text = wfMsg( 'create' );

		$property_name_error_str = '';
		$save_page = $wgRequest->getCheck( 'save' );
		if ( $save_page ) {
			$template_name = trim( $wgRequest->getVal( "template_name" ) );
			$form_name = trim( $wgRequest->getVal( "form_name" ) );
			$category_name = trim( $wgRequest->getVal( "category_name" ) );
			if ( $template_name == '' | $form_name == '' || $category_name == '' ) {
				$text = Xml::element( 'p', null, wfMsg( 'sf_createclass_missingvalues' ) );
				$wgOut->addHTML( $text );
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
				$field = SFTemplateField::create( $field_name, $field_name );
				$field->semantic_property = $property_name;
				$field->is_list = $is_list;
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
			$full_text = SFTemplateField::createTemplateText( $template_name, $fields, $category_name, '', '', '' );
			$template_title = Title::makeTitleSafe( NS_TEMPLATE, $template_name );
			$template_article = new Article( $template_title );
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

			$text = Xml::element( 'p', null, wfMsg( 'sf_createclass_success' ) );
			$wgOut->addHTML( $text );
			return;
		}

		$datatype_labels = $smwgContLang->getDatatypeLabels();

		// set 'title' as hidden field, in case there's no URL niceness
		global $wgContLang;
		$mw_namespace_labels = $wgContLang->getNamespaces();
		$special_namespace = $mw_namespace_labels[NS_SPECIAL];

		// make links to all the other 'Create...' pages, in order to
		// link to them at the top of the page
		$sk = $wgUser->getSkin();
		$creation_links = array();
		$cp = SpecialPage::getPage( 'CreateProperty' );
		$creation_links[] = $sk->makeKnownLinkObj( $cp->getTitle(), $cp->getDescription() );
		$ct = SpecialPage::getPage( 'CreateTemplate' );
		$creation_links[] = $sk->makeKnownLinkObj( $ct->getTitle(), $ct->getDescription() );
		$cf = SpecialPage::getPage( 'CreateForm' );
		$creation_links[] = $sk->makeKnownLinkObj( $cf->getTitle(), $cf->getDescription() );
		$cc = SpecialPage::getPage( 'CreateCategory' );
		$creation_links[] = $sk->makeKnownLinkObj( $cc->getTitle(), $cc->getDescription() );
		$create_class_docu = wfMsg( 'sf_createclass_docu', $wgLang->listToText( $creation_links ) );
		$leave_field_blank = wfMsg( 'sf_createclass_leavefieldblank' );
		$form_name_label = wfMsg( 'sf_createform_nameinput' );
		$template_name_label = wfMsg( 'sf_createtemplate_namelabel' );
		$category_name_label = wfMsg( 'sf_createcategory_name' );
		$property_name_label = wfMsg( 'sf_createproperty_propname' );
		$field_name_label = wfMsg( 'sf_createtemplate_fieldname' );
		$type_label = wfMsg( 'sf_createproperty_proptype' );
		$allowed_values_label = wfMsg( 'sf_createclass_allowedvalues' ) . wfMsg( 'colon-separator' );
		$list_of_values_label = wfMsg( 'sf_createclass_listofvalues' ) . '?';

		$text = <<<END
                <script>
        
var NumOfRow = $numStartingRows;
function addRowDynamic(options) {
	NumOfRow++;
	// get the reference of the main div
	var mainDiv = document.getElementById('addrows');

	// create new div that will work as a container
	var newDiv = document.createElement('div');
	newDiv.setAttribute('id','innerDiv' + NumOfRow);

	//create span to contain the text
	var newtable = document.createElement('table');
	var newRow = document.createElement('tr');
	var newCol1 = document.createElement('td');
	newCol1.innerHTML="<input type=\"text\" size=\"25\" name=\"property_name_" + NumOfRow + "\" />";
	var newCol2 = document.createElement('td');
	newCol2.innerHTML="<input type=\"text\" size=\"25\" name=\"field_name_" + NumOfRow + "\" />";
	var newCol3 = document.createElement('td');
	newCol3.innerHTML = "<input type=\"text\" size=\"25\" name=\"allowed_values_" + NumOfRow + "\" />";
	var newCol4 = document.createElement('td');
	newCol4.innerHTML = "<input type=\"checkbox\"  name=\"is_list_" + NumOfRow + "\" />";

	var selectCol = document.createElement('td');
	var s = "<select id=\"property_dropdown_" + NumOfRow + "\"  name=\"property_type_" + NumOfRow + "\">" + options + "</select>";
	var optionString = "";
	var myArray = options.split(',');
 
	for (i=0; i<myArray.length-1; i++) {
		optionString += "<option>" + myArray[i] + "</option>";
	}
	selectCol.innerHTML = "<select id=\"property_dropdown_" + NumOfRow + "\"  name=\"property_type_" + NumOfRow + "\">" + optionString + "</select>";

	newRow.innerHTML = newCol1.innerHTML+newCol2.innerHTML + newCol3.innerHTML;
	newtable.innerHTML = "<tr>" + "<td>" + NumOfRow + ". " + newCol1.innerHTML + "</td>" + "<td>" + newCol2.innerHTML + "</td>" + "<td>" + selectCol.innerHTML + "</td>" + "<td>" + newCol3.innerHTML + "</td>" + "<td>" + newCol4.innerHTML + "</td></tr>";
	newDiv.appendChild(newtable);

	// finally append the new div to the main div
	mainDiv.appendChild(newDiv);
}
</script>

<form action="" method="post">
	<p>$create_class_docu</p>
	<p>$leave_field_blank</p>
	<p>$template_name_label <input type="text" size="30" name="template_name"></p>
	<p>$form_name_label: <input type="text" size="30" name="form_name"></p>
	<p>$category_name_label <input type="text" size="30" name="category_name"></p>
	<div id="addrows">
                <table>
		<tr>
			<th colspan="2">$property_name_label</th>
			<th>$field_name_label</th>
			<th>$type_label</th>
			<th>$allowed_values_label</th>
			<th>$list_of_values_label</th>
		</tr>

END;
		for ( $i = 1; $i <= $numStartingRows; $i++ ) {
			$text .= <<<END
		<tr>
			<td>$i.</td>
			<td><input type="text" size="25" name="property_name_$i" /></td>
			<td><input type="text" size="25" name="field_name_$i" /></td>
			<td>
			<select id="property_dropdown_$i" name="property_type_$i">

END;
                        $optionsStr ="";                       
			foreach ( $datatype_labels as $label ) {
				$text .= "				<option>$label</option>\n";                                
                                $optionsStr .= $label . ",";
			}
			$text .= <<<END
			</select>
			</td>
			<td><input type="text" size="25" name="allowed_values_$i" /></td>
			<td><input type="checkbox" name="is_list_$i" /></td>

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
				'onclick' => "addRowDynamic('$optionsStr')"
			)
		);
		$text .= Xml::tags( 'p', null, $add_another_button );
		$text .= Xml::element( 'input',
			array(
				'type' => 'hidden',
				'name' => 'title',
				'value' => "$special_namespace:CreateClass",
			)
		);
		$text .= Xml::element( 'input',
			array(
				'type' => 'submit',
				'name' => 'save',
				'value' => $create_button_text
			)
		);
		$text .= "</form>\n";
		$wgOut->addHTML( $text );
	}
}
