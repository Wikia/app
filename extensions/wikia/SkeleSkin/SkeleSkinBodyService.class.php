<?php
class SkeleSkinBodyService extends WikiaService {
	public function index() {
		$bodyContent = $this->getVal( 'bodyText', '');
		$afterBodyHtml = '';
		$afterContentHookText = '';
		
		// this hook allows adding extra HTML just after <body> opening tag
		// append your content to $html variable instead of echoing
		// (taken from Monaco skin)
		wfRunHooks( 'GetHTMLAfterBody', array ( $this->wg->User->getSkin(), &$afterBodyHtml ) );

		// this hook is needed for SMW's factbox
		if ( !wfRunHooks('SkinAfterContent', array( &$afterContentHookText ) ) ) {
			$this->afterContentHookText = '';
		}
		
		$this->setVal( 'headerText', $this->wg->Sitename );
		$this->setVal( 'bodyContent', $bodyContent );
		$this->setVal( 'afterBodyContent', $afterBodyHtml );
		$this->setVal( 'afterContentHookText', $afterContentHookText );
	}
}