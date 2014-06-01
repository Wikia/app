<?php
/**
 * WikiaMobile page body
 * 
 * @author Jakub Olek <bukaj.kelo(at)gmail.com>
 * @authore Federico "Lox" Lucignano <federico(at)wikia-inc.com>
 */
class WikiaMobileBodyService extends WikiaService {
	public function index() {
		$bodyContent = $this->request->getVal( 'bodyText', '' );
		$categoryLinks = $this->request->getVal( 'categoryLinks', '' );
		$afterBodyHtml = '';
		$afterContentHookText = null;

		// this hook allows adding extra HTML just after <body> opening tag
		// append your content to $html variable instead of echoing
		// (taken from Monaco skin)
		wfRunHooks( 'GetHTMLAfterBody', array ( RequestContext::getMain()->getSkin(), &$afterBodyHtml ) );

		// this hook is needed for SMW's factbox
		if ( !wfRunHooks('SkinAfterContent', array( &$afterContentHookText ) ) ) {
			$afterContentHookText = '';
		}

		/* Dont show header if user profile page */
		if( !$this->wg->Title->inNamespace( NS_USER ) ){
			$this->response->setVal( 'pageHeaderContent', $this->app->renderView( 'WikiaMobilePageHeaderService', 'index' ));
		}else{
			$this->response->setVal( 'pageHeaderContent', '');
		}
		$this->response->setVal('bodyContent', $bodyContent);

		$this->response->setVal(
			'categoryLinks',
			$this->app->renderView(
				'WikiaMobileCategoryService',
				'index',
				array( 'categoryLinks' => $categoryLinks )
			)
		);

		$this->response->setVal( 'afterBodyContent', $afterBodyHtml );
		$this->response->setVal( 'afterContentHookText', $afterContentHookText );
	}
}