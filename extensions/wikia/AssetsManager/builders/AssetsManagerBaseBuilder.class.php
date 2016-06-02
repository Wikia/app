<?php

/**
 * @author Inez Korczyński <korczynski@gmail.com>
 */

use Wikia\Util\GlobalStateWrapper;

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
				$newContent = self::minifyJS( $this->mContent, ( $this->mOid == 'oasis_shared_js' || $this->mOid == 'rte' ) ? true : false );
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
	 * @param $content
	 * @param bool $useYUI
	 * @return string
	 * @throws Exception
	 */
	public static function minifyJS($content, $useYUI = false) {
		global $IP;
		wfProfileIn(__METHOD__);

		$tempInFile = tempnam(sys_get_temp_dir(), 'AMIn');
		file_put_contents($tempInFile, $content);

		$retval = 1;

		if($useYUI) {
			wfProfileIn(__METHOD__ . '::yui');

			$wrapper = new GlobalStateWrapper( [
				'wgMaxShellMemory' => 0, // because Java is hungry
			] );

			$out = $wrapper->wrap( function () use ( $IP, &$retval, $tempInFile ) {
				$tempOutFile = tempnam(sys_get_temp_dir(), 'AMOut');
				$out = wfShellExec("nice -n 15 java -jar {$IP}/lib/vendor/yuicompressor-2.4.2.jar --type js -o {$tempOutFile} {$tempInFile} 2>&1", $retval);

				if ($retval === 0) {
					$out = file_get_contents($tempOutFile);
				}
				unlink($tempOutFile);

				return $out;
			});

			wfProfileOut(__METHOD__ . '::yui');
		} else {
			wfProfileIn(__METHOD__ . '::jsmin');
			$jsmin = "{$IP}/lib/vendor/jsmin";
			$out = wfShellExec("cat $tempInFile | $jsmin", $retval);
			wfProfileOut(__METHOD__ . '::jsmin');
		}

		unlink($tempInFile);

		if ( $retval !== 0 ) {
			$e = new Exception( 'JS minification failed', $retval );

			\Wikia\Logger\WikiaLogger::instance()->error( 'AssetsManagerBaseBuilder::minifyJS failed', [
				'exception' => $e,
				'output' => $out,
			]);

			throw $e;
		}

		wfProfileOut(__METHOD__);
		return $out;
	}

	private function minifyCSS($content) {
		wfProfileIn(__METHOD__);
		$out = CSSMin::minify($content);
		wfProfileOut(__METHOD__);

		return $out;
	}
}
