<?php

class SiteWideMessagesController extends WikiaController {

	const CACHE_VALIDITY_VARNISH = 10800; // 3 hours
	const CACHE_VALIDITY_BROWSER = 3600; // 1 hour

	private function shouldSkipSiteWideMessages() {
		global $wgEnableArticleFeaturedVideo;

		$title = Title::newFromID( $this->getVal( 'articleId' ) );
		if ( !is_null( $title ) ) {
			$isFeaturedVideoEmbedded = !empty( $wgEnableArticleFeaturedVideo ) &&
				ArticleVideoContext::isFeaturedVideoEmbedded( $title->getArticleID() );
		} else {
			$isFeaturedVideoEmbedded = false;
		}

		return $this->wg->User->isLoggedIn() || $isFeaturedVideoEmbedded;
	}

	public function getAnonMessages() {

		if ( $this->shouldSkipSiteWideMessages() ) {
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
