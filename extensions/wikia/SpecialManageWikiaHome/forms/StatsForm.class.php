<?php
class StatsForm extends FormBuilderService {

	public function __construct( $prefix = '', $fields = [] ) {
		parent::__construct( $prefix, $fields );

		$fields = [
			'visitors' => [
				'label' => wfMessage( 'manage-wikia-home-stats-visitors-label' )->text(),
				'validator' => new WikiaValidatorInteger( [
						'required' => true,
						'min' => 0
					] ),
			],
			'mobilePercentage' => [
				'label' => wfMessage( 'manage-wikia-home-stats-mobile-percentage-label' )->text(),
				'validator' => new WikiaValidatorNumeric( [
						'required' => true,
						'min' => 0,
						'max' => 100
					] ),
			],
			'editsDefault' => [
				'label' => wfMessage( 'manage-wikia-home-stats-edits-default-label' )->text(),
				'validator' => new WikiaValidatorInteger( [
						'required' => true,
						'min' => 0
					] ),
			],
			'totalPages' => [
				'label' => wfMessage( 'manage-wikia-home-stats-total-pages-label' )->text(),
				'validator' => new WikiaValidatorInteger( [
						'required' => true,
						'min' => 0
					] ),
			],
		];
		$this->setFields( $fields );
	}
}
