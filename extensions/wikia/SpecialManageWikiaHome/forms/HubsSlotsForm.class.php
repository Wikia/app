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

			];
			$fields['marketing_slot_title'] = [
				'label' => 'Title',
				'type' => 'text',
				'isArray' => true
			];
			$fields['marketing_slot_image'] = [
				'type' => 'hidden',
				'validator' => new WikiaValidatorFileTitle(
						array(
							'required' => true
						),
						array('wrong-file' => 'wikia-hubs-validator-wrong-file')
					),
				'attributes' => array(
					'class' => 'required wmu-file-name-input'
				),
				'class' => 'hidden',
				'label' => 'Image',
				'isArray' => true
			];
			$fields['marketing_slot_link'] = [
				'label' => 'Link',
				'type' => 'text',
				'isArray' => true
			];
		}

		$this->setFields( $fields );
	}
}
