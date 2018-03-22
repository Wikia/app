<?php

class RTE {

	const INIT_MODE_SOURCE = 'source';
	const INIT_MODE_WYSIWYG = 'wysiwyg';

	// unique editor instance ID
	private static $instanceId = null;

	/* @var RTEParser reference to RTEParser object instance */
	public static $parser = null;

	// should we use Wysiwyg editor?
	private static $useWysiwyg = true;

	// reason of fallback to source mode
	private static $wysiwygDisabledReason = '';

	// are we using development version of CK?
	private static $devMode;

	// mode in which CK editor should be stared
	private static $initMode = self::INIT_MODE_WYSIWYG;

	// list of edgecases which occurred in parsed wikitext
	public static $edgeCases = [];

	// Title object of currently edited page
	private static $title;

	/**
	 * Perform "reverse" parsing of HTML to wikitext when saving / doing preview from wysiwyg mode
	 *
	 * @param EditPage $form
	 */
	public static function reverse( $form, $out = null ): bool {
		global $wgRequest;

		if ( $wgRequest->wasPosted() ) {
			if ( $wgRequest->getVal( 'RTEMode' ) == 'wysiwyg' ) {
				RTE::log( 'performing reverse parsing back to wikitext' );
				if ( $out == null ) {
					$wikitext = RTE::HtmlToWikitext( $wgRequest->getText( 'wpTextbox1' ) );
					$wgRequest->setVal( 'wpTextbox1', $wikitext );
				} else {
					$form->textbox1 = $form->getContent();
				}
			}
		}

		return true;
	}

	/**
	 * Callback function for preg_replace_callback which handles placeholder markers.
	 * Called from RTEParser class.
	 * @see RTEParser::parse()
	 *
	 * @author: Inez Korczyński
	 * @param $var
	 * @return string
	 */
	public static function replacePlaceholder( $var ): string {
		$data = RTEData::get( 'placeholder', intval( $var[1] ) );

		if ( $data ) {
			return RTE::renderPlaceholder( $data['type'], $data );
		}

		return '';
	}

	/**
	 * Render HTML for given placeholder
	 *
	 * @author: Macbre
	 */
	public static function renderPlaceholder( $label, $data ) {
		// this is placeholder
		$data['placeholder'] = 1;

		// store data
		$dataIdx = RTEData::put( 'data', $data );

		// render placeholder
		global $wgBlankImgUrl;
		return Xml::element( 'img', [
			'_rte_dataidx' => sprintf( '%04d', $dataIdx ),
			'class' => "placeholder placeholder-{$data['type']}",
			'src' => $wgBlankImgUrl,
			'type' => $data['type'],
		] );
	}

	/**
	 * Setup Rich Text Editor by loading needed JS/CSS files and adding hook(s)
	 *
	 * @author Inez KorczyDski, Macbre
	 */
	public static function init( $form ) {
		global $wgOut, $wgHooks, $wgAllInOne, $wgRequest;

		RTE::log( 'init' );

		// save reference to Title object of currently edited page
		self::$title = $form->mTitle;

		// check 'useeditor' URL param, user settings...
		self::checkEditorConditions();

		JSMessages::registerPackage( 'rte-infobox-builder', [
			'rte-infobox',
			'rte-add-template',
			'rte-select-infobox-title',
			'rte-infobox-builder'
		] );
		JSMessages::enqueuePackage( 'rte-infobox-builder', JSMessages::INLINE );

		// add global JS variables
		$wgHooks['MakeGlobalVariablesScript'][] = 'RTE::makeGlobalVariablesScript';

		// should CK editor be disabled?
		if ( self::$useWysiwyg === false ) {
			RTE::log( 'fallback to MW editor' );
			return true;
		}

		// devmode
		self::$devMode = $wgRequest->getBool( 'allinone', $wgAllInOne ) === false;

		// add RTE javascript files
		// scripts loaded by edit page layout

		// add RTE css file
		$wgOut->addExtensionStyle( AssetsManager::getInstance()->getSassCommonURL( 'extensions/wikia/RTE/css/RTE.scss' ) );

		// parse wikitext of edited page and add extra fields to editform
		$wgHooks['EditPage::showEditForm:fields'][] = 'RTE::init2';

		// add CSS class to <body> tag
		$wgHooks['SkinGetPageClasses'][] = 'RTE::addBodyClass';

		// remove default editor toolbar (RT #78393)
		$wgHooks['EditPageBeforeEditToolbar'][] = 'RTE::removeDefaultToolbar';

		// add fake form used by MW suggest in CK dialogs
		$wgHooks['SkinAfterBottomScripts'][] = 'RTE::onSkinAfterBottomScripts';

		// adds fallback for non-JS users (RT #20324)
		self::addNoScriptFallback();

		return true;
	}

