<?php
/**
 * Renders page header (title, subtitle, comments chicklet button, history dropdown, top categories)
 *
 * @author Maciej Brencz
 */

class PageHeaderModule extends Module {

	var $wgStylePath;

	var $content_actions;
	var $displaytitle;
	var $title;
	var $contentsub;

	var $action;
	var $actionName;
	var $actionImage;
	var $categories;
	var $comments;
	var $dropdown;
	var $likes;
	var $pageExists;
	var $showSearchBox;
	var $subtitle;
	var $isMainPage;
	var $total;

	/**
	 * Use MW core variable to generate action button
	 */
	private function prepareActionButton() {
		global $wgTitle, $wgRequest;

		$namespace = $wgTitle->getNamespace();
		$isDiff = !is_null($wgRequest->getVal('diff'));

		// "Add topic" action
		if (isset($this->content_actions['addsection'])) {
			// remove on Forum namespace pages / diff pages (RT #72666)
			if ($namespace == NS_FORUM || $isDiff) {
				unset($this->content_actions['addsection']);
			}
		}

		// action button
		#print_pre($this->content_actions);

		// "Add topic"
		if (isset($this->content_actions['addsection'])) {
			$this->action = $this->content_actions['addsection'];
			$this->action['text'] = wfMsg('oasis-page-header-add-topic');

			$this->actionImage = MenuButtonModule::ADD_ICON;
			$this->actionName = 'addtopic';
		}
		// "Edit with form" (SMW)
		else if (isset($this->content_actions['form_edit'])) {
			$this->action = $this->content_actions['form_edit'];
			$this->actionImage = MenuButtonModule::EDIT_ICON;
			$this->actionName = 'form-edit';
		}
		// edit
		else if (isset($this->content_actions['edit'])) {
			$this->action = $this->content_actions['edit'];
			$this->actionImage = MenuButtonModule::EDIT_ICON;
			$this->actionName = 'edit';
			$this->action["href"] .= "#EditPage"; // jumping to a-tag
		}
		// view source
		else if (isset($this->content_actions['viewsource'])) {
			$this->action = $this->content_actions['viewsource'];
			$this->actionImage = MenuButtonModule::LOCK_ICON;
			$this->actionName = 'source';
		}
	}

	/**
	 * Get content actions for dropdown
	 */
	private function getDropdownActions() {

		// var_dump($this->content_actions);
		$ret = array();

		// items to be added to "edit" dropdown
		$actions = array('move', 'protect', 'unprotect', 'delete', 'undelete');

		// add "edit" to dropdown if edit button says:
		//  * "Add topic" (__NEWSECTIONLINK__ magic word used on Forum namespace pages)
		//  * "Edit with form" (SMW pages)
		if (in_array($this->actionName, array('addtopic', 'form-edit'))) {
			array_unshift($actions, 'edit');
		}

		foreach($actions as $action) {
			if (isset($this->content_actions[$action])) {
				$ret[$action] = $this->content_actions[$action];
			}
		}

		return $ret;
	}

	/**
	 * Get recent revisions of current article and format them
	 */
	private function getRecentRevisions() {
		global $wgTitle, $wgMemc;

		// use service to get data
		$service = new PageStatsService($wgTitle->getArticleId());

		// get info about current revision and list of authors of recent five edits
		// This key is refreshed by the onArticleSaveComplete() hook
		$mKey = wfMemcKey('mOasisRecentRevisions2', $wgTitle->getArticleId());
		$revisions = $wgMemc->get($mKey);

		if (empty($revisions)) {
			$revisions = $service->getCurrentRevision();

			// format timestamps, render avatars and user links
			if (is_array($revisions)) {
				foreach($revisions as &$revision) {
					if (isset($revision['user'])) {
						$revision['avatarUrl'] = AvatarService::getAvatarUrl($revision['user']);
						$revision['link'] = AvatarService::renderLink($revision['user']);
					}
				}
			}
			$wgMemc->set($mKey, $revisions);
		}

		return $revisions;
	}

	public static function formatTimestamp($stamp) {

		$diff = time() - strtotime($stamp);

		// show time difference if it's 14 or less days
		if ($diff < 15 * 86400) {
			$ret = wfTimeFormatAgo($stamp);
		}
		else {
			$ret = '';
		}
		return $ret;
	}

