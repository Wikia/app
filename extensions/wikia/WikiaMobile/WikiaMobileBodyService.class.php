<?php
/**
 * WikiaMobile page body
 * 
 * @author Jakub Olek <bukaj.kelo(at)gmail.com>
 * @authore Federico "Lox" Lucignano <federico(at)wikia-inc.com>
 */
class WikiaMobileBodyService extends WikiaService {
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
		
		$this->pageHeaderContent = $this->sendRequest( 'WikiaMobilePageHeaderService', 'index' )->toString();
		$this->bodyContent = $bodyContent;
		$this->afterBodyContent = $afterBodyHtml;
		$this->afterContentHookText = $afterContentHookText;
	}
}