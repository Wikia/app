<?php

class WdsFandomOverview {
	public $links = [];

	/**
	 * @param array $links
	 * @return WdsFandomOverview
	 */
	public function setLinks( array $links ) {
		$this->links = $links;

		return $this;
	}
}
