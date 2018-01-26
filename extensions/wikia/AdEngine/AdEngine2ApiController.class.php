<?php
class AdEngine2ApiController extends WikiaController {

	const DEFAULT_TEMPLATE_ENGINE = WikiaResponse::TEMPLATE_ENGINE_MUSTACHE;

	public function getCollapse() {
		$this->response->setCacheValidity( WikiaResponse::CACHE_STANDARD );
	}

	public function postPorvataInfo() {
		\Wikia\Logger\WikiaLogger::instance()
			->debug( 'Porvata info', [
				'ad_system' => $this->request->getVal('ad_system'),
				'advertiser' => $this->request->getVal('advertiser'),
				'advertiser_id' => $this->request->getVal('advertiser_id'),
				'network_id' => $this->request->getVal('network_id'),
				'content_type' => $this->request->getVal('content_type'),
				'media_url' => $this->request->getVal('media_url'),
				'event_name' => $this->request->getVal('event_name'),
				'ad_error_code' => $this->request->getVal('ad_error_code'),
				'position' => $this->request->getVal('position'),
				'browser' => $this->request->getVal('browser'),
				'vast_url' => $this->request->getVal('vast_url')
			]);

		$this->response->setCacheValidity( WikiaResponse::CACHE_SHORT );
	}

	public function getSubtitles() {
		$params = $this->request->getParams();
		$filename = sprintf('%s-%s.srt', $params['mediaId'], $params['language']);

		$this->response->setBody(file_get_contents(__DIR__ . '/subtitles/' . $filename));
		$this->response->setCacheValidity( WikiaResponse::CACHE_SHORT );
	}
}
