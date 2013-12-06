<?
class StatsForm extends FormBuilderService {

	public function __construct($prefix = '', $fields = []) {
		parent::__construct($prefix, $fields);

		$fields = [
			'visitors' => [
				'label' => wfMsg('manage-wikia-home-stats-visitors-label'),
				'validator' => new WikiaValidatorInteger(['required' => true]),
			],
			'mobilePercentage' => [
				'label' => wfMsg('manage-wikia-home-stats-mobile-percentage-label'),
				'validator' => new WikiaValidatorInteger(['required' => true]),
			],
			'editsDefault' => [
				'label' => wfMsg('manage-wikia-home-stats-edits-default-label'),
				'validator' => new WikiaValidatorInteger(['required' => true]),
			],
			'totalPages' => [
				'label' => wfMsg('manage-wikia-home-stats-total-pages-label'),
				'validator' => new WikiaValidatorInteger(['required' => true]),
			],
		];
		$this->setFields($fields);
	}
}
