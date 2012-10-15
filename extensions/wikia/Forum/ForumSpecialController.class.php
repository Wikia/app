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
		$this->response->addAsset('extensions/wikia/Forum/css/Forum.scss');
		$this->response->addAsset('extensions/wikia/Forum/css/ForumSpecial.scss');
		$this->response->setJsVar('wgIsForum', true);
		$this->wg->IsForum = true;
	}

	public function index() {
		$this->wf->profileIn( __METHOD__ );

		$this->wg->Out->setPageTitle($this->wf->msg('forum-forum-title', $this->wg->Sitename));

		$this->blurb = $this->wf->MsgExt('forum-specialpage-blurb', 'parse');
		$this->blurbHeading = $this->wf->Msg('forum-specialpage-blurb-heading');
		$this->lastPostBy = $this->wf->Msg('forum-specialpage-board-lastpostby');

		$forum = F::build( 'Forum' );
		$this->boards = $forum->getBoardList();

		$this->wf->profileOut( __METHOD__ );
	}
}
