<?php
use Wikia\Vignette\UrlConfig;
use Wikia\Vignette\UrlGenerator;

class VignetteRequest {
	/**
	 * @param File $file
	 * @return UrlGenerator
	 */
	public static function fromFile(File $file) {
		$timestamp = $file->isOld() ? $file->getArchiveTimestamp() : $file->getTimestamp();

		return self::fromConfigMap([
			'is-archive' => $file->isOld(),
			'timestamp' => $timestamp,
			'relative-path' => $file->getHashPath().rawurlencode($file->getName()),
			'path-prefix' => $file->getPathPrefix(),
		]);
	}

	/**
	 * create a UrlGenerator from a config map. $config must have the following keys: relative-path.
	 * optionally, it can also have timestamp, is-archive, path-prefix, bucket, base-url, and domain-shard-count.
	 * if the optional values aren't in the map, they'll be generated from the current wiki environment
	 *
	 * @param $config
	 * @return UrlGenerator
	 * @throws InvalidArgumentException
	 */
	public static function fromConfigMap($config) {
		$requiredKeys = [
			'relative-path',
		];

		$isArchive = isset($config['is-archive']) ? $config['is-archive'] : false;
		$pathPrefix = isset($config['path-prefix']) ? $config['path-prefix'] : null;
		$timestamp = isset($config['timestamp']) ? $config['timestamp'] : 0;

		if (!isset($config['base-url'])) {
			global $wgVignetteUrl;
			$config['base-url'] = $wgVignetteUrl;
		}

		if (!isset($config['bucket'])) {
			/**
			 * get the top level bucket for a given wiki. this may or may not be the same as $wgDBName. This is done via
			 * regular expression because there is no variable that contains the bucket name :(
			 */
			global $wgUploadPath;
			$config['bucket'] = self::parseBucket($wgUploadPath);
		}

		if (!isset($config['domain-shard-count'])) {
			global $wgImageServers;
			$config['domain-shard-count'] = $wgImageServers;
		}

		foreach ($requiredKeys as $key) {
			if (!isset($config[$key])) {
				\Wikia\Logger\WikiaLogger::instance()->error("missing key", array_merge($config, ['missing_key' => $key]));
				throw new InvalidArgumentException("missing key '{$key}'");
			}
		}

		$config = ( new UrlConfig() )
			->setIsArchive( $isArchive )
			->setTimestamp( $timestamp )
			->setRelativePath( $config['relative-path'] )
			->setPathPrefix( $pathPrefix )
			->setBucket( $config['bucket'] )
			->setBaseUrl( $config['base-url'] )
			->setDomainShardCount( $config['domain-shard-count'] );

		return new UrlGenerator($config);
	}

	/**
	 * parse image bucket from a url. ex: http://images.wikia.com/muppet/images/a/ab/image.jpg will return "muppet"
	 * @param $url
	 * @return mixed
	 */
	public static function parseBucket( $url ) {
		$bucket = null;

		if ( preg_match( '/http(s?):\/\/(.*?)\/(.*?)\/(.*)$/', $url, $matches ) ) {
			$bucket = $matches[3];
		}

		return $bucket;
	}

	/**
	 * parse the path prefix from a url.
	 * http://images.wikia.com/walkingdead/ru/images -> "ru",
	 * http://images.wikia.com/walkingdead/images -> null
	 * http://images.wikia.com/p__/psychusa/zh/images -> psychusa/zh
	 * @param $url
	 * @return null
	 */
	public static function parsePathPrefix( $url ) {
		$pathPrefix = null;

		if ( preg_match( '/http(s)?:\/\/(.*?)\/(.*?)\/(.*?\/)?images$/', $url, $matches ) && isset( $matches[4] ) ) {
			$pathPrefix = rtrim($matches[4], '/');
		}

		return $pathPrefix;
	}

	/**
	 * parse relative path from url. ex: http://images.wiukia.com/muppet/images/a/ab/image.jpg will
	 * return "a/ab/image.jpg"
	 * @param $url
	 * @return mixed
	 */
	public static function parseRelativePath( $url ) {
		$relativePath = null;

		if ( preg_match( '/\w\/\w\w\/(.*)$/', $url, $matches ) ) {
			$relativePath = $matches[0];
		}

		return $relativePath;
	}
}
