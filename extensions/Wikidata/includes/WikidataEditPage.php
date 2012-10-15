<?php

class WikidataEditPage extends EditPage {

	public function edit() {
  		wfProfileIn( __METHOD__ );
 
		global $wdHandlerClasses;
		$ns = $this->mTitle->getNamespace();
		$handlerClass = $wdHandlerClasses[ $ns ];
		$handlerInstance = new $handlerClass();
		$handlerInstance->edit();

		wfProfileOut( __METHOD__ );

	}

}
