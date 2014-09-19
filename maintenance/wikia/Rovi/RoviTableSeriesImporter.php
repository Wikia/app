<?php
require_once 'RoviTableImporter.php';

class RoviTableSeriesImporter extends RoviTableImporter {
	public function __construct() {
		$this->table = 'rovi_series';
		$this->fields = [ 'series_id', 'full_title', 'synopsis', 'delta' ];
		$this->primary_key = [ 'series_id' ];
		parent::__construct();
	}
}