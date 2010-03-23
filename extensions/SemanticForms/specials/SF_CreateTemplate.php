<?php
/**
 * A special page holding a form that allows the user to create a template
 * with semantic fields.
 *
 * @author Yaron Koren
 */

/**
 * Protect against register_globals vulnerabilities.
 * This line must be present before any global variable is referenced.
 */
if ( !defined( 'MEDIAWIKI' ) ) die();

class SFCreateTemplate extends SpecialPage {

	/**
	 * Constructor
	 */
	function SFCreateTemplate() {
		SpecialPage::SpecialPage( 'CreateTemplate' );
		wfLoadExtensionMessages( 'SemanticForms' );
	}

	function execute( $query ) {
		$this->setHeaders();
		doSpecialCreateTemplate();
	}

	static function getAllPropertyNames() {
		$all_properties = array();

		// set limit on results - a temporary fix until SMW's
		// getProperties() functions stop requiring a limit
		$options = new SMWRequestOptions();
		$options->limit = 10000;
		$used_properties = smwfGetStore()->getPropertiesSpecial( $options );
		foreach ( $used_properties as $property ) {
			$all_properties[] = $property[0]->getWikiValue();
		}
		$unused_properties = smwfGetStore()->getUnusedPropertiesSpecial( $options );
		foreach ( $unused_properties as $property ) {
			$all_properties[] = $property->getWikiValue();
		}

		// sort properties list alphabetically
		sort( $all_properties );
		return $all_properties;
	}

	function printPropertiesDropdown( $all_properties, $id, $selected_property ) {
		$dropdown_str = "<select name=\"semantic_property_$id\">\n";
		$dropdown_str .= "<option value=\"\"></option>\n";
		foreach ( $all_properties as $prop_name ) {
			$selected = ( $selected_property == $prop_name ) ? "selected" : "";
			$dropdown_str .= "<option value=\"$prop_name\" $selected>$prop_name</option>\n";
		}
		$dropdown_str .= "</select>\n";
		return $dropdown_str;
	}

	function printFieldEntryBox( $id, $f, $all_properties ) {
		wfLoadExtensionMessages( 'SemanticForms' );
		$dropdown_html = SFCreateTemplate::printPropertiesDropdown( $all_properties, $id, $f->semantic_property );
		$text = '	<div class="fieldBox">' . "\n";
		$text .= '	<p>' . wfMsg( 'sf_createtemplate_fieldname' ) . ' <input size="15" name="name_' . $id . '" value="' . $f->field_name . '">' . "\n";
		$text .= '	' . wfMsg( 'sf_createtemplate_displaylabel' ) . ' <input size="15" name="label_' . $id . '" value="' . $f->label . '">' . "\n";
		$text .= '	' . wfMsg( 'sf_createtemplate_semanticproperty' ) . ' ' . $dropdown_html . "</p>\n";
		$checked_str = ( $f->is_list ) ? " checked" : "";
		$text .= '	<p><input type="checkbox" name="is_list_' . $id . '"' .  $checked_str . '> ' . wfMsg( 'sf_createtemplate_fieldislist' ) . "\n";
	
		if ( $id != "new" ) {
			$text .= '	&nbsp;&nbsp;<input name="del_' . $id . '" type="submit" value="' . wfMsg( 'sf_createtemplate_deletefield' ) . '">' . "\n";
		}
		$text .= <<<END
</p>
</div>

END;
		return $text;
	}
}