	/**
	 * Render default page header (with edit dropdown, history dropdown, ...)
	 *
	 * @param: array $params
	 *    key: showSearchBox (default: false)
	 */
	public function executeIndex($params) {
		global $wgTitle, $wgContLang, $wgSupressPageTitle, $wgSupressPageSubtitle, $wgSuppressNamespacePrefix, $wgCityId;
		wfProfileIn(__METHOD__);

		// page namespace
		$ns = $wgTitle->getNamespace();

		// action button (edit / view soruce) and dropdown for it
		$this->prepareActionButton();

		// dropdown actions
		$this->dropdown = $this->getDropdownActions();

		// for not existing pages page header is a bit different
		$this->pageExists = !empty($wgTitle) && $wgTitle->exists();

		if ($this->pageExists) {
			// use service to get data
			$service = new PageStatsService($wgTitle->getArticleId());

			// comments
			$this->comments = $service->getCommentsCount();

			// show likes
			$this->likes = true;

			// get two popular categories this article is in
			$categories = array();

			// FIXME: Might want to make a WikiFactory variable for controlling this feature if we aren't
			// comfortable with its performance.
			// NOTE: Skip getMostLinkedCategories() on Lyrics and Marvel because we're not sure yet that it's fast enough.
			$LYRICS_CITY_ID = "43339";
			$MARVEL_CITY_ID = "2233";
			if(($wgCityId != $LYRICS_CITY_ID)  && ($wgCityId != $MARVEL_CITY_ID)){
				$categories = $service->getMostLinkedCategories();
			}

			// render links to most linked category page
			$this->categories = array();
			foreach($categories as $category => $cnt) {
				$title = Title::newFromText($category, NS_CATEGORY);
				$this->categories[] = View::link($title, $title->getText());
			}

			// get info about current revision and list of authors of recent five edits
			$this->revisions = $this->getRecentRevisions();

			// mainpage?
			if (ArticleAdLogic::isMainPage()) {
				$this->isMainPage = true;

				// number of pages on this wiki
				$this->total = SiteStats::articles();
			}
		}

		// remove namespaces prefix from title
		$namespaces = array(NS_MEDIAWIKI, NS_TEMPLATE, NS_CATEGORY, NS_FILE);
		if (defined('NS_VIDEO')) {
			$namespaces[] = NS_VIDEO;
		}
		if ( in_array($ns, array_merge( $namespaces, $wgSuppressNamespacePrefix ) ) ) {
			$this->title = $wgTitle->getText();
		}

		// show contentSub links (RT #68421 and RT #70442)
		if (in_array($ns, array(NS_MEDIAWIKI, NS_TEMPLATE, NS_SPECIAL, NS_CATEGORY, NS_FORUM))) {
			$this->contentsub = $this->subtitle;
		}

		// talk pages
		if ($wgTitle->isTalkPage()) {
			// remove comments button
			$this->comments = false;

			// Talk: <page name without namespace prefix>
			$this->displaytitle = true;
			$this->title = Xml::element('strong', array(), $wgContLang->getNsText(NS_TALK) . ':');
			$this->title .= htmlspecialchars($wgTitle->getText());

			// back to subject article link
			switch($ns) {
				case NS_TEMPLATE_TALK:
					$msgKey = 'oasis-page-header-back-to-template';
					break;

				case NS_MEDIAWIKI_TALK:
					$msgKey = 'oasis-page-header-back-to-mediawiki';
					break;

				case NS_CATEGORY_TALK:
					$msgKey = 'oasis-page-header-back-to-category';
					break;

				case NS_FILE_TALK:
					$msgKey = 'oasis-page-header-back-to-file';
					break;

				default:
					$msgKey = 'oasis-page-header-back-to-article';
			}

			// special case for NS_VIDEO_TALK
			if (defined('NS_VIDEO') && ($ns == MWNamespace::getTalk(NS_VIDEO))) {
				$msgKey = 'oasis-page-header-back-to-video';
			}

			$this->subtitle = View::link($wgTitle->getSubjectPage(), wfMsg($msgKey), array('accesskey' => 'c'));
		}

		// category pages
		if ($ns == NS_CATEGORY) {
			// hide revisions / categories bar
			$this->categories = false;
			$this->revisions = false;
		}

		// forum namespace
		if ($ns == NS_FORUM) {
			// remove comments button
			$this->comments = false;

			// remove namespace prefix
			$this->title = $wgTitle->getText();
		}

		// mainpage
		if (ArticleAdLogic::isMainPage()) {
			// change page title to just "Home"
			$this->title = wfMsg('oasis-home');
			// hide revisions / categories bar
			$this->categories = false;
			$this->revisions = false;
		}

		// render proper message below page title (Mediawiki page, Template page, ...)
		switch($ns) {
			case NS_MEDIAWIKI:
				$this->subtitle = wfMsg('oasis-page-header-subtitle-mediawiki');
				break;

			case NS_TEMPLATE:
				$this->subtitle = wfMsg('oasis-page-header-subtitle-template');
				break;

			case NS_SPECIAL:
				$this->subtitle = wfMsg('oasis-page-header-subtitle-special');

				// special case for wiki activity page
				if ($wgTitle->isSpecial('WikiActivity')) {
					/*$this->subtitle = View::specialPageLink('WikiActivity/watchlist', 'oasis-button-wiki-activity-watchlist');
					$this->subtitle .= View::specialPageLink('WikiActivity', 'oasis-button-wiki-activity-feed');*/
					$this->subtitle = '&nbsp;';
					
				} else if ($wgTitle->isSpecial('ThemeDesignerPreview')) {
					// fake static data for ThemeDesignerPreview
					$this->revisions = array('current' => array('user' => 'foo',
							'avatarUrl' => '/extensions/wikia/ThemeDesigner/images/td-avatar.jpg',
							'link' => '<a>FunnyBunny</a>',
							'timestamp' => ''),
						array('user' => 'foo',
							'avatarUrl' => '/extensions/wikia/ThemeDesigner/images/td-avatar.jpg',
							'link' => '<a>FunnyBunny</a>',
							'timestamp' => ''));
					//$title = Title::newFromText("More Examples", NS_CATEGORY);
					//$this->categories[] = View::link($title, $title->getText());
					$this->categories = array("<a>More Sample</a>", "<a>Others</a>");
					$this->comments = 23;
					$this->subtitle = false;
					$this->action = array("text" => "Edit this page");
					$this->actionImage = '';
					$this->actionName = 'edit';
					$this->dropdown = array('foo', 'bar');
				} elseif($wgTitle->isSpecial('PageLayoutBuilderForm') || $wgTitle->isSpecial('PageLayoutBuilder') ) {
					$this->subtitle = "";
				}
				break;

			case NS_CATEGORY:
				$this->subtitle = wfMsg('oasis-page-header-subtitle-category');
				break;

			case NS_FORUM:
				$this->subtitle = wfMsg('oasis-page-header-subtitle-forum');
				break;
		}

		// if page is rendered using one column layout, show search box as a part of page header
		$this->showSearchBox = isset($params['showSearchBox']) ? $params['showSearchBox'] : false ;

		if (!empty($wgSupressPageTitle)) {
			$this->title = '';
			$this->subtitle = '';
		}

		if (!empty($wgSupressPageSubtitle)) {
			$this->subtitle = '';
		}

		wfProfileOut(__METHOD__);
	}

