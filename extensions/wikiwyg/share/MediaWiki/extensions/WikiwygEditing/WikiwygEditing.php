<?php

global $wgHooks;
$wgHooks['EditPage::showEditForm:initial'][] = 'WikiwygAlternateEdit';
$wgHooks['EditPage:BeforeDisplayingTextbox'][] = 'WikiwygHideTextarea';
$wgHooks['EditPage::AfterEdit:Form'][] = 'WikiwygEditTagCloud';

$wgExtensionFunctions[] = 'registerWikiwygEditing';
$wgExtensionCredits['other'][] = array(
	'name' => 'WikiwygEditing',
	'author' => 'Bartek Łapiński',
	'version' => '1.0',
	'url' => 'http://www.mediawiki.org/wiki/Extension:Wikiwyg',
	'description' => 'MediaWiki integration of the Wikiwyg WYSIWYG wiki editor - for full page editing'
);

function registerWikiwygEditing () {
}

function wfIsCategoryCloudAllowed ($epage) {
	global $wgRequest;
	if (($epage->mArticle->mTitle->getNamespace() != NS_MAIN) || ($wgRequest->getVal ('categoryCloud') == 'off' ) ) {
		/* allow parameter override */
		if ($wgRequest->getVal ('categoryCloud') != 'on' ) {
			return false;
		}
	}
	return true;
}

