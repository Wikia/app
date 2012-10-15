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
	$wgHooks['MakeGlobalVariablesScript'][] = 'wfAutoPageCreateSetupVars';
	$wgHooks['WikiaMiniUpload::fetchTextForImagePlaceholder'][] = 'wfAutoPageCreateTextForImagePlaceholder';

	$wgOut->addExtensionStyle( "$wgExtensionsPath/wikia/AutoPageCreate/AutoPageCreate.css" );
}

function wfAutoPageCreateTextForImagePlaceholder( Title $title, &$text ) {
	// this was for RT#45568 - Bartek
	// basic idea is to load the template for ImagePlaceholder to work when the article does not yet exist
	// but on view, not on article edit (on preview the placeholder is blocked by default)
	global $wgRequest;
	if( !$title->exists() && ( 'edit' != $wgRequest->getVal( 'action' ) ) ) {
		$text = wfMsgForContent( 'newpagelayout' );
	}

	return true;
}

function wfAutoPageCreateEditPage( $editpage ) {
	global $wgRequest;
	$preload = $wgRequest->getVal( 'preload' );

	if( !$editpage->mTitle->exists() && !$editpage->preview  && empty( $preload ) ) {
		if( $editpage->mTitle->isContentPage() ) {
			$editpage->textbox1 = wfMsgForContent( 'newpagelayout' );
		} else if( ( $editpage->mTitle->getNamespace() == NS_USER ) && !wfAutoPageCreateIsAnonUserpage( $editpage->mTitle->getText()  ) ) {
			$editpage->textbox1 = wfMsgForContent( 'welcome-user-page', $editpage->mTitle->getText() );
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

function wfAutoPageCreateSetupVars( Array &$vars ) {
	global $wgWikiaEnableAutoPageCreateExt;

	$vars['WikiaEnableAutoPageCreate'] = $wgWikiaEnableAutoPageCreateExt;

	return true;
}

/**
 * @param Article $article
 * @param OutputPage $out
 * @param string $text
 * @return bool
 */
function wfAutoPageCreateViewPage( $article, $out, &$text  ) {
	wfProfileIn(__METHOD__);

	global $wgOut;

	$article->autoPageCreate__content = null;
	$origText = $text;

	$title = $article->mTitle;
	$ns = $title->getNamespace();

	$retval = true;

	switch( $ns ) {
		case NS_MEDIAWIKI:
		// BugId:15387 - Let's skip user pages too.
		case NS_USER:
		case NS_CATEGORY:
		case NS_HELP:
			$text = "<div class=\"noarticletext\">\n$text\n</div>";
			$retval = false;
			break;

		default:
			$text = $title->isContentPage() ? wfMsgForContent( "newpagelayout" ) : '';
			$overlayMsgKey = "autopagecreate-newpage-notice-other";

			if( $title->isContentPage() ) {
				$overlayMsgKey = "autopagecreate-newpage-notice-content";
			} elseif( $title->isTalkPage() ) {
				$overlayMsgKey = "autopagecreate-newpage-notice-talk";
				$wgOut->setRobotPolicy( 'noindex,nofollow' );
			} else {
				switch( $ns ) {
					case NS_USER:
						// RT #48042
						if ( $title->isSubpage() ) {
							$overlayMsgKey = false;
						}
						else if( !wfAutoPageCreateIsAnonUserpage( $title->getText() ) ) {
							$text = wfMsgForContent( 'welcome-user-page', $title->getText() );
							$overlayMsgKey = "autopagecreate-newpage-notice-user";
						}
						else {
							$overlayMsgKey = "autopagecreate-empty";
						}
						break;

					case NS_PROJECT:
						$overlayMsgKey = "autopagecreate-newpage-notice-project";
						break;

					case NS_TEMPLATE:
						$overlayMsgKey = "autopagecreate-newpage-notice-template";
						break;

					case NS_FORUM:
						$overlayMsgKey = "autopagecreate-newpage-notice-forum";
						break;

					case 502 /* NS_BLOG_LISTING */:
						$overlayMsgKey = "autopagecreate-newpage-notice-blog";
						break;
				}

				$wgOut->setRobotPolicy( 'noindex,nofollow' );
			}

			if (!empty($overlayMsgKey)) {
				wfDebug(__METHOD__ . ": showing message '{$overlayMsgKey}'\n");

				$overlayMsg4JS = Xml::escapeJsString( wfMsgExt( $overlayMsgKey, "parseinline" ) );
				if( $overlayMsg4JS != "-" ) {
					$js = <<<END
wgAfterContentAndJS.push( function() { $( function() {
	$("#wikia_page").prepend("<div id=\"NoArticleTextNotice\">{$overlayMsg4JS}<img id=\"NoArticleTextNoticeClose\" src=\""+wgBlankImgUrl+"\" class=\"sprite close\" /></div>");
	$("#NoArticleTextNoticeClose").click( function() { $(this).parent().slideUp() } );
} ) } );
END;
					$wgOut->addInlineScript( $js );
				}
			}
			else {
				wfDebug(__METHOD__ . ": forced to not show the message\n");
			}
	}

	if ( $text !== $origText ) {
		$article->autoPageCreate__content = $text;
	}

	wfProfileOut(__METHOD__);
	return $retval;
}
