<?php
use \Wikia\Vignette\UrlGenerator;
use \Wikia\Logger\Loggable;

/**
 * Class VignetteUrlToUrlGenerator
 * create a UrlGenerator object from a Vignette Url (string)
 */
class VignetteUrlToUrlGenerator {
	use Loggable;

	const URL_REGEX = '/^\/(?<bucket>[^\/]+)\/(images\/|avatars\/)?(?<relativePath>.*?)\/revision\/(?<revision>latest|\d+)(\/(?<thumbnailDefinition>.*))?/';

	private $url;
	private $asOriginal;
	private $urlParts;
	private $query;
	private $timestamp;
	private $pathPrefix;

	public function __construct($url, $asOriginal=false) {
		$this->url = $url;
		$this->asOriginal = $asOriginal;

		if (!VignetteRequest::isVignetteUrl($url)) {
			$this->reportWarning('invalid url');
		}
	}

	public function build() {
		if (!$this->parseUrl()) {
			$this->reportWarning('unable to parse url');
		}

		$isArchive = $this->urlParts['revision'] != \Wikia\Vignette\UrlGenerator::REVISION_LATEST;
		if ($isArchive) {
			$this->timestamp = $this->urlParts['revision'];
		}

		$generator = VignetteRequest::fromConfigMap([
			'bucket' => $this->urlParts['bucket'],
			'relative-path' => $this->urlParts['relativePath'],
			'timestamp' => $this->timestamp,
			'path-prefix' => $this->pathPrefix,
			'is-archive' => $isArchive,
		]);

		if (!$this->asOriginal && isset($this->urlParts['thumbnailDefinition'])) {
			$this->addThumbDefinition($generator);
		}

		return $generator;
	}

	private function parseUrl() {
		$parts = parse_url($this->url);

		if (isset($parts['query'])) {
			parse_str($parts['query'], $this->query);

			if (isset($this->query['cb'])) {
				$this->timestamp = $this->query['cb'];
			}

			if (isset($this->query['path-prefix'])) {
				$this->pathPrefix = $this->query['path-prefix'];
			}
		}

		return preg_match(self::URL_REGEX, $parts['path'], $this->urlParts);
	}

	private function addThumbDefinition(UrlGenerator $generator) {
		if (isset($this->query['format'])) {
			$generator->format($this->query['format']);
		}

		if (isset($this->query['fill'])) {
			$generator->backgroundFill($this->query['fill']);
		}

		$parts = explode("/", $this->urlParts['thumbnailDefinition']);
		$mode = array_shift($parts);
		$generator->mode($mode);

		if ($mode == UrlGenerator::MODE_SCALE_TO_WIDTH || $mode == UrlGenerator::MODE_SCALE_TO_WIDTH_DOWN) {
			$generator->width(array_shift($parts));
			return;
		}

		foreach (array_chunk($parts, 2) as $chunk) {
			if (count($chunk) != 2) {
				$this->reportWarning('invalid chunk');
			}

			list($key, $val) = $chunk;
			switch ($key) {
				case 'width':
					$generator->width($val);
					break;
				case 'height':
					$generator->height($val);
					break;
				case 'x-offset':
					$generator->xOffset($val);
					break;
				case 'y-offset':
					$generator->yOffset($val);
					break;
				case 'window-width':
					$generator->windowWidth($val);
					break;
				case 'window-height':
					$generator->windowHeight($val);
					break;
				default:
					$this->reportWarning('invalid key while building thumb mode', [
						'key' => $key,
						'val' => $val,
					]);
					break;
			}
		}
	}

	private function reportWarning($message, Array $context=[]) {
		$exception = new InvalidArgumentException($message);
		$context['exception'] = $exception;

		$this->warning($message, $context);
		throw $exception;
	}

	protected function getLoggerContext() {
		return [
			'class' => __CLASS__,
			'url' => $this->url,
		];
	}
}
