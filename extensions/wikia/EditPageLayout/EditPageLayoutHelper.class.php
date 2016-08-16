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
		if ( !isset( self::$instance ) ) {
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
	function setupEditPage( Article $editedArticle, $fullScreen = true, $class = false ) {
		global $wgHooks, $wgEditPreviewMercuryUrl;

		wfProfileIn( __METHOD__ );

		$user = $this->app->wg->User;

		// don't render edit area when we're in read only mode
		if ( wfReadOnly() ) {
			// set correct page title
			$this->out->setPageTitle( wfMessage( 'editing', $this->app->getGlobal( 'wgTitle' )->getPrefixedText())->escaped() );
			wfProfileOut( __METHOD__ );
			return false;
		}

		// use "reskined" edit page layout
		$this->fullScreen = $fullScreen;
		if ( $fullScreen ) {
			// set Oasis entry-point
			Wikia::setVar( 'OasisEntryControllerName', 'EditPageLayout' );
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

		// Add variables for pages to edit code (css, js, lua)
		if ( $this->isCodeSyntaxHighlightingEnabled( $editedArticleTitle ) ) {
			$this->prepareVarsForCodePage( $editedArticleTitle );
		}

		// initialize custom edit page
		$this->editPage = new EditPageLayout( $editedArticle );
		$editedTitle = $this->editPage->getEditedTitle();

		$formCustomHandler = $this->editPage->getCustomFormHandler();

		$this->addJsVariable( 'wgIsEditPage', true );
		$this->addJsVariable( 'wgEditedTitle', $editedTitle->getPrefixedText() );

		$this->addJsVariable( 'wgEditPageClass', $class ? $class:'SpecialCustomEditPage' );

		$this->addJsVariable( 'wgEditPageHandler',  !is_null( $formCustomHandler )
			? $formCustomHandler->getLocalUrl( 'wpTitle=$1' )
			: $this->app->getGlobal( 'wgScript' ) . '?action=ajax&rs=EditPageLayoutAjax&title=$1' );

		$this->addJsVariable( 'wgEditPreviewMercuryUrl', $wgEditPreviewMercuryUrl );

		$this->addJsVariable( 'wgEditPagePopularTemplates', TemplateService::getPromotedTemplates() );
		$this->addJsVariable( 'wgEditPageIsWidePage', $this->isWidePage() );
		$this->addJsVariable( 'wgIsDarkTheme', SassUtil::isThemeDark() );

		if ( $user->isLoggedIn() ) {
			global $wgRTEDisablePreferencesChange;
			$wgRTEDisablePreferencesChange = true;
			$this->addJsVariable( 'wgEditPageWideSourceMode', (bool)$user->getGlobalPreference( 'editwidth' ) );
			unset( $wgRTEDisablePreferencesChange );
		}

		$this->addJsVariableRef( 'wgEditPageFormType', $this->editPage->formtype );
		$this->addJsVariableRef( 'wgEditPageIsConflict', $this->editPage->isConflict );
		$this->addJsVariable( 'wgEditPageIsReadOnly', $this->editPage->isReadOnlyPage() );
		$this->addJsVariableRef( 'wgEditPageHasEditPermissionError', $this->editPage->mHasPermissionError );
		$this->addJsVariableRef( 'wgEditPageSection', $this->editPage->section );

		// data for license module (BugId:6967)
		$titleLicensing = GlobalTitle::newFromText( 'Community_Central:Licensing', null, 177 );
		$this->addJsVariable( 'wgEditPageLicensingUrl', $titleLicensing->getFullUrl() );
		$this->addJsVariable( 'wgRightsText', $this->app->wg->RightsText );

		// copyright warning for notifications (BugId:7951)
		$this->addJsVariable( 'wgCopywarn', $this->editPage->getCopyrightNotice() );

		// extra hooks for edit page
		$wgHooks['MakeGlobalVariablesScript'][] = 'EditPageLayoutHooks::onMakeGlobalVariablesScript';
		$wgHooks['SkinGetPageClasses'][] = 'EditPageLayoutHooks::onSkinGetPageClasses';

		$this->helper = self::getInstance();

		wfProfileOut( __METHOD__ );
		return $this->editPage;
	}

	function isWidePage() {
		global $wgTitle;

		// Custom edit pages are mostly using special pages
		// and the default Oasis logic is not to show any rail modules
		// there so we need to tweak it
		if ( $wgTitle->getNamespace() == NS_SPECIAL ) {
			return false;
		}

		// Some nasty trick to make BodyModule think we are not
		// on edit page so it will make proper list of modules
		$action = $this->request->setVal( 'action',null );
		$diff = $this->request->setVal( 'diff',null );
		$railModuleList = (new BodyController)->getRailModuleList();
		$this->request->setVal( 'action',$action );
		$this->request->setVal( 'diff',$diff );

		return empty( $railModuleList );
	}

	function getEditPage() {
		return $this->editPage;
	}

	/**
	 * Check if edited page is a code page
	 * (page to edit CSS, JS, Lua code or an infobox template)
	 *
	 * @param Title $articleTitle page title
	 * @return bool
	 */
	static public function isCodePage( Title $articleTitle ) {
		global $wgCityId, $wgEnableTemplateClassificationExt, $wgEnableTemplateDraftExt;

		if ( $articleTitle->inNamespace( NS_MODULE ) ) {
			return true;
		} elseif ( $articleTitle->inNamespace( NS_TEMPLATE ) ) {
			// Is template being converted to a portable infobox?
			if ( $wgEnableTemplateDraftExt && TemplateConverter::isConversion()	) {
				return true;
			} elseif ( $wgEnableTemplateClassificationExt ) {
				$templateType = ( new UserTemplateClassificationService() )
					->getType( $wgCityId, $articleTitle->getArticleID() );
				return $templateType === TemplateClassificationService::TEMPLATE_INFOBOX;
			}
		}

		return $articleTitle->isCssOrJsPage() || $articleTitle->isCssJsSubpage();
	}

	/**
	 * Check if code syntax highlighting is enabled
	 *
	 * @param Title $articleTitle page title
	 * @return bool
	 */
	static public function isCodeSyntaxHighlightingEnabled( Title $articleTitle ) {
		global $wgEnableEditorSyntaxHighlighting, $wgUser;

		return self::isCodePage( $articleTitle )
			&& $wgEnableEditorSyntaxHighlighting
			&& !$wgUser->getGlobalPreference( 'disablesyntaxhighlighting' );
	}

	static public function isTemplateDraft( $title ) {
		global $wgEnableTemplateDraftExt;

		return !empty( $wgEnableTemplateDraftExt ) && TemplateDraftHelper::isTitleDraft( $title );
	}

	/**
	 * Check if wikitext syntax highlighting is enabled, so
	 * - $wgEnableEditorSyntaxHighlighting is set to true
	 * - user doesn't disable syntax highlighting in preferences
	 *
	 * @return bool
	 */
	static public function isWikitextSyntaxHighlightingEnabled() {
		global $wgEnableEditorSyntaxHighlighting, $wgUser;

		return $wgEnableEditorSyntaxHighlighting
				&& !$wgUser->getGlobalPreference( 'disablesyntaxhighlighting' );
	}

	/**
	 * Check if we should show mobile and desktop preview icon
	 * Excluded pages:
	 * - Main page
	 * - Code page (CSS, JS and Lua)
	 * - MediaWiki:Wiki-navigation
	 *
	 * @param Title $title
	 * @return bool
	 */
	public function showMobilePreview( Title $title ) {
		$blacklistedPage = ( self::isCodePage( $title )
				&& !self::isCodePageWithPreview( $title ) )
			|| $title->isMainPage()
			|| NavigationModel::isWikiNavMessage( $title );

		return !$blacklistedPage;
	}

	/**
	 * This method checks if the $title comes from one of whitelisted code pages with
	 * a preview enabled for them. DO NOT check for self::isCodePage, it makes no sense if
	 * by definition you include only code pages here.
	 * @param Title $title
	 * @return bool
	 */
	public static function isCodePageWithPreview( Title $title ) {
		return $title->inNamespace( NS_TEMPLATE );
	}

	/**
	 * Prepare variables to init and support edit code pages
	 *
	 * @param Title $title
	 */
	private function prepareVarsForCodePage( Title $title ) {
		$namespace = $title->getNamespace();
		$type = '';

		$aceUrl = AssetsManager::getInstance()->getOneCommonURL( 'resources/Ace' );
		$aceUrlParts = parse_url( $aceUrl );
		$this->addJsVariable( 'aceScriptsPath', $aceUrlParts['path'] );

		$this->addJsVariable( 'wgEnableCodePageEditor', true );
		$this->addJsVariable( 'showPagePreview', self::showMobilePreview( $title ) );

		if ( $namespace === NS_MODULE ) {
			$type = 'lua';
		} elseif ( $title->isCssPage() || $title->isCssSubpage() ) {
			$type = 'css';
		} elseif ( $title->isJsPage() || $title->isJsSubpage() ) {
			$type = 'javascript';
		} else {
			// default to XML since most templates use HTML tags or infobox markup
			$type = 'xml';
		}

		$this->addJsVariable( 'codePageType', $type );
	}

	/*
	 * adding js variable
	 */
	function addJsVariable( $name, $value ) {
		if( $this->jsVarsPrinted ) {
			throw new Exception( 'addJsVariable: too late to add js var' );
		}
		$this->jsVars[$name] = $value;
	}

	function addJsVariableRef( $name, &$value ) {
		if( $this->jsVarsPrinted ) {
			throw new Exception( 'addJsVariable: too late to add js var' );
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
			// >> editor core
			'extensions/wikia/EditPageLayout/js/editor/WikiaEditor.js',
			'extensions/wikia/EditPageLayout/js/editor/WikiaEditorStorage.js',
			'extensions/wikia/EditPageLayout/js/editor/Buttons.js',
			'extensions/wikia/EditPageLayout/js/editor/Modules.js',
			// >> Wikia specific editor plugins
			'extensions/wikia/EditPageLayout/js/plugins/EditorSurvey.js',
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
			'extensions/wikia/EditPageLayout/js/plugins/TemplateClassificationEditorPlugin.js',
			'extensions/wikia/EditPageLayout/js/plugins/Wikiacore.js',
			'extensions/wikia/EditPageLayout/js/plugins/Widescreen.js',
			'extensions/wikia/EditPageLayout/js/plugins/Preloads.js',
			'extensions/wikia/EditPageLayout/js/plugins/Leaveconfirm.js',
			'extensions/wikia/EditPageLayout/js/plugins/WikitextSyntaxHighlighterQueueInit.js',
			'extensions/wikia/EditPageLayout/js/plugins/WikitextSyntaxHighlighter.js',
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
