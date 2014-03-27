<?php

class HubsSlotsForm extends FormBuilderService {
	public function __construct($prefix = '', $fields = []) {
		parent::__construct($prefix, $fields);

		if(empty($fields)) {
			$fields = [
				'hub_slot_1' => [
					'label' => wfMessage('manage-wikia-home-hubs-slot-1')->plain(),
					'type' => 'select'
				],
				'hub_slot_2' => [
					'label' => wfMessage('manage-wikia-home-hubs-slot-2')->plain(),
					'type' => 'select'
				],
				'hub_slot_3' => [
					'label' => wfMessage('manage-wikia-home-hubs-slot-3')->plain(),
					'type' => 'select'
				]
			];
		}

		$this->setFields( $fields );
	}
}
