<?php
if (!defined('MEDIAWIKI')) die();
/*
 * FCKeditor extension for MediaWiki
 * Author: Inez Korczyński ( inez at wikia dot com )
 * Based on: FCKeditor extension
 * To enable it please set variables: $wgRawHtml and $wgFCKUseEditor to true in LocalSettings.php
 */

$wgHooks['EditPage::showEditForm:initial'][]    = 'wfFCKeditorAddFCKScript';
$wgHooks['ArticleAfterFetchContent'][]          = 'wfFCKeditorCheck';
$wgHooks['ArticleSave'][]			= 'wfFCKeditorAddHTMLtag';

function wfFCKeditorAddFCKScript($editpage)
{
	global $wgOut, $wgFCKUseEditor;

	if ( $wgFCKUseEditor == true )
	{
		$wgOut->addScript( '<script type="text/javascript" src="extensions/wikia/FCKeditor/fckeditor/fckeditor.js"></script>' );
		$wgOut->addScript( "
<script type=\"text/javascript\">
function onLoadFCK () {
	var oFCKeditor = new FCKeditor('wpTextbox1');
	oFCKeditor.BasePath = \"extensions/wikia/FCKeditor/fckeditor/\";
	if (document.getElementById(\"wpTextbox1\")) {
		oFCKeditor.Height = \"600\";
		oFCKeditor.ReplaceTextarea();
		var oDiv = document.getElementById(\"toolbar\");
		oDiv.style.cssText = 'display: none;';
	}
}
addOnloadHook(onLoadFCK);
</script>\n" );
	}
	return true;
}

function wfFCKeditorCheck ($q, $text)
{
        global $wgOut, $wgFCKUseEditor, $wgRequest;

        $action = $wgRequest->getVal( 'action' );

        if ( $action == 'edit' && $wgFCKUseEditor == true )
	{
		if ( strpos( $text, '<html>' ) == 0 && strpos( $text, '</html>' ) == ( strlen( $text ) - 7 ) )
        	{
        		$text = substr($text, 6, strlen( $text ) - 7 - 6);
        	}
        	else
        	{
        		$text = $wgOut->parse($text);
        	}
        }
        return true;
}

function wfFCKeditorAddHTMLtag(&$article, &$user, &$text, &$summary, $minor, $watch, $sectionanchor, &$flags)
{
	global $wgFCKUseEditor;
	if ($wgFCKUseEditor == true )
	{
		$text = '<html>'.$text.'</html>';
	}
	return true;
}

?>
