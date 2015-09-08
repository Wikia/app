<?php

/**
 * Use this class to generate URLs to files uploaded using StaticAssetsManager
 *
 * Example URL: http://vignette.wikia-dev.com/3feccb7c-d544-4998-b127-3eba49eb59af
 */
namespace Wikia\Vignette;

class StaticAssetsUrlGenerator extends UrlGenerator {

	/**
	 * get url for thumbnail/image that's been built up so far
	 * @return string
	 * @throws \Exception
	 */
	public function url() {
		$imagePath = ltrim( $this->config->relativePath(), '/' );

		if ( !isset( $this->query['replace'] ) && $this->config->replaceThumbnail() ) {
			$this->replaceThumbnail();
		}

		$imagePath .= $this->modePath();

		return $this->domainShard( $imagePath );
	}
}
