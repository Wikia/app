<?php

class FCKeditor_MediaWiki
{
	private $count = array();
	private $wgFCKBypassText = "";
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

	static $messagesLoaded = false;

	function __call($m,$a)
	{
		print "\n#### " . $m . "\n";
		if (!isset($this->count[$m])) {
			$this->count[$m] = 0;
		}
		$this->count[$m]++;
		return true;
	}

	function onMonoBookTemplateToolboxEnd()
	{
		if ($this->debug) {
			print_r($this->count);
		}
	}

	private function getExcludedNamespaces()
	{
		global $wgUser;

		if ( is_null( $this->excludedNamespaces ) ) {
			$this->excludedNamespaces = array();
			foreach ( self::$nsToggles as $toggle ) {
				if ( $wgUser->getOption( $toggle ) ) {
					$this->excludedNamespaces[] = constant(strtoupper(str_replace("riched_disable_", "", $toggle)));
				}
			}
		}

		return $this->excludedNamespaces;
	}

	public function onLanguageGetMagic(&$magicWords, $langCode)
	{
		$magicWords['NORICHEDITOR'] = array( 0, '__NORICHEDITOR__' );
		
		return true;
	}
	
	public function onParserBeforeInternalParse(&$parser, &$text, &$strip_state)
	{
		MagicWord::get( 'NORICHEDITOR' )->matchAndRemove( $text );
		
		return true;
	}
	
	public function onEditPageShowEditFormFields($pageEditor, $wgOut)
	{
		global $wgUser, $wgFCKEditorIsCompatible, $wgTitle, $wgVersion;

		/*
		If FCKeditor extension is enabled, BUT it shouldn't appear (because it's disabled by user, we have incompatible browser etc.)
		We must do this trick to show the original text as WikiText instead of HTML when conflict occurs
		*/
		if ( (!$wgUser->getOption( 'showtoolbar' ) || $wgUser->getOption( 'riched_disable' ) || !$wgFCKEditorIsCompatible) ||
				in_array($wgTitle->getNamespace(), $this->getExcludedNamespaces()) ||
				false !== strpos($pageEditor->textbox1, "__NORICHEDITOR__")
			) {
			if ($pageEditor->isConflict) {
				$pageEditor->textbox1 = $pageEditor->getWikiContent();
			}
		}
		/*
		If FCKeditor extension is enabled, and it should appear
		We must do this trick to show HTML instead of the original text when conflict occurs
		This hack is only needed for MW 1.11 and below
		*/
		else if (version_compare("1.12", $wgVersion, ">")) {
			if ($pageEditor->isConflict) {
			$options = new FCKeditorParserOptions();
			$options->setTidy(true);
			$parser = new FCKeditorParser();
			$parser->setOutputType(OT_HTML);
			$pa = $parser->parse($pageEditor->textbox1, $pageEditor->mTitle, $options);
			$pageEditor->textbox1 = $pa->mText;
			}
		}
		
		return true;
	}

	public function onEditPageBeforeConflictDiff($pageEditor, $wgOut)
	{
		global $fckPageEditor, $wgRequest;

		/*
		Show WikiText instead of HTML when there is a conflict
		http://dev.fckeditor.net/ticket/1385
		*/
		$pageEditor->textbox2 = $wgRequest->getVal( 'wpTextbox1' );
		$pageEditor->textbox1 = $pageEditor->getWikiContent();
				
		return true;
	}
	
	public function onSanitizerAfterFixTagAttributes($text, $element, &$attribs)
	{
		$text = preg_match_all("/Fckmw\d+fckmw/", $text, $matches);
		
		if (!empty($matches[0][0])) {
			global $leaveRawTemplates;
			if (!isset($leaveRawTemplates)) {
				$leaveRawTemplates = array();
			}
			$leaveRawTemplates = array_merge($leaveRawTemplates, $matches[0]);
			$attribs = array_merge($attribs, $matches[0]);
		}

		return true;
	}

