<?php
/**
 * WikiaMobile Ads Service
 * 
 * @author Jakub Olek <bukaj.kelo(at)gmail.com>
 */
class WikiaMobileAdService extends WikiaService {
				
	public function index() {
		$this->wf->profileIn( __METHOD__ );

		// TODO: Use AdEngine logic:
		// if ($this->wg->EnableAdEngineExt
		//     && AdEngine2Controller::getAdLevelForPage === AdEngine2Controller::LEVEL_ALL
		// )
		// or move the whole thing to a separate AdEngine2 view

		if ( $this->wg->Title->isSpecialPage() ) {
			$this->skipRendering();
		}

		$this->wf->profileOut( __METHOD__ );
	}
}
