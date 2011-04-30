<?php

/**
 * Applies updated layout for edit pages (Oasis only) Class is use as singleton
 */

class EditPageLayoutHelper {

	private $app;
	private $out;
	private $request;
	private $jsVars = array();
	private $jsVarsPrinted = false;
	public $editPage;

	function __construct() {
		$this->app = WF::build('App');
		$this->out = $this->app->getGlobal('wgOut');
		$this->request = $this->app->getGlobal('wgRequest');
	}

	/**
	 * Change the module used as an entry-point for Oasis skin and use custom class for rendering edit page
	 *
	 * Keep global and user nav only.
	 *
	 * @author macbre
	 */
	function setupEditPage(Article $editedArticle, $fullScreen = true) {
		wfProfileIn(__METHOD__);
		// don't render edit area when we're in read only mode
		if ($this->app->runFunction('wfReadOnly')) {
			// set correct page title
			$this->out->setPageTitle($this->app->runFunction('wfMsg', 'editing', $this->app->getGlobal('wgTitle')->getPrefixedText()));
			return false;
		}
		// TODO: create static chute package
		$wgExtensionsPath = $this->app->getGlobal('wgExtensionsPath');
		$cb = $this->app->getGlobal('wgStyleVersion');
		$wgJsMimeType = $this->app->getGlobal('wgJsMimeType');

		if ($fullScreen) {
			// add stylesheet
			$this->out->addStyle( AssetsManager::getInstance()->getSassCommonURL('extensions/wikia/EditPageLayout/css/EditPageLayout.scss'));

			// add javascript engine
			$srcs = F::build('AssetsManager',array(),'getInstance')->getGroupCommonURL('epl');
			foreach($srcs as $src) {
				$this->out->addScript("<script src=\"{$src}\" type=\"{$wgJsMimeType}\"></script>");
			}

			// set Oasis entry-point
			Wikia::setVar('OasisEntryModuleName', 'EditPageLayout');

			/*
			$files = self::getAssets();
			foreach ($files as $file) {
				$this->out->addScript("<script type=\"{$wgJsMimeType}\" src=\"{$wgExtensionsPath}/wikia/EditPageLayout/js/{$file}?{$cb}\"></script>");
			}
			*/
		}

		// macbre: load YUI on edit page (it's always loaded using $.loadYUI)
		// PLB has problems with $.loadYUI not working correctly in Firefox (callback is fired to early)
		$staticChute = new StaticChute('js');
		$staticChute->useLocalChuteUrl();

		$this->out->addScript($staticChute->getChuteHtmlForPackage('yui'));

		// initialize custom edit page
		$this->editPage = new EditPageLayout($editedArticle);
		$editedTitle = $this->editPage->getEditedTitle();

		$formCustomHandler = $this->editPage->getCustomFormHandler();

		$this->addJsVariable('wgIsEditPage', true);
		$this->addJsVariable('wgEditedTitle', $editedTitle->getPrefixedText());

		$this->addJsVariable('wgEditPageHandler',  !is_null($formCustomHandler)
			? $formCustomHandler->getLocalUrl('wpTitle=$1')
			: $this->app->getGlobal('wgScript') . '?action=ajax&rs=EditPageLayoutAjax&title=$1' );

		$this->addJsVariable('wgEditPagePopularTemplates', TemplateService::getPromotedTemplates());
		$this->addJsVariable('wgEditPageIsWidePage', $this->isWidePage() );

		$this->addJsVariableRef('wgEditPageFormType', $this->editPage->formtype);
		$this->addJsVariableRef('wgEditPageIsConflict', $this->editPage->isConflict);
		$this->addJsVariable('wgEditPageIsReadOnly', $this->editPage->isReadOnlyPage());
		$this->addJsVariableRef('wgEditPageHasEditPermissionError', $this->editPage->mHasPermissionError);

		$titleLicensing = GlobalTitle::newFromText( 'Community_Central:Licensing', null, 177 );
		$this->addJsVariable('wgEditPageLicensingUrl', $titleLicensing->getFullUrl());

		// extra hooks for edit page
		$this->app->registerHook('MakeGlobalVariablesScript', 'EditPageLayoutHelper', 'onMakeGlobalVariablesScript', array(), false, $this);
		$this->app->registerHook('SkinGetPageClasses', 'EditPageLayoutHelper', 'onSkinGetPageClasses', array(), false, $this);

		WF::setInstance('EditPageLayoutHelper', $this );

		wfProfileOut(__METHOD__);
		return $this->editPage;
	}

