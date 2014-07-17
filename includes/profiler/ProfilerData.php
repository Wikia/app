<?php

/**
 * Class ProfilerData is a data object storing information passed to ProfilerDataSink
 */
class ProfilerData {

	const ENGINE_MEDIAWIKI = 'mwprofiler';
	const ENGINE_XHPROF = 'xhprof';

	private $engine;
	private $profile;
	private $request;
	private $entries;

	public function __construct( $engine, $profile, $request, $entries ) {
		$this->engine = $engine;
		$this->profile = $profile;
		$this->request = $request;
		$this->entries = $entries;
	}

	public function setEngine( $engine ) { $this->engine = $engine; }
	public function setProfile( $profile ) { $this->profile = $profile; }
	public function setRequest( $request ) { $this->request = $request; }
	public function setEntries( $entries ) { $this->entries = $entries; }

	public function getEngine() { return $this->engine; }
	public function getProfile() { return $this->profile; }
	public function getRequest() { return $this->request; }
	public function getEntries() { return $this->entries; }

}