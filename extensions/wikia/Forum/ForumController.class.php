<?php 

class ForumController extends WikiaController {
	private $isThreadLevel = false;

	public function __construct() {
		parent::__construct();
	}

	public function init() {
		$this->response->addAsset('extensions/wikia/Forum/js/Forum.js');
		$this->response->addAsset('extensions/wikia/Forum/css/Forum.scss');
	}

	public function board() {
		$wall = $this->app->renderView('WallController', 'index', array( 
			'dontRenderUserTalkArchiveAnchor' => true,
			'title' => $this->request->getVal('title') 
		));
		$this->response->setVal('wall', $wall);
	}
}