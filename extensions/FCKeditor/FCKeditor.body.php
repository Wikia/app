<?php
/**
 * Options for FCKeditor
 * [start with FCKeditor]
 */
define('RTE_VISIBLE', 1);
/**
 * Options for FCKeditor
 * [show toggle link]
 */
define('RTE_TOGGLE_LINK', 2);
/**
 * Options for FCKeditor
 * [show popup link]
 */
define('RTE_POPUP', 4);

class FCKeditor_MediaWiki {
	public $showFCKEditor;
	private $count = array();
	private $wgFCKBypassText = '';
	private $debug = 0;
	private $excludedNamespaces;
	private $oldTextBox1;
	static $nsToggles = array(
	'riched_disable_ns_main',
	'riched_disable_ns_talk',
	'riched_disable_ns_user',
	'riched_disable_ns_user_talk',
	'riched_disable_ns_project',
	'riched_disable_ns_project_talk',
	'riched_disable_ns_image',
	'riched_disable_ns_image_talk',
	'riched_disable_ns_mediawiki',
	'riched_disable_ns_mediawiki_talk',
	'riched_disable_ns_template',
	'riched_disable_ns_template_talk',
	'riched_disable_ns_help',
	'riched_disable_ns_help_talk',
	'riched_disable_ns_category',
	'riched_disable_ns_category_talk',
	);

	function __call( $m, $a ) {
		print "\n#### " . $m . "\n";
		if( !isset( $this->count[$m] ) ) {
			$this->count[$m] = 0;
		}
		$this->count[$m]++;
		return true;
	}

	/**
	 * Gets the namespaces where FCKeditor should be disabled
	 * First check is done against user preferences, second is done against the global variable $wgFCKEditorExcludedNamespaces
	 */
	private function getExcludedNamespaces() {
		global $wgUser, $wgDefaultUserOptions, $wgFCKEditorExcludedNamespaces;

		if( is_null( $this->excludedNamespaces ) ) {
			$this->excludedNamespaces = array();
			foreach( self::$nsToggles as $toggle ) {
				$default = isset( $wgDefaultUserOptions[$toggle] ) ? $wgDefaultUserOptions[$toggle] : '';
				if( $wgUser->getOption( $toggle, $default ) ) {
					$this->excludedNamespaces[] = constant( strtoupper( str_replace( 'riched_disable_', '', $toggle ) ) );
				}
			}
			/*
			If this site's LocalSettings.php defines Namespaces that shouldn't use the FCKEditor (in the #wgFCKexcludedNamespaces array), those excluded
			namespaces should be combined with those excluded in the user's preferences.
			*/
			if( !empty( $wgFCKEditorExcludedNamespaces ) && is_array( $wgFCKEditorExcludedNamespaces ) ) {
				$this->excludedNamespaces = array_merge( $wgFCKEditorExcludedNamespaces, $this->excludedNamespaces );
			}
		}

		return $this->excludedNamespaces;
	}

	public static function onLanguageGetMagic( &$magicWords, $langCode ) {
		$magicWords['NORICHEDITOR'] = array( 0, '__NORICHEDITOR__' );

		return true;
	}

	public static function onParserBeforeInternalParse( &$parser, &$text, &$strip_state ) {
		MagicWord::get( 'NORICHEDITOR' )->matchAndRemove( $text );

		return true;
	}

	public function onEditPageShowEditFormFields( $pageEditor, $wgOut ) {
		global $wgUser, $wgFCKEditorIsCompatible, $wgTitle;

		/*
		If FCKeditor extension is enabled, BUT it shouldn't appear (because it's disabled by user, we have incompatible browser etc.)
		We must do this trick to show the original text as WikiText instead of HTML when conflict occurs
		*/
		if ( ( !$wgUser->getOption( 'showtoolbar' ) || $wgUser->getOption( 'riched_disable' ) || !$wgFCKEditorIsCompatible ) ||
				in_array( $wgTitle->getNamespace(), $this->getExcludedNamespaces() ) || !( $this->showFCKEditor & RTE_VISIBLE ) ||
				false !== strpos( $pageEditor->textbox1, '__NORICHEDITOR__' )
			) {
			if( $pageEditor->isConflict ) {
				$pageEditor->textbox1 = $pageEditor->getWikiContent();
			}
		}

		return true;
	}

