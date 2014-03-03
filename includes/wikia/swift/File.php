<?php

namespace Wikia\Swift\File;

class Md5Cache {
	protected $cacheFile;
	protected $cache = array();

	public function setCacheFile( $cacheFile ) {
		$this->cacheFile = $cacheFile;
		$dirName = dirname($this->cacheFile);
		if ( !is_dir( $dirName ) ) {
			mkdir( dirname($this->cacheFile), 0777, true );
		}
		$this->load();
	}

	protected function load() {
		$rawCache = @file_get_contents($this->cacheFile);
		$cache = array();
		if ( $rawCache !== false ) {
			$lines = preg_split("/[\r\n]+/",$rawCache);
			foreach ($lines as $line) {
				$line = trim($line);
				if ( empty($line) ) continue;
				list($md5,$key) = explode(';',$line,2);
				$cache[$key] = $md5;
			}
		}
		$this->cache = $cache;
	}

	protected function getKey( $file ) {
		clearstatcache();
		if ( !is_file($file) || !is_readable($file) ) {
			return null;
		}
		$size = filesize($file);
		$mtime = filemtime($file);

		return "{$file}:{$size}:{$mtime}";
	}

	protected function add( $key, $md5, $writeToFile = true ) {
		$this->cache[$key] = $md5;
		if ( $writeToFile ) {
			$f = fopen($this->cacheFile,'a');
			fwrite($f,"{$md5};{$key}\n");
			fclose($f);
		}
	}


	public function get( $file ) {
		if ( !$this->cacheFile ) {
			// fallback if not configured
			return md5_file($file);
		}
		$key = $this->getKey($file);
		if ( $key === null ) {
			return null;
		}
		if ( empty($this->cache[$key]) ) {
			$md5 = md5_file($file);
			$afterKey = $this->getKey($file);
			$this->add($key,$md5,$key === $afterKey);
		}
		return $this->cache[$key];
	}

	public function getCachedCount() {
		return is_array($this->cache) ? count($this->cache) : 0;
	}

	static public function getInstance() {
		static $instance;
		if ( empty($instance) ) {
			$instance = new static();
		}
		return $instance;
	}

}
