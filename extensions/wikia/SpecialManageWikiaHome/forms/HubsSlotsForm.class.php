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
				],
				'hub_slot_desc' => [
					'label' => wfMessage('manage-wikia-home-hubs-slot-description')->plain(),
					'type' => 'textarea',
					'isArray' => true
				],
				'hub_slot_more_links' => [
					'label' => wfMessage('manage-wikia-home-hubs-slot-more-links')->plain(),
					'type' => 'textarea',
					'isArray' => true
				]
			];
		}

		$this->setFields( $fields );
	}
}