	/**
	 * Render header for edit page
	 */
	public function executeEditPage() {
		global $wgTitle, $wgRequest, $wgSuppressToolbar, $wgShowMyToolsOnly;

		// special handling for special pages (CreateBlogPost, CreatePage)
		if ($wgTitle->getNamespace() == NS_SPECIAL) {
			wfProfileOut(__METHOD__);
			return;
		}

		// detect section edit
		$isSectionEdit = is_numeric($wgRequest->getVal('section'));

		// show proper message in the header
		$action = $wgRequest->getVal('action', 'view');

		$isPreview = $wgRequest->getCheck( 'wpPreview' ) || $wgRequest->getCheck( 'wpLivePreview' );
		$isShowChanges = $wgRequest->getCheck( 'wpDiff' );
		$isDiff = !is_null($wgRequest->getVal('diff')); // RT #69931
		$isEdit = in_array($action, array('edit', 'submit'));
		$isHistory = $action == 'history';

		// add editor's right rail when not editing main page
		if (!Wikia::isMainPage()) {
			OasisModule::addBodyClass('editor-rail');
		}

		// hide floating toolbar when on edit page / in preview mode / show changes
		if ($isEdit || $isPreview) {
			$wgSuppressToolbar = true;
		}

		// choose header message
		if ($isPreview) {
			$titleMsg = 'oasis-page-header-preview';
		}
		else if ($isShowChanges) {
			$titleMsg = 'oasis-page-header-changes';
		}
		else if ($isDiff) {
			$titleMsg = 'oasis-page-header-diff';
		}
		else if ($isSectionEdit) {
			$titleMsg = 'oasis-page-header-editing-section';
		}
		else if ($isHistory) {
			$titleMsg = 'oasis-page-header-history';
		}
		else {
			$titleMsg = 'oasis-page-header-editing';
		}

		$this->displaytitle = true;
		$this->title = wfMsg($titleMsg, htmlspecialchars($wgTitle->getPrefixedText()));

		// back to article link
		if (!$isPreview && !$isShowChanges) {
			$this->subtitle = View::link($wgTitle, wfMsg('oasis-page-header-back-to-article'), array('accesskey' => 'c'), array(), 'known');
		}

		// add edit button
		if ($isDiff || $isHistory) {
			$this->prepareActionButton();

			// show only "My Tools" dropdown on toolbar
			$wgShowMyToolsOnly = true;
		}

		// render edit dropdown / commments chicklet on history pages
		if ($isHistory) {
			// dropdown actions
			$this->dropdown = $this->getDropdownActions();

			// use service to get data
			$service = new PageStatsService($wgTitle->getArticleId());

			// comments
			$this->comments = $service->getCommentsCount();
		}
	}

