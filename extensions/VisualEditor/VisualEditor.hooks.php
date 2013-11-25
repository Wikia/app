<?php
/**
 * VisualEditor extension hooks
 *
 * @file
 * @ingroup Extensions
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

class VisualEditorHooks {
	/** List of skins VisualEditor integration supports */
	protected static $supportedSkins = array( 'oasis' );

	public static function isAvailable( $skin ) {
		static $isAvailable = null;
		if ( is_null( $isAvailable ) ) {
			$isAvailable = (
				in_array( $skin->getSkinName(), self::$supportedSkins ) &&
				$skin->getUser()->getOption( 'visualeditor-enable' ) &&
				!$skin->getUser()->getOption( 'visualeditor-betatempdisable' )
			);
		}
		return $isAvailable;
	}

	public static function onSetup() {
		global $wgResourceModules, $wgVisualEditorResourceTemplate,
			$wgVisualEditorTabMessages;

		// This prevents VisualEditor from being run in environments that don't
		// have the dependent code in core; this should be updated as a part of
		// when additional dependencies are created and pushed into MediaWiki's
		// core. The most direct effect of this is to avoid confusing any third
		// parties who attempt to install VisualEditor onto non-alpha wikis, as
		// this should have no impact on deploying to Wikimedia's wiki cluster.
		// Is fine for release tarballs because 1.22wmf11 < 1.22alpha < 1.22.0.
		//wfUseMW( '1.22wmf11' ); #back-compat

		// Add tab messages to the init init module
		foreach ( $wgVisualEditorTabMessages as $msg ) {
			if ( $msg !== null ) {
				$wgResourceModules['ext.visualEditor.viewPageTarget.init']['messages'][] = $msg;
			}
		}

		// Only load jquery.ULS if ULS Extension isn't already installed:
		if ( !class_exists( 'UniversalLanguageSelectorHooks' ) ) {
			$wgResourceModules['jquery.uls'] = $wgVisualEditorResourceTemplate + array(
				'scripts' => array(
					'jquery.uls/src/jquery.uls.core.js',
					'jquery.uls/src/jquery.uls.lcd.js',
					'jquery.uls/src/jquery.uls.languagefilter.js',
					'jquery.uls/src/jquery.uls.regionfilter.js',
				),
				'styles' => array(
					'jquery.uls/css/jquery.uls.css',
					'jquery.uls/css/jquery.uls.lcd.css',
				),
				'dependencies' => array(
					'jquery.uls.grid',
					'jquery.uls.data',
					'jquery.uls.compact',
				),
			);
			$wgResourceModules['jquery.uls.data'] = $wgVisualEditorResourceTemplate + array(
				'scripts' => array(
					'jquery.uls/src/jquery.uls.data.js',
					'jquery.uls/src/jquery.uls.data.utils.js',
				),
				'position' => 'top',
			);
			$wgResourceModules['jquery.uls.grid'] = $wgVisualEditorResourceTemplate + array(
				'styles' => 'jquery.uls/css/jquery.uls.grid.css',
				'position' => 'top',
			);
			$wgResourceModules['jquery.uls.compact'] = $wgVisualEditorResourceTemplate + array(
				'styles' => 'jquery.uls/css/jquery.uls.compact.css',
				'position' => 'top',
			);
		}
	}

	/**
	 * Adds VisualEditor JS to the output.
	 *
	 * This is attached to the MediaWiki 'BeforePageDisplay' hook.
	 *
	 * @param $output OutputPage
	 * @param $skin Skin
	 */
	public static function onBeforePageDisplay( &$output, &$skin ) {
		// Only do this if the user has VE enabled
		if ( !self::isAvailable( $skin ) ) {
			return true;
		}
		$output->addModules( array( 'ext.visualEditor.wikiaViewPageTarget.init' ) );
		//$output->addModuleStyles( array( 'ext.visualEditor.viewPageTarget.noscript' ) );
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
	public static function onSkinTemplateNavigation( &$skin, &$links ) {
		// Only do this if the user has VE enabled
		if ( !self::isAvailable( $skin ) ) {
			return true;
		}

		global $wgVisualEditorTabMessages, $wgVisualEditorTabPosition;
		if ( !isset( $links['views']['edit'] ) ) {
			// There's no edit link, nothing to do
			return true;
		}
		$title = $skin->getRelevantTitle();
		// Rebuild the $links['views'] array and inject the VisualEditor tab before or after
		// the edit tab as appropriate. We have to rebuild the array because PHP doesn't allow
		// us to splice into the middle of an associative array.
		$newViews = array();
		foreach ( $links['views'] as $action => $data ) {
			if ( $action === 'edit' ) {
				// Build the VisualEditor tab
				$existing = $title->exists() || (
					$title->getNamespace() == NS_MEDIAWIKI &&
					$title->getDefaultMessageText() !== false
				);
				$veParams = $skin->editUrlOptions();
				unset( $veParams['action'] ); // Remove action=edit
				$veParams['veaction'] = 'edit'; // Set veaction=edit
				$veTabMessage = $wgVisualEditorTabMessages[$existing ? 'edit' : 'create'];
				$veTabText = $veTabMessage === null ? $data['text'] :
					wfMessage( $veTabMessage )->setContext( $skin->getContext() )->text();
				$veTab = array(
					'href' => $title->getLocalURL( $veParams ),
					'text' => $veTabText,
					'primary' => true,
					'class' => '',
				);

				// Alter the edit tab
				$editTab = $data;
				$editTabMessage = $wgVisualEditorTabMessages[$existing ? 'editsource' : 'createsource'];
				if ( $editTabMessage !== null ) {
					$editTab['text'] = wfMessage( $editTabMessage )->setContext( $skin->getContext() )->text();
				}

				// Inject the VE tab before or after the edit tab
				if ( $wgVisualEditorTabPosition === 'before' ) {
					$newViews['ve-edit'] = $veTab;
					$newViews['edit'] = $editTab;
				} else {
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
	 * @returns bool true
	 */
	public static function onDoEditSectionLink( $skin, $title, $section, $tooltip, &$result, $lang ) {
		// Only do this if the user has VE enabled
		// (and we're not in parserTests)
		if (
			!self::isAvailable( $skin ) ||
			isset( $GLOBALS[ 'wgVisualEditorInParserTests' ] )
		) {
			return true;
		}

		global $wgVisualEditorTabMessages, $wgVisualEditorTabPosition;
		$veEditSection = $wgVisualEditorTabMessages['editsection'] !== null ?
			$wgVisualEditorTabMessages['editsection'] : 'editsection';
		$sourceEditSection = $wgVisualEditorTabMessages['editsectionsource'] !== null ?
			$wgVisualEditorTabMessages['editsectionsource'] : 'editsection';

		// Code mostly duplicated from Skin::doEditSectionLink() :(
		$attribs = array();
		if ( !is_null( $tooltip ) ) {
			# Bug 25462: undo double-escaping.
			$tooltip = Sanitizer::decodeCharReferences( $tooltip );
			$attribs['title'] = wfMessage( 'editsectionhint' )->rawParams( $tooltip )
				->inLanguage( $lang )->text();
		}
		$veLink = Linker::link( $title, wfMessage( $veEditSection )->inLanguage( $lang )->text(),
			$attribs + array( 'class' => 'mw-editsection-visualeditor' ),
			array( 'veaction' => 'edit', 'section' => $section ),
			array( 'noclasses', 'known' )
		);
		$sourceLink = Linker::link( $title, wfMessage( $sourceEditSection )->inLanguage( $lang )->text(),
			$attribs,
			array( 'action' => 'edit', 'section' => $section ),
			array( 'noclasses', 'known' )
		);

		$veFirst = $wgVisualEditorTabPosition === 'before';
		$result = '<span class="mw-editsection">'
			. '<span class="mw-editsection-bracket">[</span>'
			. ( $veFirst ? $veLink : $sourceLink )
			. '<span class="mw-editsection-divider">'
			. wfMessage( 'pipe-separator' )->inLanguage( $lang )->text()
			. '</span>'
			. ( $veFirst ? $sourceLink : $veLink )
			. '<span class="mw-editsection-bracket">]</span>'
			. '</span>';

		return true;
	}

	public static function onGetPreferences( $user, &$preferences ) {
		$preferences['visualeditor-enable'] = array(
			'type' => 'toggle',
			'label-message' => 'visualeditor-preference-enable',
			'section' => 'editing/beta'
		);
		$preferences['visualeditor-betatempdisable'] = array(
			'type' => 'toggle',
			'label-message' => 'visualeditor-preference-betatempdisable',
			'section' => 'editing/beta'
		);
		return true;
	}

	public static function onGetBetaPreferences( $user, &$preferences ) {
		global $wgExtensionAssetsPath;

		$preferences['visualeditor-enable-experimental'] = array(
			'version' => '1.0',
			'label-message' => 'visualeditor-preference-experimental-label',
			'desc-message' => 'visualeditor-preference-experimental-description',
			'info-link' => 'visualeditor-preference-experimental-info-link',
			'discussion-link' => 'visualeditor-preference-experimental-discussion-link',
			'screenshot' => $wgExtensionAssetsPath . '/VisualEditor/logo-experimental.png',
		);
	}

	public static function onListDefinedTags( &$tags ) {
		$tags[] = 'visualeditor';
		$tags[] = 'visualeditor-needcheck';
		return true;
	}

	/**
	 * Adds extra variables to the page config.
	 */
	public static function onMakeGlobalVariablesScript( array &$vars, OutputPage $out ) {
		global $wgStylePath, $wgContLang;
		$vars['wgVisualEditor'] = array(
			'isPageWatched' => $out->getUser()->isWatched( $out->getTitle() ),
			// Same as in Linker.php
			'magnifyClipIconURL' => $wgStylePath .
				'/common/images/magnify-clip' .
				( $wgContLang->isRTL() ? '-rtl' : '' ) . '.png',
			'pageLanguageCode' => $out->getTitle()->getPageLanguage()->getHtmlCode(),
			'pageLanguageDir' => $out->getTitle()->getPageLanguage()->getDir()
		);

		return true;
	}

	/**
	 * Adds extra variables to the global config
	 */
	public static function onResourceLoaderGetConfigVars( array &$vars ) {
		global $wgDefaultUserOptions,
			$wgVisualEditorDisableForAnons,
			$wgVisualEditorEnableExperimentalCode,
			$wgVisualEditorNamespaces,
			$wgVisualEditorPluginModules,
			$wgVisualEditorTabPosition,
			$wgVisualEditorTabMessages,
			$wgVisualEditorShowBetaWelcome;

		$vars['wgVisualEditorConfig'] = array(
			'disableForAnons' => $wgVisualEditorDisableForAnons,
			'enableExperimentalCode' => $wgVisualEditorEnableExperimentalCode,
			'namespaces' => $wgVisualEditorNamespaces,
			'pluginModules' => $wgVisualEditorPluginModules,
			'defaultUserOptions' => array(
				'betatempdisable' => $wgDefaultUserOptions['visualeditor-betatempdisable'],
				'enable' => $wgDefaultUserOptions['visualeditor-enable'],
				'experimental' => $wgDefaultUserOptions['visualeditor-enable-experimental'],
			),
			'skins' => self::$supportedSkins,
			'tabPosition' => $wgVisualEditorTabPosition,
			'tabMessages' => $wgVisualEditorTabMessages,
			'showBetaWelcome' => $wgVisualEditorShowBetaWelcome,
		);

		return true;
	}

	public static function onResourceLoaderTestModules(
		array &$testModules,
		ResourceLoader &$resourceLoader
	) {
		$testModules['qunit']['ext.visualEditor.test'] = array(
			'scripts' => array(
				// MW config preload
				've-mw/test/mw-preload.js',
				// QUnit plugin
				've/test/ve.qunit.js',
				// UnicodeJS Tests
				'unicodejs/test/unicodejs.test.js',
				'unicodejs/test/unicodejs.graphemebreak.test.js',
				'unicodejs/test/unicodejs.wordbreak.test.js',
				// VisualEditor Tests
				've/test/ve.test.utils.js',
				've/test/ve.test.js',
				've/test/ve.Document.test.js',
				've/test/ve.Element.test.js',
				've/test/ve.Node.test.js',
				've/test/ve.BranchNode.test.js',
				've/test/ve.LeafNode.test.js',
				've/test/ve.Factory.test.js',
				// VisualEditor DataModel Tests
				've/test/dm/ve.dm.example.js',
				've/test/dm/ve.dm.AnnotationSet.test.js',
				've/test/dm/ve.dm.NodeFactory.test.js',
				've/test/dm/ve.dm.Node.test.js',
				've/test/dm/ve.dm.Converter.test.js',
				've/test/dm/ve.dm.BranchNode.test.js',
				've/test/dm/ve.dm.LeafNode.test.js',
				've/test/dm/ve.dm.LinearData.test.js',
				've/test/dm/nodes/ve.dm.TextNode.test.js',
				've-mw/test/dm/nodes/ve.dm.MWTransclusionNode.test.js',
				've/test/dm/ve.dm.Document.test.js',
				've/test/dm/ve.dm.DocumentSynchronizer.test.js',
				've/test/dm/ve.dm.IndexValueStore.test.js',
				've/test/dm/ve.dm.InternalList.test.js',
				've-mw/test/dm/ve.dm.InternalList.test.js',
				've/test/dm/ve.dm.Transaction.test.js',
				've-mw/test/dm/ve.dm.Transaction.test.js',
				've/test/dm/ve.dm.TransactionProcessor.test.js',
				've/test/dm/ve.dm.Surface.test.js',
				've/test/dm/ve.dm.SurfaceFragment.test.js',
				've-mw/test/dm/ve.dm.SurfaceFragment.test.js',
				've/test/dm/ve.dm.ModelRegistry.test.js',
				've/test/dm/ve.dm.MetaList.test.js',
				've/test/dm/ve.dm.Model.test.js',
				've/test/dm/lineardata/ve.dm.ElementLinearData.test.js',
				've/test/dm/lineardata/ve.dm.MetaLinearData.test.js',
				've-mw/test/dm/ve.dm.mwExample.js',
				've-mw/test/dm/ve.dm.MWConverter.test.js',
				// VisualEditor ContentEditable Tests
				've/test/ce/ve.ce.test.js',
				've/test/ce/ve.ce.Document.test.js',
				've/test/ce/ve.ce.Surface.test.js',
				've-mw/test/ce/ve.ce.Document.test.js',
				've/test/ce/ve.ce.NodeFactory.test.js',
				've/test/ce/ve.ce.Node.test.js',
				've/test/ce/ve.ce.BranchNode.test.js',
				've/test/ce/ve.ce.ContentBranchNode.test.js',
				've-mw/test/ce/ve.ce.ContentBranchNode.test.js',
				've/test/ce/ve.ce.LeafNode.test.js',
				've/test/ce/nodes/ve.ce.TextNode.test.js',
				// VisualEditor Actions Tests
				've/test/ui/actions/ve.ui.FormatAction.test.js',
				've-mw/test/ui/actions/ve.ui.FormatAction.test.js',
				've/test/ui/actions/ve.ui.IndentationAction.test.js',
				've/test/ui/actions/ve.ui.ListAction.test.js',
				// VisualEditor initialization Tests
				've/test/init/ve.init.Platform.test.js',
				've-mw/test/init/targets/ve.init.mw.ViewPageTarget.test.js',
			),
			'dependencies' => array(
				'unicodejs.wordbreak',
				'ext.visualEditor.standalone',
				'ext.visualEditor.core',
				'ext.visualEditor.experimental',
				'ext.visualEditor.viewPageTarget.init',
				'ext.visualEditor.viewPageTarget',
			),
			'localBasePath' => dirname( __FILE__ ) . '/modules',
			'remoteExtPath' => 'VisualEditor/modules',
		);

		return true;
	}

	/**
	 * Ensures that we know whether we're running inside a parser test.
	 */
	public static function onParserTestGlobals( array &$settings ) {
		$settings['wgVisualEditorInParserTests'] = true;
	}
}
