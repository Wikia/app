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
		SFUtils::loadMessages();
	}

	function execute( $query ) {
		$this->setHeaders();
		doSpecialCreateCategory();
	}

	static function createCategoryText( $default_form, $category_name, $parent_category ) {
		SFUtils::loadMessages();

		if ( $default_form == '' ) {
			$text = wfMsgForContent( 'sf_category_desc', $category_name );
		} else {
			global $sfgContLang;
			$specprops = $sfgContLang->getPropertyLabels();
			$form_tag = "[[" . $specprops[SF_SP_HAS_DEFAULT_FORM] . "::$default_form]]";
			$text = wfMsgForContent( 'sf_category_hasdefaultform', $form_tag );
		}
		if ( $parent_category != '' ) {
			global $wgContLang;
			$namespace_labels = $wgContLang->getNamespaces();
			$category_namespace = $namespace_labels[NS_CATEGORY];
			$text .= "\n\n[[$category_namespace:$parent_category]]";
		}
		return $text;
	}
}

function doSpecialCreateCategory() {
	global $wgOut, $wgRequest, $wgUser, $sfgScriptPath;

	SFUtils::loadMessages();

	# cycle through the query values, setting the appropriate local variables
	$category_name = $wgRequest->getVal( 'category_name' );
	$default_form = $wgRequest->getVal( 'default_form' );
	$parent_category = $wgRequest->getVal( 'parent_category' );

	$category_name_error_str = '';
	$save_page = $wgRequest->getCheck( 'wpSave' );
	$preview_page = $wgRequest->getCheck( 'wpPreview' );
	if ( $save_page || $preview_page ) {
		# validate category name
		if ( $category_name == '' ) {
			$category_name_error_str = wfMsg( 'sf_blank_error' );
		} else {
			# redirect to wiki interface
			$wgOut->setArticleBodyOnly( true );
			$title = Title::makeTitleSafe( NS_CATEGORY, $category_name );
			$full_text = SFCreateCategory::createCategoryText( $default_form, $category_name, $parent_category );
			$text = SFUtils::printRedirectForm( $title, $full_text, "", $save_page, $preview_page, false, false, false, null, null );
			$wgOut->addHTML( $text );
			return;
		}
	}

	$all_forms = SFUtils::getAllForms();

	// set 'title' as hidden field, in case there's no URL niceness
	global $wgContLang;
	$mw_namespace_labels = $wgContLang->getNamespaces();
	$special_namespace = $mw_namespace_labels[NS_SPECIAL];
	$name_label = wfMsg( 'sf_createcategory_name' );
	$form_label = wfMsg( 'sf_createcategory_defaultform' );
	$text = <<<END
	<form action="" method="get">

END;
	$text .= SFFormUtils::hiddenFieldHTML( 'title', "$special_namespace:CreateCategory" );
	$text .= <<<END
	<p>$name_label <input size="25" name="category_name" value="" />
	<span style="color: red;">$category_name_error_str</span>
	$form_label
	<select id="form_dropdown" name="default_form">
	<option></option>

END;
	foreach ( $all_forms as $form ) {
		$text .= "\t" . Xml::element( 'option', null, $form ) . "\n";
	}

	$subcategory_label = wfMsg( 'sf_createcategory_makesubcategory' );
	$categories = SFUtils::getCategoriesForPage();
	$sk = $wgUser->getSkin();
	$create_form_link = SFUtils::linkForSpecialPage( $sk, 'CreateForm' );
	$text .= <<<END
	</select>
	<p>$subcategory_label
	<select id="category_dropdown" name="parent_category">
	<option></option>

END;
	foreach ( $categories as $category ) {
		$category = str_replace( '_', ' ', $category );
		$text .= "\t" . Xml::element( 'option', null, $category ) . "\n";
	}
	$text .= "\t</select>\n";
	$editButtonsText = "\t" . Xml::element( 'input', array( 'type' => 'submit', 'id' => 'wpSave', 'name' => 'wpSave', 'value' => wfMsg( 'savearticle' ) ) ) . "\n";
	$editButtonsText .= "\t" . Xml::element( 'input', array( 'type' => 'submit', 'id' => 'wpPreview', 'name' => 'wpPreview', 'value' => wfMsg( 'preview' ) ) ) . "\n";
	$text .= "\t" . Xml::tags( 'div', array( 'class' => 'editButtons' ), $editButtonsText ) . "\n";
	$text .= <<<END
	<br /><hr /<br />

END;

	$text .= "	" . Xml::tags( 'p', null, $create_form_link . '.' ) . "\n";
	$text .= "	</form>\n";

	$wgOut->addExtensionStyle( $sfgScriptPath . "/skins/SemanticForms.css" );
	$wgOut->addHTML( $text );
}
