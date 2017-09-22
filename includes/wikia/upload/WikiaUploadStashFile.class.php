<?php

class WikiaUploadStashFile extends UploadStashFile {
	/**
	 * Get the filename hash component of the directory including trailing slash,
	 * e.g. f/fa/
	 * If the repository is not hashed, returns an empty string.
	 * Wikia change: We need to calculate directory hash only from fileName - not date that was added after computing hash
	 *
	 * @return string
	 */
	function getHashPath() {
		$this->assertRepoDefined();

		$name = $this->getName();
		if (strpos($name, '!') !== false) {
			$name = explode('!', $name)[1];
		}

		$this->hashPath = $this->repo->getHashPath( $name );
		return $this->hashPath;
	}

	/**
	 * Get a URL to access the thumbnail
	 * This is required because the model of how files work requires that
	 * the thumbnail urls be predictable. However, in our model the URL is not based on the filename
	 * (that's hidden in the db)
	 * Wikia change:
	 *		Use our external thumbnailer for UploadStashFiles
	 *		We need to look into temp directory while upload stash is saving file there
	 *
	 * @param string|bool $suffix string that will be added at the end of path
	 * @return String: URL to access thumbnail, or URL with partial path
	 */
	public function getThumbUrl( $suffix = false ) {
		return VignetteRequest::applyLegacyThumbDefinition($this->getUrlGenerator(), $suffix)->url();
	}

	/**
	 * Get an URL to access the original stashed file
	 *
	 * @return string
	 */
	public function getOriginalFileUrl() {
		return $this->getUrlGenerator()->url();
	}

	public function getUrlGenerator() {
		return parent::getUrlGenerator()->fromStash();
	}
}
