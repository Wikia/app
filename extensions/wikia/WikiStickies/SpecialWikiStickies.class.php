<?php
/**
 * @ingroup Wikia
 * @file SpecialWikiStickies.class.php
 * @package WikiStickies
 * @see https://contractor.wikia-inc.com/wiki/WikiStickies
 *
 * Creates a wiki "sticky note" visual interface, a "wikisticky."
 * Wikisticky notes appear in several different places.
 */
class SpecialWikiStickies extends SpecialPage {

	function __construct() {
		parent::__construct('WikiStickies');
		wfLoadExtensionMessages( 'WikiStickies' );
	}

	// the main heavy-hitter of the special page: wrapper for display-it-all
	function execute() {
		global $wgRequest, $wgHooks, $wgOut, $wgExtensionsPath, $wgStyleVersion, $wgJsMimeType, $wgContLang, $NWBmessages;
		// for tools: logo upload and skin chooser
		wfLoadExtensionMessages( 'NewWikiBuilder' );

                // Set up the messages variable for other languages - from NWB
                $lang = $wgContLang->getCode();

                if (empty($NWBmessages[$lang])){
                        foreach($NWBmessages["en"] as $name => $value) {
                                $NWBmessages[$lang][$name] = wfMsg($name);
                        }
                }

		$this->setHeaders();

		WikiStickies::addWikiStickyResources();

		// load additional dependencies (CSS and JS)?
		$wgOut->addExtensionStyle("{$wgExtensionsPath}/wikia/WikiStickies/css/WikiStickiesSpecialPage.css?{$wgStyleVersion}");
		$wgOut->addScript("<script type=\"{$wgJsMimeType}\">WIKIA.WikiStickies.track( '/view' );</script>");

		$wgOut->addScript("<script type=\"{$wgJsMimeType}\" src=\"{$wgExtensionsPath}/wikia/JavascriptAPI/Mediawiki.js?{$wgStyleVersion}\"></script>\n");
		$wgOut->addScript("<script type=\"{$wgJsMimeType}\" src=\"{$wgExtensionsPath}/wikia/WikiStickies/NWB/main.js?{$wgStyleVersion}\"></script>\n");

		// get the Three Feeds
		WikiStickies::formatFeed(
			'wikistickies-pageswithoutimages',
			WikiStickies::getPagesWithoutImagesFeed( WikiStickies::SPECIAL_FEED_LIMIT ),
			wfMsg('wikistickies-pageswithoutimages-hd'),
			wfMsg( 'wikistickies-pageswithoutimages-st-short' ) ) ;

		WikiStickies::formatFeed( 'wikistickies-newpages', 
			WikiStickies::getNewpagesFeed( WikiStickies::SPECIAL_FEED_LIMIT ), 
			wfMsg('wikistickies-newpages-hd'), 
			wfMsg( 'wikistickies-newpages-st-short' ) );

		WikiStickies::formatFeed( 'wikistickies-wantedpages', 
			WikiStickies::getWantedpagesFeed( WikiStickies::SPECIAL_FEED_LIMIT ), 
			wfMsg('wikistickies-wantedpages-hd'), 
			wfMsg( 'wikistickies-wantedpages-st-short' ) );

		// get the Two Tools
		WikiStickies::generateTools();
	}

}
