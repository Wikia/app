<?php

/**
 * @author Inez Korczyński <korczynski@gmail.com>
 */

class AssetsManagerBaseBuilder {

	protected $mOid;
	protected $mType;
	protected $mParams;
	protected $mCb;

	protected $mContent;
	protected $mContentType;
	protected $mCacheMode = 'public';

	public function __construct(WebRequest $request) {
		$this->mType = $request->getText('type');
		$this->mOid = $request->getText('oid');
		parse_str(urldecode($request->getText('params')), $this->mParams);
		$this->mCb = $request->getInt('cb');
	}

	public function getContent() {
		if((!empty($this->mContent)) && ((!isset($this->mParams['minify'])) || ($this->mParams['minify'] == true))){
			$start = microtime(true);

			if($this->mOid == 'oasis_shared_js' || $this->mOid == 'rte') {
				$newContent = $this->minifyJS($this->mContent, true);
			} else if($this->mContentType == AssetsManager::TYPE_CSS) {
				$newContent = $this->minifyCSS($this->mContent);
			} else if($this->mContentType == AssetsManager::TYPE_JS) {
				$newContent = $this->minifyJS($this->mContent);
			}

			$stop = microtime(true);
		}

		if(!empty($newContent)) {
			$this->mContent = '/* Minify took '.($stop-$start)." */\n\n".$newContent;
		}

		return $this->mContent;
	}

	public function getCacheDuration() {
		global $wgStyleVersion;
		if($this->mCb > $wgStyleVersion) {
			return 10 * 60; // 10 minutes
		} else {
			return 7 * 24 * 60 * 60; // 7 days
		}
	}

	public function getCacheMode() {
		return $this->mCacheMode;
	}

	public function getContentType() {
		return $this->mContentType;
	}

	private function minifyJS($content, $useYUI = false) {
		global $IP;
		wfProfileIn(__METHOD__);

		$tempInFile = tempnam(sys_get_temp_dir(), 'AMIn');
		file_put_contents($tempInFile, $content);

		if($useYUI) {
			$tempOutFile = tempnam(sys_get_temp_dir(), 'AMOut');
			shell_exec("nice -n 15 java -jar {$IP}/lib/yuicompressor-2.4.2.jar --type js -o {$tempOutFile} {$tempInFile}");
			$out = file_get_contents($tempOutFile);
			unlink($tempOutFile);
		} else {
			$jsmin = dirname(__FILE__) . '/../../StaticChute/jsmin';
			$out = shell_exec("cat $tempInFile | $jsmin");
		}

		unlink($tempInFile);

		wfProfileOut(__METHOD__);
		return $out;
	}

	private function minifyCSS($content) {
		wfProfileIn(__METHOD__);

		require_once dirname(__FILE__) . '/../../StaticChute/Minify_CSS_Compressor.php';
		$out = Minify_CSS_Compressor::process($content);

		wfProfileOut(__METHOD__);
		return $out;
	}
}
