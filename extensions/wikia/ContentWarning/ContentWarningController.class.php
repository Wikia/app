<?php

/**
 * Content Warning Controller
 * @author Kyle Florence, Saipetch Kongkatong, Tomasz Odrobny
 */
class ContentWarningController extends WikiaController {

	public function init() {
		$this->response->addAsset( 'extensions/wikia/ContentWarning/js/ContentWarning.js' );
		$this->response->addAsset( 'extensions/wikia/ContentWarning/css/ContentWarning.scss' );
	}

	public function index() {
		$this->title = $this->wf->Msg('content-warning-title');
		$this->body = $this->wf->MsgExt( 'content-warning-body', array('parse'), $this->wg->Server );
		$this->btnContinue = $this->wf->Msg( 'content-warning-button-continue' );
		$this->btnCancel = $this->wf->Msg( 'content-warning-button-cancel' );
	}

	public function approveContentWarning() {
		if( $this->wg->User->isLoggedIn() ) {
			
		}
	}
}
