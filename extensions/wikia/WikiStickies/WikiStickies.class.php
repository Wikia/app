<?php
/**
 * WikiStickies
 *
 * @see https://contractor.wikia-inc.com/wiki/WikiStickies
 */
class WikiStickies extends SpecialPage {

	const STICKY_FEED_LIMIT = 1; // one for the sticky note, to display in yellow
	const INITIAL_FEED_LIMIT = 10; // 10 to get initially for this nice viewer fellow
	const SPECIAL_FEED_LIMIT = 21; // 21 to rule them all, and in light display them

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

		// load dependencies (CSS and JS)
		$wgOut->addExtensionStyle("{$wgExtensionsPath}/wikia/WikiStickies/css/WikiStickies.css?{$wgStyleVersion}");
		$wgOut->addScript("<script type=\"{$wgJsMimeType}\" src=\"{$wgExtensionsPath}/wikia/JavascriptAPI/Mediawiki.js?{$wgStyleVersion}\"></script>\n");
		$wgOut->addScript("<script type=\"{$wgJsMimeType}\" src=\"{$wgExtensionsPath}/wikia/WikiStickies/NWB/main.js?{$wgStyleVersion}\"></script>\n");
		$wgOut->addScript("<script type=\"{$wgJsMimeType}\" src=\"{$wgExtensionsPath}/wikia/WikiStickies/js/WikiStickies.js?{$wgStyleVersion}\"></script>\n");

		// get the Three Feeds
		$this->formatFeed( 'wikistickies-wantedimages', $this->getWantedimagesFeed( self::SPECIAL_FEED_LIMIT ), wfMsg('wikistickies-wantedimages-hd'), wfMsg( 'wikistickies-wantedimages-st' ) ) ;

		$this->formatFeed( 'wikistickies-newpages', $this->getNewpagesFeed( self::SPECIAL_FEED_LIMIT ), wfMsg('wikistickies-newpages-hd'), wfMsg( 'wikistickies-newpages-st' ) );
		$this->formatFeed( 'wikistickies-wantedpages', $this->getWantedpagesFeed( self::SPECIAL_FEED_LIMIT ), wfMsg('wikistickies-wantedpages-hd'), wfMsg( 'wikistickies-wantedpages-st' ) );

