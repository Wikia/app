<?php

class WdsSearch {
	public $module;

	/**
	 * @param WdsSearchModule $module
	 * @return WdsSearch
	 */
	public function setModule( WdsSearchModule $module ) {
		$this->module = $module;

		return $this;
	}


}
