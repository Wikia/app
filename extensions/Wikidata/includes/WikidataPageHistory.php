<?php

class WikidataPageHistory extends PageHistory {

	public function history() {
  		wfProfileIn( __METHOD__ );
 
		global $wdHandlerClasses;
		$ns = $this->mTitle->getNamespace();
		$handlerClass = $wdHandlerClasses[ $ns ];
		$handlerInstance = new $handlerClass();
		$handlerInstance->history();

		wfProfileOut( __METHOD__ );
	}

}