	function isWidePage() {
		global $wgTitle, $wgRequest;

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
		$railModuleList = WF::build('BodyModule')->getRailModuleList();
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
			return ;
		}
		$this->jsVars[$name] = $value;
	}

	function addJsVariableRef($name, &$value) {
		if($this->jsVarsPrinted) {
			throw new Exception('addJsVariable: too late to add js var' );
			return ;
		}
		$this->jsVars[$name] = & $value;
	}

	function onAlternateEditPageClass(&$editPage) {
		// apply only for Oasis
		if (!Wikia::isOasis()) {
			return true;
		}

		$editPage = $this->setupEditPage($this->app->getGlobal('wgArticle'));

		// return false when in read-only mode
		return !empty($editPage);
	}

	/**
	 * Add wgIsEditPage global JS variable on edit pages
	 */
	function onMakeGlobalVariablesScript($vars) {
		foreach( $this->jsVars as $key => $value ) {
			$vars[$key] = $value;
		}

		return true;
	}

	/**
	 * Add CSS class to <body> element when there's an conflict edit or undo revision is about to be performed
	 */
	function onSkinGetPageClasses(&$classes) {
		if ($this->editPage->isConflict || $this->editPage->formtype == 'diff') {
			$classes .= ' EditPageScrollable';
		}

		if (!empty($this->editPage->mHasPermissionError)) {
			$classes .= ' EditPagePermissionError';
		}

		return true;
	}

	/**
	 * Reverse parse wikitext when performing diff for edit conflict
	 */
	function onEditPageBeforeConflictDiff(&$editform, &$out ) {
		if (class_exists('RTE') && $this->request->getVal('RTEMode') == 'wysiwyg') {
			$editform->textbox2 = RTE::HtmlToWikitext($editform->textbox2);
		}

		return true;
	}

	/**
	 * Reverse parse wikitext when performing diff for undo revision
	 */
	function onEditPageGetDiffText($editform, &$newtext) {
		if (class_exists('RTE') && $this->app->getGlobal('wgWysiwygEdit')) {
			$newtext = RTE::HtmlToWikitext($newtext);
		}

		return true;
	}

	/**
	 * Apply user preferences changes
	 */
	function onGetPreferences($user, &$defaultPreferences) {
		// rewrite sections for the following user options
		$prefs = array(
			// General
			'enablerichtext' => 'general',
			'disablespellchecker' => 'general',

			// Starting an edit
			'editsection' => 'starting-an-edit',
			'editsectiononrightclick' => 'starting-an-edit',
			'editondblclick' => 'starting-an-edit',
			'createpagedefaultblank' => 'starting-an-edit',
			'createpagepopupdisabled' => 'starting-an-edit',

			// Editing experience
			'minordefault' => 'editing-experience',
			'forceeditsummary' => 'editing-experience',
			'disablecategoryselect' => 'editing-experience',
			'editwidth' => 'editing-experience',

			// Monobook layout only
			'showtoolbar' => 'monobook-layout',
			'previewontop' => 'monobook-layout',
			'previewonfirst' => 'monobook-layout',
			'disablelinksuggest' => 'monobook-layout',

			// Size of editing window (Monobook layout only)
			'cols' => 'editarea-size',
			'rows' => 'editarea-size',
		);

		foreach($prefs as $name => $section) {
			if (isset($defaultPreferences[$name])) {
				$defaultPreferences[$name]['section'] = 'editing/' . $section;
			}
		}

		return true;
	}

	static public function getAssets() {
		return array(
			'extensions/wikia/EditPageLayout/js/loaders/EditPageEditorLoader.js',
			'extensions/wikia/EditPageLayout/js/editor/WikiaEditor.js',
			'extensions/wikia/EditPageLayout/js/editor/Tracker.js',
			'extensions/wikia/EditPageLayout/js/editor/PageControls.js',
			'extensions/wikia/EditPageLayout/js/editor/CommonPlugins.js',
			'extensions/wikia/EditPageLayout/js/editor/Modules.js',
			'extensions/wikia/EditPageLayout/js/editor/Buttons.js',
			'extensions/wikia/EditPageLayout/js/editor/Widescreen.js',
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
