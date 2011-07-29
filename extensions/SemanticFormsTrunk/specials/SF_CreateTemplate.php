<?php
/**
 * A special page holding a form that allows the user to create a template
 * with semantic fields.
 *
 * @author Yaron Koren
 * @file
 * @ingroup SF
 */

/**
 * @ingroup SFSpecialPages
 */
class SFCreateTemplate extends SpecialPage {

	/**
	 * Constructor
	 */
	public function SFCreateTemplate() {
		parent::__construct( 'CreateTemplate' );
		SFUtils::loadMessages();
	}

	public function execute( $query ) {
		$this->setHeaders();
		$this->printCreateTemplateForm();
	}

	public static function getAllPropertyNames() {
		$all_properties = array();

		// Set limit on results - we don't want a massive dropdown
		// of properties, if there are a lot of properties in this wiki.
		// getProperties() functions stop requiring a limit
		$options = new SMWRequestOptions();
		$options->limit = 500;
		$used_properties = smwfGetStore()->getPropertiesSpecial( $options );
		foreach ( $used_properties as $property ) {
			if ( $property[0] instanceof SMWDIProperty ) {
				// SMW 1.6+
				$propName = $property[0]->getKey();
				if ( $propName{0} != '_' ) {
					$all_properties[] = str_replace( '_', ' ', $propName );
				}
			} else {
				$all_properties[] = $property[0]->getWikiValue();
			}
		}

		$unused_properties = smwfGetStore()->getUnusedPropertiesSpecial( $options );
		foreach ( $unused_properties as $property ) {
			if ( $property instanceof SMWDIProperty ) {
				// SMW 1.6+
				$all_properties[] = str_replace( '_' , ' ', $property->getKey() );
			} else {
				$all_properties[] = $property->getWikiValue();
			}
		}

		// Sort properties list alphabetically.
		sort( $all_properties );
		return $all_properties;
	}

	public static function printPropertiesDropdown( $all_properties, $id, $selected_property = null ) {
		$selectBody = "<option value=\"\"></option>\n";
		foreach ( $all_properties as $prop_name ) {
			$optionAttrs = array( 'value' => $prop_name );
			if ( $selected_property == $prop_name ) { $optionAttrs['selected'] = 'selected'; }
			$selectBody .= Xml::element( 'option', $optionAttrs, $prop_name ) . "\n";
		}
		return Xml::tags( 'select', array( 'name' => "semantic_property_$id" ), $selectBody ) . "\n";
	}

	public static function printFieldEntryBox( $id, $all_properties, $display = true ) {
		SFUtils::loadMessages();

		$fieldString = $display ? '' : 'id="starterField" style="display: none"';
		$text = "\t<div class=\"fieldBox\" $fieldString>\n";
		$text .= "\t<p>" . wfMsg( 'sf_createtemplate_fieldname' ) . ' ' .
			Xml::element( 'input',
				array( 'size' => '15', 'name' => 'name_' . $id ), null
			) . "\n";
		$text .= "\t" . wfMsg( 'sf_createtemplate_displaylabel' ) . ' ' .
			Xml::element( 'input',
				array( 'size' => '15', 'name' => 'label_' . $id ), null
			) . "\n";

		$dropdown_html = self::printPropertiesDropdown( $all_properties, $id );
		$text .= "\t" . wfMsg( 'sf_createtemplate_semanticproperty' ) . ' ' . $dropdown_html . "</p>\n";
		$text .= "\t<p>" . '<input type="checkbox" name="is_list_' . $id . '" /> ' . wfMsg( 'sf_createtemplate_fieldislist' ) . "\n";
		$text .= '	&#160;&#160;<input type="button" value="' . wfMsg( 'sf_createtemplate_deletefield' ) . '" class="deleteField" />' . "\n";
		
		$text .= <<<END
</p>
</div>

END;
		return $text;
	}

	static function addJavascript() {
		global $wgOut;

		SFUtils::addJavascriptAndCSS();

		// TODO - this should be in a JS file
		$template_name_error_str = wfMsg( 'sf_blank_error' );
		$jsText =<<<END
<script type="text/javascript">
var fieldNum = 1;
function createTemplateAddField() {
	fieldNum++;
	newField = jQuery('#starterField').clone().css('display', '').removeAttr('id');
	newHTML = newField.html().replace(/starter/g, fieldNum);
	newField.html(newHTML);
	newField.find(".deleteField").click( function() {
		// Remove the encompassing div for this instance.
		jQuery(this).closest(".fieldBox")
			.fadeOut('fast', function() { jQuery(this).remove(); });
	});
	jQuery('#fieldsList').append(newField);
}

function validateCreateTemplateForm() {
	templateName = jQuery('#template_name').val();
	if (templateName == '') {
		scroll(0, 0);
		jQuery('#template_name_p').append(' <font color="red">$template_name_error_str</font>');
		return false;
	} else {
		return true;
	}
}

jQuery(document).ready(function() {
	jQuery(".deleteField").click( function() {
		// Remove the encompassing div for this instance.
		jQuery(this).closest(".fieldBox")
			.fadeOut('fast', function() { jQuery(this).remove(); });
	});
	jQuery('#createTemplateForm').submit( function() { return validateCreateTemplateForm(); } );
});
</script>

END;
		$wgOut->addScript( $jsText );
	}

