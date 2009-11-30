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
		$tpl->set_vars( array(
				     ));

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
			Xml::closeElement( 'ul' ).			
			Xml::closeElement( 'div' );
					       	
                $wgOut->addHTML( $html );
	}
                               
	// fetch the feed for SpecialNewpages
	function getNewpagesFeed( $limit ) {
		wfProfileIn( __METHOD__ );
		$newpages = array();

		$oFauxRequest = new FauxRequest(
				array(
					'action'        => 'query',
					'list'		=> 'recentchanges',
					'rcprop'	=> 'title',					
					'rcnamespace'	=> 0,
					'rctype'	=> 'new',
					'rclimit'	=> intval($limit),
				     )
				);

		$oApi = new ApiMain($oFauxRequest);
                $oApi->execute();
                $aResult =& $oApi->GetResultData();

		if( count($aResult['query']['recentchanges']) > 0) {
			foreach( $aResult['query']['recentchanges'] as $newfound ) {
				$newpages[] = $newfound['title'] ;
			}
		}

		wfProfileOut( __METHOD__ ); 		
		return $newpages;
	}

	// fetch the feed for SpecialWantedpages
	function getWantedpagesFeed( $limit ) {
		wfProfileIn( __METHOD__ );
		$wantedpages = array();

		$oFauxRequest = new FauxRequest(
				array(
					'action'        => 'query',
					'list'		=> 'wantedpages',
					'wnlimit'	=> intval($limit),
				     )
				);

		$oApi = new ApiMain($oFauxRequest);
                $oApi->execute();
                $aResult =& $oApi->GetResultData();

		if( count($aResult['query']['wantedpages']) > 0) {
			foreach( $aResult['query']['wantedpages'] as $newfound ) {
				$wantedpages[] = $newfound['title'] ;
			}
		}

		wfProfileOut( __METHOD__ ); 		
		return $wantedpages;
	}

	// fetch the feed for pages without images
	function getWantedimagesFeed( $limit ) {
		wfProfileIn( __METHOD__ );
		$wantedimages = array();

		$oFauxRequest = new FauxRequest(
				array(
					'action'        => 'query',
					'list'		=> 'wantedimages',
					'wilimit'	=> intval($limit),
				     )
				);

		$oApi = new ApiMain($oFauxRequest);
                $oApi->execute();
                $aResult =& $oApi->GetResultData();

		if( !isset($aResult['warnings']) )  {
			if( count($aResult['query']['wantedimages']) > 0) {
				foreach( $aResult['query']['wantedimages'] as $newfound ) {
					$wantedimages[] = $newfound['title'] ;
				}
			}
		}

		wfProfileOut( __METHOD__ ); 		
		return $wantedimages;
	}

}