	/**
	 * @param $pageEditor EditPage instance
	 * @param $out OutputPage instance
	 * @return true
	 */
	public static function onEditPageBeforeConflictDiff( $pageEditor, $out ) {
		global $wgRequest;

		/*
		Show WikiText instead of HTML when there is a conflict
		http://dev.fckeditor.net/ticket/1385
		*/
		$pageEditor->textbox2 = $wgRequest->getVal( 'wpTextbox1' );
		$pageEditor->textbox1 = $pageEditor->getWikiContent();

		return true;
	}

	public static function onParserBeforeStrip( &$parser, &$text, &$stripState ) {
		$text = $parser->strip( $text, $stripState );
		return true;
	}

	public static function onSanitizerAfterFixTagAttributes( $text, $element, &$attribs ) {
		$text = preg_match_all( "/Fckmw\d+fckmw/", $text, $matches );

		if( !empty( $matches[0][0] ) ) {
			global $leaveRawTemplates;
			if( !isset( $leaveRawTemplates ) ) {
				$leaveRawTemplates = array();
			}
			$leaveRawTemplates = array_merge( $leaveRawTemplates, $matches[0] );
			$attribs = array_merge( $attribs, $matches[0] );
		}

		return true;
	}

	public function onCustomEditor( $article, $user ) {
		global $wgRequest, $mediaWiki;

		$action = $mediaWiki->getVal( 'Action' );

		$internal = $wgRequest->getVal( 'internaledit' );
		$external = $wgRequest->getVal( 'externaledit' );
		$section = $wgRequest->getVal( 'section' );
		$oldid = $wgRequest->getVal( 'oldid' );
		if( !$mediaWiki->getVal( 'UseExternalEditor' ) || $action == 'submit' || $internal ||
		$section || $oldid || ( !$user->getOption( 'externaleditor' ) && !$external ) ) {
			$editor = new FCKeditorEditPage( $article );
			$editor->submit();
		} elseif( $mediaWiki->getVal( 'UseExternalEditor' ) && ( $external || $user->getOption( 'externaleditor' ) ) ) {
			$mode = $wgRequest->getVal( 'mode' );
			$extedit = new ExternalEdit( $article, $mode );
			$extedit->edit();
		}

		return false;
	}

	public function onEditPageBeforePreviewText( &$editPage, $previewOnOpen ) {
		global $wgUser, $wgRequest;

		if( $wgUser->getOption( 'showtoolbar' ) && !$wgUser->getOption( 'riched_disable' ) && !$previewOnOpen ) {
			$this->oldTextBox1 = $editPage->textbox1;
			$editPage->importFormData( $wgRequest );
		}

		return true;
	}

	public function onEditPagePreviewTextEnd( &$editPage, $previewOnOpen ) {
		global $wgUser;

		if( $wgUser->getOption( 'showtoolbar' ) && !$wgUser->getOption( 'riched_disable' ) && !$previewOnOpen ) {
			$editPage->textbox1 = $this->oldTextBox1;
		}

		return true;
	}

	public function onParserAfterTidy( &$parser, &$text ) {
		global $wgUseTeX, $wgUser, $wgTitle, $wgFCKEditorIsCompatible;

		# Don't initialize for users that have chosen to disable the toolbar, rich editor or that do not have a FCKeditor-compatible browser
		if( !$wgUser->getOption( 'showtoolbar' ) || $wgUser->getOption( 'riched_disable' ) || !$wgFCKEditorIsCompatible ) {
			return true;
		}

		# Are we editing a page that's in an excluded namespace? If so, bail out.
		if( is_object( $wgTitle ) && in_array( $wgTitle->getNamespace(), $this->getExcludedNamespaces() ) ) {
			return true;
		}

		if( $wgUseTeX ) {
			// it may add much overload on page with huge amount of math content...
			$text = preg_replace( '/<img class="tex" alt="([^"]*)"/m', '<img _fckfakelement="true" _fck_mw_math="$1"', $text );
			$text = preg_replace( "/<img class='tex' src=\"([^\"]*)\" alt=\"([^\"]*)\"/m", '<img src="$1" _fckfakelement="true" _fck_mw_math="$2"', $text );
		}

		return true;
	}

