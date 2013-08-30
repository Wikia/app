<?php

/**
 * @author Inez Korczyński <korczynski@gmail.com>
 * @author Piotr Bablok <piotr.bablok@gmail.com>
 */

class AssetsManagerSassBuilder extends AssetsManagerBaseBuilder {
	const CACHE_VERSION = 2;

	public function __construct(WebRequest $request) {
		global $IP;
		parent::__construct($request);

		if (strpos($this->mOid, '..') !== false) {
			throw new Exception('File path must not contain \'..\'.');
		}

		if (!endsWith($this->mOid, '.scss', false)) {
			throw new Exception('Requested file must be .scss.');
		}

		//remove slashes at the beginning of the string, we need a pure relative path to open the file
		$this->mOid = preg_replace( '/^[\/]+/', '', $this->mOid );

		if ( !file_exists( "{$IP}/{$this->mOid}" ) ) {
			throw new Exception("File {$this->mOid} does not exist!");
		}
		$this->mContentType = AssetsManager::TYPE_CSS;
	}

	public function getContent( $processingTimeStart = null ) {
		global $IP;
		wfProfileIn(__METHOD__);

		$processingTimeStart = null;

		if ( $this->mForceProfile ) {
			$processingTimeStart = microtime( true );
		}

		$memc = F::App()->wg->Memc;

		$this->mContent = null;

		$content = null;
		$sassService = null;
		$hasErrors = false;

		try {
			$sassService = SassService::newFromFile("{$IP}/{$this->mOid}");
			$sassService->setSassVariables($this->mParams);
			$sassService->setFilters(
				SassService::FILTER_IMPORT_CSS | SassService::FILTER_CDN_REWRITE
				| SassService::FILTER_BASE64 | SassService::FILTER_JANUS
			);

			$cacheId = __CLASS__ . "-minified-".$sassService->getCacheKey();
			$content = $memc->get( $cacheId );
		} catch (Exception $e) {
			$content = "/* {$e->getMessage()} */";
			$hasErrors = true;
		}


		if ( $content ) {
			$this->mContent = $content;

		} else {
			// todo: add extra logging of AM request in case of any error
			try {
				$this->mContent = $sassService->getCss( /* useCache */ false);
			} catch (Exception $e) {
				$this->mContent = $this->makeComment($e->getMessage());
				$hasErrors = true;
			}

			// This is the final pass on contents which, among other things, performs minification
			parent::getContent( $processingTimeStart );

			// Prevent cache poisoning if we are serving sass from preview server
			if ( !empty($cacheId) && getHostPrefix() == null && !$this->mForceProfile ) {
				$expTime = 0;
				if ( $hasErrors ) {
					$expTime = 10; // prevent flooding servers with sass processes
				}
				$memc->set( $cacheId, $this->mContent, $expTime );
			}
		}

		wfProfileOut(__METHOD__);

		return $this->mContent;
	}

	/**
	 * Get a JS/CSS comment with the given text
	 *
	 * @param $text string Text to be put in the comment
	 * @return string Input text wrapped in the comment
	 */
	protected function makeComment( $text ) {
		$encText = str_replace( '*/', '* /', $text );
		return "/*\n$encText\n*/\n";
	}
}