		// get the Two Tools
		$this->generateTools();
	}

	// tool generation wrapper (basically template call)
	function generateTools() {
		global $wgOut, $wgUser;

		// same as for Monaco bar, I guess
		if( !$wgUser->isAllowed( 'editinterface' ) ) {
			return false;
		}

		$tpl = new EasyTemplate( dirname( __FILE__ )."/templates/" );
		$tpl->set_vars( array());

		$text = $tpl->execute('tools');
		$wgOut->addHTML( $text );
	}

	/**
	 * Constructs the majority of HTML output to render.
	 *
	 * @param string $type Moniker for the feed. This becomes the HTML ID attribute value.
	 * @param array $feed_data The list of page names that will become items in the feed.
	 * @param string $header The natural-language feed headline.
	 * @param string $sticker ???
	 *
	 * @TODO: Need a non-redundant way of informing this function what feed is being used.
	 *		We should probably find some way of collapsing the $type, $header,
	 *		and $sticker variables.
	 */
	function formatFeed( $type, &$feed_data, $header, $sticker ) {
		global $wgOut, $wgUser;

		$sk = $wgUser->getSkin () ;
		$body = $body2 = '';

		if( empty( $feed_data ) ) {
			return false;
		}

		if( isset( $feed_data['continue'] ) ) {
			array_pop( $feed_data );
		}

		// display the sticky
		$sticky = Xml::openElement( 'div', array( 'id' => 'wikisticky_browser' ) ).
			Xml::openElement( 'div', array( 'id' => 'wikisticky_content' ) ).
			Xml::openElement( 'p' ).
			$sticker . ' ' . $sk->makeKnownLinkObj( array_shift( $feed_data ) ). '?'.
			Xml::closeElement( 'p' ).
			Xml::closeElement( 'div' ).
			Xml::closeElement( 'div' );

		$uptolimit = 0;

		foreach( $feed_data as $title ) {
			if( $uptolimit < self:: INITIAL_FEED_LIMIT ) {
				if ( $uptolimit > 4 ) { // start a new column at 6th item
					if ( $uptolimit === 5 ) {
						$body .= Xml::openElement ( 'li', array ( 'class' => 'secondcolumn reset' ) );
					} else {
						$body .= Xml::openElement ( 'li', array ( 'class' => 'secondcolumn' ) );
					}
				} else {
					$body .= Xml::openElement( 'li' );
				}
				// todo namespace too (especially for Wantedpages)
				$body .= $sk->makeKnownLinkObj( $title ).
				Xml::closeElement( 'li' );
				array_shift( $feed_data );
				$uptolimit++;
			}
		}

		$uptolimit = 0;
		foreach( $feed_data as $title ) {
			if( $uptolimit < self:: INITIAL_FEED_LIMIT ) {
				if ( $uptolimit > 4 ) { // start a new column at 6th item
					if ( $uptolimit === 5 ) {
						$body2 .= Xml::openElement ( 'li', array ( 'class' => 'secondcolumn reset' ) );
					} else {
						$body2 .= Xml::openElement ( 'li', array ( 'class' => 'secondcolumn' ) );
					}
				} else {
					$body2 .= Xml::openElement( 'li' );
				}
				// todo namespace too (especially for Wantedpages)
				$body2 .= $sk->makeKnownLinkObj( $title ).
				Xml::closeElement( 'li' );
				array_shift( $feed_data );
				$uptolimit++;
			}
		}


		$html = Xml::openElement( 'div', array( 'id' => $type, 'class' => 'wikistickiesfeed' ) ).
			'<img alt="" class="sprite" src="/skins/monobook/blank.gif" />'.
			Xml::openElement( 'h2' ).
						$header.
			Xml::closeElement( 'h2' ).
			$sticky.
			Xml::openElement( 'ul' ).
			$body.
			Xml::closeElement( 'ul' ).
			Xml::openElement( 'ul', array ( 'class' => 'submerged' ) ).
			$body2.
			Xml::closeElement( 'ul' );

		// See more link
		// TODO: This href attribute should actually point to the source of the feed
		//       in case JS is off.
		$html .= Xml::openElement( 'a', array( 'href' => '#', 'class' => 'MoreLink' ) ).
			wfMsg( 'wikistickies-more' ).
			Xml::closeElement( 'a' ).
			Xml::closeElement( 'div' );

		$wgOut->addHTML( $html );
	}

	// feed packaging
	function getFeed( $feed, $data ) {
		wfProfileIn( __METHOD__ );
		$result = array();
		$oFauxRequest = new FauxRequest( $data );

		$oApi = new ApiMain($oFauxRequest);
		$oApi->execute();
		$aResult =& $oApi->GetResult()->getData();

		// get the pages
		if( !isset($aResult['warnings']) ) {
			if( count($aResult['query'][$feed]) > 0) {
				foreach( $aResult['query'][$feed] as $newfound ) {
					if( isset( $newfound['namespace'] ) ) {
						$result[] = Title::makeTitle( $newfound['namespace'], $newfound['title']);
					} else {
						$result[] = Title::makeTitle( $newfound['ns'], $newfound['title']);
					}
				}
			}
		}

		wfProfileOut( __METHOD__ );
		return $result;
	}

	// fetch the feed for SpecialNewpages
	function getNewpagesFeed( $limit ) {
		global $wgContentNamespaces;
		$data =	array(
				'action'		=> 'query',
				'list'			=> 'recentchanges',
				'rcprop'		=> 'title',
				'rcnamespace'		=> $wgContentNamespaces,
				'rctype'		=> 'new',
				'rcshow' 		=> '!redirect',
				'rclimit'		=> intval($limit),
				 );

		return $this->getFeed( 'recentchanges', $data );
	}

	// fetch the feed for SpecialWantedpages
	function getWantedpagesFeed( $limit ) {
		$data = array(
				'action'	=> 'query',
				'list'		=> 'wantedpages',
				'wnlimit'	=> intval($limit),
				 );

			return $this->getFeed( 'wantedpages', $data );
	}

	// fetch the feed for pages without images
	function getWantedimagesFeed( $limit ) {
		$data = array(
				'action'	=> 'query',
				'list'		=> 'wantedimages',
				'wilimit'	=> intval($limit),
				 );

			return $this->getFeed( 'wantedimages', $data );
	}

	// run on a hook adding sidebar content for Special:MyHome
	static function addToMyHome( $html ) {
		wfLoadExtensionMessages( 'WikiStickies' );
		global $wgOut, $wgExtensionsPath, $wgStyleVersion;

		$wgOut->addExtensionStyle("{$wgExtensionsPath}/wikia/WikiStickies/css/WikiStickiesMyHome.css?{$wgStyleVersion}");

		$html = Xml::openElement( 'div', array( 'id' => 'wikisticky_browser' ) ).
			Xml::openElement( 'div', array( 'id' => 'wikisticky_content' ) ).
                        Xml::openElement( 'strong' ).
			wfMsg( 'wikistickies' ).
			Xml::closeElement( 'strong' ).
			Xml::openElement( 'p' ).
			Xml::closeElement( 'p' ).
			Xml::openElement( 'a', array( 'id' => 'wikisticky_next' ) ).
			wfMsg( 'wikistickies-next' ).
                	Xml::closeElement( 'a' ).
			Xml::openElement( 'img', array( 'src' => '../WikiStickies/images/curl.png', 'id' => 'wikisticky_curl' ) ).
			Xml::closeElement( 'img' ).
			Xml::closeElement( 'div' ).
			Xml::closeElement( 'div' );

		return true;
	}
}
