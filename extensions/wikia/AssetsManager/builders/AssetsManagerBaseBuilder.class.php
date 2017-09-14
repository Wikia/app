<?php

/**
 * @author Inez Korczyński <korczynski@gmail.com>
 */

class AssetsManagerBaseBuilder {

	protected $mOid;
	protected $mType;
	protected $mParams;
	protected $mCb;
	protected $mNoExternals;
	protected $mForceProfile;
	protected $mProfilerData = array();

	protected $mContent;
	protected $mContentType;

	public function __construct(WebRequest $request) {
		$this->mType = $request->getText('type');
		$this->mOid = preg_replace( '/\?.*$/', '', $request->getText('oid') );
		parse_str(urldecode($request->getText('params')), $this->mParams);
		$this->mCb = $request->getInt('cb');

		if (!empty($this->mParams['noexternals'])) {
			$this->mNoExternals = true;
		}

		if (!empty($this->mParams['forceprofile'])) {
			$this->mForceProfile = true;
		}
	}

	/**
	 * @param float $processingTimeStart Unix timestamp in microseconds used for profiling (when profiling is forced)
	 * @return string
	 * @throws Exception
	 */
	public function getContent( $processingTimeStart = null ) {
		$minifyTimeStart = null;

		if ( !empty( $this->mContent ) && ( !isset( $this->mParams['minify'] ) || $this->mParams['minify'] == true ) ) {
			if ( $this->mForceProfile ) {
				$minifyTimeStart = microtime( true );
			}

			if ( $this->mContentType == AssetsManager::TYPE_CSS ) {
				$newContent = $this->minifyCSS( $this->mContent );

			} else if ( $this->mContentType == AssetsManager::TYPE_JS ) {
				$newContent = self::minifyJS( $this->mContent );
			}
		}

		if ( !empty( $newContent ) ) {
			if ( $this->mForceProfile ) {
				$timeEnd = microtime( true );

				if ( $processingTimeStart ) {
					$this->mProfilerData[] = "Processing time: " . intval( ( $timeEnd - $processingTimeStart ) * 1000 ) . "ms";
				}

				if ( $minifyTimeStart ) {
					$this->mProfilerData[] = "Minification time: " . intval( ( $timeEnd - $minifyTimeStart ) * 1000 ) . "ms";
				}

				$oldSize = intval( strlen( $this->mContent ) / 1024 );
				$newSize = intval( strlen( $newContent ) / 1024 );

				$this->mProfilerData[] = "Compressed Size: " . $newSize . "kb";
				$this->mProfilerData[] = "Compression Ratio: " . intval( ( 1 - ( $newSize / $oldSize ) ) * 100 ) . "%";

				$newContent = "/* " . implode( " | ", $this->mProfilerData ) . " */\n\n" . $newContent;
			}

			$this->mContent = $newContent;
		}

		return $this->mContent;
	}

	public function getCacheDuration() {
		global $wgResourceLoaderMaxage, $wgStyleVersion;
		if($this->mCb > $wgStyleVersion) {
			return $wgResourceLoaderMaxage['unversioned'];
		} else {
			return $wgResourceLoaderMaxage['versioned'];
		}
	}

	public function getContentType() {
		return $this->mContentType;
	}

	public function getVary() {
		return 'Accept-Encoding';
	}

	/**
	 * @param $content string
	 * @return string
	 * @throws Exception
	 */
	public static function minifyJS($content) {
		wfProfileIn(__METHOD__);
		$res = JavaScriptMinifier::minify($content);

		if ( !is_string( $res ) ) {
			$e = new Exception( 'JS minification failed' );

			\Wikia\Logger\WikiaLogger::instance()->error( 'AssetsManagerBaseBuilder::minifyJS failed', [
				'exception' => $e,
			]);

			throw $e;
		}

		wfProfileOut(__METHOD__);
		return $res;
	}

	private function minifyCSS($content) {
		wfProfileIn(__METHOD__);
		$out = CSSMin::minify($content);
		wfProfileOut(__METHOD__);

		return $out;
	}
}
