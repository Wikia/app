<?php

global $wgHooks, $wgInPageEnabled;
	if (!isset($wgInPageEnabled) || ($wgInPageEnabled == false)) {
		return;
	}

$wgHooks['ParserBeforeTidy'][] = 'beforeTidyHook';
$wgHooks['UserToggles'][] = 'wfWikiwygToggle';
$wgHooks['handleWikiPrefs'][] = 'wfWikiwygHandleEditingPrefs';
$wgHooks['getEditingPreferencesTab'][] = 'wfWikiwygAddEditingPrefs';

$wgExtensionFunctions[] = 'registerWikiwygExtension';
$wgExtensionCredits['other'][] = array(
	'name' => 'MediaWikiWyg',
	'author' => array('http://svn.wikiwyg.net/code/trunk/wikiwyg/AUTHORS', 'Bartek Łapiński'),
	'version' => 0.20,
	'url' => 'http://www.mediawiki.org/wiki/Extension:Wikiwyg',
	'description' => 'MediaWiki integration of the Wikiwyg WYSIWYG wiki editor'
);

function wfGetDependingOnSkin () {
    $useInPageTrue = '';
    global $wgCookiePrefix, $wgUser, $wgInPageEnabled;

    /* do not forget about editor disabled from variable... */
    if (!$wgInPageEnabled || !isset ($wgInPageEnabled)) {
        return 0;
    }

    if ($wgUser->getOption ('in-page', 2) == 2) {
	$skin = $wgUser->getSkin();
	if (is_object ($skin)){
		/* forget about the _real_ skinname - it's not loaded yet */
		$skinname = get_class($skin);
		/*
                if (($skinname == 'SkinMonoBook') ) {
			return 1 ;
		} else {
			return 0 ;
		}*/
		return 1;
	} else {
		return 0;
	}
    }  else {
       	  return $wgUser->getOption ('in-page', 1);
    }
}

