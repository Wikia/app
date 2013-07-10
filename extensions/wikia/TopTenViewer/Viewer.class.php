<?php
class Viewer {
	private $app;
	private $id;
	private $name;

	public function __construct($id) {
		$this->app = F::app();
		$this->id = $id;
	}
}

