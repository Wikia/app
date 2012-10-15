<?php
/**
 * A special page holding a form that allows the user to create a category
 * page, with SF forms associated with it
 *
 * @author Yaron Koren
 * @file
 * @ingroup SF
 */

/**
 * @ingroup SFSpecialPages
 */
class SFCreateCategory extends SpecialPage {

	/**
	 * Constructor
	 */
	function __construct() {
		parent::__construct( 'CreateCategory' );
	}

	static function createCategoryText( $default_form, $category_name, $parent_category ) {

		if ( $default_form === '' ) {
			$text = wfMsgForContent( 'sf_category_desc', $category_name );
		} else {
			global $sfgContLang;
			$specprops = $sfgContLang->getPropertyLabels();
			$form_tag = "[[" . $specprops[SF_SP_HAS_DEFAULT_FORM] . "::$default_form]]";
			$text = wfMsgForContent( 'sf_category_hasdefaultform', $form_tag );
		}
		if ( $parent_category !== '' ) {
			global $wgContLang;
			$namespace_labels = $wgContLang->getNamespaces();
			$category_namespace = $namespace_labels[NS_CATEGORY];
			$text .= "\n\n[[$category_namespace:$parent_category]]";
		}
		return $text;
	}

	function execute( $query ) {
		global $wgOut, $wgRequest, $wgUser, $sfgScriptPath;

		$this->setHeaders();

		// Cycle through the query values, setting the appropriate
		// local variables.
		$category_name = $wgRequest->getVal( 'category_name' );
		$default_form = $wgRequest->getVal( 'default_form' );
		$parent_category = $wgRequest->getVal( 'parent_category' );

		$category_name_error_str = null;
		$save_page = $wgRequest->getCheck( 'wpSave' );
		$preview_page = $wgRequest->getCheck( 'wpPreview' );
		if ( $save_page || $preview_page ) {
			// Validate category name
			if ( $category_name === '' ) {
				$category_name_error_str = wfMsg( 'sf_blank_error' );
			} else {
				// Redirect to wiki interface
				$wgOut->setArticleBodyOnly( true );
				$title = Title::makeTitleSafe( NS_CATEGORY, $category_name );
				$full_text = SFCreateCategory::createCategoryText( $default_form, $category_name, $parent_category );
				$text = SFUtils::printRedirectForm( $title, $full_text, "", $save_page, $preview_page, false, false, false, null, null );
				$wgOut->addHTML( $text );
				return;
			}
		}

		$all_forms = SFUtils::getAllForms();

		// Set 'title' as hidden field, in case there's no URL niceness
		global $wgContLang;
		$mw_namespace_labels = $wgContLang->getNamespaces();
		$special_namespace = $mw_namespace_labels[NS_SPECIAL];
		$text = <<<END
	<form action="" method="get">

END;
		$text .= "\t" . Html::hidden( 'title', "$special_namespace:CreateCategory" ) . "\n";
		$firstRow = wfMsg( 'sf_createcategory_name' ) . ' ' .
			Html::input( 'category_name', null, 'text',
				array( 'size' => 25 ) ) . "\n";
		if ( !is_null( $category_name_error_str ) ) {
			$firstRow .= Html::element( 'span',
				array( 'style' => 'color: red;' ),
				$category_name_error_str ) . "\n";
		}
		$firstRow .= "\t" . wfMsg( 'sf_createcategory_defaultform' ) . "\n";
		$formSelector = "\t" . Html::element( 'option', null, null ). "\n";
		foreach ( $all_forms as $form ) {
			$formSelector .= "\t" . Html::element( 'option', null, $form ) . "\n";
		}

		$firstRow .= Html::rawElement( 'select',
			array( 'id' => 'form_dropdown', 'name' => 'default_form' ),
			$formSelector );
		$text .= Html::rawElement( 'p', null, $firstRow );
		$subcategory_label = wfMsg( 'sf_createcategory_makesubcategory' );
		$text .= <<<END
	<p>$subcategory_label
	<select id="category_dropdown" name="parent_category">
	<option></option>

END;
		$categories = SFUtils::getCategoriesForPage();
		foreach ( $categories as $category ) {
			$category = str_replace( '_', ' ', $category );
			$text .= "\t" . Html::element( 'option', null, $category ) . "\n";
		}
		$text .= "\t</select>\n";
		$editButtonsText = "\t" . Html::input( 'wpSave', wfMsg( 'savearticle' ), 'submit', array( 'id' => 'wpSave' ) ) . "\n";
		$editButtonsText .= "\t" . Html::input( 'wpPreview', wfMsg( 'preview' ), 'submit', array( 'id' => 'wpPreview' ) ) . "\n";
		$text .= "\t" . Html::rawElement( 'div', array( 'class' => 'editButtons' ), $editButtonsText ) . "\n";
		$text .= <<<END
	<br /><hr /<br />

END;

		$sk = $wgUser->getSkin();
		$create_form_link = SFUtils::linkForSpecialPage( $sk, 'CreateForm' );
		$text .= "\t" . Html::rawElement( 'p', null, $create_form_link . '.' ) . "\n";
		$text .= "\t</form>\n";

		$wgOut->addExtensionStyle( $sfgScriptPath . "/skins/SemanticForms.css" );
		$wgOut->addHTML( $text );
	}
}