	/**
	 * Render edit box header when doing preview / showing changes
	 */
	public function executeEditBox() {
		global $wgTitle, $wgRequest;

		// detect section edit
		$isSectionEdit = is_numeric($wgRequest->getVal('wpSection'));

		if ($isSectionEdit) {
			$msg = 'oasis-page-header-editing-section';
		}
		else {
			$msg = 'oasis-page-header-editing';
		}

		// Editing: foo
		$this->displaytitle = true;
		$this->title = wfMsg($msg, htmlspecialchars($wgTitle->getPrefixedText()));

		// back to article link
		$this->subtitle = View::link($wgTitle, wfMsg('oasis-page-header-back-to-article'), array('accesskey' => 'c'), array(), 'known');
	}

	public function executeCorporate() {
		global $wgTitle;

		if (ArticleAdLogic::isMainPage()) {
			$this->title = '';
			$this->subtitle = '';
		}
		else if (BodyModule::isHubPage()) {
			$this->title = wfMsg('hub-header', $wgTitle);
			global $wgOut;
			$wgOut->addScriptFile('../oasis/js/CorporateHub.js');
		}
	}

	/**
	 * Modify edit page: add preview notice bar and render edit box header
	 */
	public static function modifyEditPage(&$editPage) {
		wfProfileIn(__METHOD__);
		global $wgUser;

		// get skin name
		$skinName = get_class($wgUser->getSkin());

		if ($skinName == 'SkinOasis') {
			// load CSS for editpage
			global $wgOut;
			$wgOut->addStyle(wfGetSassUrl('skins/oasis/css/core/_EditPage.scss'));

			// TODO: dirty hack to make CategorySelect works
			$wgOut->addScriptFile('jquery/jquery-ui-1.7.2.custom.js');
			$wgOut->addScriptFile('jquery/jquery.json-1.3.js');

			// render preview notice bar
			if ($editPage->preview) {
				// show preview confirmation bar below global nav
				NotificationsModule::addConfirmation(wfMsg('oasis-preview-confirmation'), NotificationsModule::CONFIRMATION_PREVIEW);
			}

			// render edit box header
			if ($editPage->preview || $editPage->diff) {
				$editPage->editFormTextTop .= wfRenderModule('PageHeader', 'EditBox');
			}
		}

		wfProfileOut(__METHOD__);
		return true;
	}

	static function onArticleSaveComplete(&$article, &$user, $text, $summary,
		$minoredit, $watchthis, $sectionanchor, &$flags, $revision, &$status, $baseRevId) {
		global $wgMemc;
		$wgMemc->delete(wfMemcKey('mOasisRecentRevisions2', $article->getTitle()->getArticleId()));
		return true;
	}
}
