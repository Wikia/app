<?php

/**
 * Applies updated layout for edit pages (Oasis only) Class is use as singleton
 */

class EditPageLayoutHelper {

	private $app;

	/* @var $request OutputPage */
	private $out;

	/* @var $request WebRequest */
	private $request;
	private $jsVars = array();
	private $jsVarsPrinted = false;

	/* @var $editPage EditPageLayout */
	public $editPage;

	static private $instance;

	private function __construct() {
		$this->app = F::app();
		$this->out = $this->app->wg->Out;
		$this->request = $this->app->wg->Request;
	}

	static function getInstance() {
		if (!isset(self::$instance)) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	function getJsVars() {
		return $this->jsVars;
	}

	function getRequest() {
		return $this->request;
	}

	/**
	 * Change the module used as an entry-point for Oasis skin and use custom class for rendering edit page
	 *
	 * Keep global and user nav only.
	 *
	 * @author macbre
	 */
	function setupEditPage(Article $editedArticle, $fullScreen = true, $class = false) {
		global $wgHooks;

		wfProfileIn(__METHOD__);

		$user = $this->app->wg->User;

		// don't render edit area when we're in read only mode
		if (wfReadOnly()) {
			// set correct page title
			$this->out->setPageTitle(wfMsg('editing', $this->app->getGlobal('wgTitle')->getPrefixedText()));
			wfProfileOut(__METHOD__);
			return false;
		}

		// use "reskined" edit page layout
		$this->fullScreen = $fullScreen;
		if ($fullScreen) {
			// set Oasis entry-point
			Wikia::setVar('OasisEntryControllerName', 'EditPageLayout');
		}

		// Disable custom JS while loading the edit page on MediaWiki JS pages and user subpages (BugID: 41449)
		$editedArticleTitle     = $editedArticle->getTitle();
		$editedArticleTitleNS   = $editedArticleTitle->getNamespace();
		$editedArticleTitleText = $editedArticleTitle->getText();
		if ( ( $editedArticleTitleNS === NS_MEDIAWIKI
			&& substr( $editedArticleTitleText, -3 ) === '.js' )
			|| ( $editedArticleTitleNS === NS_USER
			&& preg_match( '/^' . preg_quote( $user->getName(), '/' ) . '\/.*\.js$/', $editedArticleTitleText ) )
		) {
			$this->out->disallowUserJs();
		}

		// initialize custom edit page
		$this->editPage = new EditPageLayout($editedArticle);
		$editedTitle = $this->editPage->getEditedTitle();

		$formCustomHandler = $this->editPage->getCustomFormHandler();

		$this->addJsVariable('wgIsEditPage', true);
		$this->addJsVariable('wgEditedTitle', $editedTitle->getPrefixedText());

		$this->addJsVariable('wgEditPageClass', $class ? $class:'SpecialCustomEditPage' );

		$this->addJsVariable('wgEditPageHandler',  !is_null($formCustomHandler)
			? $formCustomHandler->getLocalUrl('wpTitle=$1')
			: $this->app->getGlobal('wgScript') . '?action=ajax&rs=EditPageLayoutAjax&title=$1' );

		$this->addJsVariable('wgEditPagePopularTemplates', TemplateService::getPromotedTemplates());
		$this->addJsVariable('wgEditPageIsWidePage', $this->isWidePage() );

		if ($user->isLoggedIn()) {
			global $wgRTEDisablePreferencesChange;
			$wgRTEDisablePreferencesChange = true;
			$this->addJsVariable('wgEditPageWideSourceMode', (bool)$user->getOption( 'editwidth' ) );
			unset($wgRTEDisablePreferencesChange);
		}

		$this->addJsVariableRef('wgEditPageFormType', $this->editPage->formtype);
		$this->addJsVariableRef('wgEditPageIsConflict', $this->editPage->isConflict);
		$this->addJsVariable('wgEditPageIsReadOnly', $this->editPage->isReadOnlyPage());
		$this->addJsVariableRef('wgEditPageHasEditPermissionError', $this->editPage->mHasPermissionError);
		$this->addJsVariableRef('wgEditPageSection', $this->editPage->section);

		// data for license module (BugId:6967)
		$titleLicensing = GlobalTitle::newFromText( 'Community_Central:Licensing', null, 177 );
		$this->addJsVariable('wgEditPageLicensingUrl', $titleLicensing->getFullUrl());
		$this->addJsVariable('wgRightsText', $this->app->wg->RightsText);

		// copyright warning for notifications (BugId:7951)
		$this->addJsVariable('wgCopywarn', $this->editPage->getCopyrightNotice());

		// extra hooks for edit page
		$wgHooks['MakeGlobalVariablesScript'][] = 'EditPageLayoutHooks::onMakeGlobalVariablesScript';
		$wgHooks['SkinGetPageClasses'][] = 'EditPageLayoutHooks::onSkinGetPageClasses';

		$this->helper = self::getInstance();

		wfProfileOut(__METHOD__);
		return $this->editPage;
	}

	function isWidePage() {
		global $wgTitle;

		// Custom edit pages are mostly using special pages
		// and the default Oasis logic is not to show any rail modules
		// there so we need to tweak it
		if ($wgTitle->getNamespace() == NS_SPECIAL) {
			return false;
		}

		// Some nasty trick to make BodyModule think we are not
		// on edit page so it will make proper list of modules
		$action = $this->request->setVal('action',null);
		$diff = $this->request->setVal('diff',null);
		$railModuleList = (new BodyController)->getRailModuleList();
		$this->request->setVal('action',$action);
		$this->request->setVal('diff',$diff);

		return empty($railModuleList);
	}

	function getEditPage() {
		return $this->editPage;
	}

	/*
	 * adding js variable
	 */
	function addJsVariable($name, $value) {
		if($this->jsVarsPrinted) {
			throw new Exception('addJsVariable: too late to add js var' );
		}
		$this->jsVars[$name] = $value;
	}

	function addJsVariableRef($name, &$value) {
		if($this->jsVarsPrinted) {
			throw new Exception('addJsVariable: too late to add js var' );
		}
		$this->jsVars[$name] = $value;
	}



	/**
	 * Get static assets for AssetsManager group
	 *
	 * @static
	 * @return array
	 */
	static public function getAssets() {
		return array(
			// >> 3rd party libraries
			'resources/jquery.ui/jquery.ui.core.js',
			'resources/jquery.ui/jquery.ui.widget.js',
			'resources/jquery.ui/jquery.ui.position.js',
			'resources/jquery.ui/jquery.ui.autocomplete.js',
			'resources/wikia/libraries/jquery/md5/jquery.md5.js',
			'resources/wikia/libraries/mustache/mustache.js',
			//'resources/wikia/modules/uniqueId.js', // REQUIRED by RestoreEdit.js only
			// >> editor stack loaders and configurers
			'extensions/wikia/EditPageLayout/js/loaders/EditPageEditorLoader.js',
			// >> editor core
			'extensions/wikia/EditPageLayout/js/editor/WikiaEditor.js',
			'extensions/wikia/EditPageLayout/js/editor/WikiaEditorStorage.js',
			'extensions/wikia/EditPageLayout/js/editor/Buttons.js',
			'extensions/wikia/EditPageLayout/js/editor/Modules.js',
			// >> Wikia specific editor plugins
			'extensions/wikia/EditPageLayout/js/plugins/Tracker.js',
			'extensions/wikia/EditPageLayout/js/plugins/PageControls.js',
			'extensions/wikia/EditPageLayout/js/plugins/Autoresizer.js',
			'extensions/wikia/EditPageLayout/js/plugins/AddFile.js',
			'extensions/wikia/EditPageLayout/js/plugins/Collapsiblemodules.js',
			'extensions/wikia/EditPageLayout/js/plugins/Cssloadcheck.js',
			'extensions/wikia/EditPageLayout/js/plugins/Edittools.js',
			'extensions/wikia/EditPageLayout/js/plugins/Loadingstatus.js',
			'extensions/wikia/EditPageLayout/js/plugins/Noticearea.js',
			'extensions/wikia/EditPageLayout/js/plugins/Railminimumheight.js',
			'extensions/wikia/EditPageLayout/js/plugins/Sizechangedevent.js',
			'extensions/wikia/EditPageLayout/js/plugins/Wikiacore.js',
			'extensions/wikia/EditPageLayout/js/plugins/Widescreen.js',
			'extensions/wikia/EditPageLayout/js/plugins/Preloads.js',
			'extensions/wikia/EditPageLayout/js/plugins/Leaveconfirm.js',
			//'extensions/wikia/EditPageLayout/js/plugins/RestoreEdit.js',
			// >> extras (mainly things which should be moved elsewhere)
			'extensions/wikia/EditPageLayout/js/extras/Buttons.js',
			// >> visual modules - toolbars etc.
			'extensions/wikia/EditPageLayout/js/modules/Container.js',
			'extensions/wikia/EditPageLayout/js/modules/RailContainer.js',
			'extensions/wikia/EditPageLayout/js/modules/ButtonsList.js',
			'extensions/wikia/EditPageLayout/js/modules/Format.js',
			'extensions/wikia/EditPageLayout/js/modules/FormatExpanded.js',
			'extensions/wikia/EditPageLayout/js/modules/Insert.js',
			'extensions/wikia/EditPageLayout/js/modules/License.js',
			'extensions/wikia/EditPageLayout/js/modules/ModeSwitch.js',
			'extensions/wikia/EditPageLayout/js/modules/Categories.js',
			'extensions/wikia/EditPageLayout/js/modules/Templates.js',
			'extensions/wikia/EditPageLayout/js/modules/ToolbarMediawiki.js',
			'extensions/wikia/EditPageLayout/js/modules/ToolbarWidescreen.js',
		);
	}
}
