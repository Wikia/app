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

	/**
	 * Adds VisualEditor JS to the output.
	 *
	 * This is attached to the MediaWiki 'BeforePageDisplay' hook.
	 *
	 * @param OutputPage $output
	 * @param Skin $skin
	 * @return boolean
	 */
	public static function onBeforePageDisplay( OutputPage $output, Skin $skin ): bool {
		// Wikia change
		if ( self::isAvailable( $skin ) ) {
			$output->addModules( array( 'ext.visualEditor.wikia.viewPageTarget.init' ) );
		}

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
	public static function onResourceLoaderRegisterModules( ResourceLoader $resourceLoader ): bool {

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
		ResourceLoader $resourceLoader
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
