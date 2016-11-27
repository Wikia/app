<?php
/**
 * VisualEditor extension hooks
 *
 * @file
 * @ingroup Extensions
 * @copyright 2011-2014 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

class VisualEditorHooks {

	public static function isAvailable( $skin ) {
		global $wgVisualEditorSupportedSkins;
		static $isAvailable = null;
		if ( is_null( $isAvailable ) ) {
			$isAvailable = in_array( $skin->getSkinName(), $wgVisualEditorSupportedSkins );
		}
		return $isAvailable;
	}

	public static function isVisible( $skin ) {
		global $wgEnableVisualEditorUI;
		return $wgEnableVisualEditorUI && self::isAvailable( $skin );
	}

	public static function onSetup() {
		// This prevents VisualEditor from being run in environments that don't
		// have the dependent code in core; this should be updated as a part of
		// when additional dependencies are created and pushed into MediaWiki's
		// core. The most direct effect of this is to avoid confusing any third
		// parties who attempt to install VisualEditor onto non-alpha wikis, as
		// this should have no impact on deploying to Wikimedia's wiki cluster;
		// is fine for release tarballs because 1.22wmf11 < 1.22alpha < 1.22.0.
		wfUseMW( '1.25wmf13' );
	}

	/**
	 * Adds VisualEditor JS to the output.
	 *
	 * This is attached to the MediaWiki 'BeforePageDisplay' hook.
	 *
	 * @param OutputPage $output
	 * @param Skin $skin
	 * @return boolean
	 */
	public static function onBeforePageDisplay( OutputPage &$output, Skin &$skin ) {
		// Wikia change
		// SUS-936: Only load this for article related pages (where the editor can appear)
		if ( static::isAvailable( $skin ) && $output->isArticleRelated() ) {
			$output->addModules( array( 'ext.visualEditor.wikia.viewPageTarget.init' ) );
		}
		//$output->addModules( array( 'ext.visualEditor.viewPageTarget.init' ) );
		//$output->addModuleStyles( array( 'ext.visualEditor.viewPageTarget.noscript' ) );
		return true;
	}

	/**
	 * Convert the content model of messages that are actually JSON to JSON.
	 * This only affects validation and UI when saving and editing, not
	 * loading the content.
	 *
	 * @param Title $title
	 * @param string $model
	 * @return bool
	 */
	public static function onContentHandlerDefaultModelFor( Title $title, &$model ) {
		$messages = array(
			'Visualeditor-cite-tool-definition.json',
			'Visualeditor-specialcharinspector-characterlist-insert'
		);

		if ( $title->inNamespace( NS_MEDIAWIKI ) && in_array( $title->getText(), $messages ) ) {
			$model = CONTENT_MODEL_JSON;
		}

		return true;
	}

	/**
	 * Changes the Edit tab and adds the VisualEditor tab.
	 *
	 * This is attached to the MediaWiki 'SkinTemplateNavigation' hook.
	 *
	 * @param SkinTemplate $skin
	 * @param array $links Navigation links
	 * @return boolean
	 */
	public static function onSkinTemplateNavigation( SkinTemplate &$skin, array &$links ) {
		// Only do this if the user has VE enabled
		if ( !self::isVisible( $skin ) ) {
			return true;
		}

		$config = ConfigFactory::getDefaultInstance()->makeConfig( 'visualeditor' );

		if ( !isset( $links['views']['edit'] ) ) {
			// There's no edit link, nothing to do
			return true;
		}
		$title = $skin->getRelevantTitle();
		if ( defined( 'EP_NS' ) && $title->inNamespace( EP_NS ) ) {
			return true;
		}
		$tabMessages = $config->get( 'VisualEditorTabMessages' );
		// Rebuild the $links['views'] array and inject the VisualEditor tab before or after
		// the edit tab as appropriate. We have to rebuild the array because PHP doesn't allow
		// us to splice into the middle of an associative array.
		$newViews = array();
		foreach ( $links['views'] as $action => $data ) {
			if ( $action === 'edit' ) {
				// Build the VisualEditor tab
				$existing = $title->exists() || (
					$title->inNamespace( NS_MEDIAWIKI ) &&
					$title->getDefaultMessageText() !== false
				);
				$action = $existing ? 'edit' : 'create';
				$veParams = $skin->editUrlOptions();
				unset( $veParams['action'] ); // Remove action=edit
				$veParams['veaction'] = 'edit'; // Set veaction=edit
				$veTabMessage = $tabMessages[$action];
				$veTabText = $veTabMessage === null ? $data['text'] :
					$skin->msg( $veTabMessage )->text();
				$veTab = array(
					'href' => $title->getLocalURL( $veParams ),
					'text' => $veTabText,
					'primary' => true,
					'class' => '',
				);

				// Alter the edit tab
				$editTab = $data;
				if (
					$title->inNamespace( NS_FILE ) &&
					WikiPage::factory( $title ) instanceof WikiFilePage &&
					!WikiPage::factory( $title )->isLocal()
				) {
					$editTabMessage = $tabMessages[$action . 'localdescriptionsource'];
				} else {
					$editTabMessage = $tabMessages[$action . 'source'];
				}

				if ( $editTabMessage !== null ) {
					$editTab['text'] = $skin->msg( $editTabMessage )->text();
				}

				// Inject the VE tab before or after the edit tab
				if ( $config->get( 'VisualEditorTabPosition' ) === 'before' ) {
					$editTab['class'] .= ' collapsible';
					$newViews['ve-edit'] = $veTab;
					$newViews['edit'] = $editTab;
				} else {
					$veTab['class'] .= ' collapsible';
					$newViews['edit'] = $editTab;
					$newViews['ve-edit'] = $veTab;
				}
			} else {
				// Just pass through
				$newViews[$action] = $data;
			}
		}
		$links['views'] = $newViews;
		return true;
	}

	/**
	 * Called when the normal wikitext editor is shown.
	 * Inserts a 'veswitched' hidden field if requested by the client
	 *
	 * @param $editPage EditPage
	 * @param $output OutputPage
	 * @return boolean true
	 */
	public static function onEditPageShowEditFormFields( EditPage $editPage, OutputPage $output ) {
		$request = $output->getRequest();
		if ( $request->getBool( 'veswitched' ) ) {
			$output->addHTML( Xml::input( 'veswitched', false, '1', array( 'type' => 'hidden' ) ) );
		}
		return true;
	}

	/**
	 * Called when an edit is saved
	 * Adds 'visualeditor-switched' tag to the edit if requested
	 *
	 * @param $article WikiPage
	 * @param $user User
	 * @param $content Content
	 * @param $summary string
	 * @param $isMinor boolean
	 * @param $isWatch boolean
	 * @param $section int
	 * @param $flags int
	 * @param $revision Revision|null
	 * @param $status Status
	 * @param $baseRevId int|boolean
	 * @return boolean true
	 */
	public static function onPageContentSaveComplete(
		$article, $user, $content, $summary, $isMinor, $isWatch,
		$section, $flags, $revision, $status, $baseRevId
	) {
		$request = RequestContext::getMain()->getRequest();
		if ( $request->getBool( 'veswitched' ) && $revision ) {
			ChangeTags::addTags( 'visualeditor-switched', null, $revision->getId() );
		}
		return true;
	}

	/**
	 * Changes the section edit links to add a VE edit link.
	 *
	 * This is attached to the MediaWiki 'DoEditSectionLink' hook.
	 *
	 * @param $skin Skin
	 * @param $title Title
	 * @param $section string
	 * @param $tooltip string
	 * @param $result string HTML
	 * @param $lang Language
	 * @return bool true
	 */
	public static function onDoEditSectionLink( Skin $skin, Title $title, $section,
		$tooltip, &$result, $lang
	) {
		// Only do this if the user has VE enabled
		// (and we're not in parserTests)
		// (and we're not on a foreign file description page)
		if (
			!self::isVisible( $skin ) ||
			isset( $GLOBALS[ 'wgVisualEditorInParserTests' ] ) ||
			!$skin->getUser()->getGlobalPreference( 'visualeditor-enable' ) ||
			$skin->getUser()->getGlobalPreference( 'visualeditor-betatempdisable' ) ||
			(
				$title->inNamespace( NS_FILE ) &&
				WikiPage::factory( $title ) instanceof WikiFilePage &&
				!WikiPage::factory( $title )->isLocal()
			)
		) {
			return true;
		}

		$config = ConfigFactory::getDefaultInstance()->makeConfig( 'visualeditor' );
		$tabMessages = $config->get( 'VisualEditorTabMessages' );
		$veEditSection = $tabMessages['editsection'] !== null ?
			$tabMessages['editsection'] : 'editsection';
		$sourceEditSection = $tabMessages['editsectionsource'] !== null ?
			$tabMessages['editsectionsource'] : 'editsection';

		// Code mostly duplicated from Skin::doEditSectionLink() :(
		$attribs = array();
		if ( !is_null( $tooltip ) ) {
			# Bug 25462: undo double-escaping.
			$tooltip = Sanitizer::decodeCharReferences( $tooltip );
			$attribs['title'] = $skin->msg( 'editsectionhint' )->rawParams( $tooltip )
				->inLanguage( $lang )->text();
		}
		$veLink = Linker::link( $title, $skin->msg( $veEditSection )->inLanguage( $lang )->text(),
			$attribs + array( 'class' => 'mw-editsection-visualeditor' ),
			array( 'veaction' => 'edit', 'vesection' => $section ),
			array( 'noclasses', 'known' )
		);
		$sourceLink = Linker::link( $title, $skin->msg( $sourceEditSection )->inLanguage( $lang )->text(),
			$attribs,
			array( 'action' => 'edit', 'section' => $section ),
			array( 'noclasses', 'known' )
		);

		$veFirst = $config->get( 'VisualEditorTabPosition' ) === 'before';
		$result = '<span class="mw-editsection">'
			. '<span class="mw-editsection-bracket">[</span>'
			. ( $veFirst ? $veLink : $sourceLink )
			. '<span class="mw-editsection-divider">'
			. $skin->msg( 'pipe-separator' )->inLanguage( $lang )->text()
			. '</span>'
			. ( $veFirst ? $sourceLink : $veLink )
			. '<span class="mw-editsection-bracket">]</span>'
			. '</span>';

		return true;
	}

	/**
	 * Convert a namespace index to the local text for display to the user.
	 *
	 * @param $nsIndex int
	 * @return string
	 */
	private static function convertNs( $nsIndex ) {
		global $wgLang;
		if ( $nsIndex ) {
			return $wgLang->convertNamespace( $nsIndex );
		} else {
			return wfMessage( 'blanknamespace' )->text();
		}
	}

	public static function onGetPreferences( User $user, array &$preferences ) {
		global $wgLang;
		if ( !class_exists( 'BetaFeatures' ) ) {
			$namespaces = ConfigFactory::getDefaultInstance()
				->makeConfig( 'visualeditor' )
				->get( 'VisualEditorNamespaces' );

			$preferences['visualeditor-enable'] = array(
				'type' => 'toggle',
				'label-message' => array(
					'visualeditor-preference-enable',
					$wgLang->commaList( array_map(
						array( 'self', 'convertNs' ),
						$namespaces
					) ),
					count( $namespaces )
				),
				'section' => 'editing/editor'
			);
		}
		$preferences['visualeditor-betatempdisable'] = array(
			'type' => 'toggle',
			'label-message' => 'visualeditor-preference-betatempdisable',
			'section' => 'editing/editor'
		);
		$preferences['visualeditor-hidebetawelcome'] = array(
			'type' => 'api'
		);
		return true;
	}

	public static function onGetBetaPreferences( User $user, array &$preferences ) {
		$coreConfig = RequestContext::getMain()->getConfig();
		$iconpath = $coreConfig->get( 'ExtensionAssetsPath' ) . "/VisualEditor";

		$veConfig = ConfigFactory::getDefaultInstance()->makeConfig( 'visualeditor' );
		$preferences['visualeditor-enable'] = array(
			'version' => '1.0',
			'label-message' => 'visualeditor-preference-core-label',
			'desc-message' => 'visualeditor-preference-core-description',
			'screenshot' => array(
				'ltr' => "$iconpath/betafeatures-icon-VisualEditor-ltr.svg",
				'rtl' => "$iconpath/betafeatures-icon-VisualEditor-rtl.svg",
			),
			'info-message' => 'visualeditor-preference-core-info-link',
			'discussion-message' => 'visualeditor-preference-core-discussion-link',
			'requirements' => array(
				'javascript' => true,
				'blacklist' => $veConfig->get( 'VisualEditorBrowserBlacklist' ),
				'skins' => $veConfig->get( 'VisualEditorSupportedSkins' ),
			)
		);

		$preferences['visualeditor-enable-language'] = array(
			'version' => '1.0',
			'label-message' => 'visualeditor-preference-language-label',
			'desc-message' => 'visualeditor-preference-language-description',
			'screenshot' => array(
				'ltr' => "$iconpath/betafeatures-icon-VisualEditor-language-ltr.svg",
				'rtl' => "$iconpath/betafeatures-icon-VisualEditor-language-rtl.svg",
			),
			'info-message' => 'visualeditor-preference-language-info-link',
			'discussion-message' => 'visualeditor-preference-language-discussion-link',
			'requirements' => array(
				'betafeatures' => array(
					'visualeditor-enable',
				),
			),
		);

/* Disabling Beta Features option for generic content for now
		$preferences['visualeditor-enable-mwalienextension'] = array(
			'version' => '1.0',
			'label-message' => 'visualeditor-preference-mwalienextension-label',
			'desc-message' => 'visualeditor-preference-mwalienextension-description',
			'screenshot' => array(
				'ltr' => "$iconpath/betafeatures-icon-VisualEditor-alien-ltr.svg",
				'rtl' => "$iconpath/betafeatures-icon-VisualEditor-alien-rtl.svg",
			),
			'info-message' => 'visualeditor-preference-mwalienextension-info-link',
			'discussion-message' => 'visualeditor-preference-mwalienextension-discussion-link',
			'requirements' => array(
				'betafeatures' => array(
					'visualeditor-enable',
				),
			),
		);
*/
	}

	public static function onListDefinedTags( &$tags ) {
		$tags[] = 'visualeditor';
		$tags[] = 'visualeditor-needcheck';
		$tags[] = 'visualeditor-switched';
		return true;
	}

	/**
	 * Adds extra variables to the page config.
	 */
	public static function onMakeGlobalVariablesScript( array &$vars, OutputPage $out ) {
		global $wgSVGMaxSize, $wgNamespacesWithSubpages;

		$pageLanguage = $out->getTitle()->getPageLanguage();

		$vars['wgVisualEditor'] = array(
			'isPageWatched' => $out->getUser()->isWatched( $out->getTitle() ),
			'pageLanguageCode' => $pageLanguage->getHtmlCode(),
			'pageLanguageDir' => $pageLanguage->getDir(),
			'svgMaxSize' => $wgSVGMaxSize,
			'namespacesWithSubpages' => $wgNamespacesWithSubpages
		);

		return true;
	}

	/**
	 * Adds extra variables to the global config
	 */
	public static function onResourceLoaderGetConfigVars( array &$vars ) {
		global $wgDefaultUserOptions, $wgThumbLimits;
		$veConfig = ConfigFactory::getDefaultInstance()->makeConfig( 'visualeditor' );

		$vars['wgVisualEditorConfig'] = array(
			'disableForAnons' => $veConfig->get( 'VisualEditorDisableForAnons' ),
			'preferenceModules' => $veConfig->get( 'VisualEditorPreferenceModules' ),
			'namespaces' => $veConfig->get( 'VisualEditorNamespaces' ),
			'pluginModules' => $veConfig->get( 'VisualEditorPluginModules' ),
			'defaultUserOptions' => array(
				'betatempdisable' => $wgDefaultUserOptions['visualeditor-betatempdisable'],
				'enable' => $wgDefaultUserOptions['visualeditor-enable'],
				'defaultthumbsize' => $wgThumbLimits[ $wgDefaultUserOptions['thumbsize'] ]
			),
			'blacklist' => $veConfig->get( 'VisualEditorBrowserBlacklist' ),
			'skins' => $veConfig->get( 'VisualEditorSupportedSkins' ),
			'tabPosition' => $veConfig->get( 'VisualEditorTabPosition' ),
			'tabMessages' => $veConfig->get( 'VisualEditorTabMessages' ),
			'showBetaWelcome' => $veConfig->get( 'VisualEditorShowBetaWelcome' ),
			'enableTocWidget' => $veConfig->get( 'VisualEditorEnableTocWidget' )
		);

		foreach ( $veConfig->get( 'VisualEditorPreferenceModules' ) as $pref => $module ) {
			$vars['wgVisualEditorConfig']['defaultUserOptions'][$pref] =
				$wgDefaultUserOptions[$pref];
		}

		return true;
	}

	/**
	 * Conditionally register the jquery.uls.data and jquery.i18n modules, in case they've already
	 * been registered by the UniversalLanguageSelector extension.
	 *
	 * @param ResourceLoader $resourceLoader
	 * @return boolean true
	 */
	public static function onResourceLoaderRegisterModules( ResourceLoader &$resourceLoader ) {
		global $wgResourceModules;

		$veResourceTemplate = ConfigFactory::getDefaultInstance()
			->makeConfig( 'visualeditor')->get( 'VisualEditorResourceTemplate' );
		$libModules = array(
			'jquery.uls.data' => $veResourceTemplate + array(
				'scripts' => array(
					'lib/ve/lib/jquery.uls/src/jquery.uls.data.js',
					'lib/ve/lib/jquery.uls/src/jquery.uls.data.utils.js',
				),
				'targets' => array( 'desktop', 'mobile' ),
			),
			'jquery.i18n' => $veResourceTemplate + array(
				'scripts' => array(
					'lib/ve/lib/jquery.i18n/src/jquery.i18n.js',
					'lib/ve/lib/jquery.i18n/src/jquery.i18n.messagestore.js',
					'lib/ve/lib/jquery.i18n/src/jquery.i18n.parser.js',
					'lib/ve/lib/jquery.i18n/src/jquery.i18n.emitter.js',
					'lib/ve/lib/jquery.i18n/src/jquery.i18n.language.js',
				),
				'dependencies' => 'mediawiki.libs.pluralruleparser',
				'languageScripts' => array(
					'bs' => 'lib/ve/lib/jquery.i18n/src/languages/bs.js',
					'dsb' => 'lib/ve/lib/jquery.i18n/src/languages/dsb.js',
					'fi' => 'lib/ve/lib/jquery.i18n/src/languages/fi.js',
					'ga' => 'lib/ve/lib/jquery.i18n/src/languages/ga.js',
					'he' => 'lib/ve/lib/jquery.i18n/src/languages/he.js',
					'hsb' => 'lib/ve/lib/jquery.i18n/src/languages/hsb.js',
					'hu' => 'lib/ve/lib/jquery.i18n/src/languages/hu.js',
					'hy' => 'lib/ve/lib/jquery.i18n/src/languages/hy.js',
					'la' => 'lib/ve/lib/jquery.i18n/src/languages/la.js',
					'ml' => 'lib/ve/lib/jquery.i18n/src/languages/ml.js',
					'os' => 'lib/ve/lib/jquery.i18n/src/languages/os.js',
					'ru' => 'lib/ve/lib/jquery.i18n/src/languages/ru.js',
					'sl' => 'lib/ve/lib/jquery.i18n/src/languages/sl.js',
					'uk' => 'lib/ve/lib/jquery.i18n/src/languages/uk.js',
				),
				'targets' => array( 'desktop', 'mobile' ),
			),
		);

		$addModules = array();

		foreach ( $libModules as $name => $data ) {
			if ( !isset( $resourceModules[$name] ) && !$resourceLoader->getModule( $name ) ) {
				$addModules[$name] = $data;
			}
		}

		$resourceLoader->register( $addModules );
		return true;
	}

	public static function onResourceLoaderTestModules(
		array &$testModules,
		ResourceLoader &$resourceLoader
	) {
		$testModules['qunit']['ext.visualEditor.test'] = array(
			'styles' => array(
				// jsdifflib
				'lib/ve/lib/jsdifflib/diffview.css',
			),
			'scripts' => array(
				// MW config preload
				'modules/ve-mw/tests/mw-preload.js',
				// jsdifflib
				'lib/ve/lib/jsdifflib/diffview.js',
				'lib/ve/lib/jsdifflib/difflib.js',
				// QUnit plugin
				'lib/ve/tests/ve.qunit.js',
				// VisualEditor Tests
				'lib/ve/tests/ve.test.utils.js',
				'modules/ve-mw/tests/ve.test.utils.js',
				'lib/ve/tests/ve.test.js',
				'lib/ve/tests/ve.Document.test.js',
				'lib/ve/tests/ve.Node.test.js',
				'lib/ve/tests/ve.BranchNode.test.js',
				'lib/ve/tests/ve.LeafNode.test.js',
				// VisualEditor DataModel Tests
				'lib/ve/tests/dm/ve.dm.example.js',
				'lib/ve/tests/dm/ve.dm.AnnotationSet.test.js',
				'lib/ve/tests/dm/ve.dm.NodeFactory.test.js',
				'lib/ve/tests/dm/ve.dm.Node.test.js',
				'lib/ve/tests/dm/ve.dm.Converter.test.js',
				'lib/ve/tests/dm/ve.dm.BranchNode.test.js',
				'lib/ve/tests/dm/ve.dm.LeafNode.test.js',
				'lib/ve/tests/dm/ve.dm.LinearData.test.js',
				'lib/ve/tests/dm/nodes/ve.dm.TextNode.test.js',
				'modules/ve-mw/tests/dm/nodes/ve.dm.MWTransclusionNode.test.js',
				'lib/ve/tests/dm/ve.dm.Document.test.js',
				'modules/ve-mw/tests/dm/ve.dm.Document.test.js',
				'lib/ve/tests/dm/ve.dm.DocumentSynchronizer.test.js',
				'lib/ve/tests/dm/ve.dm.IndexValueStore.test.js',
				'lib/ve/tests/dm/ve.dm.InternalList.test.js',
				'modules/ve-mw/tests/dm/ve.dm.InternalList.test.js',
				'lib/ve/tests/dm/ve.dm.Transaction.test.js',
				'modules/ve-mw/tests/dm/ve.dm.Transaction.test.js',
				'lib/ve/tests/dm/ve.dm.TransactionProcessor.test.js',
				'lib/ve/tests/dm/ve.dm.Surface.test.js',
				'lib/ve/tests/dm/ve.dm.SurfaceFragment.test.js',
				'modules/ve-mw/tests/dm/ve.dm.SurfaceFragment.test.js',
				'lib/ve/tests/dm/ve.dm.ModelRegistry.test.js',
				'lib/ve/tests/dm/ve.dm.MetaList.test.js',
				'lib/ve/tests/dm/ve.dm.Model.test.js',
				'lib/ve/tests/dm/lineardata/ve.dm.FlatLinearData.test.js',
				'lib/ve/tests/dm/lineardata/ve.dm.ElementLinearData.test.js',
				'lib/ve/tests/dm/lineardata/ve.dm.MetaLinearData.test.js',
				'modules/ve-mw/tests/dm/ve.dm.mwExample.js',
				'modules/ve-mw/tests/dm/ve.dm.Converter.test.js',
				'modules/ve-mw/tests/dm/ve.dm.MWImageModel.test.js',
				// VisualEditor ContentEditable Tests
				'lib/ve/tests/ce/ve.ce.test.js',
				'lib/ve/tests/ce/ve.ce.Document.test.js',
				'lib/ve/tests/ce/ve.ce.Surface.test.js',
				'modules/ve-mw/tests/ce/ve.ce.Surface.test.js',
				'lib/ve/tests/ce/ve.ce.NodeFactory.test.js',
				'lib/ve/tests/ce/ve.ce.Node.test.js',
				'lib/ve/tests/ce/ve.ce.BranchNode.test.js',
				'lib/ve/tests/ce/ve.ce.ContentBranchNode.test.js',
				'modules/ve-mw/tests/ce/ve.ce.ContentBranchNode.test.js',
				'lib/ve/tests/ce/ve.ce.LeafNode.test.js',
				'lib/ve/tests/ce/nodes/ve.ce.TextNode.test.js',
				// VisualEditor Actions Tests
				'lib/ve/tests/ui/actions/ve.ui.AnnotationAction.test.js',
				'lib/ve/tests/ui/actions/ve.ui.FormatAction.test.js',
				'modules/ve-mw/tests/ui/actions/ve.ui.FormatAction.test.js',
				'lib/ve/tests/ui/actions/ve.ui.IndentationAction.test.js',
				'lib/ve/tests/ui/actions/ve.ui.ListAction.test.js',
				// VisualEditor initialization Tests
				'lib/ve/tests/init/ve.init.Platform.test.js',
				'modules/ve-mw/tests/init/targets/ve.init.mw.ViewPageTarget.test.js',
				// IME tests
				// FIXME: these work in VE core but break in VE-MW, so not running most of them for now
				'lib/ve/tests/ce/ve.ce.TestRunner.js',
				'lib/ve/tests/ce/ve.ce.imetests.test.js',
				//'lib/ve/tests/ce/imetests/backspace-chromium-ubuntu-none.js',
				//'lib/ve/tests/ce/imetests/backspace-firefox-ubuntu-none.js',
				//'lib/ve/tests/ce/imetests/backspace-ie-win-none.js',
				/*
				'lib/ve/tests/ce/imetests/input-chrome-win-chinese-traditional-handwriting.js',
				'lib/ve/tests/ce/imetests/input-chrome-win-greek.js',
				'lib/ve/tests/ce/imetests/input-chrome-win-welsh.js',
				'lib/ve/tests/ce/imetests/input-chromium-ubuntu-ibus-chinese-cantonese.js',
				'lib/ve/tests/ce/imetests/input-chromium-ubuntu-ibus-japanese-anthy-' .
					'-hiraganaonly.js',
				'lib/ve/tests/ce/imetests/input-chromium-ubuntu-ibus-korean-korean.js',
				'lib/ve/tests/ce/imetests/input-chromium-ubuntu-ibus-malayalam-swanalekha.js',
				'lib/ve/tests/ce/imetests/input-firefox-ubuntu-ibus-chinese-cantonese.js',
				'lib/ve/tests/ce/imetests/input-firefox-ubuntu-ibus-japanese-anthy--hiraganaonly.js',
				'lib/ve/tests/ce/imetests/input-firefox-ubuntu-ibus-korean-korean.js',
				'lib/ve/tests/ce/imetests/input-firefox-ubuntu-ibus-malayalam.swanalekha.js',
				'lib/ve/tests/ce/imetests/input-firefox-win-chinese-traditional-handwriting.js',
				'lib/ve/tests/ce/imetests/input-firefox-win-greek.js',
				'lib/ve/tests/ce/imetests/input-firefox-win-welsh.js',
				'lib/ve/tests/ce/imetests/input-ie-win-chinese-traditional-handwriting.js',
				'lib/ve/tests/ce/imetests/input-ie-win-greek.js',
				'lib/ve/tests/ce/imetests/input-ie-win-korean.js',
				'lib/ve/tests/ce/imetests/input-ie-win-welsh.js',
				'lib/ve/tests/ce/imetests/leftarrow-chromium-ubuntu-none.js',
				'lib/ve/tests/ce/imetests/leftarrow-firefox-ubuntu-none.js',
				'lib/ve/tests/ce/imetests/leftarrow-ie-win-none.js',
				*/
			),
			'dependencies' => array(
				'unicodejs',
				'ext.visualEditor.standalone',
				'ext.visualEditor.core',
				'ext.visualEditor.mwcore',
				'ext.visualEditor.mwformatting',
				'ext.visualEditor.mwlink',
				'ext.visualEditor.mwgallery',
				'ext.visualEditor.mwimage',
				'ext.visualEditor.mwmeta',
				'ext.visualEditor.mwreference',
				'ext.visualEditor.mwtransclusion',
				'ext.visualEditor.experimental',
				'ext.visualEditor.viewPageTarget.init',
				'ext.visualEditor.viewPageTarget',
			),
			'localBasePath' => __DIR__,
			'remoteExtPath' => 'VisualEditor',
		);

		return true;
	}

	/**
	 * Ensures that we know whether we're running inside a parser test.
	 */
	public static function onParserTestGlobals( array &$settings ) {
		$settings['wgVisualEditorInParserTests'] = true;
	}

	/**
	 * @param Array $redirectParams Parameters preserved on special page redirects
	 *   to wiki pages
	 * @return bool Always true
	 */
	public static function onRedirectSpecialArticleRedirectParams( &$redirectParams ) {
		array_push( $redirectParams, 'veaction', 'vesection' );

		return true;
	}

	/**
	 * If the user has specified that they want to edit the page with VE, suppress any redirect.
	 * @param Title $title Title being used for request
	 * @param Article|null $article
	 * @param OutputPage $output
	 * @param User $user
	 * @param WebRequest $request
	 * @param MediaWiki $mediaWiki
	 * @return bool Always true
	 */
	public static function onBeforeInitialize(
		Title $title, $article, OutputPage $output,
		User $user, WebRequest $request, MediaWiki $mediaWiki
	) {
		if ( $request->getVal( 'veaction' ) === 'edit' ) {
			$request->setVal( 'redirect', 'no' );
		}
		return true;
	}
}
