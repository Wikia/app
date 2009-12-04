<?php
/**
 * WikiStickies
 *
 * @see https://contractor.wikia-inc.com/wiki/WikiStickies
 */
class SpecialWikiStickies extends SpecialPage {

	function __construct() {
		parent::__construct('WikiStickies');
	}

	// the main heavy-hitter of the special page: wrapper for display-it-all
	function execute() {
		global $wgRequest, $wgHooks, $wgOut, $wgExtensionsPath, $wgStyleVersion, $wgJsMimeType;
		wfLoadExtensionMessages( 'WikiStickies' );
		// for tools: logo upload and skin chooser
		wfLoadExtensionMessages( 'NewWikiBuilder' );

		$this->setHeaders();

		WikiStickies::addWikiStickyResources();
		// load additional dependencies (CSS and JS)?
		$wgOut->addScript("<script type=\"{$wgJsMimeType}\" src=\"{$wgExtensionsPath}/wikia/JavascriptAPI/Mediawiki.js?{$wgStyleVersion}\"></script>\n");
		$wgOut->addScript("<script type=\"{$wgJsMimeType}\" src=\"{$wgExtensionsPath}/wikia/WikiStickies/NWB/main.js?{$wgStyleVersion}\"></script>\n");

		// get the Three Feeds
		WikiStickies::formatFeed(
			'wikistickies-wantedimages',
			WikiStickies::getWantedimagesFeed( WikiStickies::SPECIAL_FEED_LIMIT ),
			wfMsg('wikistickies-wantedimages-hd'),
			wfMsg( 'wikistickies-wantedimages-st' ) ) ;

		WikiStickies::formatFeed( 'wikistickies-newpages', 
			WikiStickies::getNewpagesFeed( WikiStickies::SPECIAL_FEED_LIMIT ), 
			wfMsg('wikistickies-newpages-hd'), 
			wfMsg( 'wikistickies-newpages-st' ) );

		WikiStickies::formatFeed( 'wikistickies-wantedpages', 
			WikiStickies::getWantedpagesFeed( WikiStickies::SPECIAL_FEED_LIMIT ), 
			wfMsg('wikistickies-wantedpages-hd'), 
			wfMsg( 'wikistickies-wantedpages-st' ) );

		// get the Two Tools
		WikiStickies::generateTools();
	}

}