	/**
	 * Parse wikitext of edited article, so CK can be provided with HTML
	 */
	public static function init2( $form, OutputPage $out ) {
		// add hidden edit form field
		$out->addHTML( "\n" . Xml::element( 'input', [ 'type' => 'hidden', 'value' => '', 'name' => 'RTEMode', 'id' => 'RTEMode' ] ) );

		// add fields to perform temporary save
		self::addTemporarySaveFields( $out );

		// let's parse wikitext (only for wysiwyg mode)
		if ( self::$initMode == self::INIT_MODE_WYSIWYG ) {

			// SUS-3839: perform RTE parsing behind PoolCounter + parser cache
			$parserCacheStorage = wfGetParserCacheStorage();

			$parserCache = new RTEParserCache( $parserCacheStorage );
			$parserOptions = static::makeParserOptions();

			$worker = new RTEParsePoolWork( $parserCache, $form, $parserOptions );

			// fall back to source mode if RTE parsing fails
			if ( !$worker->execute() ) {
				self::$initMode = self::INIT_MODE_SOURCE;
				return true;
			}

			$html = $worker->getParserOutput()->getText();
		}

		// check for edgecases (found during parsing done above)
		if ( RTE::edgeCasesFound() ) {
			self::$initMode = self::INIT_MODE_SOURCE;

			// get edgecase type and add it to JS variables
			$edgeCaseType = Xml::encodeJsVar( self::getEdgeCaseType() );
			$out->addInlineScript( "var RTEEdgeCase = {$edgeCaseType}" );

			// SUS-1909: Log the type of edge case that was found
			\Wikia\Logger\WikiaLogger::instance()->debugSampled( 0.01, 'SUS-1909: RTE edge case', [
				'edgeCaseType' => static::getEdgeCaseType()
			] );
		}

		// parse wikitext using RTEParser (only for wysiwyg mode)
		if ( self::$initMode == self::INIT_MODE_WYSIWYG ) {
			// set editor textarea content
			$form->textbox1 = $html;
		}

		// allow other extensions to add extra HTML to edit form
		Hooks::run( 'RTEAddToEditForm', [ &$form, &$out ] );

		return true;
	}

