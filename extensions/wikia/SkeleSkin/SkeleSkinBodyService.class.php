<?php
class SkeleSkinBodyService extends WikiaService {
	public function index() {
		$bodyContent = $this->getVal( 'bodyText', '');
		$afterBodyHtml = '';
		$afterContentHookText;
		
		// this hook allows adding extra HTML just after <body> opening tag
		// append your content to $html variable instead of echoing
		// (taken from Monaco skin)
		$this->wf->RunHooks( 'GetHTMLAfterBody', array ( $this->wg->User->getSkin(), &$afterBodyHtml ) );

		// this hook is needed for SMW's factbox
		if ( !$this->wf->RunHooks('SkinAfterContent', array( &$afterContentHookText ) ) ) {
			$afterContentHookText = '';
		}
		
		$this->headerText = $this->wg->Sitename;
		$this->bodyContent = $bodyContent;
		$this->afterBodyContent = $afterBodyHtml;
		$this->afterContentHookText = $afterContentHookText;
	}
}