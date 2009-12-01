<?php

class WikiStickies extends SpecialPage {

	const FEED_LIMIT = 3;

        function __construct() {
                parent::__construct('WikiStickies');
        }

        function execute() {
                global $wgRequest, $wgHooks, $wgOut, $wgExtensionsPath, $wgStyleVersion, $wgJsMimeType;
		wfLoadExtensionMessages( 'WikiStickies' );
		// for tools: logo upload and skin chooser
		wfLoadExtensionMessages( 'NewWikiBuilder' );

                $this->setHeaders();

		// load dependencies (CSS and JS)
		$wgOut->addExtensionStyle("{$wgExtensionsPath}/wikia/WikiStickies/NWB/main.css?{$wgStyleVersion}");
		$wgOut->addScript("<script type=\"{$wgJsMimeType}\" src=\"{$wgExtensionsPath}/wikia/JavascriptAPI/Mediawiki.js?{$wgStyleVersion}\"></script>\n");
		$wgOut->addScript("<script type=\"{$wgJsMimeType}\" src=\"{$wgExtensionsPath}/wikia/WikiStickies/NWB/main.js?{$wgStyleVersion}\"></script>\n");		
		$wgOut->addScript("<script type=\"{$wgJsMimeType}\" src=\"{$wgExtensionsPath}/wikia/WikiStickies/js/WikiStickies.js?{$wgStyleVersion}\"></script>\n");		

		// get the Three Feeds		
		$this->formatFeed( $this->getNewpagesFeed( self::FEED_LIMIT ), wfMsg('wikistickies-newpages-hd') );
		$this->formatFeed( $this->getWantedpagesFeed( self::FEED_LIMIT ), wfMsg('wikistickies-wantedpages-hd') );
		$this->formatFeed( $this->getWantedimagesFeed( self::FEED_LIMIT ), wfMsg('wikistickies-wantedimages-hd') ) ;

		// get the Two Tools
                $this->generateTools();
        }
	
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
		$continue = false;

		if( empty( $feed_data ) ) {
			return false;
		}

		if( isset( $feed_data['continue'] ) ) {
			$continue = true;						
			array_pop( $feed_data );
		}

		foreach( $feed_data as $title ) {
			
			if( 1 != 'title' ) {
			$body .= Xml::openElement( 'li' ).
				// todo namespace too (especially for Wantedpages)
				$sk->makeLink( $title ).			
				Xml::closeElement( 'li' );
			}
		}
		
		$html = Xml::openElement( 'div', array( 'class' => 'wikistickiesfeed' ) ).
			Xml::openElement( 'div', array( 'class' => 'wikistickiesheader' ) ).
                        $header.
			Xml::closeElement( 'div' ).
			Xml::openElement( 'ul', array( 'class' => 'wikistickiesul' ) ).
			$body.
			Xml::closeElement( 'ul' );
			if( $continue  ) {
				$onclick = 'WikiStickies.clickMoreWantedpages();';
				$linkmore =	Xml::openElement( 'a', array( 'href' => '#', 'onclick' => $onclick ) ) .
						'more V'.
						Xml::closeElement( 'a' );

				$html .= Xml::openElement( 'div', array( 'class' => 'wikistickiesmore' ) ).
				 	$linkmore.       
					Xml::closeElement( 'div' );
			}
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
			// can we continue or not?
			if( count($aResult['query-continue'][$feed]) > 0) {
				$result['continue'] = true;
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
