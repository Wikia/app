<?php
class CampfireBodyController extends WikiaController {

	private static $onEditPage;
	
	public function init() {
		
		$this->afterBodyHtml = '';
	}
	

	/**
	 * This method is called when edit form is rendered
	 */
	public static function onEditPageRender(&$editPage) {
		self::$onEditPage = true;
		return true;
	}

	/**
	 * Detect we're on edit (or diff) page
	 */
	public static function isEditPage() {
		global $wgRequest;
		return !empty(self::$onEditPage) ||
			!is_null($wgRequest->getVal('diff')) /* diff pages - RT #69931 */ ||
			in_array($wgRequest->getVal('action', 'view'), array('edit' /* view source page */, 'formedit' /* SMW edit pages */, 'history' /* history pages */));
	}

	/**
	 * Check whether current page is blog post
	 */
	public static function isBlogPost() {
		global $wgTitle;
		return defined('NS_BLOG_ARTICLE') && $wgTitle->getNamespace() == NS_BLOG_ARTICLE && $wgTitle->isSubpage();
	}

	/**
	 * Check whether current page is blog listing
	 */
	public static function isBlogListing() {
		global $wgTitle;
		return defined('NS_BLOG_LISTING') && $wgTitle->getNamespace() == NS_BLOG_LISTING;
	}

	/**
	 * Decide whether to show user pages header on current page
	 */
	public static function showUserPagesHeader() {
		wfProfileIn(__METHOD__);

		global $wgTitle;

		// perform namespace and special page check
		$ret = in_array($wgTitle->getNamespace(), self::getUserPagesNamespaces())
				|| $wgTitle->isSpecial( 'Following' )
				|| $wgTitle->isSpecial( 'Contributions' )
				|| (defined('NS_BLOG_LISTING') && $wgTitle->getNamespace() == NS_BLOG_LISTING);

		wfProfileOut(__METHOD__);
		return $ret;
	}

	public function executeIndex() {
		global $wgOut, $wgTitle, $wgSitename, $wgUser, $wgEnableBlog, $wgEnableCorporatePageExt, $wgEnableInfoBoxTest, $wgEnableWikiAnswers, $wgRequest, $wgMaximizeArticleAreaArticleIds;

		$this->isMainPage = WikiaPageType::isMainPage();

		// Replaces ContentDisplayModule->index()
		$this->bodytext = $this->app->getSkinTemplateObj()->data['bodytext'];

		// this hook allows adding extra HTML just after <body> opening tag
		// append your content to $html variable instead of echoing
		// (taken from Monaco skin)
		wfRunHooks('GetHTMLAfterBody', array ($wgUser->getSkin(), &$this->afterBodyHtml));

		$this->headerModuleAction = 'Index';
		$this->headerModuleParams = array ('showSearchBox' => false);

		$this->headerModuleName = 'CampfireHeader';

	}
}
