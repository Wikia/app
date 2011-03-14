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
		global $IP;

		if(!empty($this->mContentType) && (!isset($this->mParams['minify']) || $this->mParams['minify'] == true)) {
			$tempInFile = tempnam(sys_get_temp_dir(), 'AssetsManager');
			$tempOutFile = tempnam(sys_get_temp_dir(), 'AssetsManager');
			file_put_contents($tempInFile, $this->mContent);
			
			$start = microtime(true);
			
			if($this->mContentType == AssetsManagerBaseBuilder::TYPE_JS) {
//				shell_exec("java -jar {$IP}/extensions/wikia/AssetsManager/compiler.jar --compilation_level SIMPLE_OPTIMIZATIONS --js {$tempInFile} --js_output_file {$tempOutFile}");
				shell_exec("java -jar {$IP}/extensions/wikia/AssetsManager/yuicompressor-2.4.2/build/yuicompressor-2.4.2.jar --type js -o {$tempOutFile} {$tempInFile} ");
			} else {
				shell_exec("java -jar {$IP}/extensions/wikia/AssetsManager/yuicompressor-2.4.2/build/yuicompressor-2.4.2.jar --type css -o {$tempOutFile} {$tempInFile} ");
			}
			
			$stop = microtime(true);
			
			$total = $stop - $start;
			
			$this->mContent = "/* Minify took {$total} */\n\n\n";
			
			$this->mContent .= file_get_contents($tempOutFile);
			unlink($tempInFile);
			unlink($tempOutFile);
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
			return 60; // 60 seconds
		} else {
			return 7 * 24 * 60 * 60; // 7 days
		}
	}
	
	public function getContentType() {
		return $this->mContentType;
	}
		
}