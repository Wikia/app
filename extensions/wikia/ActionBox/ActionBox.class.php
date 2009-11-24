<?php

class ActionBox extends SpecialPage {

        function __construct() {
                parent::__construct('ActionBox');
        }

        function execute() {
                global $wgRequest, $wgHooks, $wgOut;
                $this->setHeaders();


		// get the Two Tools

		$this->getNewpagesFeed( 5 );


		// get the Three Feeds

        }


	// fetch the feed for SpecialNewpages
	function getNewpagesFeed( $limit ) {
		wfProfileIn( __METHOD__ );

		$oFauxRequest = new FauxRequest(
				array(
					'action'        => 'query',
					'list'		=> 'recentchanges',
					'prop'          => array('title'),					
					'namespace'	=> 0,
					'limit'		=> intval($limit),
				     )
				);

		$oApi = new ApiMain($oFauxRequest);
                $oApi->execute();
                $aResult =& $oApi->GetResultData();

		// todo nicely format and return

		wfProfileOut( __METHOD__ ); 		
	}
}
