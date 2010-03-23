<?php
/**
 * A special page holding a form that allows the user to create a semantic
 * property.
 *
 * @author Yaron Koren
 */

if ( !defined( 'MEDIAWIKI' ) ) die();

class SFCreateProperty extends SpecialPage {

	/**
	 * Constructor
	 */
	function SFCreateProperty() {
		SpecialPage::SpecialPage( 'CreateProperty' );
		wfLoadExtensionMessages( 'SemanticForms' );
	}

	function execute( $query ) {
		$this->setHeaders();
		doSpecialCreateProperty();
	}

	function createPropertyText( $property_type, $default_form, $allowed_values_str ) {
		global $smwgContLang;
		$prop_labels = $smwgContLang->getPropertyLabels();
		$type_tag = "[[{$prop_labels['_TYPE']}::$property_type]]";
		$text = wfMsgForContent( 'sf_property_isproperty', $type_tag );
		if ( $default_form != '' ) {
			global $sfgContLang;
			$sf_prop_labels = $sfgContLang->getPropertyLabels();
			$default_form_tag = "[[{$sf_prop_labels[SF_SP_HAS_DEFAULT_FORM]}::$default_form]]";
			$text .= ' ' . wfMsgForContent( 'sf_property_linkstoform', $default_form_tag );
		}
		if ( $allowed_values_str != '' ) {
			// replace the comma substitution character that has no chance of
			// being included in the values list - namely, the ASCII beep
			global $sfgListSeparator;
			$allowed_values_str = str_replace( "\\$sfgListSeparator", "\a", $allowed_values_str );
			$allowed_values_array = explode( $sfgListSeparator, $allowed_values_str );
			$text .= "\n\n" . wfMsgExt( 'sf_property_allowedvals', array( 'parsemag', 'content' ), count( $allowed_values_array ) );
			foreach ( $allowed_values_array as $i => $value ) {
				// replace beep back with comma, trim
				$value = str_replace( "\a", $sfgListSeparator, trim( $value ) );
				if ( method_exists( $smwgContLang, 'getPropertyLabels' ) ) {
					$prop_labels = $smwgContLang->getPropertyLabels();
					$text .= "\n* [[" . $prop_labels['_PVAL'] . "::$value]]";
				} else {
					$spec_props = $smwgContLang->getSpecialPropertiesArray();
					$text .= "\n* [[" . $spec_props[SMW_SP_POSSIBLE_VALUE] . "::$value]]";
				}
			}
		}
		return $text;
	}

}

function doSpecialCreateProperty() {
	global $wgOut, $wgRequest, $sfgScriptPath;
	global $smwgContLang;

	wfLoadExtensionMessages( 'SemanticForms' );

	# cycle through the query values, setting the appropriate local variables
	$property_name = $wgRequest->getVal( 'property_name' );
	$property_type = $wgRequest->getVal( 'property_type' );
	$default_form = $wgRequest->getVal( 'default_form' );
	$allowed_values = $wgRequest->getVal( 'values' );

	$save_button_text = wfMsg( 'savearticle' );
	$preview_button_text = wfMsg( 'preview' );

	$property_name_error_str = '';
	$save_page = $wgRequest->getCheck( 'wpSave' );
	$preview_page = $wgRequest->getCheck( 'wpPreview' );
	if ( $save_page || $preview_page ) {
		# validate property name
		if ( $property_name == '' ) {
			$property_name_error_str = wfMsg( 'sf_blank_error' );
		} else {
			# redirect to wiki interface
			$wgOut->setArticleBodyOnly( true );
			$title = Title::makeTitleSafe( SMW_NS_PROPERTY, $property_name );
			$full_text = SFCreateProperty::createPropertyText( $property_type, $default_form, $allowed_values );
			$text = SFUtils::printRedirectForm( $title, $full_text, "", $save_page, $preview_page, false, false, false, null, null );
			$wgOut->addHTML( $text );
			return;
		}
	}

	$datatype_labels = $smwgContLang->getDatatypeLabels();

	$javascript_text = <<<END
function toggleDefaultForm(property_type) {
	var default_form_div = document.getElementById("default_form_div");
	if (property_type == '{$datatype_labels['_wpg']}') {
		default_form_div.style.display = "";
	} else {
		default_form_div.style.display = "none";
	}
}

END;

	// set 'title' as hidden field, in case there's no URL niceness
	global $wgContLang;
	$mw_namespace_labels = $wgContLang->getNamespaces();
	$special_namespace = $mw_namespace_labels[NS_SPECIAL];
	$name_label = wfMsg( 'sf_createproperty_propname' );
	$type_label = wfMsg( 'sf_createproperty_proptype' );
	$text = <<<END
	<form action="" method="post">
	<input type="hidden" name="title" value="$special_namespace:CreateProperty">
	<p>$name_label <input size="25" name="property_name" value="">
	<span style="color: red;">$property_name_error_str</span>
	$type_label
END;
	$select_body = "";
	foreach ( $datatype_labels as $label ) {
		$select_body .= "	" . Xml::element( 'option', null, $label ) . "\n";
	}
	$text .= Xml::tags( 'select', array( 'id' => 'property_dropdown', 'name' => 'property_type', 'onChange' => 'toggleDefaultForm(this.value);' ), $select_body ) . "\n";

	$default_form_input = wfMsg( 'sf_createproperty_linktoform' );
	$values_input = wfMsg( 'sf_createproperty_allowedvalsinput' );
	$text .= <<<END
	<div id="default_form_div" style="padding: 5px 0 5px 0; margin: 7px 0 7px 0;">
	<p>$default_form_input
	<input size="20" name="default_form" value=""></p>
	</div>
	<div id="allowed_values" style="margin-bottom: 15px;">
	<p>$values_input</p>
	<p><input size="80" name="values" value=""></p>
	</div>

END;
	$edit_buttons = '	' . Xml::element( 'input', array( 'id' => 'wpSave', 'type' => 'submit', 'name' => 'wpSave', 'value' => $save_button_text ) );
	$edit_buttons .= '	' . Xml::element( 'input', array( 'id' => 'wpPreview', 'type' => 'submit', 'name' => 'wpPreview', 'value' => $preview_button_text ) );
	$text .= '	' . Xml::tags( 'div', array( 'class' => 'editButtons' ), $edit_buttons ) . "\n";
	$text .= "	</form>\n";

	$wgOut->addLink( array(
		'rel' => 'stylesheet',
		'type' => 'text/css',
		'media' => "screen",
		'href' => $sfgScriptPath . "/skins/SF_main.css"
	) );
	$wgOut->addScript( '<script type="text/javascript">' . $javascript_text . '</script>' );
	$wgOut->addHTML( $text );
}
