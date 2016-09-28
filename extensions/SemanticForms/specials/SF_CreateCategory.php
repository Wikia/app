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
			$text = wfMessage( 'sf_category_desc', $category_name )->inContentLanguage()->text();
		} else {
			$text = "{{#default_form:$default_form}}";
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
		$this->setHeaders();

		$out = $this->getOutput();
		$req = $this->getRequest();

		// Cycle through the query values, setting the appropriate
		// local variables.
		if ( !is_null( $query ) ) {
			$presetCategoryName = str_replace( '_', ' ', $query );
			$out->setPageTitle( wfMessage( 'sf-createcategory-with-name', $presetCategoryName )->text() );
			$category_name = $presetCategoryName;
		} else {
			$presetCategoryName = null;
			$category_name = $req->getVal( 'category_name' );
		}
		$default_form = $req->getVal( 'default_form' );
		$parent_category = $req->getVal( 'parent_category' );

		$category_name_error_str = null;
		$save_page = $req->getCheck( 'wpSave' );
		$preview_page = $req->getCheck( 'wpPreview' );
		if ( $save_page || $preview_page ) {
			// Guard against cross-site request forgeries (CSRF).
			$validToken = $this->getUser()->matchEditToken( $req->getVal( 'csrf' ), 'CreateCategory' );
			if ( !$validToken ) {
				$text = "This appears to be a cross-site request forgery; canceling save.";
				$out->addHTML( $text );
				return;
			}
			// Validate category name
			if ( $category_name === '' ) {
				$category_name_error_str = wfMessage( 'sf_blank_error' )->text();
			} else {
				// Redirect to wiki interface
				$out->setArticleBodyOnly( true );
				$title = Title::makeTitleSafe( NS_CATEGORY, $category_name );
				$full_text = SFCreateCategory::createCategoryText( $default_form, $category_name, $parent_category );
				$text = SFUtils::printRedirectForm( $title, $full_text, "", $save_page, $preview_page, false, false, false, null, null );
				$out->addHTML( $text );
				return;
			}
		}

		$all_forms = SFUtils::getAllForms();

		// Set 'title' as hidden field, in case there's no URL niceness
		global $wgContLang;
		$mw_namespace_labels = $wgContLang->getNamespaces();
		$text = "\t" . '<form action="" method="post">' . "\n";
		$firstRow = '';
		if ( is_null( $presetCategoryName ) ) {
			$text .= "\t" . Html::hidden( 'title', $this->getTitle()->getPrefixedText() ) . "\n";
			$firstRow .= wfMessage( 'sf_createcategory_name' )->escaped() . ' ' .
				Html::input( 'category_name', null, 'text',
					array( 'size' => 25 ) ) . "\n";
			if ( !is_null( $category_name_error_str ) ) {
				$firstRow .= Html::element( 'span',
					array( 'style' => 'color: red;' ),
					$category_name_error_str ) . "\n";
			}
		}
		$firstRow .= "\t" . wfMessage( 'sf_createcategory_defaultform' )->escaped() . "\n";
		$formSelector = "\t" . Html::element( 'option', null, null ). "\n";
		foreach ( $all_forms as $form ) {
			$formSelector .= "\t" . Html::element( 'option', null, $form ) . "\n";
		}

		$firstRow .= Html::rawElement( 'select',
			array( 'id' => 'form_dropdown', 'name' => 'default_form' ),
			$formSelector );
		$text .= Html::rawElement( 'p', null, $firstRow )  . "\n";
		$secondRow = wfMessage( 'sf_createcategory_makesubcategory' )->escaped() . ' ';
		$selectBody = "\t" . Html::element( 'option', null, null ). "\n";
		$categories = SFValuesUtils::getCategoriesForPage();
		foreach ( $categories as $category ) {
			$category = str_replace( '_', ' ', $category );
			$selectBody .= "\t" . Html::element( 'option', null, $category ) . "\n";
		}
		$secondRow .= Html::rawElement( 'select', array( 'id' => 'category_dropdown', 'name' => 'parent_category' ), $selectBody );
		$text .= Html::rawElement( 'p', null, $secondRow ) . "\n";

		$text .= "\t" . Html::hidden( 'csrf', $this->getUser()->getEditToken( 'CreateCategory' ) ) . "\n";

		$editButtonsText = "\t" . Html::input( 'wpSave', wfMessage( 'savearticle' )->text(), 'submit', array( 'id' => 'wpSave' ) ) . "\n";
		$editButtonsText .= "\t" . Html::input( 'wpPreview', wfMessage( 'preview' )->text(), 'submit', array( 'id' => 'wpPreview' ) ) . "\n";
		$text .= "\t" . Html::rawElement( 'div', array( 'class' => 'editButtons' ), $editButtonsText ) . "\n";
		$text .= "\t</form>\n";

		$out->addHTML( $text );
	}

	protected function getGroupName() {
		return 'sf_group';
	}
}
