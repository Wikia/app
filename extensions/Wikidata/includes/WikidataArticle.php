<?php

class WikidataArticle extends Article {

	public function view() {
  		wfProfileIn( __METHOD__ );
 
		global $wdHandlerClasses;
		$ns = $this->mTitle->getNamespace();
		$handlerClass = $wdHandlerClasses[ $ns ];
		$handlerInstance = new $handlerClass();
		$handlerInstance->view();

		wfProfileOut( __METHOD__ );
	}

}
