<?php
/**
 * A special page holding a form that allows the user to create a category
 * page, with SF forms associated with it
 *
 * @author Yaron Koren
 */

if ( !defined( 'MEDIAWIKI' ) ) die();

class SFCreateCategory extends SpecialPage {

	/**
	 * Constructor
	 */
	function SFCreateCategory() {
		SpecialPage::SpecialPage( 'CreateCategory' );
		wfLoadExtensionMessages( 'SemanticForms' );
	}

	function execute( $query ) {
		$this->setHeaders();
		doSpecialCreateCategory();
	}

	static function createCategoryText( $default_form, $category_name, $parent_category ) {
		wfLoadExtensionMessages( 'SemanticForms' );

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

	wfLoadExtensionMessages( 'SemanticForms' );

	# cycle through the query values, setting the appropriate local variables
	$category_name = $wgRequest->getVal( 'category_name' );
	$default_form = $wgRequest->getVal( 'default_form' );
	$parent_category = $wgRequest->getVal( 'parent_category' );

	$save_button_text = wfMsg( 'savearticle' );
	$preview_button_text = wfMsg( 'preview' );
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
	<input type="hidden" name="title" value="$special_namespace:CreateCategory">
	<p>$name_label <input size="25" name="category_name" value="">
	<span style="color: red;">$category_name_error_str</span>
	$form_label
	<select id="form_dropdown" name="default_form">
	<option></option>

END;
	foreach ( $all_forms as $form ) {
		$text .= "	<option>$form</option>\n";
	}

	$subcategory_label = wfMsg( 'sf_createcategory_makesubcategory' );
	$categories = SFLinkUtils::getCategoriesForArticle();
	$sk = $wgUser->getSkin();
	$cf = SpecialPage::getPage( 'CreateForm' );
	$create_form_link = $sk->makeKnownLinkObj( $cf->getTitle(), $cf->getDescription() );
	$text .= <<<END
	</select>
	<p>$subcategory_label
	<select id="category_dropdown" name="parent_category">
	<option></option>

END;
	foreach ( $categories as $category ) {
		$category = str_replace( '_', ' ', $category );
		$text .= "	" . Xml::element( 'option', null, $category ) . "\n";
	}
	$text .= <<<END
	</select>
	<div class="editButtons">
	<input type="submit" id="wpSave" name="wpSave" value="$save_button_text">
	<input type="submit" id="wpPreview" name="wpPreview" value="$preview_button_text">
	</div>
	<br /><hr /<br />

END;

	$text .= "	" . Xml::tags( 'p', null, $create_form_link . '.' ) . "\n";
	$text .= "	</form>\n";

	$wgOut->addLink( array(
		'rel' => 'stylesheet',
		'type' => 'text/css',
		'media' => "screen",
		'href' => $sfgScriptPath . "/skins/SF_main.css"
	) );
	$wgOut->addHTML( $text );
}
