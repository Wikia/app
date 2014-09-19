<?php

namespace Wikia\Sass\Source;

/**
 *Source is a base class for sources containing SASS source code.
 * You can request last modification time, hash of all the included sources
 * and the output compiled CSS code.
 *
 * @author Władysław Bodzek <wladek@wikia-inc.com>
 */
abstract class Source {

	protected $context;

	protected $hash;
	protected $modifiedTime;
	protected $dependencies;

	protected $humanName;

	public function __construct( Context $context ) {
		$this->context = $context;
	}

	public function getContext() {
		return $this->context;
	}

	public function getModifiedTime( $alreadyChecked = array() ) {
		if ( $this->modifiedTime === null ) {
			$modifiedTime = $this->getRawModifiedTime();

			$deps = $this->getDependencies();
			$currentDir = $this->hasPermanentFile() ? $this->getCurrentDir() : null;
//			var_dump(get_class($this),$currentDir);
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
			$currentDir = $this->hasPermanentFile() ? $this->getCurrentDir() : null;
//			var_dump(get_class($this),$currentDir);
			foreach ($deps as $dep) {
//				var_dump("in   ".$this->getHumanName());
//				var_dump('  do '.$dep);
				try {
					$source = $this->getContext()->getFile($dep,$currentDir);
				} catch( \Exception $e ) {
					$message = "SASS error: Could not resolve dependency \"{$dep}\" in context of: {$this->getHumanName()} -- {$e->getMessage()}";
					throw new \Wikia\Sass\Exception($message);
				}
//				var_dump('  >> '.$source->getHumanName());
				$hashSource .= $source->getHash();
			}
			$this->hash = md5($hashSource);
//			echo $this->hash . ' ' . $this->getHumanName() . "\n";
		}
		return $this->hash;
	}


	abstract public function hasPermanentFile();
	abstract public function getLocalFile();
	abstract public function releaseLocalFile();


	public function getHumanName() {
		return $this->humanName !== null ? $this->humanName : "(unknown)";
	}

	abstract protected function getRawSource();
	abstract protected function getRawModifiedTime();
	abstract protected function getCurrentDir();

	protected function getDependencies() {
		if ( $this->dependencies === null ) {
			$contents = $this->getRawSource();
			$matches = array();
			preg_match_all( '/^\\s*\\@import(\\s)*[\\"\']([^\\"\']*)[\\"\']/m', $contents, $matches, PREG_PATTERN_ORDER );
			$this->dependencies = $matches[2];
		}
		return $this->dependencies;
	}

}