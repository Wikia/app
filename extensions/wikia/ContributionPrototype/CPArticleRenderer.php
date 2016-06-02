<?php

namespace ContributionPrototype;

use Http;
use MWHttpRequest;
use OutputPage;
use Wikia;
use Wikia\Logger\Loggable;
use Wikia\Service\Gateway\UrlProvider;

class CPArticleRenderer {
	
	use Loggable;

	const SERVICE_NAME = "structdata";

	/** @var string */
	private $host;
	
	/** @var int */
	private $wikiId;
	
	/** @var string */
	private $dbName;

	/** @var UrlProvider */
	private $urlProvider;

	/**
	 * CPArticleRenderer constructor.
	 * @param string $host
	 * @param int $wikiId
	 * @param string $dbName
	 * @param UrlProvider $urlProvider
	 */
	public function __construct($host, $wikiId, $dbName, $urlProvider) {
		$this->host = $host;
		$this->wikiId = $wikiId;
		$this->dbName = $dbName;
		$this->urlProvider = $urlProvider;
	}

	/**
	 * @param string $title
	 * @param OutputPage $output
	 */
	public function render($title, OutputPage $output) {
		$content = $this->getArticleContent($title);
		
		if ($content === false) {
			// TODO: what do we want to show here?
			return;
		}

		$this->addStyles($output);
		$this->addScripts($output);
		$output->addHTML($content);
	}

	private function addStyles(OutputPage $output) {
		$output->addLink([
				'rel' => 'stylesheet',
				'href'=> "{$this->host}/public/assets/styles/main.css",
		]);

		// this ends up using $wgOut :(
		// TODO: try changing this to add to output directly
		Wikia::addAssetsToOutput('contribution_prototype_scss');
	}

	private function addScripts(OutputPage $output) {
		$output->addScript("<script src=\"{$this->host}/public/assets/app.js\"></script>");
	}

	private function getArticleContent($title) {
		return file_get_contents("{$this->host}/wiki/{$title}");

//		$internalHost = $this->urlProvider->getUrl(self::SERVICE_NAME);
//		$path = "/wiki/{$title}";
//
//		/** @var MWHttpRequest $response */
//		$response = Http::request(
//				'GET',
//				"{$internalHost}/{$path}",
//				[
//					'noProxy' => true,
//					'returnInstance' => true,
//					'followRedirects'=> true,
//				]
//		);
//
//		if ($response->getStatus() >= 500) {
//			// Http::request logs when http status > 399
//			return false;
//		}
//
//		return $response->getContent();
	}
}