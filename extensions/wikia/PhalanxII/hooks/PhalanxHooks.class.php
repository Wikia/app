<?php

class PhalanxHooks extends WikiaObject {
	function __construct() {
		parent::__construct();
		F::setInstance( __CLASS__, $this );
	}
	
	/**
	 * Add a link to central:Special:Phalanx from Special:Contributions/USERNAME
	 * if the user has 'phalanx' permission
	 * @param $id Integer: user ID
	 * @param $nt Title: user page title
	 * @param $links Array: tool links
	 * @return true
	 */

	public function loadLinks( $id, $nt, &$links ) {
		$this->wf->profileIn( __METHOD__ );
		
		if ( $this->wg->User->isAllowed( 'phalanx' ) ) {
			$links[] = RequestContext::getMain()->getSkin()->makeKnownLinkObj(
				GlobalTitle::newFromText( 'Phalanx', NS_SPECIAL, WikiFactory::COMMUNITY_CENTRAL ),
				'PhalanxBlock',
				wfArrayToCGI( 
					array(
						'wpPhalanxTypeFilter[]' => '8',
						'wpPhalanxCheckBlocker' => $nt->getText() 
					) 
				)
			);
		}
		
		$this->wf->profileOut( __METHOD__ );
		return true;
	}
}
