<?php

/**
 * User Path Prediction Special page
 * 
 * @author Federico "Lox" Lucignano <federico(at)wikia-inc.com>
 * @author Jakub Olek <bukaj.kelo(at)gmail.com>
 */

class UserPathPredictionSpecialController extends WikiaSpecialPageController {
		
	private $model,$controller;	
		
	public function __construct() {
		parent::__construct( 'UserPathPrediction', '', false );
	}
	
	public function init() {
		//TODO: initialization code here
	}
	
	public function index() {
		
		$this->wg->Out->setPageTitle( "User Path Prediction Demonstration" );
		//$this->wg->Out->setPageTitle( $this->wf->msg( 'helloworld-specialpage-title' ) );
		$this->response->addAsset( 'extensions/wikia/hacks/UserPathPrediction/css/UserPathPrediction.scss' );
		$this->response->addAsset( 'extensions/wikia/hacks/UserPathPrediction/js/UserPathPrediction.js' );
		$this->response->addAsset( 'extensions/wikia/hacks/UserPathPrediction/js/tablesorter.min.js' );
		
		$this->redirect( 'UserPathPredictionSpecial', 'UserPathPrediction' );
	}
	
	
	public function UserPathPrediction() {
		$this->wf->profileIn( __METHOD__ );
		
		$this->model = F::build( 'UserPathPredictionModel' );
		$this->controller = F::build('UserPathPredictionController');
		
		// getting request data
		$wikiId = $this->getVal( 'wikiId', $this->wg->CityId );

		// setting response data
		$this->setVal( 'header', $this->wf->msg('header') );
		
		$result = $this->sendRequest( 'UserPathPredictionController', 'getPath');
		$result = $result->getData();
		$result = $result["articles"];

		$this->setVal( 'articles', $result );
		$this->setVal( 'nodes', $this->model->getNodes( 11, 12 ) );
		
		//get Wiki names	
		$wikis = $this->model->getWikis();
		$this->setVal( 'wikis', $wikis );
		
		// example of setting SpecialPage::mIncluding
		$this->mIncluding = true;

		$this->wf->profileOut( __METHOD__ );
	}
		
	public function getNodes() {
		$this->model = F::build( 'UserPathPredictionModel' );
		/*$nodes = $this->model->getNodes(490, 126007, 10 );

		if ( count($nodes) > 0 ) {
			foreach ( $nodes as $node ) {
				$result += $node->citi_id ." ". $node->referrer_id ." ". $node->target_id ." ". $node->count . " ". $node->updated;
			}	
		} else {
			$result = "Database is silent " . $nodes;

		}*/
		$this->setVal('nodes',  $this->model->getNodes(490, 126007, 10 ));
	}

}
