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

		return self::fromHash([
			'is-archive' => $file->isOld(),
			'timestamp' => $timestamp,
			'relative-path' => $file->getHashPath().rawurlencode($file->getName()),
			'language-code' => $file->getLanguageCode(),
		]);
	}

	/**
	 * create a UrlGenerator from a config hash. $config must have the following keys: timestamp, relative-path, and
	 * language-code. optionally, it can also have is-archive, bucket, base-url, and domain-shard-count. if the
	 * optional values aren't in the hash, they'll be generated from the current wiki environment
	 *
	 * @param $config
	 * @return UrlGenerator
	 * @throws InvalidArgumentException
	 */
	public static function fromHash($config) {
		$requiredKeys = [
			'timestamp',
			'relative-path',
			'language-code',
		];

		$isArchive = isset($config['is-archive']) ? $config['is-archive'] : false;

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
			preg_match( '/http(s?):\/\/(.*?)\/(.*?)\/(.*)$/', $wgUploadPath, $matches );
			$config['bucket'] = $matches[3];
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
			->setTimestamp( $config['timestamp'] )
			->setRelativePath( $config['relative-path'] )
			->setLanguageCode( $config['language-code'] )
			->setBucket( $config['bucket'] )
			->setBaseUrl( $config['base-url'] )
			->setDomainShardCount( $config['domain-shard-count'] );

		return new UrlGenerator($config);
	}
}
