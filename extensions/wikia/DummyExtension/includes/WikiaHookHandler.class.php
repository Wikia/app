<?php

abstract class WikiaHookHandler implements IWikiaHookHandler {

	private $hookOptions = array();

	/**
	 * get hook options
	 * @return array
	 */
	public function getHookOptions() {
		return $this->hookOptions;
	}

	/**
	 * set hook options
	 * @param array $options
	 */
	public function setHookOptions(Array $options) {
		$this->hookOptions = $options;
	}

}
