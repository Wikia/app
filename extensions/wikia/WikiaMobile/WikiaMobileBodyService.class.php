<?php
/**
 * WikiaMobile page body
 * 
 * @author Jakub Olek <bukaj.kelo(at)gmail.com>
 * @authore Federico "Lox" Lucignano <federico(at)wikia-inc.com>
 */
//quick mock of json to test api ToDo -> remove it before merging!!!!!!!
class json {
	public $id;
	public $title;
	public $url;
	public $ns;
	public $thumbnail;
	public $originalDimensions;
	public function __construct(){
		$this->id = 234;
		$this->title = 'Rachel Berry';
		$this->url = '/Rachel_Berry';
		$this->ns = 0;
		$this->thumbnail = 'http://static3.wikia.nocookie.net/__cb20140208202628/glee/images/thumb/c/cc/Tumblr_n0p1zdllkm1qe476yo1_500.jpg/200px-0%2C501%2C0%2C500-Tumblr_n0p1zdllkm1qe476yo1_500.jpg';
		$this->originalDimensions = ['width' => 500, 'height' => 500];
	}
}

class myJsonMock {
	public $items;
	public function __construct(){
		$items1 = new json;
		$items2 = new json;
		$this->items = array( $items1, $items2 );
	}
}

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
		$this->response->setVal( 'bodyContent', $bodyContent );

		$this->response->setVal(
			'categoryLinks',
			$this->app->renderView(
				'WikiaMobileCategoryService',
				'index',
				array( 'categoryLinks' => $categoryLinks )
			)
		);

		//Render Trending Articles
		$trendingArticles = $this->sendRequest( 'WikiaMobileTrendingArticlesService', 'index' )->toString();

		$this->response->setVal( 'trendingArticles', $trendingArticles );
		$this->response->setVal( 'afterBodyContent', $afterBodyHtml );
		$this->response->setVal( 'afterContentHookText', $afterContentHookText );

	}
}