	public function registerHooks() {
		global $wgHooks, $wgExtensionFunctions;

		$wgHooks['UserToggles'][]                       = array($this, 'onUserToggles');
		$wgHooks['MessagesPreLoad'][]                   = array($this, 'onMessagesPreLoad');
		$wgHooks['ParserAfterTidy'][]                   = array($this, 'onParserAfterTidy');
		$wgHooks['EditPage::showEditForm:initial'][]    = array($this, 'onEditPageShowEditFormInitial');
		$wgHooks['EditPage::showEditForm:fields'][]		= array($this, 'onEditPageShowEditFormFields');
		$wgHooks['EditPageBeforePreviewText'][]         = array($this, 'onEditPageBeforePreviewText');
		$wgHooks['EditPagePreviewTextEnd'][]            = array($this, 'onEditPagePreviewTextEnd');
		$wgHooks['CustomEditor'][]                      = array($this, 'onCustomEditor');
		$wgHooks['LanguageGetMagic'][]                  = array($this, "onLanguageGetMagic");
		$wgHooks['ParserBeforeInternalParse'][]         = array($this, "onParserBeforeInternalParse");
		$wgHooks['EditPageBeforeConflictDiff'][]		= array($this, 'onEditPageBeforeConflictDiff');
		$wgHooks['SanitizerAfterFixTagAttributes'][]	= array($this, 'onSanitizerAfterFixTagAttributes');

		if ($this->debug) {
			/*
			This is just an array of all available hooks, useful for debugging and learning
			Add here all new hooks
			*/
			$opcje =  array('ArticleSave',
			'ArticleInsertComplete', 'ArticleSaveComplete', 'TitleMoveComplete', 'ArticleProtect', 'ArticleProtectComplete', 'ArticleDelete', 'ArticleDeleteComplete', 'AlternateEdit', 'ArticleFromTitle', 'ArticleAfterFetchContent',
			'ArticlePageDataBefore', 'ArticlePageDataAfter', 'ParserBeforeStrip', 'ParserAfterStrip', 'ParserBeforeInternalParse', 'InternalParseBeforeLinks', 'ParserBeforeTidy', 'ParserAfterTidy', 'ParserClearState', 'ParserGetVariableValueSwitch',
			'ParserGetVariableValueTs', 'ParserGetVariableValueVarCache', 'OutputPageBeforeHTML', 'OutputPageParserOutput', 'CategoryPageView', 'PageRenderingHash', 'ArticleViewHeader', 'ArticleViewRedirect', 'editSectionLinkForOther', 'editSectionLink',
			'AutoAuthenticate', 'UserLoginComplete', 'UserLogout', 'UserLogoutComplete', 'userCan', 'WatchArticle', 'WatchArticleComplete', 'UnwatchArticle', 'UnwatchArticleComplete', 'MarkPatrolled',
			'MarkPatrolledComplete', 'EmailUser', 'EmailUserComplete', 'UploadVerification', 'UploadComplete', 'SpecialMovepageAfterMove', 'SpecialSearchNogomatch', 'ArticleEditUpdateNewTalk', 'UserRetrieveNewTalks', 'UserClearNewTalkNotification',
			'ArticlePurge', 'SpecialPageGetRedirect', 'SpecialPageExecuteBeforeHeader', 'SpecialPageExecuteBeforePage', 'SpecialPageExecuteAfterPage', 'SpecialVersionExtensionTypes', 'SpecialPage_initList', 'UploadForm:initial', 'UploadForm:BeforeProcessing', 'AddNewAccount',
			'AbortNewAccount', 'BlockIp', 'BlockIpComplete', 'UserRights', 'GetBlockedStatus', 'LogPageActionText', 'LogPageLogHeader', 'LogPageLogName', 'LogPageValidTypes', 'BeforePageDisplay',
			'MonoBookTemplateToolboxEnd', 'PersonalUrls', 'SkinTemplateContentActions', 'SkinTemplateTabs', 'SkinTemplatePreventOtherActiveTabs', 'SkinTemplateSetupPageCss', 'SkinTemplateBuildContentActionUrlsAfterSpecialPage', 'SkinTemplateBuildNavUrlsNav_urlsAfterPermalink', 'UserCreateForm', 'UserLoginForm',
			'ArticleEditUpdatesDeleteFromRecentchanges', 'EditFilter', 'EditPage::showEditForm:initial', 'GetInternalURL', 'GetLocalURL', 'GetFullURL', 'LanguageGetMagic', 'MagicWordMagicWords', 'MagicWordwgVariableIDs', 'MessagesPreLoad',
			'ParserTestParser', 'SpecialContributionsBeforeMainOutput', 'UnknownAction', 'wgQueryPages', 'DisplayOldSubtitle', 'LoadAllMessages', 'RecentChange_save', 'UserToggles', 'BadImage', 'DiffViewHeader',
			'EditFormPreloadText', 'EmailConfirmed', 'FetchChangesList', 'MathAfterTexvc', 'SiteNoticeAfter', 'SiteNoticeBefore');

			foreach ($opcje as $o) {
				$wgHooks[$o][] = array($this, str_replace(":", "_", $o));
			}
		}
	}

