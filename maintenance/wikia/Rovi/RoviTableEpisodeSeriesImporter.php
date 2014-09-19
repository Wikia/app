<?php
require_once 'RoviTableImporter.php';

class RoviTableEpisodeSeriesImporter extends RoviTableImporter {
	public function __construct() {
		$this->table = 'rovi_episode_series';
		$this->fields = [
			'series_id', 'season_program_id', 'program_id',
			'episode_title', 'episode_season_number', 'episode_season_sequence',
			'episode_series_sequence', 'delta' ];
		$this->primary_key = [ 'series_id', 'program_id' ];
		parent::__construct();
	}
} 