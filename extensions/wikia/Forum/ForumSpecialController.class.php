<?php
/**
 * Forum Special Page
 * @author Kyle Florence, Saipetch Kongkatong, Tomasz Odrobny
 */
class ForumSpecialController extends WikiaSpecialPageController {

	public function __construct() {
		parent::__construct('Forum', '', false);
	}

	public function init() {
		$this->response->addAsset('extensions/wikia/Forum/js/Forum.js');
		$this->response->addAsset('extensions/wikia/Forum/css/Forum.scss');
	}

	public function index() {
		$this->wf->profileIn( __METHOD__ );

		$this->wg->Out->setPageTitle($this->wf->msg('forum-specialpage-title', $this->wg->Sitename));

		$this->blurb = $this->wf->Msg('forum-specialpage-blurb');
		$this->blurbHeading = $this->wf->Msg('forum-specialpage-blurb-heading');
		$this->lastPostBy = $this->wf->Msg('forum-specialpage-board-lastpostby');

		$helper = F::build( 'ForumBoardHelper' );
		$this->boards = $helper->getBoardList();

		$this->wf->profileOut( __METHOD__ );
	}
}
