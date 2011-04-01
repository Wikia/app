<?php

/**
 * @author Inez Korczyński <korczynski@gmail.com>
 */

class AssetsManagerBaseBuilder {

	const TYPE_CSS = 'text/css';
	const TYPE_JS = 'application/x-javascript';

	protected $mOid;
	protected $mType;
	protected $mParams;
	protected $mCb;

	protected $mContent;
	protected $mContentType;

	public function __construct($request) {
		$this->mType = $request->getText('type');
		$this->mOid = $request->getText('oid');
		parse_str(urldecode($request->getText('params')), $this->mParams);
		$this->mCb = $request->getInt('cb');
	}

	public function getContent() {
		global $IP, $wgRequest;

		if((!empty($this->mContentType) || $this->mOid == 'site_css') && (!isset($this->mParams['minify']) || $this->mParams['minify'] == true) && ($this->mOid == 'site_css' || $this->mOid == 'oasis_anon_js' || $this->mOid == 'oasis_user_js' || $this->mOid == 'skins/oasis/css/oasis.scss' )) {

			/*

			$tempInFile = tempnam(sys_get_temp_dir(), 'AMIn');
			$tempOutFile = tempnam(sys_get_temp_dir(), 'AMOut');

			file_put_contents($tempInFile, $this->mContent);

			$start = microtime(true);

			if($this->mContentType == AssetsManagerBaseBuilder::TYPE_JS) {
				shell_exec("nice -n 15 java -jar {$IP}/lib/yuicompressor-2.4.2.jar --type js -o {$tempOutFile} {$tempInFile}");
			} else {
				shell_exec("nice -n 15 java -jar {$IP}/lib/yuicompressor-2.4.2.jar --type css -o {$tempOutFile} {$tempInFile}");
			}

			$stop = microtime(true);

			$total = $stop - $start;

			$out = file_get_contents($tempOutFile);

			if($total > 5) {
				// Temporary log
				error_log("Temp log - #3 - Minifier took over 5 seconds: " . $wgRequest->getFullRequestURL());
			}

			*/

			$start = microtime(true);

			if($this->mContentType == AssetsManagerBaseBuilder::TYPE_JS) {

				$jsmin = dirname(__FILE__) . '/../../StaticChute/jsmin';
				if(is_executable($jsmin)){
					$tempInFile = tempnam(sys_get_temp_dir(), 'AMIn');
					file_put_contents($tempInFile, $this->mContent);
					$out = shell_exec("cat $tempInFile | $jsmin");
					unlink($tempInFile);
				}

			} else {
				require_once dirname(__FILE__) . '/../../StaticChute/Minify_CSS_Compressor.php';
				$out = Minify_CSS_Compressor::process($this->mContent);
			}

			$stop = microtime(true);
			$total = $stop - $start;

			if(!empty($out)) {
				$this->mContent = "/* Minify took {$total} */\n\n";
				$this->mContent .= $out;
			} else {
				// Temporary log
				error_log("Temp log - #2 - Empty output from minifier: " . $wgRequest->getFullRequestURL());
			}

			//unlink($tempInFile);
			//unlink($tempOutFile);
		}

		return $this->mContent;
	}

	protected function resolveContentType($path) {
		if(endsWith($path, '.js', false)) {
			return AssetsManagerBaseBuilder::TYPE_JS;
		} elseif(endsWith($path, '.css', false)) {
			return AssetsManagerBaseBuilder::TYPE_CSS;
		} else {
			return null;
		}
	}

	public function getCacheDuration() {
		global $wgStyleVersion;
		if($this->mCb > $wgStyleVersion) {
			syslog(LOG_ERR, "InezLog | Log 1 : {$this->mCb} > {$wgStyleVersion}");
			return 60; // 60 seconds
		} else {
			return 7 * 24 * 60 * 60; // 7 days
		}
	}

	public function getContentType() {
		return $this->mContentType;
	}
}
