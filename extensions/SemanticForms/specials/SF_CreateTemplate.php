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
	public function __construct() {
		parent::__construct( 'CreateTemplate' );
	}

	public function execute( $query ) {
		$this->setHeaders();
		$this->printCreateTemplateForm( $query );
	}

	public static function getAllPropertyNames() {
		$all_properties = array();

		// Set limit on results - we don't want a massive dropdown
		// of properties, if there are a lot of properties in this wiki.
		// getProperties() functions stop requiring a limit
		$options = new SMWRequestOptions();
		$options->limit = 500;
		$used_properties = SFUtils::getSMWStore()->getPropertiesSpecial( $options );
		if ( $used_properties instanceof SMW\SQLStore\PropertiesCollector ) {
			// SMW 1.9+
			$used_properties = $used_properties->runCollector();
		}
		foreach ( $used_properties as $property ) {
			// Skip over properties that are errors. (This
			// shouldn't happen, but it sometimes does.)
			if ( !method_exists( $property[0], 'getKey' ) ) {
				continue;
			}
			$propName = $property[0]->getKey();
			if ( $propName{0} != '_' ) {
				$all_properties[] = str_replace( '_', ' ', $propName );
			}
		}

		$unused_properties = SFUtils::getSMWStore()->getUnusedPropertiesSpecial( $options );
		if ( $unused_properties instanceof SMW\SQLStore\UnusedPropertiesCollector ) {
			// SMW 1.9+
			$unused_properties = $unused_properties->runCollector();
		}
		foreach ( $unused_properties as $property ) {
			// Skip over properties that are errors. (This
			// shouldn't happen, but it sometimes does.)
			if ( !method_exists( $property, 'getKey' ) ) {
				continue;
			}
			$all_properties[] = str_replace( '_' , ' ', $property->getKey() );
		}

		// Sort properties list alphabetically, and get unique values
		// (for SQLStore3, getPropertiesSpecial() seems to get unused
		// properties as well).
		sort( $all_properties );
		$all_properties = array_unique( $all_properties );
		return $all_properties;
	}

	public static function printPropertiesComboBox( $all_properties, $id, $selected_property = null ) {
		$selectBody = "<option value=\"\"></option>\n";
		foreach ( $all_properties as $prop_name ) {
			$optionAttrs = array( 'value' => $prop_name );
			if ( $selected_property == $prop_name ) { $optionAttrs['selected'] = 'selected'; }
			$selectBody .= Html::element( 'option', $optionAttrs, $prop_name ) . "\n";
		}
		return Html::rawElement( 'select', array( 'id' => "semantic_property_$id", 'name' => "semantic_property_$id", 'class' => 'sfComboBox' ), $selectBody ) . "\n";
	}

	static function printFieldTypeDropdown( $id ) {
		global $wgCargoFieldTypes;

		$selectBody = '';
		foreach ( $wgCargoFieldTypes as $type ) {
			$optionAttrs = array( 'value' => $type );
			$selectBody .= Html::element( 'option', $optionAttrs, $type ) . "\n";
		}
		return Html::rawElement( 'select', array( 'id' => "field_type_$id", 'name' => "field_type_$id", ), $selectBody ) . "\n";
	}

	public static function printFieldEntryBox( $id, $all_properties, $display = true ) {
		$fieldString = $display ? '' : 'id="starterField" style="display: none"';
		$text = "\t<div class=\"fieldBox\" $fieldString>\n";
		$text .= "\t<table style=\"width: 100%;\"><tr><td>\n";
		$text .= "\t<p><label>" . wfMessage( 'sf_createtemplate_fieldname' )->text() . ' ' .
			Html::input( 'name_' . $id, null, 'text',
				array( 'size' => '15' )
			) . "</label>&nbsp;&nbsp;&nbsp;\n";
		$text .= "\t<label>" . wfMessage( 'sf_createtemplate_displaylabel' )->text() . ' ' .
			Html::input( 'label_' . $id, null, 'text',
				array( 'size' => '15' )
			) . "</label>&nbsp;&nbsp;&nbsp;\n";

		if ( defined( 'SMW_VERSION' ) ) {
			$dropdown_html = self::printPropertiesComboBox( $all_properties, $id );
			$text .= "\t<label>" . wfMessage( 'sf_createtemplate_semanticproperty' )->text() . ' ' . $dropdown_html . "</label></p>\n";
		} elseif ( defined( 'CARGO_VERSION' ) ) {
			$dropdown_html = self::printFieldTypeDropdown( $id );
			$text .= "\t<label>" . wfMessage( 'sf_createproperty_proptype' )->text() . ' ' . $dropdown_html . "</label></p>\n";
		}

		$text .= "\t<p>" . '<label><input type="checkbox" name="is_list_' . $id . '" class="isList" /> ' . wfMessage( 'sf_createtemplate_fieldislist' )->text() . "</label>&nbsp;&nbsp;&nbsp;\n";
		$text .= "\t" . '<label class="delimiter" style="display: none;">' . wfMessage( 'sf_createtemplate_delimiter' )->text() . ' ' .
			Html::input( 'delimiter_' . $id, ',', 'text',
				array( 'size' => '2' )
			) . "</label>\n";
		$text .= "\t</p>\n";
		if ( !defined( 'SMW_VERSION' ) && defined( 'CARGO_VERSION' ) ) {
			$text .= "\t<p>\n";
			$text .= "\t<label>" . wfMessage( 'sf_createproperty_allowedvalsinput' )->escaped();
			$text .= Html::input( 'allowed_values_' . $id, null, 'text',
				array( 'size' => '80' ) ) . "</label>\n";
			$text .= "\t</p>\n";
		}
		$text .= "\t</td><td>\n";
		$text .= "\t" . '<input type="button" value="' . wfMessage( 'sf_createtemplate_deletefield' )->text() . '" class="deleteField" />' . "\n";

		$text .= <<<END
</td></tr></table>
</div>

END;
		return $text;
	}

	static function addJavascript() {
		global $wgOut;

		SFUtils::addJavascriptAndCSS();

		// TODO - this should be in a JS file
		$template_name_error_str = wfMessage( 'sf_blank_error' )->escaped();
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
	newField.find(".isList").click( function() {
		jQuery(this).closest(".fieldBox").find(".delimiter").toggle();
	});
	var combobox = new sf.select2.combobox();
	combobox.apply($(newField.find('.sfComboBox')));
	jQuery('#fieldsList').append(newField);
}