	public function onCustomEditor(&$article, &$user)
	{
		global $wgRequest, $mediaWiki;

		$action = $mediaWiki->getVal('Action');

		$internal = $wgRequest->getVal( 'internaledit' );
		$external = $wgRequest->getVal( 'externaledit' );
		$section = $wgRequest->getVal( 'section' );
		$oldid = $wgRequest->getVal( 'oldid' );
		if( !$mediaWiki->getVal( 'UseExternalEditor' ) || $action=='submit' || $internal ||
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

	public function onEditPageBeforePreviewText(&$editPage, $previewOnOpen)
	{
		global $wgUser, $wgRequest;

		if ($wgUser->getOption( 'showtoolbar' ) && !$wgUser->getOption( 'riched_disable' ) && !$previewOnOpen ) {
			$this->oldTextBox1 = $editPage->textbox1;
			$editPage->importFormData( $wgRequest );
		}

		return true;
	}

	public function onEditPagePreviewTextEnd(&$editPage, $previewOnOpen)
	{
		global $wgUser;

		if ($wgUser->getOption( 'showtoolbar' ) && !$wgUser->getOption( 'riched_disable' ) && !$previewOnOpen ) {
			$editPage->textbox1 = $this->oldTextBox1;
		}

		return true;
	}

	public function onParserAfterTidy(&$parser, &$text)
	{
		global $wgUseTeX, $wgUser, $wgTitle, $wgFCKEditorIsCompatible;

		if (!$wgUser->getOption( 'showtoolbar' ) || $wgUser->getOption( 'riched_disable' ) || !$wgFCKEditorIsCompatible) {
			return true;
		}

		if (is_object($wgTitle) && in_array($wgTitle->getNamespace(), $this->getExcludedNamespaces())) {
			return true;
		}

		if ($wgUseTeX) {
			//it may add much overload on page with huge amount of math content...
			$text = preg_replace('/<img class="tex" alt="([^"]*)"/m', '<img _fckfakelement="true" _fck_mw_math="$1"', $text);
			$text = preg_replace("/<img class='tex' src=\"([^\"]*)\" alt=\"([^\"]*)\"/m", '<img src="$1" _fckfakelement="true" _fck_mw_math="$2"', $text);
		}

		return true;
	}

	public function onMessagesPreLoad()
	{
		global $wgMessageCache, $wgUser, $wgContLanguageCode;

		if ( !self::$messagesLoaded ) {
			$lang = $wgUser->getOption( 'language', $wgContLanguageCode );
			$i18nfile = dirname( __FILE__ ) . DIRECTORY_SEPARATOR .'languages' . DIRECTORY_SEPARATOR . 'FCKeditor.i18n.' . $lang . '.php';

			if ( file_exists( $i18nfile ) ) {
				require( $i18nfile );
			} else {
				$lang = 'en';
				require( dirname( __FILE__ ) . DIRECTORY_SEPARATOR .'languages' . DIRECTORY_SEPARATOR . 'FCKeditor.i18n.en.php' );
			}

			$wgMessageCache->addMessages( $messages, $lang );
			self::$messagesLoaded = true;
		}

		return true;
	}

	/**
	 * Add FCK script
	 * 
	 * @param unknown_type $q
	 * @return unknown
	 */
	public function onEditPageShowEditFormInitial( $form ) {
		global $wgOut, $wgTitle, $wgScriptPath;
		global $wgFCKEditorToolbarSet, $wgFCKEditorIsCompatible;
		global $wgFCKEditorExtDir, $wgFCKEditorDir, $wgFCKEditorHeight, $wgUser;
		global $wgStylePath, $wgStyleVersion, $wgDefaultSkin, $wgExtensionFunctions;
		global $wgFCKWikiTextBeforeParse;

		if (!$wgUser->getOption( 'showtoolbar' ) || $wgUser->getOption( 'riched_disable' ) || !$wgFCKEditorIsCompatible) {
			return true;
		}

		if (in_array($wgTitle->getNamespace(), $this->getExcludedNamespaces())) {
			return true;
		}

		if (false !== strpos($form->textbox1, "__NORICHEDITOR__")) {
			return true;
		}

		$options = new FCKeditorParserOptions();
		$options->setTidy(true);
		$parser = new FCKeditorParser();
		$parser->setOutputType(OT_HTML);
		$wgFCKWikiTextBeforeParse = $form->textbox1;
		$form->textbox1 = $parser->parse($form->textbox1, $wgTitle, $options)->getText();

		$printsheet = htmlspecialchars( "$wgStylePath/common/wikiprintable.css?$wgStyleVersion" );

		//CSS trick,  we need to get user CSS stylesheets somehow... it must be done in a different way!
		$skin = $wgUser->getSkin();
		$skin->loggedin = $wgUser->isLoggedIn();
		$skin->mTitle =& $wgTitle;
		//$skin->skinname = 'monobook';
		$skin->userpage = $wgUser->getUserPage()->getPrefixedText();
		if (method_exists($skin, "setupUserCss")) {
			$skin->setupUserCss();
		}

		if (!empty($skin->usercss) && preg_match_all('/@import "([^"]+)";/', $skin->usercss, $matches)) {
			$userStyles = $matches[1];
		}
		//End of CSS trick

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

		if (!empty($userStyles)) {
			$script .= '
<script type="text/javascript"> 
sEditorAreaCSS += ",'.implode(',', $userStyles).'";
</script>';
		}

		$script .= <<<HEREDOC
<script type="text/javascript"> 

// Remove the mwSetupToolbar onload hook to avoid a JavaScript error with FF.
if ( window.removeEventListener )
	window.removeEventListener( 'load', mwSetupToolbar, false ) ;
else if ( window.detachEvent )
	window.detachEvent( 'onload', mwSetupToolbar ) ;
	
mwSetupToolbar = function() { return false ; } ;

function onLoadFCKeditor()
{
	if ( document.getElementById('wpTextbox1') )
	{
		var height = $wgFCKEditorHeight ;
		
		if ( height == 0 )
		{
			// Get the window (inner) size.
			var height = window.innerHeight || ( document.documentElement && document.documentElement.clientHeight ) || 550 ;
			
			// Reduce the height to the offset of the toolbar.
			var offset = document.getElementById('wikiPreview') || document.getElementById('toolbar') ;
			while ( offset )
			{
				height -= offset.offsetTop ;
				offset = offset.offsetParent ;
			}
			
			// Add a small space to be left in the bottom.
			height -= 20 ;
		}

		// Enforce a minimum height.
		height = ( !height || height < 300 ) ? 300 : height ;
		
		// Create the editor instance and replace the textarea.
		var oFCKeditor = new FCKeditor('wpTextbox1') ;
		oFCKeditor.BasePath = '$wgScriptPath/$wgFCKEditorDir/' ;
		oFCKeditor.Config['CustomConfigurationsPath'] = '$wgScriptPath/$wgFCKEditorExtDir/fckeditor_config.js' ;
		oFCKeditor.Config['EditorAreaCSS'] = "$wgScriptPath/$wgFCKEditorExtDir/css/fckeditor.css" ;
		oFCKeditor.Height = height ;
		oFCKeditor.ToolbarSet = '$wgFCKEditorToolbarSet' ;
		oFCKeditor.ReplaceTextarea() ;
		
		// Hide the default toolbar.
		document.getElementById('toolbar').style.cssText = 'display:none;' ;
		// do things with CharInsert for example

		var edittools_markup = document.getElementById ('editpage-specialchars') ;
		if (edittools_markup) {
			edittools_markup.style.display = 'none' ;
		}
		insertTags = function (tagOpen, tagClose, sampleText)
		{
			var txtarea;

			if ( !(typeof(FCK) == "undefined") && !(typeof(FCK.EditingArea) == "undefined") )
			{
				txtarea = FCK.EditingArea.Textarea ;
			}
			else if (document.editform)
			{
				// if we have FCK enabled, behave differently...
				FCKarea = document.getElementById( oFCKeditor.InstanceName ) ;
				if ( FCKarea.style.display == 'none' )
				{
					SRCiframe = document.getElementById ('wpTextbox1___Frame') ;
					if ( SRCiframe )
					{
						if (window.frames["wpTextbox1___Frame"])
							SRCdoc = window.frames["wpTextbox1___Frame"].document ;
						else
							SRCdoc = SRCiframe.contentDocument ;
							
						var SRCarea = SRCdoc.getElementById ('xEditingArea').firstChild ;
						
						if (SRCarea)
							txtarea = SRCarea ;
						else
							return false ;
							
					} 
					else 
					{
						return false ;
					}
				}
				else
				{
					txtarea = document.editform.wpTextbox1 ;
				}
			}
			else
			{
				// some alternate form? take the first one we can find
				var areas = document.getElementsByTagName( 'textarea' ) ;
				txtarea = areas[0] ;
			}

			var selText, isSample = false ;

			if ( document.selection  && document.selection.createRange ) 
			{ // IE/Opera

				//save window scroll position
				if ( document.documentElement && document.documentElement.scrollTop )
					var winScroll = document.documentElement.scrollTop ;
				else if ( document.body )
					var winScroll = document.body.scrollTop ;

				//get current selection
				txtarea.focus() ;
				var range = document.selection.createRange() ;
				selText = range.text ;
				//insert tags
				if (!selText) { 
					selText = sampleText; 
					isSample = true; 
				} else if (selText.charAt(selText.length - 1) == ' ') { //exclude ending space char 
					selText = selText.substring(0, selText.length - 1); 
					tagClose += ' ' 
				} 
				range.text = tagOpen + selText + tagClose ;
				//mark sample text as selected
				if ( isSample && range.moveStart )
				{
					if (window.opera)
						tagClose = tagClose.replace(/\\n/g,'') ; //check it out one more time
					range.moveStart('character', - tagClose.length - selText.length) ;
					range.moveEnd('character', - tagClose.length) ;
				}
				range.select();
				//restore window scroll position
				if ( document.documentElement && document.documentElement.scrollTop )
					document.documentElement.scrollTop = winScroll ;
				else if ( document.body )
					document.body.scrollTop = winScroll ;

			} 
			else if ( txtarea.selectionStart || txtarea.selectionStart == '0' ) 
			{ // Mozilla

				//save textarea scroll position
				var textScroll = txtarea.scrollTop ;
				//get current selection
				txtarea.focus() ;
				var startPos = txtarea.selectionStart ;
				var endPos = txtarea.selectionEnd ;
				selText = txtarea.value.substring( startPos, endPos ) ;
				
				//insert tags
				if (!selText) 
				{
					selText = sampleText ;
					isSample = true ;
				} 
				else if (selText.charAt(selText.length - 1) == ' ')
				{ //exclude ending space char
					selText = selText.substring(0, selText.length - 1) ;
					tagClose += ' ' ;
				}
				txtarea.value = txtarea.value.substring(0, startPos) + tagOpen + selText + tagClose + 
								txtarea.value.substring(endPos, txtarea.value.length) ;
				//set new selection
				if (isSample) 
				{
					txtarea.selectionStart = startPos + tagOpen.length ;
					txtarea.selectionEnd = startPos + tagOpen.length + selText.length ;
				} 
				else 
				{
					txtarea.selectionStart = startPos + tagOpen.length + selText.length + tagClose.length ;
					txtarea.selectionEnd = txtarea.selectionStart;
				}
				//restore textarea scroll position
				txtarea.scrollTop = textScroll;
			}
		}
	}
}
addOnloadHook( onLoadFCKeditor ) ;
</script>
HEREDOC;

/*
$script .= <<<HEREDOC
<script type="text/javascript">
function showSource() {
	var wp = document.getElementById("wpDiff");
	var s = document.createElement("input");
	s.type="submit";
	s.value="Wiki2HTML";
	s.name="Wiki2HTML";
	s.onclick = function wiki2html() {
		var oEditor = FCKeditorAPI.GetInstance('wpTextbox1');
		WikiToHTML_Call();
		return false;
	}
	wp.parentNode.insertBefore(s, wp.nextSibling);
}

var sajax_debug_mode = false;
var sajax_request_type = "GET";

function WikiToHTML_Result(result)
{
	var oEditor = FCKeditorAPI.GetInstance('wpTextbox1');
	oEditor.SetHTML(result.responseText);
}
function WikiToHTML_Call()
{
	var oEditor = FCKeditorAPI.GetInstance('wpTextbox1');
	sajax_do_call('wfSajaxWikiToHTML', [oEditor.GetHTML()], WikiToHTML_Result);
}

addOnloadHook(showSource);
</script>
HEREDOC;
*/

		$wgOut->addScript($script);

		return true;
	}

	public function onUserToggles( &$extraToggles ) {
		$extraToggles[] = 'riched_disable';
		$extraToggles = array_merge($extraToggles, self::$nsToggles);
		return true;
	}
}
