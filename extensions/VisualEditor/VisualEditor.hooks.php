<?php
/**
 * VisualEditor extension hooks
 *
 * @file
 * @ingroup Extensions
 * @copyright 2011-2015 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

class VisualEditorHooks {
	public static function onSetup() {
		// This prevents VisualEditor from being run in environments that don't
		// have the dependent code in core; this should be updated as a part of
		// when additional dependencies are created and pushed into MediaWiki's
		// core. The most direct effect of this is to avoid confusing any third
		// parties who attempt to install VisualEditor onto non-alpha wikis, as
		// this should have no impact on deploying to Wikimedia's wiki cluster;
		// is fine for release tarballs because 1.22wmf11 < 1.22alpha < 1.22.0.
		wfUseMW( '1.26wmf12' );
	}

	/**
	 * Initialise the 'VisualEditorAvailableNamespaces' setting, and add content
	 * namespaces to it. This will run after LocalSettings.php is processed.
	 */
	public static function onRegistration() {
		global $wgVisualEditorAvailableNamespaces, $wgContentNamespaces;

		foreach ( $wgContentNamespaces as $contentNamespace ) {
			if ( !isset( $wgVisualEditorAvailableNamespaces[$contentNamespace] ) ) {
				$wgVisualEditorAvailableNamespaces[$contentNamespace] = true;
			}
		}

	}

	public static function VisualEditorApiFactory( $main, $name ) {
		$config = ConfigFactory::getDefaultInstance()->makeConfig( 'visualeditor' );
		$class = $name === 'visualeditor' ? 'ApiVisualEditor' : 'ApiVisualEditorEdit';
		return new $class( $main, $name, $config );
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
		$output->addModules( array(
			//'ext.visualEditor.desktopArticleTarget.init',
			'ext.visualEditor.wikia.desktopArticleTarget.init',
			'ext.visualEditor.targetLoader',
			'ext.visualEditor.wikia'
		) );
		$output->addModuleStyles( array( 'ext.visualEditor.desktopArticleTarget.noscript' ) );
		// add scroll offset js variable to output
		$veConfig = ConfigFactory::getDefaultInstance()->makeConfig( 'visualeditor' );
		$skinsToolbarScrollOffset = $veConfig->get( 'VisualEditorSkinToolbarScrollOffset' );
		$toolbarScrollOffset = 0;
		$skinName = $skin->getSkinName();
		if ( isset( $skinsToolbarScrollOffset[$skinName] ) ) {
			$toolbarScrollOffset = $skinsToolbarScrollOffset[$skinName];
		}
		$output->addJsConfigVars( 'wgVisualEditorToolbarScrollOffset', $toolbarScrollOffset );
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
			'Visualeditor-quick-access-characters.json'
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
		$config = ConfigFactory::getDefaultInstance()->makeConfig( 'visualeditor' );

		// Exit if the user doesn't have VE enabled
		if (
			!$skin->getUser()->getOption( 'visualeditor-enable' ) ||
			$skin->getUser()->getOption( 'visualeditor-betatempdisable' ) ||
			( $config->get( 'VisualEditorDisableForAnons' ) && $skin->getUser()->isAnon() )
		) {
			return true;
		}

		// Exit if there's no edit link for whatever reason (e.g. protected page)
		if ( !isset( $links['views']['edit'] ) ) {
			return true;
		}

		$availableNamespaces = $config->get( 'VisualEditorAvailableNamespaces' );
		$title = $skin->getRelevantTitle();
		$namespaceEnabled = $title->inNamespaces( array_keys( array_filter( $availableNamespaces ) ) );
		/*
		$pageContentModel = $title->getContentModel();
		// Don't exit if this page isn't VE-enabled, since we should still
		// change "Edit" to "Edit source".
		$isAvailable = (
			$namespaceEnabled &&
			$pageContentModel === CONTENT_MODEL_WIKITEXT
		);
		*/
		$isAvailable = $namespaceEnabled;

		// HACK: Exit if we're in the Education Program namespace (even though it's content)
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
				if ( $isAvailable ) {
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
					// Don't add ve-edit, but do update the edit tab (e.g. "Edit source").
					$newViews['edit'] = $editTab;
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
	 * @param RecentChange $rc
	 * @return boolean true
	 */
	public static function onRecentChange_save( RecentChange $rc ) {
		$request = RequestContext::getMain()->getRequest();
		if ( $request->getBool( 'veswitched' ) && $rc->mAttribs['rc_this_oldid'] ) {
			ChangeTags::addTags( 'visualeditor-switched',
				$rc->mAttribs['rc_id'], $rc->mAttribs['rc_this_oldid'] );
		}
		return true;
	}

	/**
	 * Changes the section edit links to add a VE edit link.
	 *
	 * This is attached to the MediaWiki 'SkinEditSectionLinks' hook.
	 *
	 * @param $skin Skin
	 * @param $title Title
	 * @param $section string
	 * @param $tooltip string
	 * @param $result array
	 * @param $lang Language
	 * @return bool true
	 */
	public static function onSkinEditSectionLinks( Skin $skin, Title $title, $section,
		$tooltip, &$result, $lang
	) {
		// Exit if we're in parserTests
		if ( isset( $GLOBALS[ 'wgVisualEditorInParserTests' ] ) ) {
			return true;
		}

		// Exit if the user doesn't have VE enabled
		if (
			!$skin->getUser()->getOption( 'visualeditor-enable' ) ||
			$skin->getUser()->getOption( 'visualeditor-betatempdisable' )
		) {
			return true;
		}

		$availableNamespaces = ConfigFactory::getDefaultInstance()
			->makeConfig( 'visualeditor' )->get( 'VisualEditorAvailableNamespaces' );
		// Exit if we're not in a VE-enabled namespace
		if ( !$title->inNamespaces( array_keys( array_filter( $availableNamespaces ) ) ) ) {
			return true;
		}

		// Exit if we're on a foreign file description page
		if (
			$title->inNamespace( NS_FILE ) &&
			WikiPage::factory( $title ) instanceof WikiFilePage &&
			!WikiPage::factory( $title )->isLocal()
		) {
			return true;
		}

		$config = ConfigFactory::getDefaultInstance()->makeConfig( 'visualeditor' );
		$tabMessages = $config->get( 'VisualEditorTabMessages' );
		$veEditSection = $tabMessages['editsection'] !== null ?
			$tabMessages['editsection'] : 'editsection';
		$sourceEditSection = $tabMessages['editsectionsource'] !== null ?
			$tabMessages['editsectionsource'] : 'editsection';

		$result['editsection']['text'] = $skin->msg( $sourceEditSection )->inLanguage( $lang )->text();

		$veLink = array(
			'text' => $skin->msg( $veEditSection )->inLanguage( $lang )->text(),
			'targetTitle' => $title,
			'attribs' => $result['editsection']['attribs'] + array(
				'class' => 'mw-editsection-visualeditor'
			),
			'query' => array( 'veaction' => 'edit', 'vesection' => $section ),
			'options' => array( 'noclasses', 'known' )
		);

		$result['veeditsection'] = $veLink;
		if ( $config->get( 'VisualEditorTabPosition' ) === 'before' ) {
			krsort( $result );
			// TODO: This will probably cause weird ordering if any other extensions added something already.
			// ... wfArrayInsertBefore?
		}

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
				->get( 'VisualEditorAvailableNamespaces' );
			$onNamespaces = array_keys( array_filter( $namespaces ) );

			$preferences['visualeditor-enable'] = array(
				'type' => 'toggle',
				'label-message' => array(
					'visualeditor-preference-enable',
					$wgLang->commaList( array_map(
						array( 'self', 'convertNs' ),
						$onNamespaces
					) ),
					count( $onNamespaces )
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
		$preferences['visualeditor-findAndReplace-regex'] = array(
			'type' => 'api'
		);
		$preferences['visualeditor-findAndReplace-matchCase'] = array(
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
	}

	/**
	 * Implements the ListDefinedTags and ChangeTagsListActive hooks, to populate
	 * core Special:Tags with the change tags in use by VisualEditor.
	 *
	 * @param array $tags
	 * @return bool true
	 */
	public static function onListDefinedTags( &$tags ) {
		$tags[] = 'visualeditor';
		$tags[] = 'visualeditor-needcheck'; // No longer in active use
		$tags[] = 'visualeditor-switched';
		return true;
	}

	/**
	 * Adds extra variables to the page config.
	 */
	public static function onMakeGlobalVariablesScript( array &$vars, OutputPage $out ) {
		$pageLanguage = $out->getTitle()->getPageLanguage();

		$vars['wgVisualEditor'] = array(
			'pageLanguageCode' => $pageLanguage->getHtmlCode(),
			'pageLanguageDir' => $pageLanguage->getDir(),
			'usePageImages' => defined( 'PAGE_IMAGES_INSTALLED' ),
			'usePageDescriptions' => defined( 'WBC_VERSION' ),
		);

		return true;
	}

	/**
	 * Adds extra variables to the global config
	 */
	public static function onResourceLoaderGetConfigVars( array &$vars ) {
		global $wgDefaultUserOptions, $wgThumbLimits, $wgSVGMaxSize, $wgNamespacesWithSubpages, $wgVisualEditorRestbaseURL;
		$veConfig = ConfigFactory::getDefaultInstance()->makeConfig( 'visualeditor' );
		$availableNamespaces = $veConfig->get( 'VisualEditorAvailableNamespaces' );
		$onNamespaces = array_keys( array_filter( $availableNamespaces ) );

		$vars['wgVisualEditorConfig'] = array(
			'disableForAnons' => $veConfig->get( 'VisualEditorDisableForAnons' ),
			'preferenceModules' => $veConfig->get( 'VisualEditorPreferenceModules' ),
			'namespaces' => $onNamespaces,
			'pluginModules' => array_merge(
				ExtensionRegistry::getInstance()->getAttribute( 'VisualEditorPluginModules' ),
				$veConfig->get( 'VisualEditorPluginModules' ) // @todo deprecate the global setting
			),
			'defaultUserOptions' => array(
				'defaultthumbsize' => $wgThumbLimits[ $wgDefaultUserOptions['thumbsize'] ]
			),
			'blacklist' => $veConfig->get( 'VisualEditorBrowserBlacklist' ),
			'skins' => $veConfig->get( 'VisualEditorSupportedSkins' ),
			'tabPosition' => $veConfig->get( 'VisualEditorTabPosition' ),
			'tabMessages' => $veConfig->get( 'VisualEditorTabMessages' ),
			'showBetaWelcome' => $veConfig->get( 'VisualEditorShowBetaWelcome' ),
			'enableTocWidget' => $veConfig->get( 'VisualEditorEnableTocWidget' ),
			'svgMaxSize' => $wgSVGMaxSize,
			'namespacesWithSubpages' => $wgNamespacesWithSubpages,
			'specialBooksources' => urldecode( SpecialPage::getTitleFor( 'Booksources' )->getPrefixedURL() ),
			'restbaseUrl' => $wgVisualEditorRestbaseURL,
		);

		return true;
	}

	/**
	 * Conditionally register the jquery.uls.data and jquery.i18n modules, in case they've already
	 * been registered by the UniversalLanguageSelector extension or the TemplateData extension.
	 *
	 * @param ResourceLoader $resourceLoader
	 * @return boolean true
	 */
	public static function onResourceLoaderRegisterModules( ResourceLoader &$resourceLoader ) {
		global $wgResourceModules;

		$veResourceTemplate = array(
			'localBasePath' => __DIR__,
			'remoteExtPath' => 'VisualEditor',
		);

		// Only pull in VisualEditor core's local version of jquery.uls.data if it hasn't been
		// installed locally already (presumably, by the UniversalLanguageSelector extension).
		if (
			!isset( $wgResourceModules[ 'jquery.uls.data' ] ) &&
			!$resourceLoader->isModuleRegistered( 'jquery.uls.data' )
		) {
			$resourceLoader->register( array(
				'jquery.uls.data' => $veResourceTemplate + array(
					'scripts' => array(
						'lib/ve/lib/jquery.uls/src/jquery.uls.data.js',
						'lib/ve/lib/jquery.uls/src/jquery.uls.data.utils.js',
					),
					'targets' => array( 'desktop', 'mobile' ),
			) ) );
		}

		// Register ext.visualEditor.mwreference here, as it depends on the new
		// Cite CSS style module ext.cite.style only if the Cite extension is
		// present.
		// This is a temporary hack, once the Cite extension uses the new CSS
		// for everything (and it takes care of loading ext.cite.style itself),
		// it can be removed from here and put back in extension.json.
		$mwreferenceModule = $veResourceTemplate + array(
			'scripts' => array(
				'modules/ve-mw/ui/widgets/ve.ui.MWReferenceGroupInputWidget.js',
				'modules/ve-mw/ui/widgets/ve.ui.MWReferenceSearchWidget.js',
				'modules/ve-mw/ui/widgets/ve.ui.MWReferenceResultWidget.js',

				'modules/ve-mw/ui/commands/ve.ui.MWUseExistingReferenceCommand.js',

				'modules/ve-mw/ui/dialogs/ve.ui.MWCitationDialog.js',
				'modules/ve-mw/ui/dialogs/ve.ui.MWReferencesListDialog.js',
				'modules/ve-mw/ui/dialogs/ve.ui.MWReferenceDialog.js',

				'modules/ve-mw/ui/tools/ve.ui.MWReferenceDialogTool.js',
				'modules/ve-mw/ui/tools/ve.ui.MWCitationDialogTool.js',

				'modules/ve-mw/ui/contextitems/ve.ui.MWReferenceContextItem.js',
				'modules/ve-mw/ui/contextitems/ve.ui.MWReferencesListContextItem.js',
				'modules/ve-mw/ui/contextitems/ve.ui.MWCitationContextItem.js',
				'modules/ve-mw/ui/actions/ve.ui.MWCitationAction.js',
			),
			'styles' => array(
				'modules/ve-mw/ui/styles/contextitems/ve.ui.MWReferenceContextItem.css',
				'modules/ve-mw/ui/styles/widgets/ve.ui.MWReferenceGroupInputWidget.css',
				'modules/ve-mw/ui/styles/widgets/ve.ui.MWReferenceResultWidget.css',
				'modules/ve-mw/ui/styles/widgets/ve.ui.MWReferenceSearchWidget.css',
			),
			'dependencies' => array(
				'ext.visualEditor.mwreference.core',
				'ext.visualEditor.mwtransclusion',
				'ext.visualEditor.mediawiki'
			),
			'messages' => array(
				'visualeditor-dialog-reference-editing-reused',
				'visualeditor-dialog-reference-options-group-label',
				'visualeditor-dialog-reference-options-group-placeholder',
				'visualeditor-dialog-reference-options-name-label',
				'visualeditor-dialog-reference-options-section',
				'visualeditor-dialog-reference-title',
				'visualeditor-dialog-reference-useexisting-full-label',
				'visualeditor-dialog-reference-useexisting-label',
				'visualeditor-dialog-reference-useexisting-tool',
				'visualeditor-dialog-referenceslist-contextitem-description-general',
				'visualeditor-dialog-referenceslist-contextitem-description-named',
				'visualeditor-dialog-referenceslist-title',
				'visualeditor-dialogbutton-reference-full-label',
				'visualeditor-dialogbutton-reference-tooltip',
				'visualeditor-dialogbutton-reference-title',
				'visualeditor-dialogbutton-referenceslist-tooltip',
				'visualeditor-reference-input-placeholder',
			),
			'targets' => array( 'desktop', 'mobile' ),
		);

		if ( isset( $resourceModules['ext.cite.style'] ) ||
				$resourceLoader->isModuleRegistered( 'ext.cite.style' ) ) {
			$mwreferenceModule['dependencies'][] = 'ext.cite.style';
		}
		$resourceLoader->register( array( 'ext.visualEditor.mwreference' => $mwreferenceModule ) );
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
				'lib/ve/tests/dm/ve.dm.APIResultsQueue.test.js',
				'lib/ve/tests/dm/ve.dm.Surface.test.js',
				'lib/ve/tests/dm/ve.dm.SurfaceFragment.test.js',
				'modules/ve-mw/tests/dm/ve.dm.SurfaceFragment.test.js',
				'lib/ve/tests/dm/ve.dm.ModelRegistry.test.js',
				'lib/ve/tests/dm/ve.dm.MetaList.test.js',
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
				'lib/ve/tests/ui/actions/ve.ui.LinkAction.test.js',
				'modules/ve-mw/tests/ui/actions/ve.ui.MWLinkAction.test.js',
				'lib/ve/tests/ui/actions/ve.ui.ListAction.test.js',
				// VisualEditor DataTransferHandler tests
				'lib/ve/tests/ui/datatransferhandlers/ve.ui.DSVFileTransferHandler.test.js',
				'lib/ve/tests/ui/datatransferhandlers/ve.ui.UrlStringTransferHandler.test.js',
				'modules/ve-mw/tests/ui/datatransferhandlers/ve.ui.MWWikitextStringTransferHandler.test.js',
				'modules/ve-mw/tests/ui/datatransferhandlers/ve.ui.UrlStringTransferHandler.test.js',
				// VisualEditor initialization Tests
				'lib/ve/tests/init/ve.init.Platform.test.js',
				'modules/ve-mw/tests/init/targets/ve.init.mw.DesktopArticleTarget.test.js',
				// IME tests
				'lib/ve/tests/ce/ve.ce.TestRunner.js',
				'lib/ve/tests/ce/ve.ce.imetests.test.js',
				'lib/ve/tests/ce/imetests/backspace-chromium-ubuntu-none.js',
				'lib/ve/tests/ce/imetests/backspace-firefox-ubuntu-none.js',
				'lib/ve/tests/ce/imetests/backspace-ie-win-none.js',
				'lib/ve/tests/ce/imetests/input-chrome-mac-native-japanese-hiragana.js',
				'lib/ve/tests/ce/imetests/input-chrome-mac-native-japanese-katakana.js',
				'lib/ve/tests/ce/imetests/input-chrome-win-chinese-traditional-handwriting.js',
				'lib/ve/tests/ce/imetests/input-chrome-win-greek.js',
				'lib/ve/tests/ce/imetests/input-chrome-win-welsh.js',
				'lib/ve/tests/ce/imetests/input-chromium-ubuntu-ibus-chinese-cantonese.js',
				'lib/ve/tests/ce/imetests/input-chromium-ubuntu-ibus-japanese-anthy-' .
					'-hiraganaonly.js',
				'lib/ve/tests/ce/imetests/input-chromium-ubuntu-ibus-korean-korean.js',
				'lib/ve/tests/ce/imetests/input-chromium-ubuntu-ibus-malayalam-swanalekha.js',
				'lib/ve/tests/ce/imetests/input-firefox-mac-native-japanese-hiragana.js',
				'lib/ve/tests/ce/imetests/input-firefox-mac-native-japanese-katakana.js',
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
				'lib/ve/tests/ce/imetests/input-safari-mac-native-japanese-hiragana.js',
				'lib/ve/tests/ce/imetests/input-safari-mac-native-japanese-katakana.js',
				'lib/ve/tests/ce/imetests/leftarrow-chromium-ubuntu-none.js',
				'lib/ve/tests/ce/imetests/leftarrow-firefox-ubuntu-none.js',
				'lib/ve/tests/ce/imetests/leftarrow-ie-win-none.js',
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
				'ext.visualEditor.mwalienextension',
				'ext.visualEditor.experimental',
				'ext.visualEditor.desktopArticleTarget.init',
				'ext.visualEditor.desktopArticleTarget',
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

	/**
	 * Sets user preference to enable the VisualEditor account if the account's
	 * userID is matches modulo $wgVisualEditorNewAccountEnableProportion, if set.
	 * If set to '1', all new accounts would have VisualEditor enabled; at '2',
	 * 50% would; at '20', 5% would, and so on.
	 *
	 * To be removed once no longer needed.
	 */
	public static function onAddNewAccount( $user, $byEmail ) {
		$x = RequestContext::getMain()->getConfig()->get( 'VisualEditorNewAccountEnableProportion' );

		if (
			$x &&
			$user->isLoggedin() &&
			( ( $user->getId() % $x ) === 0 )
		) {
			$user->setOption( 'visualeditor-enable', 1 );
			$user->saveSettings();
		}
		return true;
	}

	/**
	 * Sets user preference to enable the VisualEditor account for new auto-
	 * created ('auth') accounts, if $wgVisualEditorAutoAccountEnable is set.
	 *
	 * To be removed once no longer needed.
	 */
	public static function onAuthPluginAutoCreate( $user ) {
		if (
			RequestContext::getMain()->getConfig()->get( 'VisualEditorAutoAccountEnable' ) &&
			$user->isLoggedin()
		) {
			$user->setOption( 'visualeditor-enable', 1 );
			$user->saveSettings();
		}
		return true;
	}


}
