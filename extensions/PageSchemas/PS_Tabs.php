<?php

/**
 * @file PS_Tabs.php
 * @ingroup
 *
 * @author Ankit Garg
 * @author Yaron Koren
 */
final class PSTabs {

	public static function displayTabs( $obj, &$content_actions ) {
		global $wgUser;

		$title = $obj->getTitle();
		if ( $title->getNamespace() != NS_CATEGORY ){
			return true;
		}

		$category = $title->getText();
		$pageSchemaObj = new PSSchema( $category );
		$isPSDefined = $pageSchemaObj->isPSDefined();

		global $wgTitle, $wgRequest;

		if ( $wgUser->isAllowed( 'edit' ) && $wgTitle->userCan( 'edit' ) ) {
			$content_actions['editschema'] = array(
				'text' => ( $isPSDefined ) ? wfMsg( 'editschema' ) : wfMsg( 'createschema' ),
				'class' => $wgRequest->getVal( 'action' ) == 'editschema' ? 'selected' : '',
				'href' => $title->getLocalURL( 'action=editschema' )
			);
		}

		if ( $isPSDefined && $wgUser->isAllowed( 'generatepages' ) ) {
			$content_actions['generatepages'] = array(
				'text' => wfMsg( 'generatepages' ),
				'class' => $wgRequest->getVal( 'action' ) == 'generatepages' ? 'selected' : '',
				'href' => $title->getLocalURL( 'action=generatepages' )
			);
		}

		return true;
	}

	/**
	 * Function called for some skins, most notably 'Vector'.
	 */
	public static function displayTabs2( $obj, &$links ) {
		// The old '$content_actions' array is thankfully just a sub-array of this one
		$views_links = $links['actions'];
		self::displayTabs( $obj, $views_links );
		$links['actions'] = $views_links;
		return true;
	}

	/**
	 * Adds handling for the tabs 'generatepages' and 'editschema'.
	 */
	public static function onUnknownAction( $action, Article $article ) {
		$title = $article->getTitle();

		// These tabs should only exist for category pages
		if ( $title->getNamespace() != NS_CATEGORY ) {
			return true;
		}

		$categoryName = $title->getText();
		if ( $action == 'generatepages' ) {
			$generatePagesPage = new PSGeneratePages();
			$generatePagesPage->execute( $categoryName );
			return false;
		} elseif ( $action == 'editschema' ) {
			$editSchemaPage = new PSEditSchema();
			$editSchemaPage->execute( $categoryName );
			return false;
		}
		return true;
	}
}
