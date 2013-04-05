<?php

abstract class SassSource {

	protected $context;

	protected $hash;
	protected $modifiedTime;

	protected $dependencies;
	protected $currentDir;

	protected $humanName;
	protected $rawSource;
	protected $rawModifiedTime;

	public function __construct( SassSourceContext $context ) {
		$this->context = $context;
	}

	public function getContext() {
		return $this->context;
	}

	public function getModifiedTime( $alreadyChecked = array() ) {
		if ( $this->modifiedTime === null ) {
			$modifiedTime = $this->getRawModifiedTime();

			$deps = $this->getDependencies();
			$currentDir = $this->hasCurrentDir() ? $this->getCurrentDir() : null;
			foreach ($deps as $dep) {
				$source = $this->getContext()->getFile($dep,$currentDir);
				$modifiedTime = max( $modifiedTime, $source->getModifiedTime() );
			}

			$this->modifiedTime = $modifiedTime;
		}
		return $this->modifiedTime;
	}

	public function getHash() {
		if ($this->hash === null) {
			$hashSource = md5($this->getRawSource());
			$deps = $this->getDependencies();
//			var_dump($this->getHumanName(),$deps);
			$currentDir = $this->hasCurrentDir() ? $this->getCurrentDir() : null;
			foreach ($deps as $dep) {
//				var_dump("in   ".$this->getHumanName());
//				var_dump('  do '.$dep);
				$source = $this->getContext()->getFile($dep,$currentDir);
//				var_dump('  >> '.$source->getHumanName());
				$hashSource .= $source->getHash();
			}
			$this->hash = md5($hashSource);
//			echo $this->hash . ' ' . $this->getHumanName() . "\n";
		}
		return $this->hash;
	}


	protected function getHumanName() {
		return $this->humanName !== null ? $this->humanName : "(unknown)";
	}

	protected function getRawSource() {
		if ( $this->rawSource === null ) {
			throw new SassException( sprintf( '%s::getRawSource[%s]: Raw source is not available.',
				get_class($this), $this->getHumanName() ) );
		}
		return $this->rawSource;
	}

	protected function getRawModifiedTime() {
		if ( $this->rawModifiedTime === null ) {
			throw new SassException( sprintf( '%s::getRawSource[%s]: Raw modified time is not available.',
				get_class($this), $this->getHumanName() ) );
		}
		return $this->rawModifiedTime;
	}


	protected function hasCurrentDir() {
		return $this->currentDir !== null;
	}

	protected function getCurrentDir() {
		if ( $this->currentDir === null ) {
			throw new SassException( sprintf( '%s::getRawSource[%s]: Current directory is not available.',
				get_class($this), $this->getHumanName() ) );
		}
		return $this->currentDir;
	}

	protected function getDependencies() {
		if ( $this->dependencies === null ) {
			$contents = $this->getRawSource();
			$matches = array();
			preg_match_all( '/\\@import(\\s)*[\\"\']([^\\"\']*)[\\"\']/', $contents, $matches, PREG_PATTERN_ORDER );
			$this->dependencies = $matches[2];
		}
		return $this->dependencies;
	}

}