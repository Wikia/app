<?php
use Wikia\Vignette\UrlConfig;
use Wikia\Vignette\UrlGenerator;

class VignetteRequest {
	/**
	 * @param File $file
	 * @return UrlGenerator
	 */
	public static function fromFile( File $file ) {
		$timestamp = $file->isOld() ? $file->getArchiveTimestamp() : $file->getTimestamp();

		return self::fromConfigMap( [
			'is-archive' => $file->isOld(),
			'timestamp' => $timestamp,
			'relative-path' => $file->getHashPath() . rawurlencode( $file->getName() ),
			'bucket' => $file->getBucket(),
			'path-prefix' => $file->getPathPrefix(),
		] );
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
	public static function fromConfigMap( $config ) {
		$replaceThumbnail = false;

		$requiredKeys = [
			'relative-path',
		];

		$isArchive = isset( $config['is-archive'] ) ? $config['is-archive'] : false;
		$pathPrefix = isset( $config['path-prefix'] ) ? $config['path-prefix'] : null;
		$timestamp = isset( $config['timestamp'] ) ? $config['timestamp'] : 0;

		if ( isset( $config['replace'] ) ) {
			$replaceThumbnail = $config['replace'];
		} else {
			global $wgVignetteReplaceThumbnails;
			if ( $wgVignetteReplaceThumbnails || ( !empty( $_GET['vignetteReplaceThumbnails'] ) && (bool)$_GET['vignetteReplaceThumbnails'] ) ) {
				$replaceThumbnail = true;
			}
		}

		if ( !isset( $config['base-url'] ) ) {
			global $wgVignetteUrl;
			$config['base-url'] = $wgVignetteUrl;
		}

		if ( !isset( $config['bucket'] ) ) {
			/**
			 * get the top level bucket for a given wiki. this may or may not be the same as $wgDBName. This is done via
			 * regular expression because there is no variable that contains the bucket name :(
			 */
			global $wgUploadPath;
			$config['bucket'] = self::parseBucket( $wgUploadPath );
		}

		if ( !isset( $config['domain-shard-count'] ) ) {
			global $wgImagesServers;
			$config['domain-shard-count'] = $wgImagesServers;
		}

		foreach ( $requiredKeys as $key ) {
			if ( !isset( $config[$key] ) ) {
				\Wikia\Logger\WikiaLogger::instance()->error( "missing key", array_merge( $config, ['missing_key' => $key] ) );
				throw new InvalidArgumentException( "missing key '{$key}'" );
			}
		}

		$config = ( new UrlConfig() )
			->setIsArchive( $isArchive )
			->setReplaceThumbnail( $replaceThumbnail )
			->setRelativePath( $config['relative-path'] )
			->setPathPrefix( $pathPrefix )
			->setBucket( $config['bucket'] )
			->setBaseUrl( $config['base-url'] )
			->setDomainShardCount( $config['domain-shard-count'] );

		if ( $timestamp > 0 ) {
			$config->setTimestamp( $timestamp );
		}

		return new UrlGenerator( $config );
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
			$pathPrefix = rtrim( $matches[4], '/' );
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

	/**
	 * Figure out if a url is a vignette url or not. If you're using this, you should feel sad, and a task should be
	 * filed to fix whatever code you're using to not use this function.
	 * 
	 * @param $url
	 * @return bool
	 */
	public static function isVignetteUrl( $url ) {
		global $wgVignetteUrl, $wgImagesServers;

		$isVignetteUrl = false;

		if ( strpos( $wgVignetteUrl, '<SHARD>' ) === false ) {
			$isVignetteUrl = strpos( $url, $wgVignetteUrl ) !== false;
		} else {
			for ( $i = 1; $i <= $wgImagesServers; ++$i ) {
				$candidate = str_replace( '<SHARD>', $i, $wgVignetteUrl );
				if ( strpos( $url, $candidate ) !== false ) {
					$isVignetteUrl = true;
					break;
				}
			}
		}

		return $isVignetteUrl;
	}
}
