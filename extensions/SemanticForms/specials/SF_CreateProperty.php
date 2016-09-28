<?php
/**
 * A special page holding a form that allows the user to create a semantic
 * property.
 *
 * @author Yaron Koren
 * @file
 * @ingroup SF
 */

/**
 * @ingroup SFSpecialPages
 */
class SFCreateProperty extends SpecialPage {

	/**
	 * Constructor
	 */
	function __construct() {
		parent::__construct( 'CreateProperty' );
	}

	function execute( $query ) {
		$this->setHeaders();
		$this->printCreatePropertyForm( $query );
	}

	static function createPropertyText( $property_type, $default_form, $allowed_values_str ) {
		global $smwgContLang;
		$prop_labels = $smwgContLang->getPropertyLabels();
		$type_tag = "[[{$prop_labels['_TYPE']}::$property_type]]";
		$text = wfMessage( 'sf_property_isproperty', $type_tag )->inContentLanguage()->text();
		if ( $default_form !== '' ) {
			global $sfgContLang;
			$sf_prop_labels = $sfgContLang->getPropertyLabels();
			$default_form_tag = "[[{$sf_prop_labels[SF_SP_HAS_DEFAULT_FORM]}::$default_form]]";
			$text .= ' ' . wfMessage( 'sf_property_linkstoform', $default_form_tag )->inContentLanguage()->text();
		}
		if ( $allowed_values_str !== '' ) {
			// replace the comma substitution character that has no chance of
			// being included in the values list - namely, the ASCII beep
			global $sfgListSeparator;
			$allowed_values_str = str_replace( "\\$sfgListSeparator", "\a", $allowed_values_str );
			$allowed_values_array = explode( $sfgListSeparator, $allowed_values_str );
			$text .= "\n\n" . wfMessage( 'sf_property_allowedvals' )
				->numParams( count( $allowed_values_array ) )->inContentLanguage()->text();
			foreach ( $allowed_values_array as $i => $value ) {
				if ( $value == '' ) continue;
				// replace beep back with comma, trim
				$value = str_replace( "\a", $sfgListSeparator, trim( $value ) );
				$prop_labels = $smwgContLang->getPropertyLabels();
				$text .= "\n* [[" . $prop_labels['_PVAL'] . "::$value]]";
			}
		}
		return $text;
	}

	function printCreatePropertyForm( $query ) {
		global $smwgContLang;

		$out = $this->getOutput();
		$req = $this->getRequest();

		// Cycle through the query values, setting the appropriate
		// local variables.
		$presetPropertyName = str_replace( '_', ' ', $query );
		if ( $presetPropertyName !== '' ) {
			$out->setPageTitle( wfMessage( 'sf-createproperty-with-name', $presetPropertyName)->text() );
			$property_name = $presetPropertyName;
		} else {
			$property_name = $req->getVal( 'property_name' );
		}
		$property_type = $req->getVal( 'property_type' );
		$default_form = $req->getVal( 'default_form' );
		$allowed_values = $req->getVal( 'values' );

		$save_button_text = wfMessage( 'savearticle' )->text();
		$preview_button_text = wfMessage( 'preview' )->text();

		$property_name_error_str = '';
		$save_page = $req->getCheck( 'wpSave' );
		$preview_page = $req->getCheck( 'wpPreview' );
		if ( $save_page || $preview_page ) {
			$validToken = $this->getUser()->matchEditToken( $req->getVal( 'csrf' ), 'CreateProperty' );
			if ( !$validToken ) {
				$text = "This appears to be a cross-site request forgery; canceling save.";
				$out->addHTML( $text );
				return;
			}

			// Validate property name.
			if ( $property_name === '' ) {
				$property_name_error_str = wfMessage( 'sf_blank_error' )->text();
			} else {
				// Redirect to wiki interface.
				$out->setArticleBodyOnly( true );
				$title = Title::makeTitleSafe( SMW_NS_PROPERTY, $property_name );
				$full_text = self::createPropertyText( $property_type, $default_form, $allowed_values );
				$edit_summary = wfMessage( 'sf_createproperty_editsummary', $property_type)->inContentLanguage()->text();
				$text = SFUtils::printRedirectForm( $title, $full_text, $edit_summary, $save_page, $preview_page, false, false, false, null, null );
				$out->addHTML( $text );
				return;
			}
		}

		$datatypeLabels = $smwgContLang->getDatatypeLabels();
		$pageTypeLabel = $datatypeLabels['_wpg'];
		if ( array_key_exists( '_str', $datatypeLabels ) ) {
			$stringTypeLabel = $datatypeLabels['_str'];
		} else {
			$stringTypeLabel = $datatypeLabels['_txt'];
		}
		$numberTypeLabel = $datatypeLabels['_num'];
		$emailTypeLabel = $datatypeLabels['_ema'];

		global $wgContLang;
		$mw_namespace_labels = $wgContLang->getNamespaces();
		$name_label = wfMessage( 'sf_createproperty_propname' )->escaped();
		$type_label = wfMessage( 'sf_createproperty_proptype' )->escaped();
		$text = <<<END
	<form action="" method="post">

END;
		$text .= "\n<p>";
		// set 'title' as hidden field, in case there's no URL niceness
		if ( $presetPropertyName === '' ) {
			$text .= Html::hidden( 'title', $this->getTitle()->getPrefixedText() ) . "\n";
			$text .= "$name_label\n";
			$text .= Html::input ( 'property_name', '', array( 'size' => 25 ) );
			$text .= Html::element( 'span', array( 'style' => "color: red;" ), $property_name_error_str );
		}
		$text .= "\n$type_label\n";
		$select_body = "";
		foreach ( $datatypeLabels as $label ) {
			$select_body .= "\t" . Html::element( 'option', null, $label ) . "\n";
		}
		$text .= Html::rawElement( 'select', array( 'id' => 'property_dropdown', 'name' => 'property_type'  ), $select_body ) . "\n";

		$default_form_input = wfMessage( 'sf_createproperty_linktoform' )->escaped();
		$values_input = wfMessage( 'sf_createproperty_allowedvalsinput' )->escaped();
		$text .= <<<END
	<div id="default_form_div" style="padding: 5px 0 5px 0; margin: 7px 0 7px 0;">
	<p>$default_form_input
	<input size="20" name="default_form" value="" /></p>
	</div>
	<div id="allowed_values" style="margin-bottom: 15px;">
	<p>$values_input</p>
	<p><input size="80" name="values" value="" /></p>
	</div>

END;

		$text .= "\t" . Html::hidden( 'csrf', $this->getUser()->getEditToken( 'CreateProperty' ) ) . "\n";

		$edit_buttons = "\t" . Html::input( 'wpSave', $save_button_text, 'submit', array( 'id' => 'wpSave' ) );
		$edit_buttons .= "\t" . Html::input( 'wpPreview', $preview_button_text, 'submit', array( 'id' => 'wpPreview' ) );
		$text .= "\t" . Html::rawElement( 'div', array( 'class' => 'editButtons' ), $edit_buttons ) . "\n";
		$text .= "\t</form>\n";

		$out->addJsConfigVars( 'wgPageTypeLabel', $pageTypeLabel );
		$out->addJsConfigVars( 'wgStringTypeLabel', $stringTypeLabel );
		$out->addJsConfigVars( 'wgNumberTypeLabel', $numberTypeLabel );
		$out->addJsConfigVars( 'wgEmailTypeLabel', $emailTypeLabel );

		$out->addModules( array( 'ext.semanticforms.SF_CreateProperty' ) );
		$out->addHTML( $text );
	}

	protected function getGroupName() {
		return 'sf_group';
	}
}
