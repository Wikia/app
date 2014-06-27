<?php

class HubsSlotsForm extends FormBuilderService {
	public function __construct($prefix = '', $fields = []) {
		parent::__construct($prefix, $fields);

		if(empty($fields)) {
			$fields = [
				'hub_slot' => [
					'label' => wfMessage('manage-wikia-home-hubs-slot-name')->plain(),
					'type' => 'select',
					'isArray' => true
				]
			];
		}

		$this->setFields( $fields );
	}
}