function registerWikiwygExtension() {
    global $wgOut, $wgSkin, $jsdir, $cssdir, $wgScriptPath;
    global $wgWikiwygPath, $wgUser, $wgTitle;
    global $wgServer, $wgWikiwygJsPath, $wgWikiwygCssPath, $wgWikiwygImagePath;
    global $wgRequest, $wgWysiwygEnabled, $wgMessageCache;
    global $wgLang, $wgContLang, $wgEnableAjaxLogin;

	wfLoadExtensionMessages('Wikiwyg');

    if (wfGetDependingOnSkin () == 0) {
		return;
    }

    if (! isset($wgWikiwygPath)) {
        $wgWikiwygPath = $wgScriptPath . "/extensions/wikiwyg";
    }
    if (! isset($wgWikiwygJsPath)) {
        $wgWikiwygJsPath = "$wgWikiwygPath/share/MediaWiki";
    }
    if (! isset($wgWikiwygCssPath)) {
        $wgWikiwygCssPath = "$wgWikiwygPath/share/MediaWiki/css";
    }
    if (! isset($wgWikiwygImagePath)) {
        $wgWikiwygImagePath = "$wgWikiwygPath/share/MediaWiki/images";
    }

    $wgOut->addScript("<style type=\"text/css\" media=\"screen,projection\">/*<![CDATA[*/ @import \"$wgWikiwygCssPath/MediaWikiwyg.css\"; /*]]>*/</style>\n");
    if (isset($wgWysiwygEnabled) && ($wgWysiwygEnabled == true)) {
	    $useWysiwygTrue = 1;
    } else {
	    $useWysiwygTrue = 0;
    }

    if (! isset($wgEnableAjaxLogin) || ($wgEnableAjaxLogin == false)) {
	    $wgEnableAjaxLogin = 0;
    }


    $wgOut->addScript("
<script type=\"text/javascript\">
    if (typeof(Wikiwyg) == 'undefined') Wikiwyg = function() {};
    Wikiwyg.mediawiki_source_path = \"$wgWikiwygPath\";
    var wgEditCaption = \"".mb_strtolower(wfMsg('qbedit'))."\";
    var wgSaveCaption = \"".mb_strtolower(wfMsg ('save'))."\";
    var wgCancelCaption = \"".mb_strtolower(wfMsg ('cancel'))."\";
    var wgSummaryCaption = \"".wfMsg ('edit-summary')."\";
    var wgPreviewCaption = \"".wfMsg ('preview')."\";
    var wgHelpCaption = \"".wfMsg ('help')."\" ;
    var wgBoldTip = \"".wfMsg ('bold_tip')."\";
    var wgItalicTip = \"".wfMsg ('italic_tip')."\";
    var wgIntlinkTip = \"".wfMsg ('mwlink_tip')."\";
    var wgExtlinkTip = \"".wfMsg ('extlink_tip')."\";
    var wgNowikiTip = \"".wfMsg ('nowiki_tip')."\";
    var wgHrTip = \"".wfMsg ('hr_tip')."\";
    var wgTimestampTip =  \"".wfMsg ('sig_tip')."\";
    var wgUseWysiwyg = " .$useWysiwygTrue." ;
    var wgUseInPage = ".wfGetDependingOnSkin ().";
    var wgFullPageEditing = false ;
    var wgWysiwygCaption = \"".wfMsg ('wysiwygcaption') ."\" ;
    var wgInsertImageCaption = \"".wfMsg ('insertimage') ."\" ;
    var wgMinoreditCaption = \"" .wfMsg ('minoredit') ."\" ;
    var wgWatchthisCaption = \"" .wfMsg ('watchthis') ."\" ;
    var wgDefaultMode = \"".$wgUser->getOption ('visualeditormode','wysiwyg') ."\" ;
    var wgCategoryPrefix = \"".urlencode ($wgContLang->getNsText (NS_CATEGORY) ) ."\" ;
    var wgSpecialPrefix = \"".urlencode ($wgContLang->getNsText (NS_SPECIAL) ) ."\" ;
</script>
");

    $wgOut->addScript("
		<script type=\"text/javascript\">
		function insertTags (tagOpen, tagClose, sampleText) {
		                currentWikiwyg.current_mode.markup_line_alone (['line_alone', tagOpen + sampleText + tagClose]) ;
				}
				document.insertTags = insertTags ;
		 </script>
    ") ;

    $wgOut->addScript("<script type=\"text/javascript\" src=\"$wgWikiwygJsPath/MediaWikiWyg.js?".$GLOBALS['wgStyleVersion']."\"></script>\n");
}

/*	gets the lowest header level present in the article
	or the next level when deeper in the structure,
	depending on the given level
*/

function wfDetermineStartingLevel ($text) {
	for ($i = 0; $i < 8 ; $i++) {
		if ( preg_match ('/<h'.$i.'>/i', $text) ) {
			return $i;
		}
	}
	return "NONE";
}

function wfDetermineNextLevel ($level, $text) {
	for ($i = $level + 1; $i < 8; $i++) {
                if ( preg_match ('/<h'.$i.'>/i', $text) ) {
			return $i;
		}
	}
	return "NONE";
}

/* parse recurrently depending on current header level */
function wfRecurrentParse ($text, $level) {
    $blocks = preg_split(
        '/(<a name=".*?".*?<\/a><h'.$level.'><span class="editsection".*?<\/span>)/i',
        $text, -1, PREG_SPLIT_DELIM_CAPTURE
    );

    $i = 0;

    $full = array_shift($blocks);
    $header_block = "";
    foreach ($blocks as $block) {
        /* now, _this_ is an edit link */
        if (preg_match('/<h'.$level.'><span class="editsection".*?<\/span>/i', $block)) {
		$inner_blocks = preg_split(
			'/(<h'.$level.'>)/i',
			$block, -1, PREG_SPLIT_DELIM_CAPTURE
		);
	        foreach ($inner_blocks as $inner_block) {
                	if (preg_match('/<span class="editsection".*?<\/span>/i', $inner_block)) {
                        	/* now, this is a real edit link... */
				            $i++;
					    /* extract the _real_ section number */
					    preg_match ('/section=[0-9]+/',$inner_block, $section_number);
					    $section_number = substr ($section_number[0], 8);
					    $full .= "<span class='wikiwyg_edit' id=\"wikiwyg_edit_{$section_number}\">
						$inner_block
						</span>
						";
			} else {
	                 	/* not an edit link... */
				if (!preg_match('/<h'.$level.'>/i', $inner_block)) {
					$full .= $inner_block;
				} else {
		                       	$header_block = $inner_block;
				}
			}
                }
        }
        # This is a section body
        else {
            if ($i == 0) {
                die("Wrong order!");
            }
	    /* correct next level to actually match next level... */
	    $next_level = wfDetermineNextLevel ($level - 1,$block);
            if (preg_match('/<h'.$next_level.'>/i',$block)) {
	    /* investigate matter further - there may be subsections */
	    	/* we found more sections - split it up, add the main thing and go deeper */
    		$blocked_splits = preg_split(
	        	'/(<\/h'.$level.'>)/i',
	        	$block, -1, PREG_SPLIT_DELIM_CAPTURE
		    );
		$block = '';
		$block .= $blocked_splits[0].$blocked_splits[1];
	    $block .= wfRecurrentParse($blocked_splits[2], $next_level);
	    }

	    /* split it up further to insert the throbber - we need to put it after mw-headline */
	    $full .= "<span class=\"wikiwyg_section\" id=\"wikiwyg_section_{$section_number}\">$header_block";
	    $full .= $block;
        $full .= "
</span>
<iframe class='wikiwyg_iframe'
        id=\"wikiwyg_iframe_{$section_number}\"
        height='0' width='0'
        frameborder='0'>
</iframe>
";
        }
    }
    return $full;
}

function beforeTidyHook($parser, $text) {
    global $wgServer, $wgScriptPath, $wgUser;
    if ($wgUser->getOption ('in-page', 1) == 0 ) return true;
    $wgScriptPath != "" ? $fixedPath = $wgServer."/".$wgScriptPath : $fixedPath = $wgServer;
    /* stuff changed in MW 1.9.3, the order of elements is different now */
    /* one more interesting thing - determine the maximum depth of the headers
     (remember, MW uses level 2 headers as suggested ones...) */
    $starting_level = wfDetermineStartingLevel($text);
    $text = wfRecurrentParse ($text, $starting_level, 0);
	return true;
}

# Not a valid entry point, skip unless MEDIAWIKI is defined
if (defined('MEDIAWIKI')) {
$wgExtensionFunctions[] = 'wfEZParser';

function wfEZParser() {
global $IP;
require_once( $IP.'/includes/SpecialPage.php' );

class EZParser extends UnlistedSpecialPage {
	function EZParser() {
		UnlistedSpecialPage::UnlistedSpecialPage('EZParser');
		wfLoadExtensionMessages('Wikiwyg');
	}

	function execute( $par ) {
		global $wgRequest, $wgOut, $wgTitle, $wgUser;

/*		if (!in_array( 'ezparser', $wgUser->getRights() ) ) {
			$wgOut->setArticleRelated( false );
			$wgOut->setRobotpolicy( 'noindex,follow' );
			$wgOut->errorpage( 'nosuchspecialpage', 'nospecialpagetext' );
			return;
		}
*/

		$this->setHeaders();

		$text = $wgRequest->getText('text');
        $title = $wgRequest->getText('rtitle');
		$namespace = $wgRequest->getText('rnamespace');

		if ( $text ) {
			$this->parseText( $text, $title );
		} else {
	  		$wgOut->setArticleBodyOnly( true );
		}
	}

	function parseText($text, $title){
		#still need to make it actually parse the input.
		global $wgOut, $wgUser, $wgTitle, $wgParser, $wgAllowDiffPreview, $wgEnableDiffPreviewPreference;
		$parserOptions = ParserOptions::newFromUser( $wgUser );
		$parserOptions->setEditSection( false );
		$rtitle = Title::newFromText($title);

		$pre_parsed = $wgParser->preSaveTransform ($text, $rtitle, $wgUser, $parserOptions, true) ;
		$output = $wgParser->parse( $pre_parsed, $rtitle, $parserOptions );
		$wgOut->setArticleBodyOnly( true );

		# Here we filter the output. If there's a section header in the beginning,
		# we'll have an empty wikiwyg_section_0 div, and we do not want it.
		# So we strip the empty span out.

		$goodHTML = str_replace("<span class=\"wikiwyg_section_0\">\n<p><!-- before block -->\n</p><p><br />\n</p><p><!-- After block -->\n</p>\n</span><iframe class=\"wikiwyg_iframe\" id=\"wikiwyg_iframe_0\" height='0' width='0' frameborder='0'></iframe>", "", $output->mText);
		/* manually strip away TOC */
		$goodHTML = preg_replace ('/<table id="toc".*<\/table>*.<script type="text\/javascript"> if \(window\.showTocToggle\).*<\/script>/is', "", $goodHTML);
		$wgOut->addHTML($goodHTML);
	}
}

SpecialPage::addPage( new EZParser );
}

$wgExtensionFunctions[] = 'wfPocketDiff';
function wfPocketDiff () {
global $IP;
require_once( $IP.'/includes/SpecialPage.php' );

class PocketDiff extends UnlistedSpecialPage {
	function PocketDiff() {
		UnlistedSpecialPage::UnlistedSpecialPage('PocketDiff');
		wfLoadExtensionMessages('Wikiwyg');
	}

	function execute( $par ) {
		global $wgRequest, $wgOut, $wgTitle, $wgUser;

		$this->setHeaders();

		$text = $wgRequest->getText('text');
        $title = $wgRequest->getText('rtitle');
		$section = $wgRequest->getText('rsection');
		$namespace = $wgRequest->getText('rnamespace');
	  	$wgOut->setArticleBodyOnly( true );

		if ( $text ) {
        		$this->makeADifference( $text, $title, $section );
		}
	}

	function makeADifference ($text, $title, $section) {
		global $wgOut;
		/* make an article object */
        $rtitle = Title::newFromText($title);

        $rarticle = new Article($rtitle, $rtitle->getArticleID ());
       	$epage = new EditPage($rarticle);
		$epage->section = $section;

		/* customized getDiff from EditPage */
		$oldtext = $epage->mArticle->fetchContent();
		$edittime = $epage->mArticle->getTimestamp();
		$newtext = $epage->mArticle->replaceSection(
				$section, $text, '', $edittime );

		$newtext = $epage->mArticle->preSaveTransform( $newtext );
		$oldtitle = wfMsgExt( 'currentrev', array('parseinline') );
		$newtitle = wfMsgExt( 'yourtext', array('parseinline') );
		if ( $oldtext !== false  || $newtext != '' ) {
			$de = new DifferenceEngine( $epage->mTitle );
			$de->setText( $oldtext, $newtext );
			$difftext = $de->getDiff( $oldtitle, $newtitle );
		} else {
			$difftext = '';
		}

		$diffdiv = '<div id="wikiDiff">' . $difftext . '</div>';
		$wgOut->addHTML ($diffdiv);
	}
}

SpecialPage::addPage( new PocketDiff );
}

function wfWikiwygToggle ($toggles) {
	global $wgWysiwygEnabled;
	wfLoadExtensionMessages('Wikiwyg');
	$toggles["in-page"] = "in-page";
	return true;
}

function wfWikiwygAddEditingPrefs ($prefsForm, $prefs) {
	global $wgWysiwygEnabled;
	$prefs = array_merge ($prefs, array (
						'in-page'
					));
	return true;
}

function wfWikiwygHandleEditingPrefs () {
	global $wgOut, $wgWysiwygEnabled;
	if (isset($wgWysiwygEnabled) && $wgWysiwygEnabled) {
        $wgOut->addScript("
    		<script type=\"text/javascript\">
			function WikiwygEnhanceControls () {

				var inPageControl = document.getElementById ('in-page');
				var WysiwygControl = document.getElementById ('wpVisualEditorWysiwyg');
				var WikitextControl = document.getElementById ('wpVisualEditorWikitext');

				//initial enable
				if (inPageControl.checked) {
					WysiwygControl.disabled = false;
					WysiwygControl.parentNode.style.fontColor = 'black';
					WikitextControl.disabled = false;
					WikitextControl.parentNode.style.fontColor = 'black';
				}

				var PreferencesSave = document.getElementById ('wpSaveprefs');
				inPageControl.onclick = function () {
					if (inPageControl.checked) {
						WysiwygControl.disabled = false;
						WysiwygControl.parentNode.style.fontColor = 'black';
						WikitextControl.disabled = false;
						WikitextControl.parentNode.style.fontColor = 'black';
					} else {
						WysiwygControl.parentNode.style.fontColor = 'gray';
	                                	WysiwygControl.disabled = true;
						WikitextControl.parentNode.style.fontColor = 'gray';
	                                	WikitextControl.disabled = true;
					}
				}
				PreferencesSave.onclick = function () {
				       Cookie.del (\"WikiwygEditMode\");
				       //Cookie.del (\"WikiwygFPEditMode\");
				}
			}
			addOnloadHook (WikiwygEnhanceControls);
		</script>"
	) ;
	}
	return true;
}

} # End if(defined MEDIAWIKI)
