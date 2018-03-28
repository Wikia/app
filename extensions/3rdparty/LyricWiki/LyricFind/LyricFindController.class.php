<?php

/**
 * This controller sends HTTP request to LyricFind tracking API with the following data:
 *
 * - amgid (if available)
 * - gnlyricid (if available)
 * - page title (always) - controller should be called with title parameter passed
 */
class LyricFindController extends WikiaController {

	const RESPONSE_OK = 200;
	const RESPONSE_ERR = 404;

	public function track() {
		$amgId = intval($this->getVal('amgid'));
		$gracenoteId = intval($this->getVal('gracenoteid'));
		$isMWBot = RequestContext::getMain()->getUser()->isBot();
		$isCrawler = $this->isWebCrawler(
			RequestContext::getMain()->getRequest()->getHeader( 'User-Agent' )
		);

		if ( !$isMWBot && $this->wg->Title->isKnown() && !$isCrawler ) {
			// make a request to LyricFind API
			$service = new LyricFindTrackingService();
			$status = $service->track($amgId, $gracenoteId, $this->wg->Title);

			// debug response headers
			if (!$status->isOK()) {
				$errors = $status->getErrorsArray();
				$this->response->setHeader('X-LyricFind-API-Error', reset($errors)[0]);
			}

			if (!empty($status->value)) {
				$this->response->setHeader('X-LyricFind-API-Code', $status->value);
			}

			if ($status->isOK()) {
				// emit blank image - /skins/common/blank.gif
				$this->response->setCode(self::RESPONSE_OK);
				$this->response->setContentType('image/gif');

				// emit raw GIF content when not in CLI mode
				// i.e. not running unit tests
				if ( php_sapi_name() != 'cli' ) {
					echo file_get_contents($this->wg->StyleDirectory . '/common/blank.gif');
				}
			}
			else {
				$this->response->setCode(self::RESPONSE_ERR);
			}
		} else {
			$this->response->setCode(self::RESPONSE_OK);
			$this->response->setContentType('image/gif');

			// emit raw GIF content when not in CLI mode
			// i.e. not running unit tests
			if ( php_sapi_name() != 'cli' ) {
				echo file_get_contents($this->wg->StyleDirectory . '/common/blank.gif');
			}
		}

		// don't try to find a template for this controller's method
		$this->skipRendering();
	}

	private function isWebCrawler( $userAgent ) {
		// A list of some common words used only for bots and crawlers.
		$crawlers = [
			'bot',
			'slurp',
			'crawler',
			'spider',
			'curl',
			'facebook',
			'fetch',
			'ruby',
			'python',
			'perl/lyrics::fetcher::lyricwiki',
			'mozilla/5.0 (windows; u; windows nt 5.1; en-us; rv:1.8.1.6) gecko/20070725 firefox/2.0.0.6',
			'mozilla/5.0 (x11; linux x86_64) applewebkit/535.19 (khtml, like gecko) chrome/18.0.1025.142 safari/535.19'
		];

		foreach ( $crawlers as $identifier ) {
			if ( strpos( $userAgent, $identifier ) !== false ) {
				return true;
			}
		}

		return false;
	}
}
