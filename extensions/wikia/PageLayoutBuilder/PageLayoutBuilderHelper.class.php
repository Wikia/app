<?php

class PageLayoutBuilderHelper {

	/*
	 * @author Tomasz Odrobny
	 */
	public static function rteIsCustom($name, $params, $frame, $wikitextIdx) {
		global $wgPLBwidgets;
		if (isset($wgPLBwidgets[$name])) {
			return false;
		}
		return true;
	}

	/**
	 * create table with update.php
	 */
	static public function schemaUpdate() {
		global $wgExtNewTables;
		$wgExtNewTables[] = array( "plb_field", dirname(__FILE__) . "/sql/plb_field.sql" );
		$wgExtNewTables[] = array( "plb_page", dirname(__FILE__) . "/sql/plb_page.sql" );
		return true;
	}

	/**
	 * Redirects user to page layout builder special page
	 * if the supplied argument is valid layout id
	 *
	 * @param string $text
	 * @author wladek
	 */
	static public function onCreatePageSubpage( $text ) {
		if (is_numeric($text)) {
			$id = intval($text);
			$title = Title::newFromID($id);
			if ( $title && $title->getNamespace() == NS_PLB_LAYOUT ) {
				global $wgOut;
				$wgOut->redirect( SpecialPage::getTitleFor('PageLayoutBuilderForm')->getFullUrl("plbId={$id}") );
				return false;
			}
		}

		return true;
	}

	/*
	 * copyLayout - use by task to copy layouts from commuinty
	 *
	 * @author Tomasz Odrobny
	 * @param Title
	 * @return Parser
	 */

	public static function copyLayout() {
		global $wgCityId;
		$list = PageLayoutBuilderModel::getLayoutsToCopy();
		foreach( $list as $layout => $cats ) {
			$cat = WikiFactory::getCategory( $wgCityId );
			if(in_array($cat->cat_id, $cats)) {
				PageLayoutBuilderModel::setLayoutCopy( $layout, $wgCityId );
				$layoutInfo = PageLayoutBuilderModel::getLayoutCopyInfo( $layout );

				if($layoutInfo !== false) {
					$newTitle = Title::newFromText( $layoutInfo['title'], NS_PLB_LAYOUT );
					if(!$newTitle->exists()){
						$article = new Article( $newTitle );
						$article->doEdit( $layoutInfo['text'], '', EDIT_NEW | EDIT_DEFER_UPDATES | EDIT_AUTOSUMMARY );
						PageLayoutBuilderModel::setProp($article->getId(), array('desc' => $layoutInfo['desc'] ) );

					}
				}

			}
		}

		return true;
	}


	/**
	 * myTools add link to mytools
	 *
	 * @author Tomek Odrobny
	 *
	 * @access public
	 *
	 */
	public static function onGetDefaultMyTools(&$list) {
		global $wgUser;

		wfLoadExtensionMessages( 'PageLayoutBuilder' );

		if($wgUser->isAllowed( 'plbmanager' )) {
			$list[] = array(
				'text' => wfMsg( 'plb-mytools-link' ),
				'name' => 'plbmanager',
				'href' => Title::newFromText( "LayoutBuilder", NS_SPECIAL )->getFullUrl("action=list")
			);
		}

		return true;
	}

	/**
	 * Sets up the caption and the link for this special page
	 * in user commands subsystem
	 *
	 * @param $userCommand UserCommand An instance of user command being processed
	 * @param $options Options which can be altered by this hook
	 * @return true
	 */
	public static function onGetUserCommandDetails( $userCommand, &$options ) {
		$options['caption'] = wfMsg('plb-mytools-link');
		$options['href'] = Title::newFromText( "LayoutBuilder", NS_SPECIAL )->getFullUrl("action=list");

		return true;
	}


	/**
	 * Returns the full URL to create a new layout from article being edited
	 *
	 * @return string
	 */
	protected static function getCreateLayoutFromArticleUrl() {
		return Title::newFromText('LayoutBuilder', NS_SPECIAL)->getFullURL("action=createfromarticle");
	}

	/**
	 * addNewButtonForArtilce - adding button allows you to make a layout of the article
	 *
	 * @author Tomek Odrobny
	 *
	 * @access public
	 */
	public static function addNewButtonForArtilce($cat) {
		global $wgUser, $wgOut, $wgTitle, $wgContentNamespaces;

		if (!in_array($wgTitle->getNamespace() , $wgContentNamespaces)) {
			return true;
		}

		if( !$wgUser->isAllowed( 'plbmanager' ) ) {
			return true;
		}

		$oTmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );
		$oTmpl->set_vars(array(
		    "post_url" => self::getCreateLayoutFromArticleUrl(),
		));

