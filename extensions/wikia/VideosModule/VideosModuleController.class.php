<?php

use VideosModule\Modules;
use Wikia\Service\User\Attributes;

class VideosModuleController extends WikiaController {
	const DEFAULT_TEMPLATE_ENGINE = WikiaResponse::TEMPLATE_ENGINE_MUSTACHE;
	const DEFAULT_REGION = 'US';

	/** @var $staffModule VideosModule\Modules\Staff */
	protected $staffModule;

	/** @var $generalModule VideosModule\Modules\Base */
	protected $generalModule;

	/**
	 * VideosModule
	 * Returns videos to populate the Videos Module. First check if there are
	 * categories associated with this wiki for the Videos Module and pull
	 * premium videos from those categories. Finally, if neither of those
	 * first conditions are true, search for premium videos related to the wiki.
	 * @responseParam string $title - i18n'ized title of the videos module
	 * @responseParam array $videos - list of videos
	 * @responseParam array $staffVideos - list of staff picked videos
	 */
	public function index() {
		$this->initModules();

		$staffVideos = $this->staffModule->getVideos();
		$videos = $this->generalModule->getVideos();

		$videos = $this->removeDuplicates( $videos, $staffVideos );

		$this->response->setData( [
			'title'	 => wfMessage( 'videosmodule-title-default' )->escaped(),
			'videos' => $videos,
			'staffVideos' => $staffVideos
		] );

		// Set client cache
		$this->response->setCacheValidity( Modules\Base::CACHE_TTL );
	}

	/**
	 * Clears the VideosModule cache.  Takes same parameters as the index method.
	 */
	public function clear() {
		$this->initModules();

		$this->staffModule->clearCache();
		$this->generalModule->clearCache();

		$this->response->setVal( 'result', 'ok' );
	}

	/**
	 * Initialize the modules used in this request.
	 */
	protected function initModules() {
		$userRegion = $this->request->getVal( 'userRegion', self::DEFAULT_REGION );

		$this->staffModule = new Modules\Staff( $userRegion );

		if ( !empty( $this->wg->VideosModuleCategories )  ) {
			$this->generalModule = new Modules\Category( $userRegion );
		} else {
			$this->generalModule = new Modules\Related( $userRegion );
		}
	}

	/**
	 * Since VideosModule is using Async cache, its not practical to send a list of video titles to the offline job.
	 * Dedup the titles here instead of in VideosModule
	 *
	 * @param array $removeFromList
	 * @param array $existingList
	 *
	 * @return array
	 */
	protected function removeDuplicates( array $removeFromList, array $existingList ) {
		$existingTitles = [];
		foreach ( $existingList as $videoDetail ) {
			$existingTitles[] = $videoDetail['title'];
		}

		$resultList = [];
		foreach ( $removeFromList as $videoDetail ) {
			if ( array_key_exists( $videoDetail['title'], $existingTitles ) ) {
				continue;
			}
			$resultList[] = $videoDetail;
		}

		return $resultList;
	}

	public function test() {
		/** @var Attributes\UserAttributes $userAttributes */
		$userAttributes = \Wikia\DependencyInjection\Injector::getInjector()->get(Attributes\UserAttributes::class);
		$foo = $userAttributes->getAttribute(5654074, 'nickName');
		print_r($foo);
		$userAttributes->saveAttribute( 5654074, new \Wikia\Domain\User\Attribute( 'nickName', 'AAAAAA' )  );
		$foo = $userAttributes->getAttribute(5654074, 'nickName');
		print_r($foo);
//		$config = (new \Swagger\Client\Configuration())
//			->setHost('http://10.8.38.30:31390')
//			->setApiKey('X-Wikia-UserId', 5654074);
//
//		$client = new \Swagger\Client\ApiClient($config);
//		$api = new \Swagger\Client\User\Attributes\Api\UsersAttributesApi($client);
//
//		try {
//			print_r($api->updateAttributeForUser(5654074, "fbPage", "and again"));
//		} catch (\Swagger\Client\ApiException $e) {
//			print_r($e);
//		}
	}
}
