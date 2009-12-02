<?php

class WikiStickies extends SpecialPage {

	const STICKY_FEED_LIMIT = 1; // one for the sticky note, to display in yellow
	const INITIAL_FEED_LIMIT = 11; // 11 to get initially for this nice viewer fellow
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
		$this->formatFeed( $this->getNewpagesFeed( self::SPECIAL_FEED_LIMIT ), wfMsg('wikistickies-newpages-hd') );
		$this->formatFeed( $this->getWantedpagesFeed( self::SPECIAL_FEED_LIMIT ), wfMsg('wikistickies-wantedpages-hd') );
		$this->formatFeed( $this->getWantedimagesFeed( self::SPECIAL_FEED_LIMIT ), wfMsg('wikistickies-wantedimages-hd') ) ;

		// get the Two Tools
                $this->generateTools();
        }

	// tool generation wrapper (basically template call)	
	function generateTools() {
		global $wgOut;

		$tpl = new EasyTemplate( dirname( __FILE__ )."/templates/" );
		$tpl->set_vars( array());

		$text = $tpl->execute('tools');
		$wgOut->addHTML( $text );
	}

	// general feed formatting
	function formatFeed( &$feed_data, $header ) {
        	global $wgOut, $wgUser;

		$sk = $wgUser->getSkin () ;
		$body = '';

		if( empty( $feed_data ) ) {
			return false;
		}

		if( isset( $feed_data['continue'] ) ) {
			array_pop( $feed_data );
		}

        	// display the sticky
		$sticky = '';
	

		foreach( $feed_data as $title ) {			
			$body .= Xml::openElement( 'li' ).
				// todo namespace too (especially for Wantedpages)
				$sk->makeLink( $title ).			
				Xml::closeElement( 'li' );
		}
		
		$html = Xml::openElement( 'div', array( 'class' => 'wikistickiesfeed' ) ).
			Xml::openElement( 'div', array( 'class' => 'wikistickiesheader' ) ).
                        $header.
			Xml::closeElement( 'div' ).
			Xml::openElement( 'ul', array( 'class' => 'wikistickiesul' ) ).
			$body.
			Xml::closeElement( 'ul' );
		/*
		   $onclick = 'WikiStickies.clickMoreWantedpages();';
		   $linkmore =	Xml::openElement( 'a', array( 'href' => '#', 'onclick' => $onclick ) ) .
		   'more V'.
		   Xml::closeElement( 'a' );

		   $html .= Xml::openElement( 'div', array( 'class' => 'wikistickiesmore' ) ).
		   $linkmore.       
		   Xml::closeElement( 'div' );
		 */
		$html .= Xml::closeElement( 'div' );
					       	
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
		if( !isset($aResult['warnings']) )  {
			if( count($aResult['query'][$feed]) > 0) {
				foreach( $aResult['query'][$feed] as $newfound ) {
					$result[] = $newfound['title'] ;
				}
			} 
		}

		wfProfileOut( __METHOD__ ); 		
		return $result;
	}
	                               
	// fetch the feed for SpecialNewpages
	function getNewpagesFeed( $limit ) {
		$data =	array(
				'action'        => 'query',
				'list'		=> 'recentchanges',
				'rcprop'	=> 'title',					
				'rcnamespace'	=> 0,
				'rctype'	=> 'new',
				'rclimit'	=> intval($limit),
			     );

		return $this->getFeed( 'recentchanges', $data );
	}

	// fetch the feed for SpecialWantedpages
	function getWantedpagesFeed( $limit ) {
		$data = array(
				'action'        => 'query',
				'list'		=> 'wantedpages',
				'wnlimit'	=> intval($limit),
			     );

        	return $this->getFeed( 'wantedpages', $data );
	}

	// fetch the feed for pages without images
	function getWantedimagesFeed( $limit ) {
		$data = array(
				'action'        => 'query',
				'list'		=> 'wantedimages',
				'wilimit'	=> intval($limit),
			     );

        	return $this->getFeed( 'wantedimages', $data );
	}
}
