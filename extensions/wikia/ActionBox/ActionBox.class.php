<?php

class ActionBox extends SpecialPage {

        function __construct() {
                parent::__construct('ActionBox');
        }

        function execute() {
                global $wgRequest, $wgHooks, $wgOut;
                $this->setHeaders();


		// get the Two Tools



		// get the Three Feeds
		$newpages_feed = $this->getNewpagesFeed( 5 );

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
				$newpages[] = $newfound;
			}
		}

		wfProfileOut( __METHOD__ ); 		
		return $newpages;

	}
}
