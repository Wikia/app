<?php
abstract class UserWikisFilter {
	private $wikis = [];

	public function getFiltered() {
		return $this->wikis;
	}

}