	/**
	 * Add global JS variables
	 *
	 * @author Macbre
	 */
	public static function makeGlobalVariablesScript( &$vars ) {
		global $wgLegalTitleChars, $wgScriptPath, $wgServer, $wgExtensionsPath, $wgUseSiteCss;

		// reason why wysiwyg is disabled
		if ( self::$useWysiwyg === false ) {
			if ( self::$wysiwygDisabledReason != '' ) {
				$vars['RTEDisabledReason'] = self::$wysiwygDisabledReason;
			}

			// no reason to add variables listed below
			return true;
		}

		// CK instance id
		$vars['RTEInstanceId'] = self::getInstanceId();

		// development version of CK?
		if ( !empty( self::$devMode ) ) {
			$vars['RTEDevMode'] = true;
		}

		// initial CK mode (wysiwyg / source)
		$vars['RTEInitMode'] = self::$initMode;

		// constants for regexp checking in links editor
		$vars['RTEUrlProtocols'] = wfUrlProtocols();

		// BugID: 2138 - generate utf-8 friendly regexp pattern
		$legalChars = substr( $wgLegalTitleChars, 0, -10 );
		$legalChars .= '\u00A1-\uFFFF';
		$vars['RTEValidTitleChars'] = $legalChars;

		// list of templates to be shown in dropdown on toolbar
		$vars['RTETemplatesDropdown'] = self::getTemplateDropdownList();

		// list of magic words
		$vars['RTEMagicWords'] = self::getMagicWords();

		// messages to be used in JS code
		$vars['RTEMessages'] = self::getMessages();

		// local path to RTE (used to apply htc fixes for IE)
		// this MUST point to local domain
		$vars['RTELocalPath'] = $wgServer . $wgScriptPath . '/extensions/wikia/RTE';

		$vars['CKEDITOR_BASEPATH'] = $wgExtensionsPath . '/wikia/RTE/ckeditor/';

		// link to raw version of MediaWiki:Common.css
		global $wgSquidMaxage;
		$query = wfArrayToCGI( [
			'usemsgcache' => 'yes',
			'ctype' => 'text/css',
			'smaxage' => $wgSquidMaxage,
			'action' => 'raw',
			'maxage' => $wgSquidMaxage,
		] );

		$app = F::app();
		$out = $app->wg->out;
		$user = $app->wg->user;

		if ( $wgUseSiteCss ) {
			if ( $app->checkSkin( 'oasis' ) ) {
				global $wgEnableTabberExt, $wgEnableAjaxPollExt;
				/*
				 * On Oasis we need to load both Common.css and Wikia.css
				 * to use it inside of the editor's textarea in visual mode
				 * module 'site' contains both stylesheets
				 */
				$resources = [ 'site' ];

				if ( $wgEnableTabberExt ) {
					$resources[] = 'ext.tabber';
				}

				if ( $wgEnableAjaxPollExt ) {
					$resources[] = 'ext.wikia.ajaxpoll';
				}

				$url = ResourceLoader::makeLoaderURL(
					$resources,
					$out->getLanguage()->getCode(),
					$out->getSkin()->getSkinName(),
					$user->getName(),
					null,
					ResourceLoader::inDebugMode(),
					ResourceLoaderModule::TYPE_STYLES
				);
				$vars['RTESiteCss'] = $url;
			} else {
				$vars['RTESiteCss'] = $wgServer . $wgScriptPath . Skin::makeNSUrl( 'Common.css', $query, NS_MEDIAWIKI );
			}
		}

		// domain and path for cookies
		global $wgCookieDomain, $wgCookiePath;
		$vars['RTECookieDomain'] = $wgCookieDomain;
		$vars['RTECookiePath'] = $wgCookiePath;

		// allow other extensions to add extra global JS variables to edit form
		Hooks::run( 'RTEAddGlobalVariablesScript', [ &$vars ] );

		return true;
	}

	/**
	 * Add class to <body> tag
	 */
	public static function addBodyClass( &$classes ) {
		$classes .= ' rte';
		return true;
	}

	/**
	 * Removes default editor toolbar, so we can lazy load icons for source mode toolbar (RT #78393)
	 */
	public static function removeDefaultToolbar( &$toolbar ) {
		$toolbar = strtr( $toolbar, [
			'<div id="toolbar">' => '',
			'</div>' => '',
		] );
		return true;
	}

	/**
	 * Add fake form used by MW suggest in CK dialogs
	 */
	public static function onSkinAfterBottomScripts( $skin, &$text ) {
		$text .= Xml::openElement( 'form', [ 'id' => 'RTEFakeForm' ] ) . Xml::closeElement( 'form' );
		return true;
	}

