<?php

class ActionBox extends SpecialPage {

	const FEED_LIMIT = 5;

        function __construct() {
                parent::__construct('ActionBox');
        }

        function execute() {
                global $wgRequest, $wgHooks, $wgOut;
		wfLoadExtensionMessages( 'ActionBox' );

                $this->setHeaders();

	



		// get the Two Tools


		// get the Three Feeds
		
		$this->formatFeed( $this->getNewpagesFeed( self::FEED_LIMIT ), wfMsg('actionbox-newpages-hd') );

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
				$sk->makeLink( $title ).			
				Xml::closeElement( 'li' );
		}
		
		$html = Xml::openElement( 'div' ).
			Xml::openElement( 'span', array( 'class' => 'actionboxheader' ) ).
                        $header.
			Xml::openElement( 'ul', array( 'class' => 'actionboxul' ) ).
			$body.
			Xml::closeElement( 'ul' ).			
			Xml::closeElement( 'span' ).
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
}
