<?php

class SiteWideMessagesController extends WikiaController  {

	const CACHE_VALIDITY_VARNISH = 10800; // 3 hours
	const CACHE_VALIDITY_BROWSER = 3600; // 1 hour

	public function getAnonMessages() {
		global $wgEnableArticleFeaturedVideo;

		$articleTitle = Title::newFromID($this->getVal('articleId'))->getPrefixedDBkey();
		$featuredVideoEmbedded = !empty( $wgEnableArticleFeaturedVideo ) && ArticleVideoContext::isFeaturedVideoEmbedded( $articleTitle );
		
		if ( $this->wg->User->isLoggedIn() || $featuredVideoEmbedded ) {
			// Don't return anything if this happens
			$this->skipRendering();
			return;
		}

		$msgs = SiteWideMessages::getAllAnonMessages( $this->wg->User, false, false );

		$this->siteWideMessagesCount = count( $msgs );
		$this->siteWideMessages = $msgs;
		$this->notificationType = NotificationsController::NOTIFICATION_SITEWIDE;

		$this->response->setCacheValidity( self::CACHE_VALIDITY_VARNISH, self::CACHE_VALIDITY_BROWSER );
	}

}