	/**
	 * Adds fallback for non-JS users (RT #20324)
	 */
	private static function addNoScriptFallback() {
		global $wgOut;

		$fallbackMessage = trim( wfMsgExt( 'rte-no-js-fallback', 'parseinline' ) );
		$wgOut->addHTML(
			<<<HTML

<noscript>
	<style type="text/css">
		.RTEFallback,
		#page_bar {
			display: block !important;
		}
	</style>
	<div class="RTEFallback usermessage">$fallbackMessage</div>
</noscript>

HTML
		);
	}

	/**
	 * Add fields to perform temporary save
	 */
	private static function addTemporarySaveFields( OutputPage $out ) {
		$out->addHtml(
			"\n" .
			Xml::element( 'input', [ 'type' => 'hidden', 'id' => 'RTETemporarySaveType', 'name' => 'RTETemporarySaveType' ] ) .
			Xml::element( 'input', [ 'type' => 'hidden', 'id' => 'RTETemporarySaveContent', 'name' => 'RTETemporarySaveContent' ] ) .
			"\n"
		);
	}

	/**
	 * Check CK editor conditions (fallback to MW editor / switch to source mode)
	 *
	 * Handle useeditor URL param, user settings, current skin, edgecases...
	 */
	private static function checkEditorConditions() {
		global $wgRequest, $wgUser;

		// check browser compatibility
		if ( !self::isCompatibleBrowser() ) {
			RTE::log( 'editor is disabled because of unsupported browser' );
			self::disableEditor( 'browser' );
		}

		// check useeditor URL param (wysiwyg / source / mediawiki)
		$useEditor = $wgRequest->getVal( 'useeditor', false );

		if ( !empty( $useEditor ) ) {
			RTE::log( "useeditor = '{$useEditor}'" );

			switch ( $useEditor ) {
				case 'mediawiki':
					self::disableEditor( 'useeditor' );
					break;

				case 'source':
					self::$initMode = self::INIT_MODE_SOURCE;
					break;

				case 'wysiwyg':
				case 'visual':
					$forcedWysiwyg = true;
					self::$initMode = self::INIT_MODE_WYSIWYG;
					break;
			}
		}

		// check namespaces
		global $wgWysiwygDisabledNamespaces, $wgWysiwygDisableOnTalk, $wgEnableSemanticMediaWikiExt;
		if ( !empty( $wgWysiwygDisabledNamespaces ) && is_array( $wgWysiwygDisabledNamespaces )
			&& in_array( self::$title->getNamespace(), $wgWysiwygDisabledNamespaces )
		) {
			self::disableEditor( 'disablednamespace' );
		} elseif ( self::$title->getNamespace() == NS_TEMPLATE || self::$title->getNamespace() == NS_MEDIAWIKI ) {
			self::disableEditor( 'namespace' );
		}
		if ( !empty( $wgWysiwygDisableOnTalk ) ) {
			if ( self::$title->isTalkPage() ) {
				self::disableEditor( 'talkpage' );
			}
		}
		// BugId: 11336 disable RTE on Special SMW namespaces
		if ( $wgEnableSemanticMediaWikiExt && in_array( self::$title->getNamespace(), [ SMW_NS_PROPERTY, SF_NS_FORM, NS_CATEGORY, SMW_NS_CONCEPT ] ) ) {
			self::disableEditor( 'smw_namespace' );
		}

		// RT #10170: do not initialize for user JS/CSS subpages
		if ( self::$title->isCssJsSubpage() ) {
			RTE::log( 'editor is disabled on user JS/CSS subpages' );
			self::disableEditor( 'cssjssubpage' );
		}

		// check user preferences option
		/* With the new editor option available from the EditorPreference extension,
		   the 'enablerichtext' option should no longer influence availability of the RTE.
		   See Wikia issue VE-742 for more information. If editor is set to the Source
		   editor, disable the RTE/CK editor.
		 */
		if ( $wgUser->getGlobalPreference( PREFERENCE_EDITOR ) == EditorPreference::OPTION_EDITOR_SOURCE && empty( $forcedWysiwyg ) ) {
			RTE::log( 'editor is disabled because of user preferences' );
			self::disableEditor( 'userpreferences' );
		}

		// check current skin - enable RTE only on Oasis
		$skinName = get_class( RequestContext::getMain()->getSkin() );
		if ( $skinName != 'SkinOasis' ) {
			RTE::log( "editor is disabled because skin {$skinName} is unsupported" );
			self::disableEditor( 'skin' );
		}

		// start in source when previewing from source mode
		$action = $wgRequest->getVal( 'action', 'view' );
		$mode = $wgRequest->getVal( 'RTEMode', false );
		if ( $action == 'submit' && $mode == 'source' ) {
			RTE::log( 'POST triggered from source mode' );
			self::$initMode = self::INIT_MODE_SOURCE;
		}
	}

	/**
	 * Disable CK editor - MediaWiki editor will be loaded
	 */
	public static function disableEditor( string $reason ) {
		self::$useWysiwyg = false;
		self::$wysiwygDisabledReason = $reason;

		RTE::log( "CK editor disabled - the reason is '{$reason}'" );
	}

	/**
	 * Add given edgecase to the list of found edgecases
	 */
	public static function edgeCasesPush( $edgecase ) {
		self::$edgeCases[] = $edgecase;
	}

	/**
	 * Checks whether RTEParser found any wikitext edgecases
	 */
	public static function edgeCasesFound() {
		$found = !empty( self::$edgeCases );

		if ( $found ) {
			// list edgecases in MW debug log
			$edgecases = implode( ',', self::$edgeCases );
			RTE::log( "edgecase(s) found - {$edgecases}" );
		}

		return $found;
	}

	/**
	 * Returns type of edgecase found in wikitext
	 */
	public static function getEdgeCaseType() {
		$ret = false;

		if ( !empty( self::$edgeCases ) ) {
			$ret = strtolower( self::$edgeCases[0] );
		}

		RTE::log( __METHOD__, $ret );

		return $ret;
	}

	/**
	 * Parse given wikitext to HTML for CK
	 */
	public static function WikitextToHtml( $wikitext ) {
		global $wgTitle;

		wfProfileIn(__METHOD__);

		$options = static::makeParserOptions();

		RTE::$parser = new RTEParser();

		$html = RTE::$parser->parse( $wikitext, $wgTitle, $options, true, true, $wgTitle->getLatestRevID() )->getText();

		return $html;
	}

	private static function makeParserOptions(): ParserOptions {
		$options = new ParserOptions();
		// don't show [edit] link for sections
		$options->setEditSection( false );
		// disable headings numbering
		$options->setNumberHeadings( false );

		return $options;
	}

	/**
	 * Parse given HTML from CK back to wikitext
	 */
	public static function HtmlToWikitext( $html ) {
		$RTEReverseParser = new RTEReverseParser();

		return  $RTEReverseParser->parse( $html );
	}

	/**
	 * Add given message / dump given variable to MW log
	 *
	 * @author Macbre
	 */
	public static function log( $msg, $var = null ) {
		$debug = 'RTE: ';

		if ( is_string( $msg ) ) {
			$debug .= $msg;
		} else {
			$debug .= ' - >>' . print_r( $msg, true ) . '<<';
		}

		if ( $var !== null ) {
			$debug .= ' - >>' . print_r( $var, true ) . '<<';
		}

		wfDebug( "{$debug}\n" );
	}

	/**
	 * Add hexdump of given variable to MW log
	 *
	 * @author Macbre
	 */
	public static function hex( $method, $string ) {
		$debug = "RTE: {$method}\n" . Wikia::hex( $string, false, false, true );

		wfDebug( "{$debug}\n" );
	}

	/**
	 * Return unique editor instance ID
	 */
	public static function getInstanceId() {

		if ( self::$instanceId === null ) {
			global $wgCityId;

			$id = uniqid( mt_rand() );
			self::$instanceId = "{$wgCityId}-{$id}";
		}

		return self::$instanceId;
	}

	/**
	 * Return list of templates to be placed in dropdown menu on CK toolbar
	 * (moved to TemplateService)
	 */
	private static function getTemplateDropdownList() {
		return TemplateService::getPromotedTemplates();
	}

	/**
	 * Return list of magic words ({{PAGENAME}}) and double underscores (__TOC__)
	 */
	public static function getMagicWords(): array {
		// magic words list
		$magicWords = MagicWord::getVariableIDs();

		// double underscore magic words list (RT #18631)
		$magicWordsUnderscore = MagicWord::$mDoubleUnderscoreIDs;

		// filter MAG_NOWYSIWYG and MAG_NOSHAREDHELP out from the list (RT #18631)
		// and add to the list of double underscore magic words
		$magicWords = array_flip( $magicWords );
		foreach ( $magicWords as $magic => $tmp ) {
			if ( substr( $magic, 0, 4 ) == 'MAG_' ) {
				unset( $magicWords[$magic] );
				$magicWordsUnderscore[] = strtolower( substr( $magic, 4 ) );
			}
		}
		$magicWords = array_flip( $magicWords );

		// merge and sort magic words / double underscores lists, in RTE check type of magic word by searching $magicWordUnderscore list
		$magicWords = array_merge( $magicWords, $magicWordsUnderscore );

		sort( $magicWords );
		sort( $magicWordsUnderscore );

		$ret = [
			'magicWords' => $magicWords,
			'doubleUnderscores' => $magicWordsUnderscore
		];

		return $ret;
	}

	/**
	 * Grabbing list of most included templates
	 * (moved to TemplateService)
	 */
	static public function getHotTemplates() {
		return TemplateService::getHotTemplates();
	}

	/**
	 * Get messages to be used in JS code
	 */
	static private function getMessages(): array {
		/* @var $wgLang Language */
		global $wgLang;

		$ret = [
			'ellipsis' => wfMsg( 'ellipsis' ),
			'more' => wfMsg( 'moredotdotdot' ),
			'template' => $wgLang->getNsText( NS_TEMPLATE ), # localised template namespace name (RT #3808)

			// RT #36073
			'edgecase' => [
				'title' => wfMsg( 'rte-edgecase-info-title' ),
				'content' => wfMsg( 'rte-edgecase-info' ),
			],
		];

		return $ret;
	}

	/**
	 * In some cases the entire RTE is disabled (fallback to mediawiki editor)
	 * The self::$useWysiwyg variable is set to false in this case
	 * In some cases, RTE is enabled but starts in source mode by default
	 * The self::$initMode variable is checked for this
	 * @return boolean true/false if we are in fancy edit mode
	 */

	static public function isWysiwygModeEnabled(): bool {
		return ( self::$useWysiwyg && self::$initMode == self::INIT_MODE_WYSIWYG );
	}

	/**
	 * This will be false if mediawiki editor is being used
	 * @return boolean true/false if RTE is enabled
	 */
	static function isEnabled(): bool {
		return self::$useWysiwyg;
	}

	/**
	 * Add "Enable Rich Text Editing" as the first option in editing tab of user preferences
	 */
	static function onEditingPreferencesBefore( $user, &$preferences ): bool {
		// add JS to hide certain switches when wysiwyg is enabled
		global $wgOut, $wgJsMimeType, $wgExtensionsPath;
		$wgOut->addScript( "<script type=\"{$wgJsMimeType}\" src=\"$wgExtensionsPath/wikia/RTE/js/RTE.preferences.js\"></script>" );
		return true;
	}

	/**
	 * Modify values returned by User::getGlobalPreference() when wysiwyg is enabled
	 */
	static public function userGetOption( $options, $name, &$value ): bool {
		global $wgRequest;

		$useEditor = $wgRequest->getVal( 'useeditor', false );

		// do not continue if user didn't turn on wysiwyg in preferences
		if ( ( isset( $options['editor'] ) && $options['editor'] === '1' && empty( $useEditor ) ) ) {
			return true;
		}

		if ( $useEditor === 'source' || $useEditor === 'mediawiki' ) {
			return true;
		}

		// options to be modified
		$values = [
			'editwidth' => false,
			'showtoolbar' => true,
			'previewonfirst' => false,
			'previewontop' => true,
			'disableeditingtips' => true,
			'disablelinksuggest' => false,
			'externaleditor' => false,
			'externaldiff' => false,
			'disablecategoryselect' => false,
		];

		if ( array_key_exists( $name, $values ) ) {
			// don't continue when on Special:Preferences (actually only check namespace ID, it's faster)
			global $wgTitle, $wgRTEDisablePreferencesChange;

			if ( !empty( $wgRTEDisablePreferencesChange ) || !empty( $wgTitle ) && ( $wgTitle->getNamespace() == NS_SPECIAL ) ) {
				return true;
			}
			$value = $values[$name];
		}

		return true;
	}

	/**
	 * Check whether current browser is compatible with RTE
	 *
	 * FCKeditor - The text editor for Internet - http://www.fckeditor.net
	 * Copyright (C) 2003-2009 Frederico Caldeira Knabben
	 */
	private static function isCompatibleBrowser(): bool {
		if ( isset( $_SERVER ) && isset( $_SERVER['HTTP_USER_AGENT'] ) ) {
			$sAgent = $_SERVER['HTTP_USER_AGENT'];
		} else {
			global $HTTP_SERVER_VARS;
			if ( isset( $HTTP_SERVER_VARS ) && isset( $HTTP_SERVER_VARS['HTTP_USER_AGENT'] ) ) {
				$sAgent = $HTTP_SERVER_VARS['HTTP_USER_AGENT'];
			} else {
				global $HTTP_USER_AGENT;
				$sAgent = $HTTP_USER_AGENT;
			}
		}

		RTE::log( __METHOD__, $sAgent );
		$ret = true;

		if ( strpos( $sAgent, 'Mobile' ) !== false && strpos( $sAgent, 'Safari' ) !== false ) {
			// disable for mobile devices from Apple (RT #38829)
			$ret = false;
		}

		// Disable for IE 11 (VE-675). RTE should be gone by the time IE 12 rolls out, so it's
		// not necessary to match for future versions.
		if ( strpos( $sAgent, 'Trident/' ) !== false && strpos( $sAgent, 'rv:11.0' ) !== false ) {
			$ret = false;
		}

		// Disable Edge
		if ( strpos( $sAgent, 'Edge/' ) !== false ) {
			$ret = false;
		}

		RTE::log( __METHOD__, $ret ? 'yes' : 'no' );
		return $ret;
	}


}
