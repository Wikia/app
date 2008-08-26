<?php

/// Override this URL to point to the central loader...
/// This guy gets loaded from every page on every wiki, and is heavily cached.
/// Its contents are small, and just load up another cached JS page, but this
/// allows us to update everything with a single purge. Nice, eh?
$wgNoticeLoader = 'http://smorgasbord.local/trunk/index.php/Special:NoticeLoader';

/// Override these per-wiki to pass on via the loader to the text system
/// for localization by language and project.
/// Actual user language is used for localization; $wgNoticeLang is used
/// for selective enabling/disabling on sites.
$wgNoticeLang = 'en';
$wgNoticeProject = 'wikipedia';


/// Enable the notice-hosting infrastructure on this wiki...
/// Leave at false for wikis that only use a sister site for the control.
/// All remaining options apply only to the infrastructure wiki.
$wgNoticeInfrastructure = false;

/// Enable the loader itself
/// Allows to control the loader visibility, without destroying infrastructure
/// for cached content
$wgCentralNoticeLoader = true;

/// URL prefix to the raw-text loader special.
/// Project/language and timestamp epoch keys get appended to this
/// via the loader stub.
$wgNoticeText = 'http://smorgasbord.local/trunk/index.php/Special:NoticeText';

/// If true, notice only displays if 'sitenotice=yes' is in the query string
$wgNoticeTestMode = false;

/// Array of '$lang.$project' for exceptions to the test mode rule
$wgNoticeEnabledSites = array();

/// Client-side cache timeout for the loader JS stub.
/// If 0, clients will (probably) rechceck it on every hit,
/// which is good for testing.
$wgNoticeTimeout = 0;

/// Server-side cache timeout for the loader JS stub.
/// Should be big if you won't include the counter info in the text,
/// smallish if you will. :)
$wgNoticeServerTimeout = 0;

/// Use a god-forsaken <marquee> to scroll multiple quotes...
$wgNoticeScroll = true;

/// Source for live counter information
$wgNoticeCounterSource = "http://donate.wikimedia.org/counter.php";

/// Directory for SVG-to-PNG rasterizations
$wgNoticeRenderDirectory = false; // "$wgUploadDirectory/notice"
$wgNoticeRenderPath = false; // $wgUploadPath/notice

$wgExtensionFunctions[] = 'efCentralNoticeSetup';

$wgExtensionCredits['other'][] = array(
	'name'           => 'CentralNotice',
	'author'         => 'Brion Vibber',
	'svn-date'       => '$LastChangedDate: 2008-06-16 20:54:29 +0000 (Mon, 16 Jun 2008) $',
	'svn-revision'   => '$LastChangedRevision: 36357 $',
	'url'            => 'http://www.mediawiki.org/wiki/Extension:CentralNotice',
	'description'    => 'Adds a central sitenotice',
	'descriptionmsg' => 'centralnotice-desc',
);
$wgExtensionMessagesFiles['CentralNotice'] = dirname(__FILE__) . '/CentralNotice.i18n.php';

function efCentralNoticeSetup() {
	global $wgHooks, $wgNoticeInfrastructure;
	global $wgAutoloadClasses, $wgSpecialPages;

	global $wgCentralNoticeLoader;

	if ($wgCentralNoticeLoader) {
		$wgHooks['SiteNoticeAfter'][] = 'efCentralNoticeLoader';
	}
	
	$wgHooks['ArticleSaveComplete'][] = 'efCentralNoticeLocalSaveHook';
	$wgHooks['ArticleSaveComplete'][] = 'efCentralNoticeLocalDeleteHook';
	
	$wgAutoloadClasses['NoticePage'] =
		dirname( __FILE__ ) . '/NoticePage.php';
	
	$wgSpecialPages['NoticeLocal'] = 'SpecialNoticeLocal';
	$wgAutoloadClasses['SpecialNoticeLocal'] =
		dirname( __FILE__ ) . '/SpecialNoticeLocal.php';


	if( $wgNoticeInfrastructure ) {
		$wgHooks['ArticleSaveComplete'][] = 'efCentralNoticeSaveHook';
		$wgHooks['ArticleSaveComplete'][] = 'efCentralNoticeDeleteHook';

		$wgSpecialPages['NoticeLoader'] = 'SpecialNoticeLoader';
		$wgAutoloadClasses['SpecialNoticeLoader'] =
			dirname( __FILE__ ) . '/SpecialNoticeLoader.php';

		$wgSpecialPages['NoticeText'] = 'SpecialNoticeText';
		$wgAutoloadClasses['SpecialNoticeText'] =
			dirname( __FILE__ ) . '/SpecialNoticeText.php';
		
		// The new SVG stuff
		/*
		$wgSpecialPages['NoticeRender'] = 'SpecialNoticeRender';
		$wgAutoloadClasses['SpecialNoticeRender'] = dirname( __FILE__ ) . '/SpecialNoticeRender.php';
		$wgAutoloadClasses['NoticeRender'] = dirname( __FILE__ ) . '/NoticeRender.php';
		
		global $wgNoticeRenderDirectory, $wgNoticeRenderPath;
		global $wgUploadDirectory, $wgUploadPath;
		if( !$wgNoticeRenderDirectory )
			$wgNoticeRenderDirectory = "$wgUploadDirectory/notice";
		if( !$wgNoticeRenderPath )
			$wgNoticeRenderPath = "$wgUploadPath/notice";
		*/
	}
}


