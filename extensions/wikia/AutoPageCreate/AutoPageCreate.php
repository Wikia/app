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
	global $wgHooks, $wgOut, $wgExtensionsPath, $wgStyleVersion;

	$wgHooks['EditPage::showEditForm:initial'][] = 'wfAutoPageCreateEditPage';
	$wgHooks['ArticleNonExistentPage'][] = 'wfAutoPageCreateViewPage';
	$wgHooks['MakeGlobalVariablesScript'][] = 'wfAutoPageCreateSetupVars';

	$wgOut->addExtensionStyle( "$wgExtensionsPath/wikia/AutoPageCreate/AutoPageCreate.css?$wgStyleVersion" );
}

function wfAutoPageCreateEditPage( $editpage ) {
	if( !$editpage->mTitle->exists() ) {
		if( $editpage->mTitle->isContentPage() ) {
			$editpage->textbox1 = wfMsgForContent( 'newpagelayout' );
		} else if( ( $editpage->mTitle->getNamespace() == NS_USER ) && !wfAutoPageCreateIsAnonUserpage( $editpage->mTitle  ) ) {
			$editpage->textbox1 = wfMsgForContent( 'welcome-user-page' );
		}
	}
	return true;
}

function wfAutoPageCreateIsAnonUserpage( $title  ) {
	if( User::IsIP( $title ) ) {
		if( !User::idFromName( $title ) ) {
			return true;
		}
	}	
	return false;
}

function wfAutoPageCreateSetupVars( $vars ) {
        global $wgWikiaEnableAutoPageCreateExt;

        $vars['WikiaEnableAutoPageCreate'] = $wgWikiaEnableAutoPageCreateExt;

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
					case NS_USER:
						if( !wfAutoPageCreateIsAnonUserpage( $article->mTitle ) ) {
							$text = wfMsgForContent( "welcome-user-page" );
							$overlayMsgKey = "autopagecreate-newpage-notice-user";
						}
						break;
					case NS_PROJECT:	$overlayMsgKey = "autopagecreate-newpage-notice-project"; break;
					case NS_TEMPLATE:	$overlayMsgKey = "autopagecreate-newpage-notice-template"; break;
					case 110 /* NS_FORUM */:	$overlayMsgKey = "autopagecreate-newpage-notice-forum"; break;
					case 502 /* NS_BLOG_LISTING */:	$overlayMsgKey = "autopagecreate-newpage-notice-blog"; break;
				}
				$out->setRobotPolicy( 'noindex,nofollow' );
			}
			$overlayMsg4JS = Xml::escapeJsString( wfMsgExt( $overlayMsgKey, "parseinline" ) );
			if( $overlayMsg4JS != "-" ) {
				$js = <<<END
wgAfterContentAndJS.push( function() { $( function() {
	$("#wikia_page").prepend("<div id=\"NoArticleTextNotice\">{$overlayMsg4JS}<img id=\"NoArticleTextNoticeClose\" src=\""+wgBlankImgUrl+"\" class=\"sprite close\" /></div>");
	$("#NoArticleTextNoticeClose").click( function() { $(this).parent().slideUp() } );
} ) } );
END;
				$out->addInlineScript( $js );
			}
	}
	return false;
}
