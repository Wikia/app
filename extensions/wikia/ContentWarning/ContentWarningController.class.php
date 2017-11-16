<?php

/**
 * Content Warning Controller
 * @author Kyle Florence, Saipetch Kongkatong, Tomasz Odrobny
 */
class ContentWarningController extends WikiaController {

	/**
	 * render index template
	 */
	public function index() {
		$domain = preg_replace( '!^https?://!', '', $this->wg->Server );
		$this->body = wfMsgExt( 'content-warning-body', array('parse'), $domain );

		$userLang = $this->wg->Lang->getCode();

		if ( !empty( $this->wg->LangToCentralMap[$userLang] ) ) {
			$this->btnCancelUrl = $this->wg->LangToCentralMap[$userLang];
		} else {
			$this->btnCancelUrl = 'http://www.wikia.com/';
		}
	}

	/**
	 * approve content warning
	 * @responseParam string result [ok/error]
	 * @responseParam string msg - result message
	 */
	public function approveContentWarning() {
		if( !$this->wg->User->isLoggedIn() ) {
			$this->result = 'error';
			$this->msg = 'Logged in user only.';	// for debuging
			return;
		}

		$userId = $this->wg->User->getId();
		wfSetWikiaPageProp( WPP_CONTENT_WARNING, $userId, 1);

		// clear cache
		$memKey = $this->getMemKeyContentWarning( $userId );
		$this->wg->Memc->delete( $memKey );

		$this->result = 'ok';
	}

	/**
	 * get content warning approved
	 * @responseParam integer contentWarningApproved [0/1]
	 */
	public function getContentWarningApproved() {
		wfProfileIn( __METHOD__ );

		$contentWarningApproved = 0;
		if( $this->wg->User->isLoggedIn() ) {
			$userId = $this->wg->User->getId();
			$memKey = $this->getMemKeyContentWarning( $userId );
			$contentWarningApproved = $this->wg->Memc->get( $memKey );
			if ( empty( $contentWarningApproved ) ) {
				$contentWarningApproved = intval( wfGetWikiaPageProp( WPP_CONTENT_WARNING, $userId ) );

				$this->wg->Memc->set( $memKey, $contentWarningApproved, 60*60*12 );
			}
		}

		wfProfileOut( __METHOD__ );

		$this->contentWarningApproved = intval( $contentWarningApproved );
	}

	/**
	 * get memcache key for content warning
	 * @param integer $userId
	 * @return type
	 */
	protected function getMemKeyContentWarning( $userId ) {
		return wfMemcKey( 'content_warning_'.$userId, "v1" );
	}
}