	function printCreateTemplateForm() {
		global $wgOut, $wgRequest, $wgUser, $sfgScriptPath;

		SFUtils::loadMessages();
		self::addJavascript();

		$text = '';
		$save_page = $wgRequest->getCheck( 'wpSave' );
		$preview_page = $wgRequest->getCheck( 'wpPreview' );
		if ( $save_page || $preview_page ) {
			$fields = array();
			// Cycle through the query values, setting the
			// appropriate local variables.
			foreach ( $wgRequest->getValues() as $var => $val ) {
				$var_elements = explode( "_", $var );
				// we only care about query variables of the form "a_b"
				if ( count( $var_elements ) != 2 )
					continue;
				list ( $field_field, $id ) = $var_elements;
				if ( $field_field == 'name' && $id != 'starter' ) {
					$field = SFTemplateField::create( $val, $wgRequest->getVal( 'label_' . $id ), $wgRequest->getVal( 'semantic_property_' . $id ), $wgRequest->getCheck( 'is_list_' . $id ) );
					$fields[] = $field;
				}
			}

			// Assemble the template text, and submit it as a wiki
			// page.
			$wgOut->setArticleBodyOnly( true );
			$template_name = $wgRequest->getVal( 'template_name' );
			$title = Title::makeTitleSafe( NS_TEMPLATE, $template_name );
			$category = $wgRequest->getVal( 'category' );
			$aggregating_property = $wgRequest->getVal( 'semantic_property_aggregation' );
			$aggregation_label = $wgRequest->getVal( 'aggregation_label' );
			$template_format = $wgRequest->getVal( 'template_format' );
			$full_text = SFTemplateField::createTemplateText( $template_name, $fields, null, $category, $aggregating_property, $aggregation_label, $template_format );
			$text = SFUtils::printRedirectForm( $title, $full_text, "", $save_page, $preview_page, false, false, false, null, null );
			$wgOut->addHTML( $text );
			return;
		}

		$text .= '	<form id="createTemplateForm" action="" method="post">' . "\n";
		// Set 'title' field, in case there's no URL niceness
		$text .= SFFormUtils::hiddenFieldHTML( 'title', $this->getTitle()->getPrefixedText() );
		$text .= "\t<p id=\"template_name_p\">" . wfMsg( 'sf_createtemplate_namelabel' ) . ' <input size="25" id="template_name" name="template_name" /></p>' . "\n";
		$text .= "\t<p>" . wfMsg( 'sf_createtemplate_categorylabel' ) . ' <input size="25" name="category" /></p>' . "\n";
		$text .= "\t<fieldset>\n";
		$text .= "\t" . Xml::element( 'legend', null, wfMsg( 'sf_createtemplate_templatefields' ) ) . "\n";
		$text .= "\t" . Xml::element( 'p', null, wfMsg( 'sf_createtemplate_fieldsdesc' ) ) . "\n";

		$all_properties = self::getAllPropertyNames();
		$text .= '<div id="fieldsList">' . "\n";
		$text .= self::printFieldEntryBox( "1", $all_properties );
		$text .= self::printFieldEntryBox( "starter", $all_properties, false );
		$text .= "</div>\n";

		$add_field_button = Xml::element( 'input',
			array(
				'type' => 'button',
				'value' => wfMsg( 'sf_createtemplate_addfield' ),
				'onclick' => "createTemplateAddField()"
			)
		);
		$text .= Xml::tags( 'p', null, $add_field_button ) . "\n";
		$text .= "\t</fieldset>\n";
		$text .= "\t<fieldset>\n";
		$text .= "\t" . Xml::element( 'legend', null, wfMsg( 'sf_createtemplate_aggregation' ) ) . "\n";
		$text .= "\t" . Xml::element( 'p', null, wfMsg( 'sf_createtemplate_aggregationdesc' ) ) . "\n";
		$text .= "\t<p>" . wfMsg( 'sf_createtemplate_semanticproperty' ) . ' ' .
			self::printPropertiesDropdown( $all_properties, "aggregation" ) . "</p>\n";
		$text .= "\t<p>" . wfMsg( 'sf_createtemplate_aggregationlabel' ) . ' ' .
		Xml::element( 'input',
			array( 'size' => '25', 'name' => 'aggregation_label' ), null ) .
			"</p>\n";
		$text .= "\t</fieldset>\n";
		$text .= "\t<p>" . wfMsg( 'sf_createtemplate_outputformat' ) . "\n";
		$text .= "\t" . Xml::element( 'input', array(
			'type' => 'radio',
			'name' => 'template_format',
			'checked' => 'checked',
			'value' => 'standard'
		), null ) . ' ' . wfMsg( 'sf_createtemplate_standardformat' ) . "\n";
		$text .= "\t" . Xml::element( 'input',
			array( 'type' => 'radio', 'name' => 'template_format', 'value' => 'infobox'), null ) .
			' ' . wfMsg( 'sf_createtemplate_infoboxformat' ) . "</p>\n";
		$save_button_text = wfMsg( 'savearticle' );
		$preview_button_text = wfMsg( 'preview' );
		$text .= <<<END
	<div class="editButtons">
	<input type="submit" id="wpSave" name="wpSave" value="$save_button_text" />
	<input type="submit" id="wpPreview" name="wpPreview" value="$preview_button_text" />
	</div>
	</form>

END;
		$sk = $wgUser->getSkin();
		$create_property_link = SFUtils::linkForSpecialPage( $sk, 'CreateProperty' );
		$text .= "\t<br /><hr /><br />\n";
		$text .= "\t" . Xml::tags( 'p', null, $create_property_link . '.' ) . "\n";

		$wgOut->addExtensionStyle( $sfgScriptPath . "/skins/SemanticForms.css" );
		$wgOut->addHTML( $text );
	}

}
