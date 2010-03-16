<?php
# Not a valid entry point, skip unless MEDIAWIKI is defined
if (!defined('MEDIAWIKI')) {
        echo <<<EOT
To install my extension, put the following line in LocalSettings.php:
require_once( "\$IP/extensions/AutoPageCreate/AutoPageCreate.php" );
EOT;
        exit( 1 );
}

$wgExtensionMessagesFiles['AutoPageCreate'] = dirname(__FILE__) . '/AutoPageCreate.i18n.php';
$wgExtensionFunctions[] = 'wfAutoPageCreateInit';

function wfAutoPageCreateInit() {
	global $wgHooks, $wgOut, $wgExtensionsPath;

	$wgHooks['EditPage::showEditForm:initial'][] = 'wfAutoPageCreateEditPage';
	$wgHooks['ArticleNonExistentPage'][] = 'wfAutoPageCreateViewPage';

	$wgOut->addExtensionStyle( $wgExtensionsPath . "/wikia/AutoPageCreate/AutoPageCreate.css" );
}

function wfAutoPageCreateEditPage( $editpage ) {
	if( !$editpage->mTitle->exists() && $editpage->mTitle->isContentPage() ) {
		$editpage->textbox1 = wfMsgForContent( 'newpagelayout' );
	}
	return true;
}

function wfAutoPageCreateViewPage( $article, $out, &$text, &$return404 ) {
	switch( $article->mTitle->getNamespace() ) {
		case NS_MEDIAWIKI:
			$return404 = true;
		case NS_CATEGORY:
		case NS_HELP:
			$text = "<div class=\"noarticletext\">\n$text\n</div>";
			break;
		default:
			wfLoadExtensionMessages( "AutoPageCreate" );
			$text = $article->mTitle->isContentPage() ?
					wfMsgForContent( "newpagelayout" ) :
					"";
			$overlayMsgKey = "autopagecreate-newpage-notice-other";
			if( $article->mTitle->isContentPage() ) {
				$overlayMsgKey = "autopagecreate-newpage-notice-content";
			} elseif( $article->mTitle->isTalkPage() ) {
				$overlayMsgKey = "autopagecreate-newpage-notice-talk";
				$out->setRobotPolicy( 'noindex,nofollow' );
			} else {
				switch( $article->mTitle->getNamespace() ) {
					case NS_USER:		$overlayMsgKey = "autopagecreate-newpage-notice-user"; break;
					case NS_PROJECT:	$overlayMsgKey = "autopagecreate-newpage-notice-project"; break;
					case NS_TEMPLATE:	$overlayMsgKey = "autopagecreate-newpage-notice-template"; break;
					case 110 /* NS_FORUM */:	$overlayMsgKey = "autopagecreate-newpage-notice-forum"; break;
					case 502 /* NS_BLOG_LISTING */:	$overlayMsgKey = "autopagecreate-newpage-notice-blog"; break;
				}
				$out->setRobotPolicy( 'noindex,nofollow' );
			}
			$overlayMsg4JS = Xml::escapeJsString( wfMsgExt( $overlayMsgKey, "parseinline" ) );
			$js = <<<END
wgAfterContentAndJS.push( function() { $( function() {
	$("#wikia_page").prepend("<div id=\"NoArticleTextNotice\">{$overlayMsg4JS}<div id=\"NoArticleTextNoticeClose\" /></div>");
	$("#NoArticleTextNoticeClose").click( function() { $(this).parent().slideUp() } );
} ) } );
END;
			$out->addInlineScript( $js );
	}
	return false;
}