	/**
	 * Adds some new JS global variables
	 * @param $vars Array: array of JS global variables
	 * @return true
	 */
	public static function onMakeGlobalVariablesScript( $vars ){
		global $wgFCKEditorDir, $wgFCKEditorExtDir, $wgFCKEditorToolbarSet, $wgFCKEditorHeight;

		$vars['wgFCKEditorDir'] = $wgFCKEditorDir;
		$vars['wgFCKEditorExtDir'] = $wgFCKEditorExtDir;
		$vars['wgFCKEditorToolbarSet'] = $wgFCKEditorToolbarSet;
		$vars['wgFCKEditorHeight'] = $wgFCKEditorHeight;

		return true;
	}

	/**
	 * Adds new toggles into Special:Preferences
	 * @param $user User object
	 * @param $preferences Preferences object
	 * @return true
	 */
	public static function onGetPreferences( $user, &$preferences ){
		global $wgDefaultUserOptions;
		wfLoadExtensionMessages( 'FCKeditor' );

		$preferences['riched_disable'] = array(
			'type' => 'toggle',
			'section' => 'editing/fckeditor',
			'label-message' => 'tog-riched_disable',
		);

		$preferences['riched_start_disabled'] = array(
			'type' => 'toggle',
			'section' => 'editing/fckeditor',
			'label-message' => 'tog-riched_start_disabled',
		);

		$preferences['riched_use_popup'] = array(
			'type' => 'toggle',
			'section' => 'editing/fckeditor',
			'label-message' => 'tog-riched_use_popup',
		);

		$preferences['riched_use_toggle'] = array(
			'type' => 'toggle',
			'section' => 'editing/fckeditor',
			'label-message' => 'tog-riched_use_toggle',
		);

		$preferences['riched_toggle_remember_state'] = array(
			'type' => 'toggle',
			'section' => 'editing/fckeditor',
			'label-message' => 'tog-riched_toggle_remember_state',
		);

		// Show default options in Special:Preferences
		if( !array_key_exists( 'riched_disable', $user->mOptions ) && !empty( $wgDefaultUserOptions['riched_disable'] ) )
			$user->setOption( 'riched_disable', $wgDefaultUserOptions['riched_disable'] );
		if( !array_key_exists( 'riched_start_disabled', $user->mOptions ) && !empty( $wgDefaultUserOptions['riched_start_disabled'] ) )
			$user->setOption( 'riched_start_disabled', $wgDefaultUserOptions['riched_start_disabled'] );
		if( !array_key_exists( 'riched_use_popup', $user->mOptions ) && !empty( $wgDefaultUserOptions['riched_use_popup'] ) )
			$user->setOption( 'riched_use_popup', $wgDefaultUserOptions['riched_use_popup'] );
		if( !array_key_exists( 'riched_use_toggle', $user->mOptions ) && !empty( $wgDefaultUserOptions['riched_use_toggle'] ) )
			$user->setOption( 'riched_use_toggle', $wgDefaultUserOptions['riched_use_toggle'] );
		if( !array_key_exists( 'riched_toggle_remember_state', $user->mOptions ) && !empty( $wgDefaultUserOptions['riched_toggle_remember_state'] ) )
			$user->setOption( 'riched_toggle_remember_state', $wgDefaultUserOptions['riched_toggle_remember_state'] );

		// Add the "disable rich editor on namespace X" toggles too
		foreach( self::$nsToggles as $newToggle ){
			$preferences[$newToggle] = array(
				'type' => 'toggle',
				'section' => 'editing/fckeditor',
				'label-message' => 'tog-' . $newToggle
			);
		}

		return true;
	}