		return true;
	}

	public static function onShowEditFormInitial() {
		global $wgHooks;
		$wgHooks['MakeGlobalVariablesScript'][] = 'PageLayoutBuilderHelper::onMakeGlobalVariablesScript';
		return true;
	}

	public static function onMakeGlobalVariablesScript( &$vars ) {
		$vars['PLBMakeLayoutUrl'] = self::getCreateLayoutFromArticleUrl();
		return true;
	}

	/**
	 * alternateEditHook - redirect to edit LayoutBuilder if article is in layout namespace
	 *
	 * @author Tomek Odrobny
	 *
	 * @access public
	 */
	public static function alternateEditHook($oEditPage) {
		global $wgOut, $wgRequest;
		if(empty($oEditPage->mTitle) || empty($oEditPage)) {
			return true;
		}

		if ( !empty($oEditPage->isLayoutBuilderEditPage) ) {
			return true;
		}

		if($oEditPage->mTitle->getNamespace() == NS_PLB_LAYOUT) {
			$oSpecialPageTitle = Title::newFromText('LayoutBuilder', NS_SPECIAL);
			if($oEditPage->mTitle->getArticleId() == 0) {
				$wgOut->redirect($oSpecialPageTitle->getFullUrl("default=".$oEditPage->mTitle->getText()."&plbId=" . $oEditPage->mTitle->getArticleId() ));
				return true;
			}
			$wgOut->redirect($oSpecialPageTitle->getFullUrl("plbId=" . $oEditPage->mTitle->getArticleId() ));
		}
		return true;
	}

	/**
	 * getUserPermissionsErrors -  control access to articles in the namespace layout
	 *
	 * @author Tomek Odrobny
	 *
	 * @access public
	 */
	public static function getUserPermissionsErrors( &$title, &$user, $action, &$result ) {
		if( $title->getNamespace() == NS_PLB_LAYOUT ) {
			$result = array();
			if( $user->isAllowed( 'plbmanager' )  && ($action == 'create' || $action == 'edit') ) {
				$result = null;
				return true;
			} else {
				wfLoadExtensionMessages( 'PageLayoutBuilder' );
				$result = array('badaccess-group0');
				return false;
			}
		}
		$result = null;
		return true;
	}


	/**
	 * createPageOptions - There are prepared for lists of bytes
	 *
	 * @author Tomek Odrobny
	 *
	 * @access public
	 */
	public static function createPageOptions(&$standardOptions, &$options, &$listtype) {
		global $wgExtensionsPath;
		$listtype = "long";
		$out = PageLayoutBuilderModel::getListOfLayout(DB_SLAVE);
		$optionsAdd = array();
		foreach($out as $value) {
			if( empty($value['not_publish']) ) {
				$optionsAdd["plb".$value['page_id']] = array(
					'label' => str_replace("_", " " ,$value['page_title']),
					'desc' => $value['desc'],
					'icon' => "{$wgExtensionsPath}/wikia/CreatePage/images/thumbnail_format.png",
					'trackingId' => 'blankpage',
					'submitUrl' => Title::newFromText( "LayoutBuilderForm", NS_SPECIAL )->getFullUrl("plbId=".$value['page_id']."&default=$1&action=edit")
				);
			}
		}

		if(!empty($optionsAdd)) {
			unset($standardOptions['format']);
		}
		$options = $optionsAdd + $options;
		return true;
	}


	/**
	 * beforeCategoryData - hide layout namespace from category page
	 *
	 * @author Tomek Odrobny
	 *
	 * @access public
	 */
	public static function beforeCategoryData(&$userCon) {
		$userCon = "not page_namespace = ".NS_PLB_LAYOUT;
		return true;
	}



	/**
	 * onArticleSave - prevent save if someone try to save plb article from api,etc.
	 *
	 * @author Tomek Odrobny
	 *
	 * @access public
	 *
	 */

	public static function onArticleSave(&$article, &$user, &$text, &$summary, $minor, $watchthis, $sectionanchor, &$flags, &$status) {
		global $wgTitle;
		if ( PageLayoutBuilderForm::articleIsFromPLBFull($article->getId(), $article->getContent() ) ) {
			if ( !$wgTitle->isSpecial('PageLayoutBuilderForm') ) {
				return false;
			}
		}
		return true;
	}
}
