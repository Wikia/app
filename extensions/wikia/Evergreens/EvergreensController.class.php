<?php

class EvergreensController extends WikiaController {


	public function log() {
		wfProfileIn( __METHOD__ );
//		if ( $this->request->wasPosted ) {
			$sData = $this->request->getVal( 'data', null );
			if ( $sData ) {
				\Wikia\Logger\WikiaLogger::instance()->alert(
					'Evergreens: stale page cache detected',
					[ $sData ]
				);
			}
//		}
		wfProfileOut( __METHOD__ );
	}

}
