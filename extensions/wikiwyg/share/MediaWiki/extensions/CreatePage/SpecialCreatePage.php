<?php

/**
 * A special page to create a new article, attempting to use Wikiwyg, a wysiwyg wikitext editor
 * @author Bartek Łapiński
 * @copyright Copyright © 2007, Wikia Inc.
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */
if(!defined('MEDIAWIKI'))
   die();

$wgExtensionFunctions[] = 'wfCreatePageSetup';
$wgExtensionCredits['specialpage'][] = array(
	'name' => 'Create Page',
	'author' => 'Bartek Łapiński',
	'url' => 'http://www.mediawiki.org/wiki/Extension:Wikiwyg',
	'description' => 'Allows to create a new page - with the WYSIWYG editor'
);

/* special page init */
function wfCreatePageSetup() {
	global $IP, $wgOut;
	require_once($IP. '/includes/SpecialPage.php');

	SpecialPage::addPage(new SpecialPage('Createpage', '', true, 'wfCreatePageSpecial', false));
}

/* the core */
function wfCreatePageSpecial( $par ) {
	global $IP, $wgOut, $wgUser, $wgRequest, $wgServer, $wgScriptPath, $wgEnableAjaxLogin, $wgContLang;
	wfLoadExtensionMessages('Wikiwyg');
	require_once("$IP/extensions/wikiwyg/share/MediaWiki/extensions/TagCloud/TagCloudClass.php");

	if (! isset($wgWikiwygPath)) {
		$wgWikiwygPath = "{$wgServer}/{$wgScriptPath}/extensions/wikiwyg";
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
        /* load main js file when not loaded yet */
	if (wfGetDependingOnSkin () == 0) {
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
				var wgIntlinkTip = \"".wfMsg ('link_tip')."\";
				var wgExtlinkTip = \"".wfMsg ('extlink_tip')."\";
				var wgNowikiTip = \"".wfMsg ('nowiki_tip')."\";
				var wgHrTip = \"".wfMsg ('hr_tip')."\";
				var wgTimestampTip =  \"".wfMsg ('sig_tip')."\";
				var wgUseWysiwyg = " .$useWysiwygTrue." ;
				var wgUseInPage = ".wfGetDependingOnSkin ().";
				var wgFullPageEditing = false ;
				var wgWysiwygCaption = \"".wfMsg ('wysiwygcaption') ."\" ;
				var wgInsertImageCaption = \"".wfMsg ('insertimage') ."\" ;
				var wgDefaultMode = \"".$wgUser->getOption ('visualeditormode','wysiwyg') ."\" ;
				var wgCategoryPrefix = \"".urlencode ($wgContLang->getNsText (NS_CATEGORY) ) ."\" ;
				var wgSpecialPrefix = \"".urlencode ($wgContLang->getNsText (NS_SPECIAL) ) ."\" ;
				var wgEnableAjaxLogin = ".$wgEnableAjaxLogin." ;
				</script>
			");
		$wgOut->addScript("<script type=\"text/javascript\" src=\"$wgWikiwygJsPath/MediaWikiWyg.js?".$GLOBALS['wgStyleVersion']."\"></script>\n");
	}

	$wgOut->addScript("<script type=\"text/javascript\" src=\"$wgWikiwygJsPath/extensions/CreatePage/js/createpage.js\"></script>\n");

	if (! isset($wgEnableAjaxLogin) || ($wgEnableAjaxLogin == false)) {
		$wgEnableAjaxLogin = 0;
	}
        $wgOut->addHTML ("
		<script type=\"text/javascript\">
			var wgEnableAjaxLogin = $wgEnableAjaxLogin;
		</script>"
	) ;
   	$wgOut->setPageTitle(wfMsg('createpage-title'));
	$cSF = new CreatePageForm($par);

	$action = $wgRequest->getVal('action');
	if ('success' == $action) {
		/* do something */
	} else if ( $wgRequest->wasPosted() && 'submit' == $action &&
	        $wgUser->matchEditToken( $wgRequest->getVal('wpEditToken') ) ) {
	        $cSF->doSubmit();
	} else if ('failure' == $action) {
		$cSF->showForm('Please specify title');
	} else if ('check' == $action) {
		$cSF->checkArticleExists ($wgRequest->getVal('to_check'));
	} else {
		$cSF->showForm('');
	}
}

/* the form for blocking names and addresses */
class CreatePageForm {
	var $mMode, $mLink, $mDo, $mFile;

	/* constructor */
	function CreatePageForm ( $par ) {
		global $wgRequest;
	}

	/* output */
	function showForm ( $err ) {
		global $wgOut, $wgUser, $wgRequest;
		wfLoadExtensionMessages('Wikiwyg');

		if ($wgUser->isLoggedIn()) {
			$token = htmlspecialchars( $wgUser->editToken() );
		} else {
			$token = EDIT_TOKEN_SUFFIX;
		}
		$titleObj = Title::makeTitle( NS_SPECIAL, 'Createpage' );
		$action = $titleObj->escapeLocalURL( "action=submit" ) ;

		if ( "" != $err ) {
			$wgOut->setSubtitle( wfMsgHtml( 'formerror' ) );
			$wgOut->addHTML( "<p class='error'>{$err}</p>\n" );
		}
		$alternate_link = "<a href=\"#\" onclick=\"CreatePageNormalEdit(); return false;\" >".wfMsg('createpage-here')."</a>";
		$wgOut->addHTML ("<div id=\"createpage_subtitle\" style=\"display:none\">".wfMsg('createpage-alternate-creation', $alternate_link)."</div>");

		$edittime =  wfTimestamp(TS_MW, $this->mTimestamp);
		/* make a TagCloud html */
		$cloud_html = "";
		$MyCloud = new TagCloud;
		$num = 0;

		if (is_array ($MyCloud->tags)) {
			foreach ($MyCloud->tags as $name => $tag) {
				$cloud_html .= ("<span id=\"tag-$num\" style=\"font-size:". $tag["size"]."pt\">
					<a href=\"#\" id=\"cloud_$num\" onclick=\"CreatePageAddCategory ('$name', $num); return false;\">$name</a>
					</span>
				") ;
				$num++;

			}
		}

	       	$html = "
<form name=\"editform\" method=\"post\" action=\"{$action}\">
	<div id=\"createpage_messenger\" style=\"display:none; color:red \" ></div>
        <b>".wfMsg('createpage-title-caption')."</b>
	<br />
	<input name=\"title\" id=\"title\" value=\"\" size=\"100\" /><br /><br />
             	<b>".wfMsg('createpage-enter-text')."</b>
		<br /><div id=\"wikiwyg\"></div>
		<div id=\"loading_mesg\"><b>".wfMsg('createpage-loading-mesg')."</b></div>

		<noscript>
		<style type=\"text/css\">
			#loading_mesg, #image_upload {
				display: none;
			}
		</style>
		<textarea tabindex=\"1\" accesskey=\",\" name=\"wpTextbox1\" id=\"wpTextbox1\" rows=\"25\" cols=\"80\" ></textarea>
		</noscript>
		<div id=\"backup_textarea_placeholder\"></div>
		<iframe id=\"wikiwyg-iframe\" height=\"0\" width=\"0\" frameborder=\"0\"></iframe>
		<input type=\"submit\" name=\"wpSave\" id=\"wpSaveBottom\"  value=\"".wfMsg('createpage-button-caption')."\" />
		<input type='hidden' name='wpEditToken' value=\"{$token}\" />
		<input type=\"hidden\" name=\"wpCreatePage\" value=\"true\" />

		<input type=\"hidden\" value=\"{$this->edittime}\" name=\"wpEdittime\" />
		<br />
		<div id=\"category_wrapper\">
		<table id=\"editpage_table\">
			<tr style=\"padding: 6px 0px 6px 0px\">
				<td class=\"editpage_header\">&nbsp;</td>
				<td>".wfMsg('createpage-categories-help')."</td>
			</tr>
			<tr>
				<td class=\"editpage_header\">".wfMsg('createpage-categories')."</td>
				<td>
					<textarea name=\"category\" id=\"category\" rows=\"1\" cols=\"80\" /></textarea>		
					<div id=\"category_cloud_wrapper\" class=\editpage_inside\">
					<div id=\"editpage_cloud_section\" style=\"line-height: 22pt; border: 1px solid gray; padding: 15px 15px 15px 15px\">                                        ".$cloud_html."
					</div>
				</td>
			</tr>
		</table>";

		$wgOut->addHTML( $html );
		$wgOut->addHTML("</div><br /></form>");

	}

        /* draws select and selects it properly */
        function makeSelect ($name, $options_array, $current, $tabindex) {
                global $wgOut;
                $wgOut->addHTML ("<select tabindex=\"$tabindex\" name=\"$name\" id=\"$name\">");
                foreach ($options_array as $key => $value) {
                        if ($value == $current )
                                $wgOut->addHTML("<option value=\"$value\" selected=\"selected\">$key</option>");
                        else
                                $wgOut->addHTML("<option value=\"$value\">$key</option>");
                }
                $wgOut->addHTML("</select>");
        }

	/* check if article exists */
	function checkArticleExists ($given) {
		global $wgOut;
		$wgOut->setArticleBodyOnly( true );
		$title = Title::newFromText( $given );
		$page = $title->getText();
		$page = str_replace( ' ', '_', $page );
		$dbr = wfGetDB (DB_SLAVE);
		$exists = $dbr->selectField ('page', 'page_title', array ('page_title' => $page));
		if ($exists != '')
			$wgOut->addHTML('pagetitleexists');
	}

	/* on success */
	function showSuccess () {
		global $wgOut, $wgRequest;
		wfLoadExtensionMessages('Wikiwyg');
		$wgOut->setPageTitle (wfMsg('createpage-success-title') );
		$wgOut->setSubTitle(wfMsg('createpage-success-subtitle'));
	}

	/* on submit */
	function doSubmit () {
		global $wgOut, $wgUser, $wgRequest;
		wfLoadExtensionMessages('Wikiwyg');
		$wgOut->setSubTitle ( wfMsg ('createpage-success-subtitle', wfMsg('createpage-'.$this->mMode) ) );
	}
}