function validateCreateTemplateForm() {
	templateName = jQuery('#template_name').val();
	if (templateName === '') {
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
	jQuery(".isList").click( function() {
		jQuery(this).closest(".fieldBox").find(".delimiter").toggle();
	});
	jQuery('#createTemplateForm').submit( function() { return validateCreateTemplateForm(); } );
});
</script>

END;
		$wgOut->addScript( $jsText );
	}

	static function printTemplateStyleButton( $formatStr, $formatMsg, $htmlFieldName, $curSelection ) {
		$attrs = array( 'id' => $formatStr );
		if ( $formatStr === $curSelection ) {
			$attrs['checked'] = true;
		}
		return "\t" . Html::input( $htmlFieldName, $formatStr, 'radio', $attrs ) .
			' ' . Html::element( 'label', array( 'for' => $formatStr ), wfMessage( $formatMsg )->escaped() ) . "\n";
	}

	static function printTemplateStyleInput( $htmlFieldName, $curSelection = null ) {
		if ( !$curSelection ) $curSelection = 'standard';
		$text = "\t<p>" . wfMessage( 'sf_createtemplate_outputformat' )->escaped() . "\n";
		$text .= self::printTemplateStyleButton( 'standard', 'sf_createtemplate_standardformat', $htmlFieldName, $curSelection );
		$text .= self::printTemplateStyleButton( 'infobox', 'sf_createtemplate_infoboxformat', $htmlFieldName, $curSelection );
		$text .= self::printTemplateStyleButton( 'plain', 'sf_createtemplate_plainformat', $htmlFieldName, $curSelection );
		$text .= self::printTemplateStyleButton( 'sections', 'sf_createtemplate_sectionsformat', $htmlFieldName, $curSelection );
		$text .= "</p>\n";
		return $text;
	}

	function printCreateTemplateForm( $query ) {
		global $wgOut, $wgRequest, $sfgScriptPath;

		if ( !is_null( $query ) ) {
			$presetTemplateName = str_replace( '_', ' ', $query );
			$wgOut->setPageTitle( wfMessage( 'sf-createtemplate-with-name', $presetTemplateName )->text() );
			$template_name = $presetTemplateName;
		} else {
			$presetTemplateName = null;
			$template_name = $wgRequest->getVal( 'template_name' );
		}

		self::addJavascript();

		$text = '';
		$save_page = $wgRequest->getCheck( 'wpSave' );
		$preview_page = $wgRequest->getCheck( 'wpPreview' );
		if ( $save_page || $preview_page ) {
			$validToken = $this->getUser()->matchEditToken( $wgRequest->getVal( 'csrf' ), 'CreateTemplate' );
			if ( !$validToken ) {
				$text = "This appears to be a cross-site request forgery; canceling save.";
				$wgOut->addHTML( $text );
				return;
			}

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
					$field = SFTemplateField::create(
						$val,
						$wgRequest->getVal( 'label_' . $id ),
						$wgRequest->getVal( 'semantic_property_' . $id ),
						$wgRequest->getCheck( 'is_list_' . $id ),
						$wgRequest->getVal( 'delimiter_' . $id )
					);
					// Fake attributes.
					$field->mCargoFieldType = $wgRequest->getVal( 'field_type_' . $id );
					$field->mAllowedValuesStr = $wgRequest->getVal( 'allowed_values_' . $id );
					$fields[] = $field;
				}
			}

			// Assemble the template text, and submit it as a wiki
			// page.
			$wgOut->setArticleBodyOnly( true );
			$title = Title::makeTitleSafe( NS_TEMPLATE, $template_name );
			$category = $wgRequest->getVal( 'category' );
			$cargo_table = $wgRequest->getVal( 'cargo_table' );
			$aggregating_property = $wgRequest->getVal( 'semantic_property_aggregation' );
			$aggregation_label = $wgRequest->getVal( 'aggregation_label' );
			$template_format = $wgRequest->getVal( 'template_format' );
			$sfTemplate = new SFTemplate( $template_name, $fields );
			$sfTemplate->setCategoryName( $category );
			$sfTemplate->mCargoTable = $cargo_table;
			$sfTemplate->setAggregatingInfo( $aggregating_property, $aggregation_label );
			$sfTemplate->setFormat( $template_format );
			$full_text = $sfTemplate->createText();

			$text = SFUtils::printRedirectForm( $title, $full_text, "", $save_page, $preview_page, false, false, false, null, null );
			$wgOut->addHTML( $text );
			return;
		}

		$text .= '	<form id="createTemplateForm" action="" method="post">' . "\n";
		if ( is_null( $presetTemplateName ) ) {
			// Set 'title' field, in case there's no URL niceness
			$text .= Html::hidden( 'title', $this->getTitle()->getPrefixedText() ) . "\n";
			$text .= "\t<p id=\"template_name_p\">" . wfMessage( 'sf_createtemplate_namelabel' )->escaped() . ' <input size="25" id="template_name" name="template_name" /></p>' . "\n";
		}
		$text .= "\t<p>" . wfMessage( 'sf_createtemplate_categorylabel' )->escaped() . ' <input size="25" name="category" /></p>' . "\n";
		if ( !defined( 'SMW_VERSION' ) && defined( 'CARGO_VERSION' ) ) {
			$text .= "\t<p>" . wfMessage( 'sf_createtemplate_cargotablelabel' )->escaped() . ' <input size="25" name="cargo_table" /></p>' . "\n";
		}

		$text .= "\t<fieldset>\n";
		$text .= "\t" . Html::element( 'legend', null, wfMessage( 'sf_createtemplate_templatefields' )->text() ) . "\n";
		$text .= "\t" . Html::element( 'p', null, wfMessage( 'sf_createtemplate_fieldsdesc' )->text() ) . "\n";

		if ( defined( 'SMW_VERSION' ) ) {
			$all_properties = self::getAllPropertyNames();
		} else {
			$all_properties = array();
		}
		$text .= '<div id="fieldsList">' . "\n";
		$text .= self::printFieldEntryBox( "1", $all_properties );
		$text .= self::printFieldEntryBox( "starter", $all_properties, false );
		$text .= "</div>\n";

		$add_field_button = Html::input(
			null,
			wfMessage( 'sf_createtemplate_addfield' )->text(),
			'button',
			array( 'onclick' => "createTemplateAddField()" )
		);
		$text .= Html::rawElement( 'p', null, $add_field_button ) . "\n";
		$text .= "\t</fieldset>\n";

		if ( defined( 'SMW_VERSION' ) ) {
			$text .= "\t<fieldset>\n";
			$text .= "\t" . Html::element( 'legend', null, wfMessage( 'sf_createtemplate_aggregation' )->text() ) . "\n";
			$text .= "\t" . Html::element( 'p', null, wfMessage( 'sf_createtemplate_aggregationdesc' )->text() ) . "\n";
			$text .= "\t<p>" . wfMessage( 'sf_createtemplate_semanticproperty' )->escaped() . ' ' .
				self::printPropertiesComboBox( $all_properties, "aggregation" ) . "</p>\n";
			$text .= "\t<p>" . wfMessage( 'sf_createtemplate_aggregationlabel' )->escaped() . ' ' .
				Html::input( 'aggregation_label', null, 'text',
					array( 'size' => '25' ) ) .
				"</p>\n";
			$text .= "\t</fieldset>\n";
		}

		$text .= self::printTemplateStyleInput( 'template_format' );

		$text .= "\t" . Html::hidden( 'csrf', $this->getUser()->getEditToken( 'CreateTemplate' ) ) . "\n";

		$save_button_text = wfMessage( 'savearticle' )->escaped();
		$preview_button_text = wfMessage( 'preview' )->escaped();
		$text .= <<<END
	<div class="editButtons">
	<input type="submit" id="wpSave" name="wpSave" value="$save_button_text" />
	<input type="submit" id="wpPreview" name="wpPreview" value="$preview_button_text" />
	</div>
	</form>

END;

		$wgOut->addExtensionStyle( $sfgScriptPath . "/skins/SemanticForms.css" );
		$wgOut->addHTML( $text );
	}
}
