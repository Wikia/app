<?
class WikiaHubsPollsModel extends WikiaModel {
	const MANDATORY_OPTIONS_LIMIT = 2;
	const VOLUNTARY_OPTIONS_LIMIT = 8;

	public function getMandatoryOptionsLimit() {
		return self::MANDATORY_OPTIONS_LIMIT;
	}

	public function getVoluntaryOptionsLimit() {
		return self::VOLUNTARY_OPTIONS_LIMIT;
	}

	public function getTotalOptionsLimit() {
		return self::MANDATORY_OPTIONS_LIMIT + self::VOLUNTARY_OPTIONS_LIMIT;
	}
}