	/**
	 * Add FCK script
	 *
	 * @param $form EditPage object
	 * @return true
	 */
	public function onEditPageShowEditFormInitial( $form ) {
		global $wgOut, $wgTitle, $wgScriptPath, $wgContLang, $wgUser;
		global $wgStylePath, $wgStyleVersion, $wgDefaultSkin, $wgExtensionFunctions, $wgHooks, $wgDefaultUserOptions;
		global $wgFCKWikiTextBeforeParse, $wgFCKEditorIsCompatible;
		global $wgFCKEditorExtDir, $wgFCKEditorDir, $wgFCKEditorHeight, $wgFCKEditorToolbarSet;

		if( !isset( $this->showFCKEditor ) ){
			$this->showFCKEditor = 0;
			if ( !$wgUser->getOption( 'riched_start_disabled', $wgDefaultUserOptions['riched_start_disabled'] ) ) {
				$this->showFCKEditor += RTE_VISIBLE;
			}
			if ( $wgUser->getOption( 'riched_use_popup', $wgDefaultUserOptions['riched_use_popup'] ) ) {
				$this->showFCKEditor += RTE_POPUP;
			}
			if ( $wgUser->getOption( 'riched_use_toggle', $wgDefaultUserOptions['riched_use_toggle'] ) ) {
				$this->showFCKEditor += RTE_TOGGLE_LINK;
			}
		}

		if( ( !empty( $_SESSION['showMyFCKeditor'] ) ) && ( $wgUser->getOption( 'riched_toggle_remember_state', $wgDefaultUserOptions['riched_toggle_remember_state'] ) ) ){
			// Clear RTE_VISIBLE flag
			$this->showFCKEditor &= ~RTE_VISIBLE;
			// Get flag from session
			$this->showFCKEditor |= $_SESSION['showMyFCKeditor'];
		}

		# Don't initialize if we have disabled the toolbar or FCkeditor or have a non-compatible browser
		if( !$wgUser->getOption( 'showtoolbar' ) ||
		$wgUser->getOption( 'riched_disable', !empty( $wgDefaultUserOptions['riched_disable'] ) ? $wgDefaultUserOptions['riched_disable'] : false )
		|| !$wgFCKEditorIsCompatible ) {
			return true;
		}

		# Don't do anything if we're in an excluded namespace
		if( in_array( $wgTitle->getNamespace(), $this->getExcludedNamespaces() ) ) {
			return true;
		}

		# Make sure that there's no __NORICHEDITOR__ in the text either
		if( false !== strpos( $form->textbox1, '__NORICHEDITOR__' ) ) {
			return true;
		}

		$wgFCKWikiTextBeforeParse = $form->textbox1;
		if( $this->showFCKEditor & RTE_VISIBLE ){
			$options = new FCKeditorParserOptions();
			$options->setTidy( true );
			$parser = new FCKeditorParser();
			$parser->setOutputType( OT_HTML );
			$form->textbox1 = str_replace( '<!-- Tidy found serious XHTML errors -->', '', $parser->parse( $form->textbox1, $wgTitle, $options )->getText() );
		}

		$printsheet = htmlspecialchars( "$wgStylePath/common/wikiprintable.css?$wgStyleVersion" );

		// CSS trick,  we need to get user CSS stylesheets somehow... it must be done in a different way!
		$skin = $wgUser->getSkin();
		$skin->loggedin = $wgUser->isLoggedIn();
		$skin->mTitle =& $wgTitle;
		$skin->initPage( $wgOut );
		$skin->userpage = $wgUser->getUserPage()->getPrefixedText();
		$skin->setupUserCss( $wgOut );

		if( !empty( $skin->usercss ) && preg_match_all( '/@import "([^"]+)";/', $skin->usercss, $matches ) ) {
			$userStyles = $matches[1];
		}
		// End of CSS trick

		$script = <<<HEREDOC
<script type="text/javascript" src="$wgScriptPath/$wgFCKEditorDir/fckeditor.js"></script>
<script type="text/javascript">
var sEditorAreaCSS = '$printsheet,/mediawiki/skins/monobook/main.css?{$wgStyleVersion}';
</script>
<!--[if lt IE 5.5000]><script type="text/javascript">sEditorAreaCSS += ',/mediawiki/skins/monobook/IE50Fixes.css?{$wgStyleVersion}'; </script><![endif]-->
<!--[if IE 5.5000]><script type="text/javascript">sEditorAreaCSS += ',/mediawiki/skins/monobook/IE55Fixes.css?{$wgStyleVersion}'; </script><![endif]-->
<!--[if IE 6]><script type="text/javascript">sEditorAreaCSS += ',/mediawiki/skins/monobook/IE60Fixes.css?{$wgStyleVersion}'; </script><![endif]-->
<!--[if IE 7]><script type="text/javascript">sEditorAreaCSS += ',/mediawiki/skins/monobook/IE70Fixes.css?{$wgStyleVersion}'; </script><![endif]-->
<!--[if lt IE 7]><script type="text/javascript">sEditorAreaCSS += ',/mediawiki/skins/monobook/IEFixes.css?{$wgStyleVersion}'; </script><![endif]-->
HEREDOC;

		$script .= '<script type="text/javascript"> ';
		if( !empty( $userStyles ) ) {
			$script .= 'sEditorAreaCSS += ",' . implode( ',', $userStyles ) . '";';
		}

		# Show references only if Cite extension has been installed
		$showRef = false;
		if( ( isset( $wgHooks['ParserFirstCallInit'] ) && in_array( 'wfCite', $wgHooks['ParserFirstCallInit'] ) ) ||
		( isset( $wgExtensionFunctions ) && in_array( 'wfCite', $wgExtensionFunctions ) ) ) {
			$showRef = true;
		}

		$showSource = false;
		if ( ( isset( $wgHooks['ParserFirstCallInit']) && in_array( 'efSyntaxHighlight_GeSHiSetup', $wgHooks['ParserFirstCallInit'] ) )
			|| ( isset( $wgExtensionFunctions ) && in_array( 'efSyntaxHighlight_GeSHiSetup', $wgExtensionFunctions ) ) ) {
			$showSource = true;
		}

		wfLoadExtensionMessages( 'FCKeditor' );
		$script .= '
var showFCKEditor = ' . $this->showFCKEditor . ';
var popup = false; // pointer to popup document
var firstLoad = true;
var editorMsgOn = "' . wfMsg( 'textrichditor' ) . '";
var editorMsgOff = "' . wfMsg( 'tog-riched_disable' ) . '";
var editorLink = "' . ( ( $this->showFCKEditor & RTE_VISIBLE ) ? wfMsg( 'tog-riched_disable' ) : wfMsg( 'textrichditor' ) ) . '";
var saveSetting = ' . ( $wgUser->getOption( 'riched_toggle_remember_state', $wgDefaultUserOptions['riched_toggle_remember_state']  ) ?  1 : 0 ) . ';
var RTE_VISIBLE = ' . RTE_VISIBLE . ';
var RTE_TOGGLE_LINK = ' . RTE_TOGGLE_LINK . ';
var RTE_POPUP = ' . RTE_POPUP . ';


var oFCKeditor = new FCKeditor( "wpTextbox1" );

// Set config
oFCKeditor.BasePath = wgScriptPath + "/" + wgFCKEditorDir;
oFCKeditor.Config["CustomConfigurationsPath"] = wgScriptPath + "/" + wgFCKEditorExtDir + "/fckeditor_config.js";';
		// Load fckeditor-rtl.css for right-to-left languages, but only fckeditor.css for other languages
		if( $wgContLang->isRTL() ) {
			$script .= 'oFCKeditor.Config["EditorAreaCSS"] = wgScriptPath + "/" + wgFCKEditorExtDir + "/css/fckeditor.css, wgScriptPath + "/" + wgFCKEditorExtDir + "/css/fckeditor-rtl.css";';
		} else {
			$script .= 'oFCKeditor.Config["EditorAreaCSS"] = wgScriptPath + "/" + wgFCKEditorExtDir + "/css/fckeditor.css";';
		}
		$script .= '
oFCKeditor.ToolbarSet = wgFCKEditorToolbarSet;
oFCKeditor.ready = true;
oFCKeditor.Config["showreferences"] = ' . ( ( $showRef ) ? 'true' : 'false' ) . ';
oFCKeditor.Config["showsource"] = ' . ( ( $showSource ) ? 'true' : 'false' ) . ';
';
		$script .= '</script>';

		$newWinMsg = wfMsg( 'rich_editor_new_window' );
		$script .= <<<HEREDOC
<script type="text/javascript">

//IE hack to call func from popup
function FCK_sajax(func_name, args, target) {
	sajax_request_type = 'POST';
	sajax_do_call(func_name, args, function (x) {
		// I know this is function, not object
		target(x);
		}
	);
}

function onLoadFCKeditor(){
	if( !( showFCKEditor & RTE_VISIBLE ) )
		showFCKEditor += RTE_VISIBLE;
	firstLoad = false;
	realTextarea = document.getElementById( 'wpTextbox1' );
	if ( realTextarea ){
		var height = wgFCKEditorHeight;
		realTextarea.style.display = 'none';
		if ( height == 0 ){
			// Get the window (inner) size.
			var height = window.innerHeight || ( document.documentElement && document.documentElement.clientHeight ) || 550;

			// Reduce the height to the offset of the toolbar.
			var offset = document.getElementById( 'wikiPreview' ) || document.getElementById( 'toolbar' );
			while ( offset ){
				height -= offset.offsetTop;
				offset = offset.offsetParent;
			}

			// Add a small space to be left in the bottom.
			height -= 20;
		}

		// Enforce a minimum height.
		height = ( !height || height < 300 ) ? 300 : height;

		// Create the editor instance and replace the textarea.
		oFCKeditor.Height = height;
		oFCKeditor.ReplaceTextarea();

		// Hide the default toolbar.
		document.getElementById( 'toolbar' ).style.display = 'none';

		// do things with CharInsert for example
		var edittools_markup = document.getElementById( 'editpage-specialchars' );
		if( edittools_markup ) {
			edittools_markup.style.display = 'none';
		}
		FCKeditorInsertTags = function( tagOpen, tagClose, sampleText, oDoc ){
			var txtarea;

			if ( !( typeof(oDoc.FCK) == "undefined" ) && !( typeof(oDoc.FCK.EditingArea) == "undefined" ) ){
				txtarea = oDoc.FCK.EditingArea.Textarea;
			} else if( oDoc.editform ){
				// if we have FCK enabled, behave differently...
				if ( showFCKEditor & RTE_VISIBLE ){
					SRCiframe = oDoc.getElementById( 'wpTextbox1___Frame' );
					if ( SRCiframe ){
						if( window.frames[SRCiframe] )
							SRCdoc = window.frames[SRCiframe].oDoc;
						else
							SRCdoc = SRCiframe.contentDocument;

						var SRCarea = SRCdoc.getElementById( 'xEditingArea' ).firstChild;

						if( SRCarea )
							txtarea = SRCarea;
						else
							return false;

					} else {
						return false;
					}
				} else {
					txtarea = oDoc.editform.wpTextbox1;
				}
			} else {
				// some alternate form? take the first one we can find
				var areas = oDoc.getElementsByTagName( 'textarea' );
				txtarea = areas[0];
			}

			var selText, isSample = false;

			if ( oDoc.selection  && oDoc.selection.createRange ){ // IE/Opera

				// save window scroll position
				if ( oDoc.documentElement && oDoc.documentElement.scrollTop )
					var winScroll = oDoc.documentElement.scrollTop;
				else if ( oDoc.body )
					var winScroll = oDoc.body.scrollTop;

				// get current selection
				txtarea.focus();
				var range = oDoc.selection.createRange();
				selText = range.text;
				// insert tags
				checkSelected();
				range.text = tagOpen + selText + tagClose;
				// mark sample text as selected
				if ( isSample && range.moveStart ){
					if( window.opera )
						tagClose = tagClose.replace(/\\n/g,''); // check it out one more time
					range.moveStart( 'character', - tagClose.length - selText.length );
					range.moveEnd( 'character', - tagClose.length );
				}
				range.select();
				// restore window scroll position
				if ( oDoc.documentElement && oDoc.documentElement.scrollTop )
					oDoc.documentElement.scrollTop = winScroll;
				else if ( oDoc.body )
					oDoc.body.scrollTop = winScroll;

			} else if ( txtarea.selectionStart || txtarea.selectionStart == '0' ){ // Mozilla

				// save textarea scroll position
				var textScroll = txtarea.scrollTop;
				// get current selection
				txtarea.focus();
				var startPos = txtarea.selectionStart;
				var endPos = txtarea.selectionEnd;
				selText = txtarea.value.substring( startPos, endPos );

				// insert tags
				if( !selText ){
					selText = sampleText;
					isSample = true;
				} else if( selText.charAt(selText.length - 1) == ' ' ){ //exclude ending space char
					selText = selText.substring(0, selText.length - 1);
					tagClose += ' ';
				}
				txtarea.value = txtarea.value.substring(0, startPos) + tagOpen + selText + tagClose +
								txtarea.value.substring(endPos, txtarea.value.length);
				// set new selection
				if( isSample ){
					txtarea.selectionStart = startPos + tagOpen.length;
					txtarea.selectionEnd = startPos + tagOpen.length + selText.length;
				} else {
					txtarea.selectionStart = startPos + tagOpen.length + selText.length + tagClose.length;
					txtarea.selectionEnd = txtarea.selectionStart;
				}
				// restore textarea scroll position
				txtarea.scrollTop = textScroll;
			}
		}
	}
}
function checkSelected(){
	if( !selText ) {
		selText = sampleText;
		isSample = true;
	} else if( selText.charAt(selText.length - 1) == ' ' ) { //exclude ending space char
		selText = selText.substring(0, selText.length - 1);
		tagClose += ' '
	}
}
function initEditor(){
	var toolbar = document.getElementById( 'toolbar' );
	// show popup or toogle link
	if( showFCKEditor & ( RTE_POPUP|RTE_TOGGLE_LINK ) ){
		// add new toolbar before wiki toolbar
		var fckTools = document.createElement( 'div' );
		fckTools.setAttribute('id', 'fckTools');
		toolbar.parentNode.insertBefore( fckTools, toolbar );

		var SRCtextarea = document.getElementById( 'wpTextbox1' );
		if( showFCKEditor & RTE_VISIBLE ) SRCtextarea.style.display = 'none';
	}

	if( showFCKEditor & RTE_TOGGLE_LINK ){
		fckTools.innerHTML='[<a class="fckToogle" id="toggle_wpTextbox1" href="javascript:void(0)" onclick="ToggleFCKEditor(\'toggle\',\'wpTextbox1\')">'+ editorLink +'</a>] ';
	}
	if( showFCKEditor & RTE_POPUP ){
		var style = (showFCKEditor & RTE_VISIBLE) ? 'style="display:none"' : "";
		fckTools.innerHTML+='<span ' + style + ' id="popup_wpTextbox1">[<a class="fckPopup" href="javascript:void(0)" onclick="ToggleFCKEditor(\'popup\',\'wpTextbox1\')">{$newWinMsg}</a>]</span>';
	}

	if( showFCKEditor & RTE_VISIBLE ){
		if ( toolbar ){	// insert wiki buttons
			// Remove the mwSetupToolbar onload hook to avoid a JavaScript error with FF.
			if ( window.removeEventListener )
				window.removeEventListener( 'load', mwSetupToolbar, false );
			else if ( window.detachEvent )
				window.detachEvent( 'onload', mwSetupToolbar );
			mwSetupToolbar = function(){ return false ; };

			for( var i = 0; i < mwEditButtons.length; i++ ) {
				mwInsertEditButton(toolbar, mwEditButtons[i]);
			}
			for( var i = 0; i < mwCustomEditButtons.length; i++ ) {
				mwInsertEditButton(toolbar, mwCustomEditButtons[i]);
			}
		}
		onLoadFCKeditor();
	}
	return true;
}
addOnloadHook( initEditor );

HEREDOC;

if( $this->showFCKEditor & ( RTE_TOGGLE_LINK | RTE_POPUP ) ){
	// add toggle link and handler
	$script .= <<<HEREDOC

function ToggleFCKEditor( mode, objId ){
	var SRCtextarea = document.getElementById( objId );
	if( mode == 'popup' ){
		if ( ( showFCKEditor & RTE_VISIBLE ) && ( FCKeditorAPI ) ) { // if FCKeditor is up-to-date
			var oEditorIns = FCKeditorAPI.GetInstance( objId );
			var text = oEditorIns.GetData( oEditorIns.Config.FormatSource );
			SRCtextarea.value = text; // copy text to textarea
		}
		FCKeditor_OpenPopup('oFCKeditor', objId);
		return true;
	}

	var oToggleLink = document.getElementById( 'toggle_' + objId );
	var oPopupLink = document.getElementById( 'popup_' + objId );

	if ( firstLoad ){
		// firstLoad = true => FCKeditor start invisible
		if( oToggleLink ) oToggleLink.innerHTML = 'Loading...';
		sajax_request_type = 'POST';
		oFCKeditor.ready = false;
		sajax_do_call('wfSajaxWikiToHTML', [SRCtextarea.value], function( result ){
			if ( firstLoad ){ //still
				SRCtextarea.value = result.responseText; // insert parsed text
				onLoadFCKeditor();
				if( oToggleLink ) oToggleLink.innerHTML = editorMsgOff;
				oFCKeditor.ready = true;
			}
		});
		return true;
	}

	if( !oFCKeditor.ready ) return false; // sajax_do_call in action
	if( !FCKeditorAPI ) return false; // not loaded yet
	var oEditorIns = FCKeditorAPI.GetInstance( objId );
	var oEditorIframe  = document.getElementById( objId + '___Frame' );
	var FCKtoolbar = document.getElementById( 'toolbar' );
	var bIsWysiwyg = ( oEditorIns.EditMode == FCK_EDITMODE_WYSIWYG );

	//FCKeditor visible -> hidden
	if ( showFCKEditor & RTE_VISIBLE ){
		var text = oEditorIns.GetData( oEditorIns.Config.FormatSource );
		SRCtextarea.value = text;
		if ( bIsWysiwyg ) oEditorIns.SwitchEditMode(); // switch to plain
		var text = oEditorIns.GetData( oEditorIns.Config.FormatSource );
		// copy from FCKeditor to textarea
		SRCtextarea.value = text;
		if( saveSetting ){
			sajax_request_type = 'GET';
			sajax_do_call( 'wfSajaxToggleFCKeditor', ['hide'], function(){} ); //remember closing in session
		}
		if( oToggleLink ) oToggleLink.innerHTML = editorMsgOn;
		if( oPopupLink ) oPopupLink.style.display = '';
		showFCKEditor -= RTE_VISIBLE;
		oEditorIframe.style.display = 'none';
		FCKtoolbar.style.display = '';
		SRCtextarea.style.display = '';
	} else {
		// FCKeditor hidden -> visible
		if ( bIsWysiwyg ) oEditorIns.SwitchEditMode(); // switch to plain
		SRCtextarea.style.display = 'none';
		// copy from textarea to FCKeditor
		oEditorIns.EditingArea.Textarea.value = SRCtextarea.value;
		FCKtoolbar.style.display = 'none';
		oEditorIframe.style.display = '';
		if ( !bIsWysiwyg ) oEditorIns.SwitchEditMode();	// switch to WYSIWYG
		showFCKEditor += RTE_VISIBLE; // showFCKEditor+=RTE_VISIBLE
		if( oToggleLink ) oToggleLink.innerHTML = editorMsgOff;
		if( oPopupLink ) oPopupLink.style.display = 'none';
	}
	return true;
}

HEREDOC;
}

if( $this->showFCKEditor & RTE_POPUP ){
	$script .= <<<HEREDOC

function FCKeditor_OpenPopup(jsID, textareaID){
	popupUrl = wgFCKEditorExtDir + '/FCKeditor.popup.html';
	popupUrl = popupUrl + '?var='+ jsID + '&el=' + textareaID;
	window.open(popupUrl, null, 'toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=no,resizable=1,dependent=yes');
	return 0;
}
HEREDOC;
}
$script .= '</script>';

		$wgOut->addScript( $script );

		return true;
	}

}
