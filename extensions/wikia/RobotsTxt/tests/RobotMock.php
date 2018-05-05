<?php

class RobotMock extends \Wikia\RobotsTxt\Robot {
	public $spiedAllowed = [];
	public $spiedDisallowed = [];

	public function allowPaths( array $paths ) {
		$this->spiedAllowed[] = $paths;
	}

	public function disallowPaths( array $paths ) {
		$this->spiedDisallowed[] = $paths;
	}

	public function block() {
		$this->spiedAllowed = [];
		$this->spiedDisallowed = [];
		$this->disallowPaths( [ '/' ] );
	}

	public function getContent() {
	}
}