function doSpecialCreateTemplate() {
	global $wgOut, $wgRequest, $wgUser, $sfgScriptPath, $wgContLang;

	wfLoadExtensionMessages( 'SemanticForms' );

	$all_properties = SFCreateTemplate::getAllPropertyNames();
	
	$template_name = $wgRequest->getVal( 'template_name' );
	$template_name_error_str = "";
	$category = $wgRequest->getVal( 'category' );
	$cur_id = 1;
	$fields = array();
	# cycle through the query values, setting the appropriate local variables
	foreach ( $wgRequest->getValues() as $var => $val ) {
		$var_elements = explode( "_", $var );
		// we only care about query variables of the form "a_b"
		if ( count( $var_elements ) != 2 )
			continue;
		list ( $field_field, $old_id ) = $var_elements;
		if ( $field_field == "name" ) {
			if ( $old_id != "new" || ( $old_id == "new" && $val != "" ) ) {
				if ( $wgRequest->getVal( 'del_' . $old_id ) != '' ) {
					# do nothing - this field won't get added to the new list
				} else {
					$field = SFTemplateField::create( $val, $wgRequest->getVal( 'label_' . $old_id ) );
					$field->semantic_property = $wgRequest->getVal( 'semantic_property_' . $old_id );
					$field->is_list = $wgRequest->getCheck( 'is_list_' . $old_id );
					$fields[] = $field;
				}
			}
		}
	}
	$aggregating_property = $wgRequest->getVal( 'semantic_property_aggregation' );
	$aggregation_label = $wgRequest->getVal( 'aggregation_label' );
	$template_format = $wgRequest->getVal( 'template_format' );

	$text = "";
	$save_button_text = wfMsg( 'savearticle' );
	$preview_button_text = wfMsg( 'preview' );
	$save_page = $wgRequest->getCheck( 'wpSave' );
	$preview_page = $wgRequest->getCheck( 'wpPreview' );
	if ( $save_page || $preview_page ) {
		# validate template name
		if ( $template_name == '' ) {
			$template_name_error_str = wfMsg( 'sf_blank_error' );
		} else {
			// redirect to wiki interface
			$wgOut->setArticleBodyOnly( true );
			$title = Title::makeTitleSafe( NS_TEMPLATE, $template_name );
			$full_text = SFTemplateField::createTemplateText( $template_name, $fields, $category, $aggregating_property, $aggregation_label, $template_format );
			$text = SFUtils::printRedirectForm( $title, $full_text, "", $save_page, $preview_page, false, false, false, null, null );
			$wgOut->addHTML( $text );
			return;
		}
	}

	$text .= '	<form action="" method="post">' . "\n";
	// set 'title' field, in case there's no URL niceness
	$mw_namespace_labels = $wgContLang->getNamespaces();
	$special_namespace = $mw_namespace_labels[NS_SPECIAL];
	$text .= '    <input type="hidden" name="title" value="' . $special_namespace . ':CreateTemplate">' . "\n";
	$text .= '	<p>' . wfMsg( 'sf_createtemplate_namelabel' ) . ' <input size="25" name="template_name" value="' . $template_name . '"> <font color="red">' . $template_name_error_str . '</font></p>' . "\n";
	$text .= '	<p>' . wfMsg( 'sf_createtemplate_categorylabel' ) . ' <input size="25" name="category" value="' . $category . '"></p>' . "\n";
	$text .= "	<fieldset>\n";
	$text .= '	' . Xml::element( 'legend', null, wfMsg( 'sf_createtemplate_templatefields' ) ) . "\n";
	$text .= '	' . Xml::element( 'p', null, wfMsg( 'sf_createtemplate_fieldsdesc' ) ) . "\n";

	foreach ( $fields as $i => $field ) {
		$text .= SFCreateTemplate::printFieldEntryBox( $i + 1, $field, $all_properties );
	}
	$new_field = new SFTemplateField();
	$text .= SFCreateTemplate::printFieldEntryBox( "new", $new_field, $all_properties );

	$text .= '	<p><input type="submit" value="' . wfMsg( 'sf_createtemplate_addfield' ) . '"></p>' . "\n";
	$text .= "	</fieldset>\n";
	$text .= "	<fieldset>\n";
	$text .= '	' . Xml::element( 'legend', null, wfMsg( 'sf_createtemplate_aggregation' ) ) . "\n";
	$text .= '	' . Xml::element( 'p', null, wfMsg( 'sf_createtemplate_aggregationdesc' ) ) . "\n";
	$text .= '	<p>' . wfMsg( 'sf_createtemplate_semanticproperty' ) . " " . SFCreateTemplate::printPropertiesDropdown( $all_properties, "aggregation", $aggregating_property ) . "</p>\n";
	$text .= '	<p>' . wfMsg( 'sf_createtemplate_aggregationlabel' ) . ' <input size="25" name="aggregation_label" value="' . $aggregation_label . '"></p>' . "\n";
	$text .= "	</fieldset>\n";
	$text .= '	<p>' . wfMsg( 'sf_createtemplate_outputformat' ) . "\n";
	$text .= '	<input type="radio" name="template_format" checked value="standard">' . wfMsg( 'sf_createtemplate_standardformat' ) . "\n";
	$text .= '	<input type="radio" name="template_format" value="infobox">' . wfMsg( 'sf_createtemplate_infoboxformat' ) . "</p>\n";
	$text .= <<<END
	<div class="editButtons">
	<input type="submit" id="wpSave" name="wpSave" value="$save_button_text">
	<input type="submit" id="wpPreview" name="wpPreview" value="$preview_button_text">
	</div>
	</form>

END;
	$sk = $wgUser->getSkin();
	$cp = SpecialPage::getPage( 'CreateProperty' );
	$create_property_link = $sk->makeKnownLinkObj( $cp->getTitle(), $cp->getDescription() );
	$text .= "	<br /><hr /><br />\n";
	$text .= "	" . Xml::tags( 'p', null, $create_property_link . '.' ) . "\n";

	$wgOut->addLink( array(
		'rel' => 'stylesheet',
		'type' => 'text/css',
		'media' => "screen",
		'href' => $sfgScriptPath . "/skins/SF_main.css"
		) );
	$wgOut->addHTML( $text );
}