function WikiwygAlternateEdit ($epage) {
    global $wgOut, $wgSkin, $jsdir, $cssdir;
    global $wgWikiwygPath;
    global $wgServer, $wgWikiwygJsPath, $wgWikiwygCssPath, $wgWikiwygImagePath, $wgStyleVersion;
    global $wgUser, $wgServer, $wgArticlePath, $wgEnableAjaxLogin;

	wfLoadExtensionMessages('Wikiwyg');

    /* in-page disabled automatically disables this loading */
    if ( wfGetDependingOnSkin () == 0 ) {
	return true;
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
    $wgOut->addScript("<script type=\"text/javascript\" src=\"$wgWikiwygJsPath/extensions/WikiwygEditing/js/editpage.js?$wgStyleVersion\"></script>\n");

    if (! isset($wgEnableAjaxLogin) || ($wgEnableAjaxLogin == false)) {
	    $wgEnableAjaxLogin = 0;
    }

    $wgOut->addScript("
	<script type=\"text/javascript\">
	    if (typeof(Wikiwyg) == 'undefined') Wikiwyg = function() {};
	    Wikiwyg.mediawiki_source_path = \"$wgWikiwygPath\";
	    var wgEnableAjaxLogin = $wgEnableAjaxLogin ;
	</script>
");

    $wgOut->addScript("<script type=\"text/javascript\" src=\"$wgWikiwygJsPath/MediaWikiWyg.js\"></script>\n");
    $fixed_art_path = preg_replace('/\$1/', "", $wgArticlePath);

    $alternate_link = "<a href=\"".$fixed_art_path."Special:Preferences#prefsection-4\" >".wfMsg('wikiwyg-editing-here')."</a>";
    $has_cloud = wfIsCategoryCloudAllowed($epage);

    $subtitle_text = wfMsg('wikiwyg-editing-option', $alternate_link);
    if ($has_cloud) {
		$nocloud_link = "<a href=\"".$fixed_art_path.$epage->mArticle->mTitle->getPrefixedUrl()."?action=edit&categoryCloud=off\" >".wfMsg('wikiwyg-editing-this')."</a>";
    } else {
		$nocloud_link = "<a href=\"".$fixed_art_path.$epage->mArticle->mTitle->getPrefixedUrl()."?action=edit&categoryCloud=on\" >".wfMsg('wikiwyg-editing-this')."</a>";
		$subtitle_text .=  wfMsg('wikiwyg-use-cloud', $nocloud_link);
    }

    $wgOut->addHTML ("<div id=\"wikiwyg_cancel_form\" style=\"display:none;\">
    	<form id=\"wikiwyg_toggle_editor\" action=\"\" >
			".$subtitle_text);

    $wgOut->addHTML ("</form></div>");
    $wgOut->addHTML ("<div id=\"backup_textarea_placeholder\"></div>");
    return true;
}

function WikiwygHideTextarea ($epage, $hidden) {
	global $wgOut;
	wfLoadExtensionMessages('Wikiwyg');
	if (wfGetDependingOnSkin () == 1) {
		$hidden = 'style="display:none;"';
		$wgOut->addHTML ("<div id=\"WikiwygEditingLoadingMesg\" style=\"font-weight:bold\">".wfMsg('createpage-loading-mesg')."</div>");
		$wgOut->addHTML ("<div id=\"WikiwygEditingUpperToolbar\" style=\"display:none; float: clear;\">
					<div style=\"float: right\"><a href=\"#article\">".wfMsg('wikiwyg-return')."</a></div>
					<div><a href=\"#article\">".wfMsg('wikiwyg-return')."</a></div>
				  </div>");
		$wgOut->addHTML ("<div id=\"WikiwygEditingPreviewArea\" style=\"display:none\"></div>");
		/* allow for users not having js enabled to edit too */
                $wgOut->addHTML ("
			<noscript>
				<style type=\"text/css\">
					#wpTextbox1 {						
						display: block !important;
					}
					#WikiwygEditingLoadingMesg, #wikiwyg_lower_wrapper {
						display: none;
					}
				</style>
			</noscript>
		");
	}
	return true;
}

function WikiwygEditTagCloud ($epage) {
    global $IP, $wgOut, $wgRequest;
	wfLoadExtensionMessages('Wikiwyg');
    if (wfGetDependingOnSkin () == 1) {
    	/* only for NS_MAIN, except on override */
	if ( !wfIsCategoryCloudAllowed ($epage) ) {
		return true;
	}
	require_once($IP. '/extensions/wikiwyg/share/MediaWiki/extensions/TagCloud/TagCloudClass.php');

	    $MyCloud = new TagCloud;
	    $num = 0;
	    $cloud_html = '';

            if (is_array ($MyCloud->tags)) {
                    foreach ($MyCloud->tags as $name => $tag) {
                            /* take care of the sorting parameter */
                            $core_name = str_replace('/|.*/','',$name);
                            $cloud_html .= "<span id=\"tag-$num\" style=\"font-size:". $tag["size"]."pt\">
                                            <a href=\"#\" id=\"cloud_$num\" onclick=\"EditPageAddCategory ('$name', $num) ; return false ;\">$core_name</a>
                                            </span>";
                            $num++;
                    }
            }

	    $wgOut->addHTML ("
	    	<br />
                <div id=\"wikiwyg_lower_wrapper\">
		<table id=\"editpage_table\">
		<tr>
			<td class=\"editpage_header\">".wfMsg('edit-summary').":</td>
			<td id=\"editpage_summary_td\"></td>
		</tr>
		<tr style=\"padding: 6px 0px 6px 0px\">
			<td class=\"editpage_header\">&nbsp;</td>
			<td>".wfMsg('createpage-categories-help')."</td>
		</tr>
		<tr>
			<td class=\"editpage_header\">".wfMsg('createpage-categories')."</td>
			<td>
				<span id=\"category_textarea_placeholder\"></span>
				<div id=\"category_cloud_wrapper\" style=\"display: none\" class=\editpage_inside\">
					<div id=\"editpage_cloud_section\" style=\"line-height: 22pt; border: 1px solid gray; padding: 15px 15px 15px 15px\">
					".$cloud_html."
				</div>
			</td>
		</tr>
                </table>
		</div>
		<input type=\"hidden\" name=\"wpCategoryTagCount\", id=\"category_tag_count\" value=\"$num\" />
	    ");
    }
    return true;
}