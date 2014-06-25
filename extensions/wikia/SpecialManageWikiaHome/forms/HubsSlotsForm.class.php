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
				'validator' => new WikiaValidatorListValue(
						array(
							'validator' => new WikiaValidatorImageSize(
								array(
									'minWidth' => 330,
									'minHeight' => 210,
									'maxWidth' => 330,
									'maxHeight' => 210,
								),
								array('wrong-size' => 'Image should have 330px x 210px')
							),
						)
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
