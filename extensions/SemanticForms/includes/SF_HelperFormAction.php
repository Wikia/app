<?php
/**
 * Handles the formcreate action - used for helper forms for creating
 * properties, forms, etc..
 * 
 * @author Yaron Koren
 * @file
 * @ingroup SF
 */

class SFHelperFormAction extends Action 
{
	/**
	 * Return the name of the action this object responds to
	 * @return String lowercase
	 */
	public function getName(){
		return 'formcreate';
	}
	
	/**
	 * The main action entry point.  Do all output for display and send it to the context
	 * output.  Do not use globals $wgOut, $wgRequest, etc, in implementations; use
	 * $this->getOutput(), etc.
	 * @throws ErrorPageError
	 */
	public function show(){
		return self::displayForm($this, $this->page);
	}

	/**
	 * Execute the action in a silent fashion: do not display anything or release any errors.
	 * @return Bool whether execution was successful
	 */
	public function execute(){
		return true;
	}

	/**
	 * Adds an "action" (i.e., a tab) to edit the current article with
	 * a form
	 */
	static function displayTab( $obj, &$content_actions ) {
		if ( method_exists ( $obj, 'getTitle' ) ) {
			$title = $obj->getTitle();
		} else {
			$title = $obj->mTitle;
		}
		// Make sure that this page is in one of the relevant
		// namespaces, and that it doesn't exist yet.
		$namespacesWithHelperForms = array( NS_TEMPLATE, SF_NS_FORM, NS_CATEGORY );
		if ( defined( 'SMW_NS_PROPERTY' ) ) {
			$namespacesWithHelperForms[] = SMW_NS_PROPERTY;
		}
		if ( !isset( $title ) ||
			( !in_array( $title->getNamespace(), $namespacesWithHelperForms ) ) ) {
			return true;
		}
		if ( $title->exists() ) {
			return true;
		}

		// The tab should show up automatically for properties and
		// forms, but not necessarily for templates and categories,
		// since some of them might be outside of the SMW/SF system.
		if ( in_array( $title->getNamespace(), array( NS_TEMPLATE, NS_CATEGORY ) ) ) {
			global $sfgShowTabsForAllHelperForms;
			if ( !$sfgShowTabsForAllHelperForms ) { return true; }
		}

		global $wgRequest, $wgUser;

		if ( $wgUser->isAllowed( 'edit' ) && $title->userCan( 'edit' ) ) {
			$form_create_tab_text = 'sf_formcreate';
		} else {
			$form_create_tab_text = 'sf_viewform';
		}
		$class_name = ( $wgRequest->getVal( 'action' ) == 'formcreate' ) ? 'selected' : '';
		$form_create_tab = array(
			'class' => $class_name,
			'text' => wfMessage( $form_create_tab_text )->text(),
			'href' => $title->getLocalURL( 'action=formcreate' )
		);

		// Find the location of the 'create' tab, and add 'create
		// with form' right before it.
		// This is a "key-safe" splice - it preserves both the keys
		// and the values of the array, by editing them separately
		// and then rebuilding the array. Based on the example at
		// http://us2.php.net/manual/en/function.array-splice.php#31234
		$tab_keys = array_keys( $content_actions );
		$tab_values = array_values( $content_actions );
		$edit_tab_location = array_search( 'edit', $tab_keys );

		// If there's no 'edit' tab, look for the 'view source' tab
		// instead.
		if ( $edit_tab_location == null ) {
			$edit_tab_location = array_search( 'viewsource', $tab_keys );
		}

		// This should rarely happen, but if there was no edit *or*
		// view source tab, set the location index to -1, so the
		// tab shows up near the end.
		if ( $edit_tab_location == null ) {
			$edit_tab_location = - 1;
		}
		array_splice( $tab_keys, $edit_tab_location, 0, 'formedit' );
		array_splice( $tab_values, $edit_tab_location, 0, array( $form_create_tab ) );
		$content_actions = array();
		for ( $i = 0; $i < count( $tab_keys ); $i++ ) {
			$content_actions[$tab_keys[$i]] = $tab_values[$i];
		}

		global $wgUser;
		if ( ! $wgUser->isAllowed( 'viewedittab' ) ) {
			// The tab can have either of these two actions.
			unset( $content_actions['edit'] );
			unset( $content_actions['viewsource'] );
		}

		return true; // always return true, in order not to stop MW's hook processing!
	}

	/**
	 * Like displayTab(), but called with a different hook - this one is
	 * called for the 'Vector' skin, and others.
	 */
	static function displayTab2( $obj, &$links ) {
		// the old '$content_actions' array is thankfully just a
		// sub-array of this one
		return self::displayTab( $obj, $links['views'] );
	}

	/**
	 * The function called if we're in index.php (as opposed to one of the
	 * special pages).
	 */
	static function displayForm( $action, $article ) {
		$title = $article->getTitle();
		if ( $title->getNamespace() == SMW_NS_PROPERTY ) {
			$createPropertyPage = new SFCreateProperty();
			$createPropertyPage->execute( $title->getText() );
		} elseif ( $title->getNamespace() == NS_TEMPLATE ) {
			$createTemplatePage = new SFCreateTemplate();
			$createTemplatePage->execute( $title->getText() );
		} elseif ( $title->getNamespace() == SF_NS_FORM ) {
			$createFormPage = new SFCreateForm();
			$createFormPage->execute( $title->getText() );
		} elseif ( $title->getNamespace() == NS_CATEGORY ) {
			$createCategoryPage = new SFCreateCategory();
			$createCategoryPage->execute( $title->getText() );
		}

		return false;
	}
}