function efCentralNoticeLoader( &$notice ) {
	global $wgScript, $wgUser;
	global $wgNoticeLoader, $wgNoticeLang, $wgNoticeProject;

	$encNoticeLoader = htmlspecialchars( $wgNoticeLoader );
	$encProject = Xml::encodeJsVar( $wgNoticeProject );
	$encLang = Xml::encodeJsVar( $wgNoticeLang );
	
	$anon = (is_object( $wgUser ) && $wgUser->isLoggedIn())
		? ''
		: '/anon';
	$localText = "$wgScript?title=Special:NoticeLocal$anon&action=raw";
	$encNoticeLocal = htmlspecialchars( $localText );
	
	// Throw away the classic notice, use the central loader...
	$notice = <<<EOT
<script type="text/javascript">
var wgNotice = "";
var wgNoticeLocal = "";
var wgNoticeLang = $encLang;
var wgNoticeProject = $encProject;
</script>
<script type="text/javascript" src="$encNoticeLoader"></script>
<script type="text/javascript" src="$encNoticeLocal"></script>
<script type="text/javascript">
if (wgNotice != "") {
  document.writeln(wgNotice);
}
if (wgNoticeLocal != "") {
  document.writeln(wgNoticeLocal);
}
</script>
EOT;
	
	return true;
}

/**
 * 'ArticleSaveComplete' hook
 * Trigger a purge of the notice loader when we've updated the source pages.
 */
function efCentralNoticeSaveHook( $article, $user, $text, $summary, $isMinor,
                                $isWatch, $section, $flags, $revision ) {
	efCentralNoticeMaybePurge( $article->getTitle() );
	return true; // Continue hook processing
}

/**
 * 'ArticleSaveComplete' hook
 * Trigger a purge of the local notice when we've updated the source pages.
 */
function efCentralNoticeLocalSaveHook( $article, $user, $text, $summary, $isMinor,
                                $isWatch, $section, $flags, $revision ) {
	efCentralNoticeMaybePurgeLocal( $article->getTitle() );
	return true; // Continue hook processing
}

/**
 * 'ArticleDeleteComplete' hook
 * Trigger a purge of the notice loader if this removed one of the source pages.
 */
function efCentralNoticeDeleteHook( $article, $user, $reason ) {
	efCentralNoticeMaybePurge( $article->getTitle() );
	return true; // Continue hook processing
}

/**
 * 'ArticleDeleteComplete' hook
 * Trigger a purge of the local notice if this removed one of the source pages.
 */
function efCentralNoticeLocalDeleteHook( $article, $user, $reason ) {
	efCentralNoticeMaybePurgeLocal( $article->getTitle() );
	return true; // Continue hook processing
}

/**
 * Purge the notice loader if the given page would affect notice display.
 */
function efCentralNoticeMaybePurge( $title ) {
	if( $title->getNamespace() == NS_MEDIAWIKI &&
		substr( $title->getText(), 0, 14 ) == 'Centralnotice-' ) {
		efCentralNoticePurge();
	}
}

/**
 * Purge the notice loader if the given page would affect notice display.
 */
function efCentralNoticeMaybePurgeLocal( $title ) {
	if( $title->getNamespace() == NS_MEDIAWIKI ) {
		global $wgScript;
		
		$purge = array();
		if( $title->getText() == 'Sitenotice' ) {
			$purge[] = "$wgScript?title=Special:NoticeLocal&action=raw";
		}
		if( $title->getText() == 'Sitenotice' || $title->getText() == 'Anonnotice' ) {
			$purge[] = "$wgScript?title=Special:NoticeLocal/anon&action=raw";
		}
		
		// Purge the squiddies...
		if( $purge ) {
			$u = new SquidUpdate( $purge );
			$u->doUpdate();
		}
	}
}

/**
 * Purge the notice loader, triggering a refresh in all clients
 * once $wgNoticeTimeout has expired.
 */
function efCentralNoticePurge() {
	global $wgNoticeLoader;
	
	// Update the notice epoch...
	efCentralNoticeUpdateEpoch();
	
	// Purge the central loader URL...
	$u = new SquidUpdate( array( $wgNoticeLoader ) );
	$u->doUpdate();
}

/**
 * Return a nice little epoch that gives the last time we updated
 * something in the notice...
 * @return string timestamp
 */
function efCentralNoticeEpoch() {
	global $wgMemc;
	$epoch = $wgMemc->get( 'centralnotice-epoch' );
	if( $epoch ) {
		return wfTimestamp( TS_MW, $epoch );
	} else {
		return efCentralNoticeUpdateEpoch();
	}
}

/**
 * Update the epoch.
 * @return string timestamp
 */
function efCentralNoticeUpdateEpoch() {
	global $wgMemc, $wgNoticeServerTimeout;
	$epoch = wfTimestamp( TS_MW );
	$wgMemc->set( "centralnotice-epoch", $epoch, $wgNoticeServerTimeout );
	return $epoch;
}
